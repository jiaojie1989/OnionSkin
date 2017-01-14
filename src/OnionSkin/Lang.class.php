<?php
namespace OnionSkin;
class Lang {

    /**
     * @var string[]
     */
    private static $instance;

    /**
     * Return instance of Lang
     * @param string|null $langType [Optional] Required lang type. If no lang type is given then is loaded language specified in http request.
     * @return string[]
     */
    public static function GetLang($langType=null)
    {
        if($langType===null && !isset(self::$instance))
            self::$instance=parse_ini_file("../lang/lang.".self::langType().".ini",false);
        elseif($langType!=null)
            self::$instance=parse_ini_file("../lang/lang.".$langType.".ini",false);
        return self::$instance;
    }
    /**
     * Get translation for given code.
     *
     * Example:
     * lang.en.ini:
     * hello= Hello {0} {1}.
     *
     * Call:
     * Lang::L("hello",array("user","Todd"));
     *
     * Returned result:
     * Hello user Todd.
     *
     * @param string $code
     * @param string[] $data [Optional] Ordered data for language procesor.
     * @return string
     */
    public static function L($code,$data=array())
    {
        if(!isset(self::$instance))
            self::GetLang();
        return self::$instance[$code];
    }
    /**
     * @return string;
     */
    private static function langType()
    {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if(isset($_SESSION["lang"]))
            $lang=$_SESSION["lang"];
        if($lang!=="cz" || $lang!=="en")
            $lang="en";
        return $lang;
    }

}
