<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:255',
            'status_task_id' => 'required|exists:status_tasks,id',
            'due_date'       => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Pole tytuł jest wymagane',
            'title.string'   => 'Tytuł musi być tekstem',
            'title.max'      => 'Tytuł nie może być dłuższy niż 255 znaków',

            'description.string' => 'Opis musi być tekstem',
            'description.max'    => 'Opis nie może być dłuższy niż 255 znaków',

            'status_task_id.required' => 'Pole status jest wymagane',
            'status_task_id.exists'   => 'Wybrany status jest niepoprawny',

            'due_date.date' => 'Pole termin musi być poprawną datą',
        ];
    }

}
