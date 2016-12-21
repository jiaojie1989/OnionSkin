<?php
namespace OnionSkin;


class Bootstrap
{
	private static $debug = false;

	/**
	 * @var \Smarty
	 */
	public static $Smarty;
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	public static $DB;
	/**
	 * @var mixed
	 */
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
        $dbconf= \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src",self::$debug));
        self::$DB=\Doctrine\ORM\EntityManager::create($CONFIG["Database"],$dbconf);
        $CONFIG["Database"]=null;
		self::$Config=$CONFIG;
		self::$Smarty = new \Smarty();
        self::$Smarty->setTemplateDir('templates/');
        self::$Smarty->setCompileDir('templates_c/');
        self::$Smarty->setConfigDir('configs/');
        self::$Smarty->setCacheDir('cache/');
        self::$Smarty->caching = \Smarty::CACHING_LIFETIME_CURRENT;
        self::$Smarty->assign('app_name', 'OnionSkin');
		self::$Smarty->assign("lng",Lang::LoadCZ());
		self::$Smarty->error_reporting = E_ALL & ~E_NOTICE;
		self::$User = $_SESSION["User"];
		self::$Page = Page::resolve(self::sanitize($_GET["url"]));
	}



	public static function sanitize($var)
	{
		if(is_null($var))
			return $var;
		return trim(stripslashes(htmlspecialchars($var)));
	}

	public static function debug($var)
	{
		self::$debug = $var;
		if($var)
		{
			error_reporting(3);
			ini_set('display_errors', TRUE);
			self::$Smarty->caching = false;
		}
		else
		{
			error_reporting(0);
			ini_set('display_errors', FALSE);
			self::$Smarty->caching = true;
		}
	}


	public static function execute()
	{
		if(!self::checkRights())
			self::fail(403);
		if(self::$debug)
			self::bakeCss();
		self::setupLang();

        $Page = self::$Page;
		$Page->execute();

	}
	public static function setupLang()
	{

	}

	static function fail($code)
	{
		die;
	}

	public static function  bakeCss()
	{
        $scss = new \Leafo\ScssPhp\Compiler();
        $scss->setLineNumberStyle(\Leafo\ScssPhp\Compiler::LINE_COMMENTS);
        $scss->setFormatter("\Leafo\ScssPhp\Formatter\Crunched");
        $scss->addImportPath("vendor/twbs/bootstrap-sass/assets/stylesheets");
		try {
          //  self::bakeFile($scss,"styles/colorMain.scss","styles_c/colorMain.css");
          //  self::bakeFile($scss,"styles/colorLight.scss","styles_c/colorLight.css");
            self::bakeFile($scss,"styles/colorDark.scss","styles_c/colorDark.css");
		} catch (exception $e) {
			self::fail(502,$e->getMessage());
		}
	}
    private static function bakeFile($scss,$inputFile,$outputFile)
    {
        $compiled=$scss->compile(file_get_contents($inputFile));
        file_put_contents($outputFile,$compiled);
    }

	static function checkRights()
	{
		return !self::$Page->RequireLogged || (!self::$Page->RequireAdmin && self::$Page->RequireLogged && self::$User->Logged) ||(self::$Page->RequireAdmin && self::$User->Admin);
	}

}