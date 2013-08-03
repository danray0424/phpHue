#!/usr/bin/php
<?php

require( '../hue.php' );

$bridge = '192.168.0.162';
$key = "replace_this_with_the_real_key";
$hue = new Hue( $bridge, $key );
$light = 1;

$hue->setLight( $light, $hue->predefinedColors( 'green' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'red' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'blue' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'purple' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'pink' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'yellow' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'orange' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'coolwhite' ) );
sleep( 1 );
$hue->setLight( $light, $hue->predefinedColors( 'warmwhite' ) );
sleep( 1 );

?>
