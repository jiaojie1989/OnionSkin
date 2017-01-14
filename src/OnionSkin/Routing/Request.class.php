<?php

namespace OnionSkin\Routing
{
    use OnionSkin\Engine;
	/**
	 */
	class Request
	{
        /**
         * Relative path from website root.
         * @var string
         */
        public $Path;

        /**
         * Coresponding page to request
         *
         * Is null before routing request thru Router.
         * @see \OnionSkin\Routing\Router
         * @var \OnionSkin\Page|null
         */
        public $Page;

        /**
         * Mapped model of request.
         *
         * Is null before routing request thru Router.
         * @see \OnionSkin\Routing\Router
         * @var \OnionSkin\Models\Model|\null
         */
        public $MappedModel;

        /**
         * GET Paramaters
         * @var string Enum["GET","POST","DELETE","PUT","PATCH"]
         */
        public $Method;

        /**
         * Paramaters from path/url.
         * @var array
         */
        public $Params;

        /**
         * GET Paramaters
         * @var array
         */
        public $GET;

        /**
         * POST Paramaters
         * @var array
         */
        public $POST;

        /**
         * @var array
         */
        public $AcceptLanguages;

        /**
         * @var array
         */
        public $Accept;

        /**
         * @var array
         */
        public $ContentType;

        /**
         * Create new Request from current scope.
         *
         * Magic methods:
         * _method = Set request method. This is little hack so <form> or <a> can send other request then GET or POST
         *
         * @return Request
         */
        public static function Current()
        {
            $request = new Request();
            $request->Path=$_GET["url"];
            $request->Method=$_SERVER['REQUEST_METHOD'];
            if(isset($_GET["_method"]))
                $request->Method=$_GET['_method'];
            if(isset($_POST["_method"]))
                $request->Method=$_POST['_method'];
            $request->AcceptLanguages=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
            $request->Accept=$_SERVER['HTTP_ACCEPT'];
            if(isset($_SERVER["CONTENT_TYPE"]))
            $request->ContentType=$_SERVER["CONTENT_TYPE"];
            $request->GET=$_GET;
            $request->POST=$_POST;
            return $request;
        }
        /**
         * Execute request.
         */
        public function Execute()
        {
            $mtd=strtolower($this->Method);
            if(isset($this->MappedModel) && !$this->MappedModel->validateAntiForgetoryToken(get_class($this->Page)))
                $this->Page->redirect("@/");
            \OnionSkin\Engine::$Smarty->assign("Request",$this);
            $this->Page->{$mtd}($this);
        }
        /**
         * Check if user has rights to this page.
         * @return boolean
         */
        public function CheckRights()
        {
            if(is_null($this->Page))
                return false;
            if($this->Page->RequireLogged && is_null(Engine::$User))
                return false;
            if($this->Page->RequireAdmin && (is_null(Engine::$User) || !Engine::$User->admin))
                return false;
            if(!$this->Page->OnCheckRights())
                return false;
            return true;
        }
	}
}
