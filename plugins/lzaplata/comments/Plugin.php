<?php namespace LZaplata\Comments;

use Backend;
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
            'name' => 'Comments',
            'description' => 'No description provided yet...',
            'author' => 'LZaplata',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
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
            'LZaplata\Comments\Components\Comment' => 'comment',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'lzaplata.comments.some_permission' => [
                'tab' => 'Comments',
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
            'comments' => [
                'label' => 'Comments',
                'url' => Backend::url('lzaplata/comments/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['lzaplata.comments.*'],
                'order' => 500,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function registerMailTemplates()
    {
        return [
            "templates" => [
                "lzaplata.comments::mail.add-comment"
            ],
        ];
    }
}
