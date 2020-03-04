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
        $settings = $this->getSettings();

        if (empty($settings)) {
            return SiteSetting::query()->create([
                'site_name'     => trim($params['site_name']),
                'site_desc'     => trim($params['site_desc']),
                'site_record'   => trim($params['site_record']),
                'site_icon'     => trim($params['site_icon']),
                'site_owner'    => trim($params['site_owner']),
            ]);
        } else {
            $settings->site_name    = trim($params['site_name']);
            $settings->site_desc    = trim($params['site_desc']);
            $settings->site_record  = trim($params['site_record']);
            $settings->site_icon    = trim($params['site_icon']);
            $settings->site_owner   = trim($params['site_owner']);
            return $settings->save();
        }
    }
}