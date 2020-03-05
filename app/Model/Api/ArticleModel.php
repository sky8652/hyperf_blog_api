<?php

declare (strict_types=1);
namespace App\Model\Api;

use Hyperf\DbConnection\Model\Model;
/**
 */
class ArticleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_title',
        'article_desc',
        'article_img',
        'article_content',
        'article_type',
        'article_status',
        'article_count',
        'article_level',
        'tag_id',
        'is_recommend',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $appends = [
        'type_name',
        'status_name',
        'is_recommend_name'
    ];

    public static $tagTypeMapping = [
        1 => '免费',
        2 => '需登录',
        3 => '付费'
    ];

    public static $statusMapping = [
        1 => '显示',
        2 => '隐藏'
    ];

    public static $recommendMapping = [
        1 => '推荐',
        2 => '未推荐'
    ];

    public function tag()
    {
        return $this->hasOne(TagModel::class,'id','tag_id');
    }


    public function getTypeNameAttribute()
    {
        return self::$tagTypeMapping[$this->article_type];
    }

    public function getStatusNameAttribute()
    {
        if ( $this->article_status ) {
            return  self::$statusMapping[$this->article_status];
        }
        return '';
    }

    public function getIsRecommendNameAttribute()
    {
        return self::$recommendMapping[$this->is_recommend];
    }
}
