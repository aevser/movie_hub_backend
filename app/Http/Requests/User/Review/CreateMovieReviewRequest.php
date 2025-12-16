<?php

namespace App\Http\Requests\User\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovieReviewRequest extends FormRequest
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
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'min:5', 'max:1000']
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Поставьте оценку',
            'rating.integer'  => 'Оценка должна быть числом',
            'rating.min'      => 'Минимальная оценка — 1',
            'rating.max'      => 'Максимальная оценка — 5',

            'review_text.required' => 'Напишите отзыв',
            'review_text.string'   => 'Отзыв должен быть текстом',
            'review_text.min'      => 'Отзыв должен содержать минимум 5 символов',
            'review_text.max'      => 'Отзыв не должен превышать 1000 символов'
        ];
    }
}
