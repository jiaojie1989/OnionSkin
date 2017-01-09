<?php
require_once('vendor/autoload.php');

function onionskin_autoload($className)
{
		$url = "src/".$className .".class.php";
		if(is_file($url))
			require_once($url);
}
spl_autoload_register("onionskin_autoload");