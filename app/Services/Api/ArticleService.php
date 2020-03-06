<?php
/**
 *
 * User: xiaowei<13177839316@163.com>
 * Date: 2020/1/20
 * Time: 15:00
 */

namespace App\Services\Api;


use App\Model\Api\ArticleModel;
use Hyperf\Database\Query\Builder;

class ArticleService
{

    public function list($params)
    {
        $tagBuild = ArticleModel::query()->with('tag')->orderBy('is_recommend')->orderByDesc('article_level');

        $tagBuild = $this->buildWhere($params,$tagBuild);

        return $tagBuild->paginate(10);
    }

    public function homeArticles($tagId) {
        return ArticleModel::query()->where('tag_id', $tagId)
            ->where('article_status', 1)
            ->orderBy('is_recommend')
            ->orderByDesc('article_level')
            ->orderByDesc('created_at')
            ->select(['id', 'article_title', 'article_type', 'article_count', 'is_recommend', 'created_at'])
            ->paginate(10);

    }

    public function row($id)
    {
        $article = ArticleModel::query()->with('tag')->where('id',$id)->first();
        $article->article_count = $article->article_count+1;
        $article->save();
        return $article;
    }


    public function save($params)
    {
        $where = ['id'=>$params['id'] ?? 0];
        $attr  = [
            'article_title'   => trim($params['article_title']),
            'article_desc'    => $params['article_desc'],
            'article_img'     => $params['article_img'] ?? '',
            'article_content' => $params['article_content'],
            'article_type'    => $params['article_type'],
            'article_status'  => $params['article_status'],
            'article_level'   => $params['article_level'],
            'tag_id'          => $params['tag_id'],
            'is_recommend'    => $params['is_recommend'],
        ];
        return ArticleModel::query()->updateOrCreate($where, $attr);
    }

    public function delete($articleId)
    {
        return ArticleModel::query()->where('id',$articleId)->delete();
    }

    /**
     * @param $params
     * @param $build Builder
     *
     * @return mixed
     */
    public function buildWhere($params,$build)
    {
        if (!empty($params['article_title'])) {
            $build->where('article_title',$params['article_title'].'%');
        }

        if (!empty($params['article_type'])) {
            $build->whereIn('article_type',$params['article_type']);
        }

        if (!empty($params['article_status'])) {
            $build->whereIn('article_status',$params['article_status']);
        }

        if (!empty($params['tag_id'])) {
            $build->whereIn('tag_id',$params['tag_id']);
        }

        if (!empty($params['article_level'])) {
            $build->where('article_level',$params['article_level']);
        }

        if (!empty($params['is_recommend'])) {
            $build->where('is_recommend',$params['is_recommend']);
        }

        if (!empty($params['created_at']) && is_array($params['created_at'])) {
            $build->where('created_at','>=',$params['created_at'][0]);
            $build->where('created_at','<=',$params['created_at'][1]);
        }

        return $build;
    }
}
