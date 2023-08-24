<?php namespace Concreta\Shorturl;

use App;
use Backend;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name' => 'concreta.shorturl::lang.plugin.name',
            'description' => 'concreta.shorturl::lang.plugin.description',
            'author' => 'Luca Benati',
            'icon' => 'wn-icon-link',
            'homepage' => 'https://concreta09.com',
        ];
    }

    public function registerNavigation()
    {
        return [
            'shorturl-mainmenu' => [
                'label'       => 'Short URL',
                'url'         => Backend::url('concreta/shorturl/shorturlcontroller'),
                'icon'        => 'wn-icon-link',
                'permissions' => ['concreta.shorturl.*'],
                'order'       => 500,
                'sideMenu' => [
                    'shorturl-sidemenu-shorturls' => [
                        'label'       => 'Short URL',
                        'icon'        => 'wn-icon-link',
                        'url'         => Backend::url('concreta/shorturl/shorturlcontroller'),
                        'permissions' => ['concreta.shorturl.*'],
                    ],
                ],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'concreta.shorturl.manage' => [
                'label' => 'Edit shorthurls',
                'tab' => 'URL shortener',
                'order' => 200,
                'roles' => []
            ],
        ];
    }

    public function boot()
    {
        $this->registerShortURLProvider();
    }

    public function registerShortURLProvider()
    {
       $aliasLoader = AliasLoader::getInstance();
       App::register(\Concreta\ShortURL\Providers\ShortURLProvider::class);
       $aliasLoader->alias('ShortURLBuilder', \Concreta\ShortURL\Facades\ShortURLBuilder::class);
    }
}
