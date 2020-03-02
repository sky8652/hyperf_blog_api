<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        $uri = $this->path();

        $rules = [];

        switch ($uri) {
            case 'api/tag/save':
                $rules = [
                    'tag_name'   => 'required|max:50',
                    'tag_type'   => 'required|integer|in:1,2,3',
                    'tag_level'  => 'required|integer|max:128',
                    'tag_status' => 'required|integer|in:1,2',
                    'id'         => 'sometimes',
                ];
                break;
            case 'api/tag/delete':
                $rules = [
                    'tag_id' => 'required',
                ];
                break;
        }

        return $rules;
    }

    public function attributes():array
    {
        return [
            'tag_name'  => '标签名称',
            'tag_type'  => '标签类型',
            'tag_level' => '标签排序',
            'tag_id'    => '标签ID',
        ];
    }

}
