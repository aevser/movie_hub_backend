<?php

namespace App\Http\Requests\Catalog\Movie;

use Illuminate\Foundation\Http\FormRequest;

class SortMovieRequest extends FormRequest
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
            'sort' => ['nullable', 'string', 'in:release_date_asc,release_date_desc,rating_asc,rating_desc']
        ];
    }
}
