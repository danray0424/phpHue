#!/usr/bin/php
<?php

require( '../hue.php' );

$bridge = '192.168.0.162';
$key = "replace_this_with_the_real_key";
$hue = new Hue( $bridge, $key );
$light = 1;

$hue->alertLight( $light, "lselect" );
sleep( 2 );
$hue->alertLight( $light, "none" );

?>
