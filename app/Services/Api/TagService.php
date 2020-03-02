<?php
/**
 *
 * User: xiaowei<13177839316@163.com>
 * Date: 2020/1/20
 * Time: 15:00
 */

namespace App\Services\Api;


use App\Exception\WrongRequestException;
use App\Model\Api\ArticleModel;
use App\Model\Api\TagModel;
use Hyperf\Database\Query\Builder;

class TagService
{

    public function list($params)
    {
        $tagBuild = TagModel::query()->orderByDesc('tag_level');

        $tagBuild = $this->buildWhere($params,$tagBuild);

        return $tagBuild->paginate(10);
    }

    public function tags()
    {
        return TagModel::query()->orderByDesc('tag_level')->get();
    }


    public function save($params)
    {
        $where = ['id'=>$params['id'] ?? 0];
        $attr  = [
            'tag_name' => trim($params['tag_name']),
            'tag_type' => $params['tag_type'],
            'tag_status' => $params['tag_status'],
            'tag_level' => $params['tag_level'],
        ];
        return TagModel::query()->updateOrCreate($where, $attr);
    }

    public function delete($tagId)
    {
        if ( ArticleModel::query()->where('tag_id',$tagId)->count() ) {
            throw new WrongRequestException("该标签下还有内容!");
        }

        return TagModel::query()->where('id',$tagId)->delete();
    }

    /**
     * @param $params
     * @param $build Builder
     *
     * @return mixed
     */
    public function buildWhere($params,$build)
    {
        if (!empty($params['tag_name'])) {
            $build->where('tag_name',$params['tag_name'].'%');
        }

        if (!empty($params['tag_type'])) {
            $build->whereIn('tag_type',$params['tag_type']);
        }

        if (!empty($params['tag_level'])) {
            $build->where('tag_level','>=',$params['tag_level']);
        }

        if (!empty($params['tag_status'])) {
            $build->whereIn('tag_status',$params['tag_status']);
        }

        return $build;
    }
}
