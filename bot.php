<?php
require_once __DIR__ . '/libraries/TeamSpeak3/TeamSpeak3.php';
require __DIR__ . '/config.php';

TeamSpeak3::init();

msg('Bot Started');
msg('PHP ' . phpversion() . ' | TS3Lib ' . TeamSpeak3::LIB_VERSION);

$host     = $cf['bot']['host'];
$username = rawurlencode($cf['bot']['username']);
$password = rawurlencode($cf['bot']['password']);
$vport    = $cf['bot']['vport'];
$qport    = $cf['bot']['qport'];
$nickname = $cf['bot']['nickname'];

try {
    $uri = "serverquery://$username:$password@$host:$qport/?server_port=$vport&timeout=3&blocking=0";
    $ts3 = TeamSpeak3::factory($uri);

    if ($cf['bot']['channel'] != false) {
        $ts3->serverGetSelected()->clientMove($ts3->whoamiGet('client_id'), $cf['bot']['channel']);
    }

    if ($ts3->serverGetSelected()->whoamiGet('client_nickname') != $nickname) {
        $ts3->serverGetSelected()->selfUpdate(['client_nickname' => $nickname]);
    }

    msg('Connected to: ' . $ts3->serverGetSelected()->getProperty('virtualserver_name') . PHP_EOL);

    while (1) {
        $x = 1;
        $ts3->channelListReset();
        foreach ($ts3->channelGetById($cf['settings']['main_channel'])->subChannelList() as $channel) {

            $array = explode('. ', $channel['channel_name'], 2);

            if ($array[0] != $x || !is_numeric($array[0])) {

                if (isset($array[1])) {
                    $channel['channel_name'] = "$x. $array[1]";
                } else {
                    $channel['channel_name'] = "$x. {$channel['channel_name']}";
                }

            }

            $x++;
        }
        
        sleep($cf['settings']['interval']);
    }

} catch (TeamSpeak3_Exception $e) {
    msg($e->getCode() . ': ' . $e->getMessage());
}

function msg($msg = '') {
    echo '[' . date('d.m.Y H:i:s') . '] ' . $msg . PHP_EOL;
}
