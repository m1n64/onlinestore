<?php

namespace App\Http\Requests\Storage\Api\Files;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "files" => ["required"],
            "folderSlug" => ["nullable"],
        ];
    }
}
