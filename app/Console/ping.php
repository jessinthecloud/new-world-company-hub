<?php
# 
# in /public/examples/ping.php
# 

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;
use Discord\Parts\Permissions\ChannelPermission;
use Discord\Parts\Guild\Guild;

require __DIR__ . '/../../vendor/autoload.php';

/**
 * Example Bot with Discord-PHP
 *
 * When a User says "ping", the Bot will reply "pong"
 *
 * Run this example bot from main directory using command:
 * php public/examples/ping.php
 *
 * END POINTS INFO:
 * https://discord.com/developers/docs/resources/guild-scheduled-event#list-scheduled-events-for-guild
 * SCHEDULED EVENT OBJECT: 
 * https://discord.com/developers/docs/resources/guild-scheduled-event#guild-scheduled-event-object
 * 
 * Example request:
 *      List Scheduled Events for Guild
 *          GET/guilds/{guild.id}/scheduled-events
 *
 *      Returns a list of guild scheduled event objects for the given guild.
 *      Query String Params:
 *      Field	            Type	    Description
 *      ----------------    -------     ---------------------
 *      with_user_count?	boolean	    include number of users subscribed to each event
 * 
 * Bot Accounts vs User Accounts:
 * https://discord.com/developers/docs/topics/oauth2#bot-vs-user-accounts
 * 
 * Authentication: 
 * https://discord.com/developers/docs/reference#authentication
 * 
 * Bot auth url example: 
 * https://discord.com/api/oauth2/authorize?client_id=157730590492196864&scope=bot&permissions=1
 * 
 * HTTP API:
 * https://discord.com/developers/docs/reference#http-api
 * 
 * 
 * Sample:
 * https://discord.com/api/guilds/926272067488350269/scheduled-events
 * 
 * curl --location --request GET 'https://discord.com/api/guilds/926272067488350269/scheduled-events' \ 
 *      --header 'Authorization: Bot <Token>>'
 *                User-Agent: DiscordBot ($url, $versionNumber)
 */

// Create a $discord BOT
$discord = new Discord( [
    'token' => ''/* config('services.discord.bot_token'); */,
    // Put your Bot token here (https://discord.com/developers/applications/)
    'intents' => Intents::getDefaultIntents() | Intents::GUILD_MEMBERS , // default intents as well as guild members
] );

// When the Bot is ready
$discord->on( 'ready', function ( Discord $discord ) {
    
    $guild_id = '926272067488350269'; // Epwna's Dev Cave
//    $guild_id = '895006799319666718'; // Breakpoint
    
    echo "
    -- FINDING GUILD --
    ";
    // true means dont use cache
    $discord->guilds->fetch( $guild_id, true )->done( function ( Guild $guild ) {
        $guild->guild_scheduled_events->freshen()->done(function() use($guild) {
            echo "
            *~* 
            DUMPING EVENTS
            *~*
            ";
            // guild_scheduled_events
            print_r( $guild->guild_scheduled_events );
            echo "
            ===
            DONE
            ===
            ";
        });
    } );

    

    // Listen for messages
    $discord->on( 'message', function ( Message $message, Discord $discord ) use ( $guild_id ) {
        // If message is "ping" and not from a Bot
        if ( $message->content == 'ping' && !$message->author->bot ) {
            // Reply with "pong"
//            $message->reply( 'pong' );
        }
    } );
    /*$discord->on( Event::MESSAGE_CREATE, function ( Message $message, Discord $discord ) {
        if ( !$message->author->bot ) {
            $message->reply( ' Did you say "' . $message->content . '"?' );
        }
    } );*/
} );

// Start the Bot
$discord->run();
