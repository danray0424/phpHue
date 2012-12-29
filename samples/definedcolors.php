#!/usr/bin/php
<?php

require('hue.php');

setLight(2, predefinedColors('green'));
sleep(1);
setLight(2, predefinedColors('red'));
sleep(1);
setLight(2, predefinedColors('blue'));
sleep(1);
setLight(2, predefinedColors('purple'));
sleep(1);
setLight(2, predefinedColors('coolwhite'));
sleep(1);
setLight(2, predefinedColors('warmwhite'));
sleep(1);

?>