<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtboardRequest;
use App\Http\Requests\UpdateArtboardRequest;
use App\Http\Resources\V1\ArtboardResource;
use App\Models\Artboard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtboardController extends Controller
{
    public function index()
    {
        $artboards = Artboard::paginate(5);
        return ArtboardResource::collection($artboards);
    }

    public function all()
    {
        $artboards = Artboard::all();
        return ArtboardResource::collection($artboards);
    }

    public function show(Artboard $artboard)
    {
        $artboard->image = str_replace('http://localhost:8000/storage/', url('/') . '/storage/', $artboard->image);
        return new ArtboardResource($artboard);
    }

    public function store(StoreArtboardRequest $storeArtboardRequest)
    {
        try {
            $image_name = Str::random(32).'.'.$storeArtboardRequest->file('image')->getClientOriginalExtension();

            $artboard = Artboard::with(['artist', 'category'])->create([
                'title' => $storeArtboardRequest->title,
                'price' => $storeArtboardRequest->price,
                'description' => $storeArtboardRequest->description,
                'image' => url(Storage::url($image_name)),
                'artist_id' => $storeArtboardRequest->artist_id,
                'category_id' => $storeArtboardRequest->category_id,
            ]);

            Storage::disk('public')->put($image_name, file_get_contents($storeArtboardRequest->file('image')));

            return response()->json(
                [
                    'artboard' => $artboard,
                    'message' => 'Artboard created successfully',
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Image not found',
                ],
                400
            );
        }
    }

    public function update(UpdateArtboardRequest $request, $id)
{
    try {
        $artboard = Artboard::findOrFail($id);

        $artboard->title = $request->title;
        $artboard->price = $request->price;
        $artboard->description = $request->description;
        $artboard->artist_id = $request->artist_id;
        $artboard->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $image_name = Str::random(32).'.'.$request->file('image')->getClientOriginalExtension();
            Storage::disk('public')->put($image_name, file_get_contents($request->file('image')));
            $artboard->image = url(Storage::url($image_name));
        }

        $artboard->save();

        return response()->json(
            [
                'artboard' => $artboard,
                'message' => 'Artboard updated successfully',
            ],
            200
        );
    } catch (\Exception $e) {
        return response()->json(
            [
                'message' => 'Artboard not found',
            ],
            404
        );
    }
}

    public function destroy(Artboard $artboard)
    {
        try {
            $artboard->delete();
            return response()->json(
                [
                    'message' => 'Artboard deleted successfully',
                ],
                200
            );
        } catch (QueryException $exception) {
            if ($exception->getCode() === '23000') {
                return response()->json(
                    [
                        'message' => 'This artboard cannot be deleted because it is related to other records.',
                    ],
                    400
                );
            }
        }
    }


    public function getArtboardsByCategory($id)
    {
        $artboards = Artboard::where('category_id', $id)->get();
        return ArtboardResource::collection($artboards);
    }
}
