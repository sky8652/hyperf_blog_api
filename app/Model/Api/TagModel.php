<?php

declare (strict_types=1);
namespace App\Model\Api;

use Hyperf\DbConnection\Model\Model;
/**
 */
class TagModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag_name',
        'tag_type',
        'tag_level',
        'tag_status',
        'created_at',
        'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $appends = [
        'tag_type_name',
        'status_name'
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

    public function getTagTypeNameAttribute()
    {
        return self::$tagTypeMapping[$this->tag_type];
    }

    public function getStatusNameAttribute()
    {
        return self::$statusMapping[$this->tag_status];
    }


}
