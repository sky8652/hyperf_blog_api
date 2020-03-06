<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SiteRequest extends FormRequest
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
            case 'api/site/save':
                $rules = [
                    'site_name'       => 'required',
                    'site_desc'       => 'required',
                    'site_icon'       => 'required',
                    'site_record'     => 'required',
                    'site_owner'      => 'required',
                    'site_owner_desc' => 'required',
                    'site_notice'     => 'required',
                ];
                break;
            case 'api/site/save_friend_link':
                $rules = [
                    'name'  => 'required',
                    'link'  => 'required',
                    'level' => 'required',
                ];
                break;
            case 'api/site/delete_friend_link':
                $rules = [
                    'id'  => 'required',
                ];
                break;
        }

        return $rules;
    }

    public function attributes():array
    {
        return [
            'site_name'       => '网站名称',
            'site_desc'       => '网站描述',
            'site_icon'       => '网站Icon',
            'site_record'     => '网站备案号',
            'site_owner'      => '站长',
            'site_owner_desc' => '站长有话',
            'name'            => '名称',
            'link'            => '链接',
            'level'           => '排序',
            'id'              => '链接ID',
        ];
    }

}
