phpHue
======

PHP scripts for interacting with the Phillips Hue lighting system on the command line.

Getting Started
---------------

hue.php contains functions for interacting with the system. Replace $bridge with your own hub's IP address. Then press your hub's center button and run register.php. That'll register your application and print out for you a key ID (big long hex string). Put that in the $key variable in hue.php.

Then check blink.php and rand.php for examples of interacting with hue.php. It uses the PEST php REST client for ease of communication, but as a client of the hue.php script, you don't need to worry about that.

colorset.php
------------

colorset.php is a command line light changer. On the command line:

	./colorset.php 
		-l [lightnumber] 
		-h [hue in degrees on the color circle 0-360] 
		-s [saturation 0-254] 
		-b [brightness 0-254] 
		-t [white color temp 150-500] 
		-o [on or off, 0-1 or something else that will cast to a boolean]
		-r [transition time, in seconds. Decimals legal (".1", for instance)]

All parameters are optional. If you don't specify a light, it'll set the values you specify on all of them.

You can turn lights on or off with the -o switch. Any other parameter implies '-o true'. In other words, if you specify another parameter while the lamp is off, we'll turn it on for you. Not sure what happens if you say '-h 90 -o false', you're on your own there.

TODO: xy mode, refactor the parameter cleanup business into hue.php.


Other Notes
-----------

Note that this is a totally quick-and-dirty batch of scripts I've tossed together here. If anyone wants to properly OO-ify these, that'd be awesome and I look forward to your pull request.

MUCH thanks to Ross McKillop (http://rsmck.co.uk/hue) and the fine folks at http://everyhue.com.
