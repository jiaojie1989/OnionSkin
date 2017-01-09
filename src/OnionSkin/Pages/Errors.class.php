<?php

namespace OnionSkin\Pages
{
	/**
	 * Error404 short summary.
	 *
	 * Error404 description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class Errors extends \OnionSkin\Page
	{

        /**
        /**
         *
         * @param \OnionSkin\Routing\Request $request
         *
         * @return void
         */
        function get($request)
        {
            switch($request->Path)
            {
                case "Error404":
                    http_response_code(404);
                    return $this->ok("error/Error404.tpl");
                case "Error500":
                    http_response_code(500);
                    return $this->ok("error/Error500.tpl");

            }
        }
    }
}