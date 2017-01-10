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


	public static function Init()
	{
		if(func_num_args()>0)
			$CONFIG = func_get_arg(0);
		else
			$CONFIG = parse_ini_file("config/configuration.ini",true);
        Routing\Router::Register("config/router.ini");
		session_start();
        $dbconf= \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(array("src/OnionSkin/Entities"),self::$debug,null,new \Doctrine\Common\Cache\ArrayCache());
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
            }
            self::$Smarty->assign("logged",!is_null(self::$User));
        }
        catch (\Exception $e) {
            if($_GET["url"]!="Error500")
                Page::RedirectTo("@\\Error500");
        }
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
		}
		else
		{
			error_reporting(0);
			ini_set('display_errors', FALSE);
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
        $scss->addImportPath("vendor/twbs/bootstrap/scss");
        $scss->addImportPath("styles");
        if (!file_exists('styles_c'))
            mkdir('styles_c', 0777, true);
		try {
          //  self::bakeFile($scss,"styles/colorMain.scss","styles_c/colorMain.css");
            self::bakeFile($scss,"styles/colorDark.scss","styles_c/colorDark.css");
            self::bakeFile($scss,"styles/colorLight.scss","styles_c/colorLight.css");
            self::bakeFile($scss,"styles/onionskin/loginpanel.scss","styles_c/login.css");
		} catch (exception $e) {
			self::fail(502,$e->getMessage());
		}
        if (!file_exists('fonts/bootstrap'))
            mkdir("fonts/bootstrap",0777,true);

        if (!file_exists('styles_c/highlightjs'))
            mkdir('styles_c/highlightjs', 0777, true);
        copy("vendor/components/highlightjs/styles/vs.css","styles_c/highlightjs/vs.css");
        copy("vendor/components/highlightjs/styles/androidstudio.css","styles_c/highlightjs/androidstudio.css");

        /*
        copy("vendor/twbs/bootstrap-sass/assets/fonts/bootstrap/glyphicons-halflings-regular.eot","fonts/bootstrap/glyphicons-halflings-regular.eot");
        copy("vendor/twbs/bootstrap-sass/assets/fonts/bootstrap/glyphicons-halflings-regular.svg","fonts/bootstrap/glyphicons-halflings-regular.svg");
        copy("vendor/twbs/bootstrap-sass/assets/fonts/bootstrap/glyphicons-halflings-regular.ttf","fonts/bootstrap/glyphicons-halflings-regular.ttf");
        copy("vendor/twbs/bootstrap-sass/assets/fonts/bootstrap/glyphicons-halflings-regular.woff","fonts/bootstrap/glyphicons-halflings-regular.woff");
        copy("vendor/twbs/bootstrap-sass/assets/fonts/bootstrap/glyphicons-halflings-regular.woff2","fonts/bootstrap/glyphicons-halflings-regular.woff2");*/
	}
    public static function BakeJs()
    {
        if (!file_exists('js_c'))
            mkdir('js_c', 0777, true);
        copy("vendor/twbs/bootstrap/dist/js/bootstrap.min.js","js_c/bootstrap.js");
        copy("vendor/components/highlightjs/highlight.pack.min.js","js_c/highlight.js");
        $mimify = new \MatthiasMullie\Minify\JS();
        $mimify->add("js/textarea_autogrown.js");
        $mimify->minify("js_c/editor.js");
        $mimify = new \MatthiasMullie\Minify\JS();
        $mimify->add("js/loginpanel.js");
        $mimify->minify("js_c/login.js");
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