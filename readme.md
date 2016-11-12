# OctoberCMS Pusher Integration

## Installation
1. You must first install Pusher's PHP library:
https://github.com/pusher/pusher-http-php
2. Fill in the config values included with this plugin with your applicable Pusher credentails. You will need your Pusher Secret, Pusher appid, and Pusher key.
3. Create an OctoberCMS page (URL: http://yoursite.com/pusher/auth) with a blank layout and only add the AuthEndpoint component included with this plugin onto that page.
4. Include Pushers javascript library to your theme:
https://js.pusher.com/3.2/pusher.min.js

##Usage

* Use this JS to create a Pusher object:

        var pusher = new Pusher('YOUR_PUSHER_KEY_GOES_HERE', {
            encrypted: true
        });

* Use this JS to connect to a Pusher public channel and bind to an event:

        var channel = pusher.subscribe('PUBLIC_CHANNEL_NAME');
        channel.bind('test', function(data) {
            console.log("Test: " + data);
        });

* Use this JS to connect and authenticate a Pusher private channel and bind to an event:

        var privateChannel = pusher.subscribe("private-PRIVATE_CHANNEL_NAME");
        privateChannel.bind('test', function(data) {
            console.log("PRIVATE - test: " + data);
        });

* Use this JS to connect and authenticate a Pusher presence channel and bind to an event:

        var presenceChannel = pusher.subscribe('presence-PRESENCE_CHANNEL_NAME');
        presenceChannel.bind('test', function(data) {
            console.log("PRESENCE - test: " + data);
        });

* Use this PHP to trigger an event to a pusher channel:

        Pusher::init()->trigger($channel_name, $event_name, $data);
