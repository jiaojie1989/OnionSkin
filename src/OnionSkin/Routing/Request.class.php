<?php

namespace OnionSkin\Routing
{
	/**
	 * Request short summary.
	 *
	 * Request description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class Request
	{
        /**
         *
         * @var string
         */
        public $Path;

        /**
         * @var \OnionSkin\Page
         */
        public $Page;

        public $MappedModel;

        public $Method;

        public $Params;

        public $AcceptLanguages;

        public $Accept;

        public $ContentType;

        public static function Current()
        {
            $request = new Request();
            $request->Path=$_GET["url"];
            $request->Method=$_SERVER['REQUEST_METHOD'];
            $request->AcceptLanguages=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
            $request->Accept=$_SERVER['HTTP_ACCEPT'];
            $request->ContentType=$_SERVER["CONTENT_TYPE"];
            $route = Router::getRouteForPath($request->Path);
            

        }
	}
}