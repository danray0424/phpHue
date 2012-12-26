#!/usr/bin/php
<?php

require("hue.php");

while (true) {
	$target = rand(1,3);
	//$data = json_encode(array('hue' => 182 * 90, 'sat' => 254));
	setLight($target, getRandomColor());
	echo "\n";
	usleep(100000);
}
?>