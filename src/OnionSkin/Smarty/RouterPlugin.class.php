<?php

namespace OnionSkin\Smarty
{
    use OnionSkin\Routing\Router;
	/**
	 * RouterPlugin short summary.
	 *
	 * RouterPlugin description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class RouterPlugin
    {
        public function Path($page,$vars=null)
        {
            return Router::Path("\\OnionSkin\\Pages\\".$page,$vars);
        }
        public function Normalize($str)
        {
            return str_replace(" ","_", str_replace(".","_",$str));
        }
    }
}