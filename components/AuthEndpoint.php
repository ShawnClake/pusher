<?php namespace Clake\Pusher\Components;

use Clake\Pusher\Classes\Pusher;
use Cms\Classes\ComponentBase;

class AuthEndpoint extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'AuthEndpoint',
            'description' => 'Provides an endpoint for an API call via Pusher'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * When a page is loaded with the component attached it will return the result of the
     * authentication process.
     * This handles both private and presence channel authentications.
     */
    public function onRun()
    {
        $channelName = post('channel_name');
        $socketId = post('socket_id');
        Pusher::init()->auth($channelName, $socketId);
    }

}