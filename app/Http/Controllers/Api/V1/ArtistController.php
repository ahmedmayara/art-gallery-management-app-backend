<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Resources\V1\ArtistResource;
use App\Models\Artist;
use Illuminate\Database\QueryException;

class ArtistController extends Controller
{
    public function index()
    {
        return ArtistResource::collection(Artist::all());
    }

    public function show(Artist $artist)
    {
        return new ArtistResource($artist);
    }

    public function store(StoreArtistRequest $storeArtistRequest)
    {
        $artist = Artist::create($storeArtistRequest->validated());

        return response()->json($artist, 200);
    }

    public function update(StoreArtistRequest $storeArtistRequest, Artist $artist)
    {
        $artist->update($storeArtistRequest->validated());

        return response()->json($artist, 200);
    }

    public function destroy(Artist $artist)
    {
        try {
            $artist->delete();

            return response()->json(
                [
                    'message' => 'Artist deleted successfully',
                ],
                200
            );
        } catch (QueryException $exception) {
            if ($exception->getCode() === '23000') {
                return response()->json(
                    [
                        'message' => 'Artist cannot be deleted because it is associated with an artboard.',
                    ],
                    400
                );
            }
        }
    }
}
