#!/usr/bin/php
<?php

require( 'hue.php' );

$bridge = '192.168.0.162';
$key = "replace_this_with_the_real_key";
$hue = new Hue( $bridge, $key );

$args = getopt( 'l:h:s:b:t:o:r:n:' );
$command = array();

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
