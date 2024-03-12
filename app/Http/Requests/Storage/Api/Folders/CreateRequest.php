<?php

namespace App\Http\Requests\Storage\Api\Folders;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string"],
            "folderSlug" => ["nullable"],
        ];
    }
}
