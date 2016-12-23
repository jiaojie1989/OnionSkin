<?php

namespace OnionSkin\Routing
{
	/**
	 * Router short summary.
	 *
	 * Router description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class Router
	{
        public function register($file)
        {
            $data=parse_ini_file($file);
            foreach($data as $key=>$value)
            {
            }
        }
        public static function getRouteForPath($path)
        {

        }
        public static function getRouteForPage($page)
        {

        }
	}
}