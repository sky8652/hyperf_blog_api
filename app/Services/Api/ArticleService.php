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
use Hyperf\Database\Query\Builder;

class ArticleService
{

    /**
     * @param $params
     * 后台展示使用
     * @return mixed
     */
    public function list($params)
    {
        $tagBuild = ArticleModel::query()->with('tag')->orderBy('is_recommend')->orderByDesc('article_level');

        $tagBuild = $this->buildWhere($params,$tagBuild);

        return $tagBuild->paginate(10);
    }

    /**
     * @param $tagId
     * 前端显示使用
     * @return \Hyperf\Contract\LengthAwarePaginatorInterface
     */
    public function homeArticles($tagId) {
        return ArticleModel::query()->where('tag_id', $tagId)
            ->where('article_status', 1)
            ->orderBy('is_recommend')
            ->orderByDesc('article_level')
            ->orderByDesc('id')
            ->select(['id', 'article_title', 'article_type', 'article_count', 'is_recommend', 'created_at'])
            ->paginate(10);

    }

    /**
     * @param $id
     * 查看文章，阅读数增加
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function row($id)
    {
        $article = ArticleModel::query()->with('tag')->where('id',$id)->first();
        $article->article_count = $article->article_count+1;
        $article->save();
        return $article;
    }

    /**
     * @param $title
     * 检测是否存在相同标题
     * @return bool
     */
    protected function hasSameTitle($title)
    {
        return ArticleModel::query()->where('article_title',$title)->count() > 0;
    }

    /**
     * @param $params
     * 保存或者编辑文章
     * @return bool
     */
    public function save($params)
    {
        $id = $params['id'] ?? 0;

        if ($id) {
            $article = ArticleModel::query()->where('id',$id)->first();
            if( $article->article_title != $params['article_title'] && $this->hasSameTitle($params['article_title']) ) {
                throw new WrongRequestException("已存在该标题!");
            }
        } else {
            if ( $this->hasSameTitle($params['article_title']) ) {
                throw new WrongRequestException("已存在该标题!");
            }
            $article = new ArticleModel();
        }

        $article->article_title   = $params['article_title'];
        $article->article_desc    = $params['article_desc'];
        $article->article_content = $params['article_content'];
        $article->article_type    = $params['article_type'];
        $article->article_status  = $params['article_status'];
        $article->article_level   = $params['article_level'];
        $article->tag_id          = $params['tag_id'];
        $article->is_recommend    = $params['is_recommend'];

        return $article->save();
    }

    /**
     * @param $articleId
     * 删除文章
     * @return int|mixed
     */
    public function delete($articleId)
    {
        return ArticleModel::query()->where('id',$articleId)->delete();
    }


    /**
     * 获取阅读量前5的文章
     * @return \Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection
     */
    public function mostReadingArticles()
    {
        return ArticleModel::query()->where('article_status',1)
                                    ->orderByDesc('article_count')
                                    ->orderByDesc('article_level')
                                    ->orderByDesc('id')
                                    ->limit(5)
                                    ->get(['id','article_title','article_count']);
    }

    /**
     * 获取最新的5篇文章
     * @return \Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection
     */
    public function newestArticles()
    {
        $articles = ArticleModel::query()
            ->where('article_status',1)
            ->orderByDesc('id')
            ->limit(5)
            ->get(['id','article_title','created_at']);
        $articles->each(function ($row) {
            $row->minus_time = $this->formatDate(strtotime($row->created_at));
        });

        return $articles;
    }

    /**
     * @param $time
     * 计算距离多长时间
     * @return string
     */
    function formatDate($time){
        $t=time()-$time;
        $f=array(
            '31536000'=>'年',
            '2592000'=>'个月',
            '604800'=>'星期',
            '86400'=>'天',
            '3600'=>'小时',
            '60'=>'分钟',
            '1'=>'秒'
        );
        foreach ($f as $k=>$v)    {
            if (0 != $c = floor($t/(int)$k)) {
                return $c.$v.'前';
            }
        }
    }

    /**
     * 获取时间线
     * @return \Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection
     */
    public function timeline()
    {
        $articles = ArticleModel::query()->where('article_status',1)
                                    ->orderByDesc('id')
                                    ->get(['id','article_title','created_at']);
        $articles->each(function ($row) {
            $row->minus_time = $this->formatDate(strtotime($row->created_at));
        });

        return $articles;
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
