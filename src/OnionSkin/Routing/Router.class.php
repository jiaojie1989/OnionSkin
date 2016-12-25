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
        /**
         * @var Route[]
         */
        private static $routes=array();

        public static function Register($file)
        {
            $data=parse_ini_file($file,true);
            foreach($data as $key=>$value)
            {
                self::$routes[]= new Route($value);
            }
        }
        public static function getRouteForPath($path)
        {

        }
        public static function getRouteForPage($page)
        {

        }
        public static function Route($request)
        {
            if(is_null($request->path))
                $request->Path="/";
            foreach(self::$routes as $route)
            {
                if($route->valide($request))
                {
                    if(!$route->route($request))
                    {
                    }
                    return;
                }
            }
        }
	}
}