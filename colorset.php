#!/usr/bin/php
<?php

require( 'hue.php' );

function echoHelp()
{
    echo "./colorset.php".
        "\n\t-i [Hue bridge's ip]".
        "\n\t-g [register a new key with the Hue bridge]".
        "\n\t-k [valid key that is registered with the Hue hub]".
        "\n\t-l [bulb number]".
        "\n\t-h [hue in degrees on the color circle 0-360]".
        "\n\t-s [saturation 0-254]".
        "\n\t-b [brightness 0-254]".
        "\n\t-t [white color temp 150-500]".
        "\n\t-o [0 for turning the bulb off, 1 for turning it on]".
        "\n\t-r [transition time, in seconds. Decimals are legal (\".1\", for instance)]".
        "\n\t-n [color name (see below)]\n";
}

$args = getopt( 'i:k:l:h:s:b:t:o:r:n:g' );
$oneParamSet = isset( $args['h'] ) || isset( $args['s'] ) || isset( $args['b'] ) || isset( $args['t'] ) || isset( $args['o'] ) || isset( $args['n'] );
$command = array();

if ( isset( $args['i'] ) && isset( $args['g'] ) )
{
    $hue = new Hue( $args['i'], '' );
    $data = json_decode( $hue->register(), true );

    if ( isset( $data[0]["error"] ) )
    {
        echo "Error: Registering new key with Hue bridge failed. Did you forget to press the link button?\n";
    }
    else if ( isset( $data[0]["success"] ) )
    {
        echo "Registered new key with Hue bridge: " .$data[0]["success"]["username"]. "\n";
        echo "You can now try to turn on a bulb like this:".
             "\n\n\t./colorset.php -i " .$args['i']. " -k " .$data[0]["success"]["username"]. " -o 1\n";
    }
    exit( 0 );
}

// we require a bridge ip and key to be specified
if ( !isset( $args['i'] ) || !isset( $args['k'] ) || !$oneParamSet )
{
    $oneParamHelp = $oneParamSet ? "" : " and at least one of the following options: -h, -s, -b, -t, -o or -n.";
    echo "Error: You need to specify an ip (-i) & key (-k)$oneParamHelp\n\n";

    echoHelp();
    exit( 0 );
}

$hue = new Hue( $args['i'], $args['k'] );

// if we didn't get a -l parameter, build an array of all lights
if ( isset( $args['l'] ) )
{
    $light = $args['l'];
}
else
{
    $light = $hue->getLightIds();
}

//handle predefined colors
if ( isset( $args['n'] ) )
{
    $command = $hue->predefinedColors( $args['n'] );
}

// clean up other inputs
// the hue interface will keep numeric parms within range for us, just sanitize the
// types for clean json encoding, and do the math on the hue input.
$fields = array( 'h' => 'hue', 's' => 'sat', 'b' => 'bri',
                 't' => 'ct', 'o' => 'on', 'r' => 'transitiontime' );

foreach ( $fields as $name => $value )
{
    if ( isset( $args[$name] ) )
    {
        if ( $name == 'o' )
        {
            $command[$value] = (bool)$args[$name];
        }
        else if ( $name == 'h' )
        {
            $command['hue'] = 182 * $args['h'];
            $command['on'] = true;
        }
        else if ($name == 'r')
        {
            $command['transitiontime'] = 10 * $args['r'];
        }
        else
        {
            $command[$value] = (int)$args[$name];
            $command['on'] = true;
        }
    }
}

echo $hue->setLight( $light, $command ) ."\n";

?>
