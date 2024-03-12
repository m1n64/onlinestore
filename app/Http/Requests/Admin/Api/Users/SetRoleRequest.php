<?php

namespace App\Http\Requests\Admin\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class SetRoleRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "role" => ["required", "string"]
        ];
    }
}
