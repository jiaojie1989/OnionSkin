<?php

namespace OnionSkin\Routing
{
    use OnionSkin\UtilsStr;
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
         * Routes
         * @var Route[]
         */
        private static $routes=array();

        /**
         * Add route from properly styled ini route file.
         * @param string $file 
         */
        public static function RegisterFromFile($file)
        {
            $data=parse_ini_file($file,true);
            foreach($data as $value)
                self::$routes[]= new Route($value);
        }
        /**
         * Add route to router
         * @param Route $route 
         */
        public static function RegisterRoute($route)
        {
            self::$routes[]=$route;
        }

        /**
         * Get path from page or direct path.
         * @param \OnionSkin\Page|\string $page If string start with @ then method return direct path.
         * @param string[] $vars Variables for path.
         * @param string $method Enum["GET","POST","PUT","DELETE","PATCH"]
         * @return \null|\string Path
         */
        public static function Path($page, $vars=array(),$method="GET")
        {
            if(is_string($page))
            {
                if(UtilsStr::startWith("@",$page))
                    return substr($page,1);
                foreach(self::$routes as $route)
                {
                    if($route->getPage()==$page && in_array($method,$route->getMethods()))
                        return "/".$route->path($vars);

                }
            }
            elseif(is_object($page))
                foreach(self::$routes as $route)
                {
                    if($route->getPage()==get_class($page))
                        return "/".$route->path($vars);
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
            \OnionSkin\Page::RedirectTo("@\\Error404");
        }
	}
}