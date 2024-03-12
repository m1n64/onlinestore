<?php

namespace App\Http\Requests\Admin\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class SetBanStatusRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "status" => ["required", "boolean"]
        ];
    }
}
