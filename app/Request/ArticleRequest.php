<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class ArticleRequest extends FormRequest
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
            case 'api/article/save':
                $rules = [
                    'article_title'   => 'required|max:100',
                    'article_desc'    => 'required',
                    'article_img'     => '',
                    'article_content' => 'required',
                    'article_type'    => 'required|integer|in:1,2,3',
                    'article_status'  => 'required|integer|in:1,2',
                    'article_level'   => 'required|integer',
                    'tag_id'          => 'required|integer',
                    'is_recommend'    => 'required|integer|in:1,2',
                    'id'              => 'sometimes',
                ];
                break;
            case 'api/article/delete':
            case 'api/article/row':
                $rules = [
                    'article_id' => 'required',
                ];
                break;
        }

        return $rules;
    }

    public function attributes():array
    {
        return [
            'article_title'   => '文章标题',
            'article_desc'    => '文章描述',
            'article_img'     => '文章主图',
            'article_content' => '文章内容',
            'article_type'    => '文章类型',
            'article_status'  => '文章状态',
            'article_level'   => '文章排序',
            'tag_id'          => '标签',
            'is_recommend'    => '是否推荐',
        ];
    }

}
