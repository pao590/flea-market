<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'required|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'ユーザー名は必須です。',
            'zipcode.required' => '郵便番号は必須です。',
            'address.required' => '住所は必須です。',
            'profile_image.required' => 'プロフィール画像は必須です。',
            'profile_image.image' => '画像ファイルを選択してください。',
        ];
    }
}
