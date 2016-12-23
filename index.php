<?php
require_once('src/OnionSkin/Engine.class.php');
require_once('vendor/autoload.php');

OnionSkin\Engine::init();        //Prepare database, configuration, sessions, etc.
OnionSkin\Engine::debug(true);   //Debug mode
//OnionSkin\Engine::bakeCss();     //Comment this if you dont want to bake CSS everytime.
OnionSkin\Engine::bakeJs();     //Comment this if you dont want to bake JS everytime.
//OnionSkin\Engine::bakeLanguageTypes();
OnionSkin\Engine::execute();     //Execute action.