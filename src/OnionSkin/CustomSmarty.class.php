<?php

namespace OnionSkin
{
	/**
	 * CustomSmarty short summary.
	 *
	 * CustomSmarty description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class CustomSmarty extends \Smarty
	{
        function __construct()
        {
            parent::__construct();
            $this->setTemplateDir('templates/');
            $this->setCompileDir('templates_c/');
            $this->setConfigDir('configs/');
            $this->setCacheDir('cache/');
            $this->caching = \Smarty::CACHING_LIFETIME_CURRENT;
            $this->assign('app_name', 'OnionSkin');
            $this->assign("L",Lang::GetLang());
            $this->assign("R",new RouterPlugin());
            $this->assign("Form",new FormPlugin());
            $this->error_reporting = E_ALL & ~E_NOTICE;
        }

	}
    class RouterPlugin
    {
        public function Path($page,$vars=null)
        {
            return Routing\Router::Path("\\OnionSkin\\Pages\\".$page,$vars);
        }
        public function Route()
        {

        }
    }
    class FormPlugin
    {
        public function AntiForgeryToken($Page)
        {
            if(!isset($_SESSION["csrf"]))
                $_SESSION["csrf"]=array();
            $token=bin2hex(random_bytes(32));
            $_SESSION["csrf"][]= array("page"=>get_class($Page), "token"=>$token, "validity"=>time()+60*30);
            return '<input type="hidden" name="csrf_token" value="'.$token.'" />';
        }
    }
}