<?php
require_once('libs/smarty/Smarty.class.php');


class CustomSmarty extends Smarty {

   function __construct()
   {

        parent::__construct();

        $this->setTemplateDir('templates/');
        $this->setCompileDir('templates_c/');
        $this->setConfigDir('configs/');
        $this->setCacheDir('cache/');

        $this->caching = Smarty::CACHING_LIFETIME_CURRENT;
        $this->assign('app_name', 'OnionSkin');
   }

}