<?php

namespace App\Http\Requests\Catalog\Movie;

use Illuminate\Foundation\Http\FormRequest;

class FilterMovieRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', 'exists:genres,id'],

            'directors' => ['nullable', 'array'],
            'directors.*' => ['integer', 'exists:crews,id'],

            'actors' => ['nullable', 'array'],
            'actors.*' => ['integer', 'exists:actors,id'],

            'rating_from' => ['nullable', 'integer', 'min:1', 'max:10'],
            'rating_to' => ['nullable', 'integer', 'min:1', 'max:10', 'gte:rating_from'],

            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],

            'page' => ['nullable', 'integer', 'min:1']
        ];
    }
}
