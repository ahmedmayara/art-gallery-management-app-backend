<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArtistRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:25', 'regex:/^([a-zA-Z\s]*)$/'],
            'last_name' => ['required', 'string', 'max:25', 'regex:/^([a-zA-Z\s]*)$/'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('artists')->ignore($this->artist)],
            'phone' => ['required', 'string', 'max:25', Rule::unique('artists')->ignore($this->artist), 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'bio' => ['required', 'string', 'max:255'],
            'website' => ['required', 'string', 'max:255'],
        ];
    }
}
