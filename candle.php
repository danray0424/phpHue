#!/usr/bin/php
<?php

require "hue.php";

while (true) {
	$target = rand(1,3);
	$command = array('ct' => rand(350,500), 'bri' => rand(25,75));
	setLight($target, $command);
	usleep(100000);
}