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

        public static function Path($page, $vars=null)
        {
            if(is_string($page))
                foreach(self::$routes as $route)
                {
                    if($route->getPage()==$page)
                        return $route->path($vars);

                }
            elseif(is_object($page))
                foreach(self::$routes as $route)
                {
                    if($route->getPage()==get_class($page))
                        return $route->path($vars);
                }
            return null;
        }
        public static function Route($request)
        {
            if(is_null($request->Path))
                $request->Path="";
            foreach(self::$routes as $route)
            {
                if($route->valide($request))
                {
                    if($route->route($request))
                    {
                        return;
                    }
                }
            }
        }
	}
}