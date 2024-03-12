<?php

namespace App\Http\Requests\Admin\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class SetMaxFilesSizeRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "max_size" => ["required", "numeric"],
        ];
    }
}
