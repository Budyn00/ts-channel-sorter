<?php
$cf['bot'] = [
    'host' => '127.0.0.1',
    'username' => 'franta',
    'password' => '9oB2odwh',
    'vport' => 9987,
    'qport' => 10011,
    'nickname' => 'channel counter',
    'channel' => 1, //after connect bot switch to this channel | false to disable this feature
];

$cf['settings'] = [
    'interval' => 10,
    'main_channel' => [60021, 60020], //parent channel of sub-channels that will be sorted
    'separator' => '. ' //{number}. {channel}
];