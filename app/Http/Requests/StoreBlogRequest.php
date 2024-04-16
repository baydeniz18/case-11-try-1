<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'category_id'=>'required|exists:categories,id',
            // 'header'=>'required',
            // 'desc_short'=>'required',
            // 'desc_long'=>'required'
        ];
    }
}
