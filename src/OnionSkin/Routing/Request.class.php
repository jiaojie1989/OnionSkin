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

        /**
         * Summary of $MappedModel
         * @var \OnionSkin\Models\Model
         */
        public $MappedModel;

        public $Method;

        public $Params;

        public $GET;

        public $POST;

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
            $request->GET=$_GET;
            $request->POST=$_POST;
            return $request;
        }
        public function Execute()
        {
            $mtd=strtolower($this->Method);
            if(isset($this->MappedModel) && !$this->MappedModel->validateAntiForgetoryToken(get_class($this->Page)))
                $this->Page->redirect("@/");
            \OnionSkin\Engine::$Smarty->assign("Request",$this);
            $this->Page->{$mtd}($this);
        }
	}
}