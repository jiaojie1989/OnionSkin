<?php
require_once('src/OnionSkin/Engine.class.php');
require_once('vendor/autoload.php');

use OnionSkin\Engine;
use OnionSkin\Routing\Request;

Engine::Init();        //Prepare database, configuration, sessions, etc.
Engine::Debug(true);   //Debug mode
//Engine::BakeCss();     //Comment this if you dont want to bake CSS everytime.
Engine::BakeJs();     //Comment this if you dont want to bake JS everytime.
//Engine::BakeLanguageTypes();
Engine::Execute(Request::Current());     //Execute action.