#!/usr/bin/php
<?php

require( '../hue.php' );

$bridge = '192.168.0.162';
$key = "replace_this_with_the_real_key";
$hue = new Hue( $bridge, $key );
$light = 1;

$hue->setLight( $light, predefinedColors( 'green' ) );
sleep( 1 );
$hue->setLight( $light, predefinedColors( 'red' ) );
sleep( 1 );
$hue->setLight( $light, predefinedColors( 'blue' ) );
sleep( 1 );
$hue->setLight( $light, predefinedColors( 'purple' ) );
sleep( 1 );
$hue->setLight( $light, predefinedColors( 'coolwhite' ) );
sleep( 1 );
$hue->setLight( $light, predefinedColors( 'warmwhite' ) );
sleep( 1 );

?>
