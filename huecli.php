#!/usr/bin/php
<?php

require( 'hue.php' );

function echoHelp()
{
    echo "./huecli.php".
        "\n\t-i [Hue bridge's ip]".
        "\n\t-g [register a new key with the Hue bridge]".
        "\n\t-k [valid key that is registered with the Hue hub]".
        "\n\t-f [fetch full state from Hue hub]".
        "\n\t-l [light number]".
        "\n\t-c [check light state: returns 0 when light is off, 1 when on]".
        "\n\t-h [hue in degrees on the color circle 0-360]".
        "\n\t-s [saturation 0-254]".
        "\n\t-b [brightness 0-254]".
        "\n\t-t [white color temp 150-500]".
        "\n\t-o [0 for turning the light off, 1 for turning it on]".
        "\n\t-r [transition time, in seconds. Decimals are legal (\".1\", for instance)]".
        "\n\t-n [color name (see below)]\n";
}

function echoLightState( $lights )
{
    global $hue;
    $names = $hue->lightName( $lights );
    $state = '';

    foreach ( $lights as $light )
    {
        $state = $hue->isLightOn( $light );
        echo "Light " .$light. " (" .$names[$light]. ") is " . ( $state ? "on" : "off" ) . "\n";
    }

    return $state;
}

$args = getopt( 'i:k:l:h:s:b:t:o:r:n:cfg' );
$oneParamSet = isset( $args['h'] ) || isset( $args['s'] ) || isset( $args['b'] ) || isset( $args['t'] ) || isset( $args['o'] ) || isset( $args['n'] ) || isset( $args['f'] ) || isset( $args['c'] );
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
        echo "You can now try to turn on a light like this:".
             "\n\n\t./huecli.php -i " .$args['i']. " -k " .$data[0]["success"]["username"]. " -o 1\n";
    }
    exit( 0 );
}

// we require a bridge ip and key to be specified
if ( !isset( $args['i'] ) || !isset( $args['k'] ) || !$oneParamSet )
{
    $oneParamHelp = $oneParamSet ? "" : " and at least one of the following options: -f, -c, -h, -s, -b, -t, -o or -n";
    echo "Error: You need to specify an ip (-i) & key (-k)$oneParamHelp.\n\n";

    echoHelp();
    exit( 0 );
}

$hue = new Hue( $args['i'], $args['k'] );

// do we want to set ot get the bridge's state
if ( isset( $args['f'] ) )
{
    $state = $hue->state();
    var_dump( $state );
    exit( 0 );
}

// if we didn't get a -l parameter, build an array of all lights
$lights = array();
if ( !isset( $args['l'] ) )
    $lights = $hue->lightIds();
else
    $lights[] = $args['l'];

// do we want to get the lights' state
if ( isset( $args['c'] ) )
{
    $state = echoLightState( $lights );
    exit( ( count( $lights ) == 1 && $state ) ? 1 : 0 );
}

// handle predefined colors
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
        else if ( $name == 'r' )
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

$hue->setLight( $lights, $command );
echoLightState( $lights );

?>
