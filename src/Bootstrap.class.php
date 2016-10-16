<?php
require_once('src/CustomSmarty.class.php');
require_once('libs/lessc.inc.php');

namespace OnionSkin;

class Bootstrap
{
	private $debug = false;
	
	const Smarty;	
	const Page;
	const User;
	
	
	
	function static function init()
	{
		session_start();
		error_reporting(0);
		ini_set('display_errors', FALSE);
		self::Smarty = new CustomSmarty();
		self::Smarty->error_reporting = E_ALL & ~E_NOTICE;
		self::User = $_SESSION["User"];
		self::Page = Bootstrap/Page::resolve(sanitize($_GET["url"]));
	}
	public static function sanitize($var)
	{
		return trim(stripslashes(htmlspecialchars($var)));
	}
	
	public static function debug($var)
	{
		$this->$debug=$var;
		if($var)
		{
			error_reporting(3);
			ini_set('display_errors', TRUE);
			self::Smarty->caching = 0; 
		}
		else
		{
			error_reporting(0);
			ini_set('display_errors', FALSE);
			self::Smarty->caching = 3; 
		}
	}
	
	
	public static function execute()
	{
		if(!checkRights())
			fail(403);
		if(!$Page->modelSanitation())
			fail(401);
		if($debug)
			bakeCss();
		setupLang();
		
		ok();
	}
	function static setupLang()
	{
		
	}
	
	function static ok($var)
	{
		$Page->execute($var);
	}
	function static fail($code)
	{
		die;
	}
	
	function static bakeCss()
	{
		$less = new lessc;
		try {
			$less->compileFile("styles/colorMain.less","styles/styleMain.css");
		} catch (exception $e) {
			fail(502,$e->getMessage());
		}
	}
	
	function static checkRights()
	{
		return !$Page->RequireLogged || (!$Page->RequireAdmin && $Page->RequireLogged && $User->Logged) ||($Page->RequireAdmin && $User->Admin);
	}
	
}