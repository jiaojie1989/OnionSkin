<?php
require_once('src/OnionSkin/Bootstrap.class.php');
require_once('vendor/autoload.php');

OnionSkin\Bootstrap::init();        //Prepare database, configuration, sessions, etc.
OnionSkin\Bootstrap::debug(true);   //Debug mode
OnionSkin\Bootstrap::bakeCss();     //Comment this if you dont want to bake CSS everytime.
OnionSkin\Bootstrap::execute();     //Execute action.