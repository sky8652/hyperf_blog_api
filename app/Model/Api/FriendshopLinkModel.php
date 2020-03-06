<?php

declare (strict_types=1);
namespace App\Model\Api;

use Hyperf\DbConnection\Model\Model;
/**
 */
class FriendshopLinkModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'friendship_link';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'level',
        'created_at',
        'updated_at',
    ];

}