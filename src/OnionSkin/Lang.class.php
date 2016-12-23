<?php
namespace OnionSkin;
class Lang {

    public static function GetLang($langType=null)
    {
        if($langType===null)
            return parse_ini_file("lang/lang.".self::langType().".ini",false);
        else
            return parse_ini_file("lang/lang".$langType."ini",false);
    }
    private static function langType()
    {
        $value=Engine::$Config["Defaults"]["Language"];
        if(isset($_SESSION["lang"]))
            $value=$_SESSION["lang"];
        return $value;
    }

}
