#!/usr/bin/php
<?php

require("hue.php");

while (true) {
	$target = rand(1,3);
	setLight($target, getRandomColor());
	usleep(100000);
}
?>