<?php
namespace OnionSkin;
class Lang {

    private static $instance;

    public static function GetLang($langType=null)
    {
        if($langType===null && !isset(self::$instance))
            self::$instance=parse_ini_file("lang/lang.".self::langType().".ini",false);
        elseif(!isset(self::$instance))
            self::$instance=parse_ini_file("lang/lang".$langType."ini",false);
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
        $value=Engine::$Config["Defaults"]["Language"];
        if(isset($_SESSION["lang"]))
            $value=$_SESSION["lang"];
        return $value;
    }

}
