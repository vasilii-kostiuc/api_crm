<?php

namespace App\Modules\Admin\Role\Requests;

use Illuminate\Foundation\Http\FormRequest;
use const http\Client\Curl\AUTH_ANY;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo(['SUPER_ADMINISTRATOR', 'ROLES_ACCESS']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required',
            'alias' => 'required'
        ];
    }
}
