#!/usr/bin/php
<?php

require( '../hue.php' );

$bridge = '192.168.0.162';
$key = "replace_this_with_the_real_key";
$hue = new Hue( $bridge, $key );
$lightRange = [ 4, 5 ];

while ( true )
{
    $target = rand( $lightRange[0], $lightRange[1] );
    $uhe->setLight( $target, getRandomColor() );
    usleep( 100000 );
}
?>
