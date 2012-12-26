phpHue
======

PHP scripts for interacting with the Phillips Hue lighting system on the command line.

hue.php contains functions for interacting with the system. Replace $bridge with your own hub's IP address. Then press your hub's center button and run register.php. That'll register your application and return you a key ID (big long hex string). Put that in the $key variable in hue.php.

Then check blink.php and rand.php for examples of interacting with hue.php. It uses the PEST php REST client for ease of communication, but as a client of the hue.php script, you don't need to worry about that.

colorset.php is a command line light changer. On the command line:

./colorset.php -l [lightnumber] -h [hue in degrees on the color circle 0-360] -s [saturation 0-254] -b [brightness 0-254] -t [white color temp 150-500]

All of these parameters are optional. If you don't specify a light, it'll set the values you specify on all of them (well... lamps numbered 1 through 3, currently).