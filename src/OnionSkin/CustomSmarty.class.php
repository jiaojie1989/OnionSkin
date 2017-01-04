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
            $this->error_reporting = E_ALL & ~E_NOTICE;
        }

	}
    class RouterPlugin
    {
        public function Path($page,$vars=null)
        {
            
        }
        public function Route()
        {
            
        }
    }
}