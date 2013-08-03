phpHue
======

PHP class for interacting with the Philips Hue lighting system

Getting Started
---------------

hue.php contains the entire phpHue class and all its functions for interacting with the Hue hub.

Check out the "samples" directory. You'll find a few demos, showing you how to interact with phpHue. It uses the PEST php REST client for ease of communication, but as a user of phpHue, you don't need to worry about the details.

huecli.php
------------

huecli.php is a command line light changer. On the command line:

    ./huecli.php
        -i [Hue bridge's ip]
        -g [register a new key with the Hue bridge]
        -k [valid key that is registered with your Hue hub]
        -f [fetch full state from Hue hub]
        -l [bulb number]
        -h [hue in degrees on the color circle 0-360]
        -s [saturation 0-254]
        -b [brightness 0-254]
        -t [white color temp 150-500]
        -o [0 for turning the bulb off, 1 for turning it on]
        -r [transition time, in seconds. Decimals are legal (".1", for instance)]
        -n [color name (see below)]

You need to specify an ip (-i), a key (-k) and at least one of the following options: -h, -s, -b, -t, -o or -n. If you don't specify a light, it'll set the values you specify on all of them.

If you don't have a key yet, you can register one by calling huecli.php with -g.

You can turn lights on or off with the -o switch. Any other parameter implies '-o 1'. In other words, if you specify any other parameter when the lamp is off, we'll turn it on for you.

### Presets ###

The '-n' switch takes a one-word name for a color, and sets the selected lights to that color. It has a small list of predefined color names, and simply doesn't do anything if you give it a string it doesn't know. It currently knows red, blue, purple, green, coolwhite, and warmwhite. A '-n' parameter may be overridden in part by other parameters. For instance, "-n red -s 50" will give you a pastel red, and "-n blue -r 10" will produce a 10-second fade to blue. Note that "-n red -h 200" will override the redness of the red command with a hue of 200, which is purpleish, but it will inherit the full saturation and brightness of the "red" preset.

Other Notes
-----------

I'm choosing not to deal with xy mode in this set of scripts at this time. Frankly, I just don't understand the color gamut layout as intuitively as I do the hsb model, and so it's way harder to work with. I understand there are also mapping difficulties between the real xy color space and the gamut range the Hue can render. So for now I'm leaving that alone (though the data interface would be extremely simple to write).

MUCH thanks to Ross McKillop (http://rsmck.co.uk/hue) and the fine folks at http://everyhue.com.
