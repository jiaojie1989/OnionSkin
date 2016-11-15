<?php
namespace OnionSkin;
require_once('src/CustomSmarty.class.php');
require_once('libs/lessc.inc.php');


class Bootstrap
{
	private $debug = false;
	
	public static $Smarty;	
	public static $DB;
	public static $Page;
	public static $User;
	public static $Config;
	
	public static function autoload($className)
	{
		$url = "src/".$className .".class.php";
		if(is_file($url))
			require_once($url);
	}
	
	public static function init()
	{
		spl_autoload_register("OnionSkin\Bootstrap::autoload");
		if(func_num_args()>0)
			$CONFIG = func_get_arg(0);
		else
			$CONFIG = parse_ini_file("config/configuration.ini",true);
		session_start();
		self::$Config=$CONFIG;
		self::$Smarty = new \CustomSmarty();
		self::$Smarty->assign("lng",Lang::LoadCZ());
		if(is_null($CONFIG) || $CONFIG['OnionSkin']['installed']!=1)
		{
			if(self::installedCheck())
			{
				self::fail(500);
			}
			else
				self::install();
		}
		self::$Smarty->error_reporting = E_ALL & ~E_NOTICE;
		self::$User = $_SESSION["User"];
		self::$Page = Bootstrap/Page::resolve(sanitize($_GET["url"]));
	}
	
	private static function install()
	{
		if(empty($_GET["url"]))
			$url="index";
		else
			$url=sanitize($_GET["url"]);
		switch($url)
		{
			case "install2": break;
			case "install3": break;
			default:
				$page =  new Install\DatabaseInstallPage();
				break;
		}
		$page->execute();
	}
	
	private static function installedCheck()
	{
		if(file_exists("src/OnionSkin/Install"))
		{
			return false;
		}
		return true;
	}
	
	public static function sanitize($var)
	{
		if(is_null($var))
			return $var;
		return trim(stripslashes(htmlspecialchars($var)));
	}
	
	public static function debug($var)
	{
		$this->$debug=$var;
		if($var)
		{
			error_reporting(3);
			ini_set('display_errors', TRUE);
			self::$Smarty->caching = 0; 
		}
		else
		{
			error_reporting(0);
			ini_set('display_errors', FALSE);
			self::$Smarty->caching = 3; 
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
	public static function setupLang()
	{
		
	}
	
	private static function ok($var)
	{
		$Page->execute($var);
	}
	static function fail($code)
	{
		die;
	}
	
	public static function  bakeCss()
	{
		$less = new \lessc;
		try {
			//$less->compileFile("styles/colorMain.less","styles/styleMain.css");
			$less->compileFile("styles/colorLight.less","styles/styleLight.css");
			//$less->compileFile("styles/colorDark.less","styles/styleDark.css");
		} catch (exception $e) {
			fail(502,$e->getMessage());
		}
	}
	
	static function checkRights()
	{
		return !$Page->RequireLogged || (!$Page->RequireAdmin && $Page->RequireLogged && $User->Logged) ||($Page->RequireAdmin && $User->Admin);
	}
	
}