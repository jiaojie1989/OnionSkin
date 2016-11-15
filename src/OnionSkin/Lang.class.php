<?php
namespace OnionSkin;
class Lang {
		
	
	public static function LoadCZ()
	{
		return parse_ini_file("lang/lang.cz.ini",true);
	}
}
