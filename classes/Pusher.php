<?php namespace Clake\Pusher\Classes;

use Clake\UserExtended\Classes\UserUtil;
use Config;

class Pusher
{

    private $key; // Pusher key
    private $secret; // Pusher secret
    private $appid; // Pusher appid
    private $options = []; // Pusher options
    private $pusher; // Pusher instance

    /**
     * Creates an instance of Pusher using config values, then returns the instance.
     * Enables us to use the builder pattern
     * @return static
     */
    public static function init()
    {
        $o = new static();
        $o->key = Config::get('clake.pusher::key');
        $o->secret = Config::get('clake.pusher::secret');
        $o->appid = Config::get('clake.pusher::appid');
        array_push($o->options, 'encrypted', Config::get('clake.pusher::encrypted'));
        $o->pusher = new \Pusher($o->key, $o->secret, $o->appid, $o->options);
        return $o;
    }

    /**
     * Returns the pusher instance
     * @return mixed
     */
    public function get()
    {
        return $this->pusher;
    }

    /**
     * Handles the presence and private channel authentications
     * @param $channelName
     * @param $socketId
     * @return $this
     */
    public function auth($channelName, $socketId)
    {
        $auth = true; // Whether the authentication is a success or not

        if(!UserUtil::getLoggedInUser()) // If we aren't logged in, then auth obviously fails
            $auth = false;

        // Allows an extra check for allowing every logged in user to have their own channel
        // Format looks like: private-userchannel1 where 1 is their user ID.
        if(strlen($channelName) > 19 && substr($channelName,8,11) == "userchannel")
            if(!(substr($channelName,19) == UserUtil::getLoggedInUser()->id))
                $auth = false;

        if($auth == true && substr($channelName, 0, 8) == "presence")
            $this->allowPresence($channelName, $socketId); // Redirects to the presence channel auth
        else if($auth == true && substr($channelName, 0, 7) == "private")
            $this->allowPrivate($channelName, $socketId); // Redirects to the private channel auth
        else
            $this->reject(); // Otherwise Authentication failed

        return $this;
    }

    /**
     * Trigger a pusher event
     * @param $channel
     * @param $event
     * @param $data
     * @return $this
     */
    public function trigger($channel, $event, $data)
    {
        $this->pusher->trigger($channel, $event, $data, post('socket_id'));
        return $this;
    }

    /**
     * Reject a pusher authentication API request
     */
    private function reject()
    {
        header('', true, 403);
        echo "Forbidden";
    }

    /**
     * Allow a private channel authentication API request
     * @param $channelName
     * @param $socketId
     */
    private function allowPrivate($channelName, $socketId)
    {
        echo $this->pusher->socket_auth($channelName, $socketId);
    }

    /**
     * Allow a presence channel authentication
     * @param $channelName
     * @param $socketId
     */
    private function allowPresence($channelName, $socketId)
    {
        echo $this->pusher->presence_auth($channelName, $socketId, UserUtil::getLoggedInUser()->id, UserUtil::getLoggedInUser()->toArray());

    }

}