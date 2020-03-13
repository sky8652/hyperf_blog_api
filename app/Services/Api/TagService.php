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

        $tagBuild = $this->buildWhere($params, $tagBuild);

        return $tagBuild->paginate(10);
    }

    public function homeTags()
    {
        $tags = TagModel::query()->with('articles')->where('is_series', 2)
            ->where('tag_status', 1)
            ->orderByDesc('tag_level')
            ->get(['tag_name', 'id']);

        $tags->each(function ($tag) {
            $tag->article_count = count($tag->articles);
            unset($tag->articles);
        });

        return $tags;
    }

    public function seriesTags()
    {
        return TagModel::query()->where('is_series', 1)
            ->where('tag_status', 1)
            ->orderByDesc('tag_level')
            ->orderByDesc('id')
            ->get(['tag_name', 'id']);
    }

    protected function hasSameName($name)
    {
        return TagModel::query()->where('tag_name',$name)->count()>0;
    }


    public function tags()
    {
        return TagModel::query()->orderByDesc('tag_level')->get();
    }


    public function save($params)
    {
        $id = $params['id'] ?? 0;

        if ($id) {
            $tag = TagModel::query()->where('id',$id)->first();
            if ( $tag->tag_name != $params['tag_name'] && $this->hasSameName($params['tag_name']) ) {
                throw new WrongRequestException("已存在该标签!");
            }
        } else {
            if ( $this->hasSameName($params['tag_name'])) {
                throw new WrongRequestException("已存在该标签!");
            }
            $tag = new TagModel();
        }

        $tag->tag_name   = $params['tag_name'];
        $tag->tag_type   = $params['tag_type'];
        $tag->tag_status = $params['tag_status'];
        $tag->tag_level  = $params['tag_level'];
        $tag->is_series  = $params['is_series'];

        return $tag->save();
    }

    public function delete($tagId)
    {
        if (ArticleModel::query()->where('tag_id', $tagId)->count()) {
            throw new WrongRequestException("该标签下还有内容!");
        }

        return TagModel::query()->where('id', $tagId)->delete();
    }

    /**
     * @param $params
     * @param $build Builder
     *
     * @return mixed
     */
    public function buildWhere($params, $build)
    {
        if (!empty($params['tag_name'])) {
            $build->where('tag_name', $params['tag_name'] . '%');
        }

        if (!empty($params['tag_type'])) {
            $build->whereIn('tag_type', $params['tag_type']);
        }

        if (!empty($params['tag_level'])) {
            $build->where('tag_level', '>=', $params['tag_level']);
        }

        if (!empty($params['tag_status'])) {
            $build->where('tag_status',$params['tag_status']);
        }

        if (!empty($params['is_series'])) {
            $build->where('is_series',$params['is_series']);
        }

        return $build;
    }
}
