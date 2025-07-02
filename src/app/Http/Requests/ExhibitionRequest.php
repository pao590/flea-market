<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['exists:categories,id'],
            'condition' => ['required', 'in:new,used,other'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => '商品名は必須です。',
            'description.required' => '商品説明は必須です。',
            'description.max' => '商品説明は255文字以内で入力してください。',
            'image.required' => '商品画像は必須です。',
            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください。',
            'categories.required' => '少なくとも1つのカテゴリを選択してください。',
            'categories.array' => 'カテゴリは配列形式で指定してください。',
            'categories.*.exists' => '選択されたカテゴリが無効です。',
            'condition.required' => '商品の状態は必須です。',
            'condition.in' => '商品の状態が不正です。',
            'price.required' => '価格は必須です。',
            'price.integer' => '価格は数値で入力してください。',
            'price.min' => '価格は0円以上で入力してください。',
        ];
    }
}
