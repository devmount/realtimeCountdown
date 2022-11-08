realtimeCountdown
=================

A Plugin for moziloCMS 2.0

Generates a countdown, that counts down in realtime.

## Installation
#### With moziloCMS installer
To add (or update) a plugin in moziloCMS, go to the backend tab *Plugins* and click the item *Manage Plugins*. Here you can choose the plugin archive file (note that it has to be a ZIP file with exactly the same name the plugin has) and click *Install*. Now the realtimeCountdown plugin is listed below and can be activated.

#### Manually
Installing a plugin manually requires FTP Access.
- Upload unpacked plugin folder into moziloCMS plugin directory: ```/<moziloroot>/plugins/```
- Set default permissions (chmod 777 for folders and 666 for files)
- Go to the backend tab *Plugins* and activate the now listed new realtimeCountdown plugin

## Syntax
```
{realtimeCountdown|<date>|<wrap>|<after>}
```
Inserts the countdown.

1. Parameter ```<date>```: The specific date, to count down to, with format ```YYYY M D h m s``` (e.g. ```2099 12 31 12 0 0``` means the 31st december 2099, 12:00:00)
2. Parameter ```<wrap>```: Wrapper text for the countdown. The placeholder for the countdown are 3 dashes: ```---``` (e.g. "The game starts in --- and lasts 2 hours.")
3. Parameter ```<after>```: Text to display, after countdown ended.

## License
This Plugin is distributed under *GNU General Public License, Version 3* (see LICENSE) or, at your choice, any further version.

## Documentation
A detailed documentation and demo can be found here:  
https://github.com/devmount-mozilo/realtimeCountdown/wiki/Dokumentation

---

This project is completely free to use. If you enjoy it and don't have the time to contribute, please consider [donating via Paypal](https://paypal.me/devmount) or [sponsoring me](https://github.com/sponsors/devmount) to support further support and development. :green_heart:
