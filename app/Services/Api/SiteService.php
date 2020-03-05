<?php


namespace App\Services\Api;


use App\Model\Api\SiteSetting;

class SiteService
{
    public function getSettings()
    {
        return SiteSetting::query()->first();
    }

    public function save($params)
    {
        $settings    = $this->getSettings();
        $siteName    = $params['site_name'];
        $site_desc   = $params['site_desc'];
        $site_record = $params['site_record'];
        $site_icon   = $params['site_icon'];
        $site_owner  = $params['site_owner'];
        $site_notice = $params['site_notice'];

        if (empty($settings)) {
            return SiteSetting::query()->create([
                'site_name'     => $siteName,
                'site_desc'     => $site_desc,
                'site_record'   => $site_record,
                'site_icon'     => $site_icon,
                'site_owner'    => $site_owner,
                'site_notice'   => $site_notice,
            ]);
        } else {
            $settings->site_name   = $siteName;
            $settings->site_desc   = $site_desc;
            $settings->site_record = $site_record;
            $settings->site_icon   = $site_icon;
            $settings->site_owner  = $site_owner;
            $settings->site_notice  = $site_notice;
            return $settings->save();
        }
    }
}