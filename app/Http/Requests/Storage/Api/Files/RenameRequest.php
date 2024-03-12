<?php

namespace App\Http\Requests\Storage\Api\Files;

use Illuminate\Foundation\Http\FormRequest;

class RenameRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
