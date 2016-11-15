<?php
require_once('src/OnionSkin/Bootstrap.class.php');

OnionSkin\Bootstrap::bakeCss();
OnionSkin\Bootstrap::init();
OnionSkin\Bootstrap::debug(true);
OnionSkin\Bootstrap::execute();