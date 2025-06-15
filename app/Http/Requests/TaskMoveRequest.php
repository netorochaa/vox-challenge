<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskMoveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'data.*.task_id'     => ['required', 'integer', 'exists:tasks,id'],
            'data.*.category_id' => ['required', 'integer', 'exists:categories,id'],
            'data.*.order'       => ['required', 'integer'],
        ];
    }
}
