<?php
namespace OnionSkin;

/**
 * Main class of OnionSkin.
 * Handles DB connection, setting up routes, initiation and many others aspects of application.
 */
class Engine
{
	/**
	 * @var bool
	 */
	private static $debug = false;

	/**
     * Smarty instance for this context.
     *
	 * @var CustomSmarty
	 */
	public static $Smarty;

	/**
     * Database context.
     *
	 * @var \Doctrine\ORM\EntityManager
	 */
	public static $DB;


	/**
     * Logged user from current context. Null if logged user doesn´t exist.
     *
     * @var Entities\User|\null
     * @since onionskin-1.0.0
	 */
	public static $User;

	/**
     * Loaded configuration. Without any passwords to aplication or database. (Obscured in Init() method)
     *
     * @see ../config/configuration.ini
     * @since onionskin-1.0.0
	 * @var string[]
	 */
	public static $Config;

	/**
     * Initiation of engine.
     *
     * @since onionskin-1.0.0
     * @see ../index.php
     * @param null|string[][] $cfg Offer option to override default configuration.
	 */
	public static function Init($cfg=null)
	{
		session_start();
		if(isset($cfg))
			$CONFIG = $cfg;
		else
			$CONFIG = parse_ini_file("../config/configuration.ini",true);

        Routing\Router::RegisterFromFile("../config/router.ini");
        if(!file_exists("js_c") && !(file_exists("style_c")))
        {
            self::BakeJs();
            self::BakeCss();
        }
        $dbconf= \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array(__DIR__."/Entities"),true,"../tmp",new \Doctrine\Common\Cache\ArrayCache());

        self::$DB=\Doctrine\ORM\EntityManager::create($CONFIG["Database"],$dbconf);

        self::$DB->getConfiguration()->addEntityNamespace('OS', "OnionSkin\\Entities");
        $CONFIG["Database"]=null;
		self::$Config=$CONFIG;
		self::$Smarty = new CustomSmarty();
        try {
            self::$DB->getConnection()->connect();
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool(self::$DB);
            $classes = self::$DB->getMetadataFactory()->getAllMetadata();
            $schemaTool->updateSchema($classes,true);
            if(isset($_SESSION["User"])){
                self::$User = self::$DB->find("\\OnionSkin\\Entities\\User",$_SESSION["User"]);
                self::$Smarty->assign("user",self::$User);
                if(isset(self::$User->lang)){
                    $_SESSION["lang"]=self::$User->lang;
                    self::$Smarty->clearAssign("L");
                    self::$Smarty->assign("L",Lang::GetLang($_SESSION["lang"]));
                }
            }
            self::$Smarty->assign("logged",!is_null(self::$User));
        }
        catch (\Exception $e) {
	print_r($e);
            if($_GET["url"]!="Error500")
                Page::RedirectTo("@\\Error500");
        }
	}


	/**
     * Sanitize input string
	 * @param string $var
	 * @return \null|string
	 */
	public static function sanitize($var)
	{
		if(is_null($var))
			return $var;
		return trim(stripslashes(htmlspecialchars($var)));
	}

	/**
     * Turn debugging on/off
	 * @param bool $var
	 */
	public static function Debug($var)
	{
		self::$debug = $var;
		if($var)
		{
			error_reporting(3);
			ini_set('display_errors', TRUE);
		}
		else
		{
			error_reporting(0);
			ini_set('display_errors', FALSE);
		}
	}

	/**
	 * Execute request
	 * @param Routing\Request $request
	 */
	public static function Execute($request)
	{
        Routing\Router::Route($request);
        $request->Execute();
	}

	/**
	 * Bake Sass/Scss sources to css and minify them.
	 */
	public static function  BakeCss()
	{
        $scss = new \Leafo\ScssPhp\Compiler();
        $scss->setLineNumberStyle(\Leafo\ScssPhp\Compiler::LINE_COMMENTS);
        $scss->setFormatter("\Leafo\ScssPhp\Formatter\Crunched");
        $scss->addImportPath("../vendor/twbs/bootstrap/scss");
        $scss->addImportPath("../styles");
        if (!file_exists('styles_c'))
            mkdir('styles_c', 0777, true);
		try {
            self::bakeFile($scss,__DIR__."/../../styles/colorDark.scss","styles_c/colorDark.css");
            self::bakeFile($scss,__DIR__."/../../styles/colorLight.scss","styles_c/colorLight.css");
            self::bakeFile($scss,__DIR__."/../../styles/onionskin/loginpanel.scss","styles_c/login.css");
		} catch (exception $e) {
			self::fail(502,$e->getMessage());
		}
        if (!file_exists('fonts/bootstrap'))
            mkdir("fonts/bootstrap",0777,true);

        if (!file_exists('styles_c/highlightjs'))
            mkdir('styles_c/highlightjs', 0777, true);
        copy("../vendor/components/highlightjs/styles/vs.css","styles_c/highlightjs/vs.css");
        copy("../vendor/components/highlightjs/styles/androidstudio.css","styles_c/highlightjs/androidstudio.css");
	}

    /**
     * Bake javascript files and minify them.
     */
    public static function BakeJs()
    {
        if (!file_exists('js_c'))
            mkdir('js_c', 0777, true);
        copy("../vendor/twbs/bootstrap/dist/js/bootstrap.min.js","js_c/bootstrap.js");
        copy("../vendor/components/highlightjs/highlight.pack.min.js","js_c/highlight.js");
        $mimify = new \MatthiasMullie\Minify\JS();
        $mimify->add("../js/textarea_autogrown.js");
        $mimify->minify("js_c/editor.js");
        $mimify = new \MatthiasMullie\Minify\JS();
        $mimify->add("../js/loginpanel.js");
        $mimify->minify("js_c/login.js");
    }
    /**
     * Bake language types.
     * @deprecated
     */
    public static function BakeLanguageTypes()
    {

        $files=scandir("../languages/"); //You must copy this files from hightlight.js github to this directory.
        chmod("../languages",0777);
        $langs=array();
        foreach($files as $file)
        {
            chmod("../languages/".$file,0777);
            $lines= file("../languages/".$file);
            if($lines!="")
                $langs[str_replace(".js","",$file)]=trim(str_replace("Language: ","",$lines[1]));
        }
        file_put_contents("../config/languages.json",json_encode($langs));
    }

	static function fail($code=500,$msg="")
	{
		die;
	}
    private static function bakeFile($scss,$inputFile,$outputFile)
    {
        $compiled=$scss->compile(file_get_contents($inputFile));
        file_put_contents($outputFile,$compiled);
    }


}
