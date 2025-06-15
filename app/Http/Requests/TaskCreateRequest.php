<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
