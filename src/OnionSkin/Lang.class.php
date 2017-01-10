<?php
namespace OnionSkin;
class Lang {

    private static $instance;

    public static function GetLang($langType=null)
    {
        if($langType===null && !isset(self::$instance))
            self::$instance=parse_ini_file("lang/lang.".self::langType().".ini",false);
        elseif($langType!=null)
            self::$instance=parse_ini_file("lang/lang.".$langType.".ini",false);
        return self::$instance;
    }
    public static function L($code)
    {
        if(!isset(self::$instance))
            self::GetLang();
        return self::$instance[$code];
    }

    private static function langType()
    {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if(isset($_SESSION["lang"]))
            $lang=$_SESSION["lang"];
        return $lang;
    }

}
