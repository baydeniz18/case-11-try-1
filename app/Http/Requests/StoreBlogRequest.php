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

        //user_id eklemeye gerek yok tokenden alınacak tokensiz bu işlemi de yapamaz.
        return [
            'category_id'=>'required|exists:categories,id',
            'header'=>'required',
            'desc_short'=>'required',
            'desc_long'=>'required'
        ];
    }
}
