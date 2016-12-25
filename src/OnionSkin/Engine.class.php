<?php
namespace OnionSkin;


class Engine
{
	private static $debug = false;

	/**
	 * @var CustomSmarty
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

	public static function Init()
	{
		spl_autoload_register("OnionSkin\Engine::autoload");
		if(func_num_args()>0)
			$CONFIG = func_get_arg(0);
		else
			$CONFIG = parse_ini_file("config/configuration.ini",true);
		session_start();
        $dbconf= \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/OnionSkin/Entities",self::$debug));
        self::$DB=\Doctrine\ORM\EntityManager::create($CONFIG["Database"],$dbconf);
        $CONFIG["Database"]=null;
		self::$Config=$CONFIG;
		self::$Smarty = new CustomSmarty();
		self::$User = $_SESSION["User"];
        Routing\Router::Register("config/router.ini");
	}



	public static function sanitize($var)
	{
		if(is_null($var))
			return $var;
		return trim(stripslashes(htmlspecialchars($var)));
	}

	public static function Debug($var)
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


	public static function Execute($request)
	{
        Routing\Router::Route($request);
        $request->Execute();
	}

	static function fail($code)
	{
		die;
	}

	public static function  BakeCss()
	{
        $scss = new \Leafo\ScssPhp\Compiler();
        $scss->setLineNumberStyle(\Leafo\ScssPhp\Compiler::LINE_COMMENTS);
        $scss->setFormatter("\Leafo\ScssPhp\Formatter\Crunched");
        $scss->addImportPath("vendor/twbs/bootstrap-sass/assets/stylesheets");
        $scss->addImportPath("styles");
        if (!file_exists('styles_c'))
            mkdir('styles_c', 0777, true);
		try {
          //  self::bakeFile($scss,"styles/colorMain.scss","styles_c/colorMain.css");
          //  self::bakeFile($scss,"styles/colorLight.scss","styles_c/colorLight.css");
            self::bakeFile($scss,"styles/colorLight.scss","styles_c/colorLight.css");
		} catch (exception $e) {
			self::fail(502,$e->getMessage());
		}
	}
    public static function BakeJs()
    {
        if (!file_exists('js_c'))
            mkdir('js_c', 0777, true);
        $mimify = new \MatthiasMullie\Minify\JS();
        $mimify->add("vendor/twbs/bootstrap-sass/assets/javascripts/bootstrap.js");
        $mimify->minify("js_c/bootstrap.js");
        $mimify = new \MatthiasMullie\Minify\JS();
        $mimify->add("vendor/components/highlightjs/highlight.pack.js");
        $mimify->minify("js_c/highlight.js");
        $mimify = new \MatthiasMullie\Minify\JS();
        $mimify->add("js/textarea_autogrown.js");
        $mimify->minify("js_c/editor.js");
    }
    public static function BakeLanguageTypes()
    {
        $files=scandir("languages/");
        chmod("languages",0777);
        $langs=array();
        foreach($files as $file)
        {
            chmod("languages/".$file,0777);
            $lines= file("languages/".$file);
            if($lines!="")
                $langs[str_replace(".js","",$file)]=trim(str_replace("Language: ","",$lines[1]));
        }
        file_put_contents("config/languages.json",json_encode($langs));
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