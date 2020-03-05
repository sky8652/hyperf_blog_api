<?php

declare (strict_types=1);
namespace App\Model\Api;

use Hyperf\DbConnection\Model\Model;
/**
 */
class SiteSetting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_settings';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_name',
        'site_desc',
        'site_icon',
        'site_record',
        'site_owner',
        'site_notice',
        'created_at',
        'updated_at',
    ];

    public $appends = [
        'site_icon_url'
    ];

    public function getSiteIconUrlAttribute() {
        return env('IMG_HOST').$this->site_icon;
    }
}