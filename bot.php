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

    if ($cf['bot']['channel'] != false)
        $ts3->clientMove($ts3->whoamiGet('client_id'), $cf['bot']['channel']);

    if ($ts3->whoamiGet('client_nickname') != $nickname)
        $ts3->selfUpdate(['client_nickname' => $nickname]);

    msg('Connected to: ' . $ts3->getProperty('virtualserver_name') . PHP_EOL);

    while (1) {
        $x = 1;
        $ts3->channelListReset();
        foreach ($ts3->channelGetById($cf['settings']['main_channel'])->subChannelList() as $channel) {

            $array = explode('. ', $channel['channel_name'], 2);

            if ($array[0] != $x || !is_numeric($array[0]) || !isset($array[1])) {

                $name = isset($array[1]) ? "$x. $array[1]" : "$x. $array[0]";

                if (mb_strlen($name) > 40)
                    $name = mb_substr($name, 0, (40 - mb_strlen($name)));

                $channel['channel_name'] = $name;

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
