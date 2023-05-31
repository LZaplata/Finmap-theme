<?php namespace LZaplata\BrokerTrust;

use Backend;
use LZaplata\BrokerTrust\Console\ImportPosts;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'BrokerTrust',
            'description' => 'Bridge for connecting BrokerTrust API',
            'author' => 'LZaplata',
            'icon' => 'icon-rss'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        $this->registerConsoleCommand("brokertrust.importposts", ImportPosts::class);
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            'LZaplata\BrokerTrust\Components\Posts' => 'posts',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'lzaplata.brokertrust.some_permission' => [
                'tab' => 'BrokerTrust',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'brokertrust' => [
                'label' => 'BrokerTrust',
                'url' => Backend::url('lzaplata/brokertrust/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['lzaplata.brokertrust.*'],
                'order' => 500,
            ],
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->command("brokertrust:importposts")->everyMinute();
    }
}
