<?php

namespace App\Http\Requests;

use App\Constants\LocationConstant;
use App\Constants\UserConstant;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'email' => 'required|unique:users,email' . ($this->user == null ? '' : ',' . $this->user->id),
            'password' => 'sometimes|string|min:8|max:255',
            'avatar' => 'sometimes|file|image',
            'department' => 'required|string|min:2|max:255|in:' . implode(',', LocationConstant::locations()),
            'position' => 'required|string|min:2|max:255|in:' . implode(',', UserConstant::positions()),
            'type' => 'required|string|min:2|max:255|in:' . implode(',', UserConstant::types()),
            'position' => 'required|string|min:2|max:255|in:' . implode(',', UserConstant::positions()),
            'status' => 'required|string|min:2|max:255|in:' . implode(',', UserConstant::statuses())
        ];
    }
}
