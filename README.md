
# TeamSpeak channel counter [![GitHub license](https://img.shields.io/github/license/Ondra3211/ts-channel-counter)](https://github.com/Ondra3211/ts-channel-counter/blob/master/LICENSE)

| Gif #1 | Gif #2 |
| ------------- | ------------- |
| ![gif #1](https://i.zerocz.eu/ja/0t5VSM3to3.gif)  | ![gif #2](https://i.zerocz.eu/ja/lqpEULMlEb.gif)  |

## Installation
**Requirements**
* PHP 7.x, `mbstring`
* TeamSpeak Server - v3.4.0 (build >= 1536564584) or higher.
* Install the TS3 PHP Framework by [manually downloading](https://github.com/ronindesign/ts3phpframework/archive/master.zip) it or using Composer:
```
composer require planetteamspeak/ts3-php-framework
```  
* Channels **must be** as subsubchannels!

## Usage
```
screen -AmdS tsbot php bot.php
```

## Configuration
```php
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
    'separator' => '. ' //EXAMPLE: {number}. {channel}
];
```
