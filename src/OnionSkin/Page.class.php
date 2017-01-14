<?php

namespace OnionSkin;

class Page {

	/**
     * If only logged user can access this page.
     * @var boolean
     */
	public $RequireLogged = true;
	/**
	 * If only admin can access this page.
	 * @var boolean
	 */
	public $RequireAdmin = true;
    /**
     * Is called during rights checking.
     * @return boolean If this function return false, then access to this page won´t be granted.
     */
    public function OnCheckRights(){ return true; }

	/**
	 * Display smarty template as result.
	 * @param string $page Smarty template used for displaying.
	 */
	protected final function ok($page)
	{
		Engine::$Smarty->display($page);
		die;
	}

    /**
     * Return json as result.
     * @param mixed $Data
     * @param int $code
     */
    protected final function json($Data,$code=200)
    {
        http_response_code($code);
        echo json_encode($Data);
        die;
    }

    /**
     * Return redirect tu user
     * @param mixed $page
     * @param int $code
     * @param string[] $vars
     */
    public final function redirect($page, $code=303,$vars=array())
    {
        self::RedirectTo($page,$code,$vars);
    }

    /**
     * Return redirect tu user
     * @param mixed $page
     * @param int $code
     * @param string[] $vars
     */
    public static function RedirectTo($page, $code=303,$vars=array())
    {
        header("Location: ".Routing\Router::Path($page,$vars),true,$code);
        die();
    }

    /**
     * Handler for get request.
     * @param Routing\Request $request
     */
    public function get($request){}
    /**
     * Handler for post request.
     * @param Routing\Request $request
     */
    public function post($request){}
    /**
     * Handler for put request.
     * @param Routing\Request $request
     */
    public function put($request){}
    /**
     * Handler for delete request.
     * @param Routing\Request $request
     */
    public function delete($request){}
    /**
     * Handler for patch request.
     * @param Routing\Request $request
     */
    public function patch($request){}
    /**
     * Handler for options request.
     * @param Routing\Request $request
     */
    public function options($request){}
    /**
     * Handler for head request.
     * @param Routing\Request $request
     */
    public function head($request){}




}