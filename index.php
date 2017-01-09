<?php
require_once('src/onionskin_autoload.php');

use OnionSkin\Engine;
use OnionSkin\Routing\Request;

Engine::Debug(true);   //Debug mode
Engine::Init();        //Prepare database, configuration, sessions, etc.
Engine::BakeCss();     //Comment this if you dont want to bake CSS everytime.
Engine::BakeJs();     //Comment this if you dont want to bake JS everytime.
//Engine::BakeLanguageTypes(); //Develop only. Try to determinate which languages can be highlighted in hightlight.js
Engine::Execute(Request::Current());     //Execute action.