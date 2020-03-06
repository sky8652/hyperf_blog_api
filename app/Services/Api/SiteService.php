<?php


namespace App\Services\Api;


use App\Exception\WrongRequestException;
use App\Model\Api\FriendshopLinkModel;
use App\Model\Api\SiteSettingModel;

class SiteService
{
    public function getSettings()
    {
        return SiteSettingModel::query()->first();
    }

    public function friendLinks() {
        return FriendshopLinkModel::query()->get();
    }


    public function saveFriendLink($params) {

        $where = ['id'=>$params['id'] ?? 0];
        $attr  = [
            'name'  => $params['name'],
            'link'  => $params['link'],
            'level' => $params['level'],
        ];
        return FriendshopLinkModel::query()->updateOrCreate($where, $attr);
    }

    public function deleteFriendLink($id) {
        return FriendshopLinkModel::query()->where('id',$id)->delete();
    }

    public function save($params)
    {
        $settings        = $this->getSettings();
        $siteName        = $params['site_name'];
        $site_desc       = $params['site_desc'];
        $site_record     = $params['site_record'];
        $site_icon       = $params['site_icon'];
        $site_owner      = $params['site_owner'];
        $site_owner_desc = $params['site_owner_desc'];
        $site_notice     = $params['site_notice'];

        if (empty($settings)) {
            return SiteSettingModel::query()->create([
                'site_name'       => $siteName,
                'site_desc'       => $site_desc,
                'site_record'     => $site_record,
                'site_icon'       => $site_icon,
                'site_owner'      => $site_owner,
                'site_owner_desc' => $site_owner_desc,
                'site_notice'     => $site_notice,
            ]);
        } else {
            $settings->site_name       = $siteName;
            $settings->site_desc       = $site_desc;
            $settings->site_record     = $site_record;
            $settings->site_icon       = $site_icon;
            $settings->site_owner      = $site_owner;
            $settings->site_owner_desc = $site_owner_desc;
            $settings->site_notice     = $site_notice;
            return $settings->save();
        }
    }
}