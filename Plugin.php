<?php namespace Clake\Pusher;

use Backend;
use System\Classes\PluginBase;

/**
 * pusher Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['Clake.UserExtended'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Pusher',
            'description' => 'Pusher plugin for OctoberCMS. It handles the authentication as well as triggering Pusher events.',
            'author'      => 'clake',
            'icon'        => 'icon-cloud-upload'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        //return []; // Remove this line to activate

        return [
            'Clake\Pusher\Components\AuthEndpoint' => 'AuthEndpoint',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate
    }

}
