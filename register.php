#!/usr/bin/php
<?php

require( 'hue.php' );

$bridge = '192.168.0.162';

$hue = new Hue( $bridge, '' );
echo $hue->register() ."\n";

?>
