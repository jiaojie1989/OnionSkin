<?php

namespace OnionSkin;

class Page {

	private $UrlParts = array();
	public $RequireLogged = true;
	public $RequireAdmin = true;
	public $Url = array();

	public final function req_metod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	public final function req_accept()
	{
		return $_SERVER['HTTP_ACCEPT'];
	}
	protected final function ok($page)
	{
		Engine::$Smarty->display($page);
		die;
	}
    protected final function json($Data,$code=200)
    {
        http_response_code($code);
        echo json_encode($Data);
        die;
    }

    public final function redirect($page, $code=303,$vars=null)
    {
        if(substr($page,0,1)==="@")
            header("Location: ".substr($page,1,strlen($page)-1),true,$code);
        else
            header("Location: ".Routing\Router::Path($page,$vars),true,$code);
        die();
    }
    public static function RedirectTo($page, $code=303,$vars=null)
    {
        if(substr($page,0,1)==="@")
            header("Location: ".substr($page,1,strlen($page)-1),true,$code);
        else
            header("Location: ".Routing\Router::Path($page,$vars),true,$code);
        die();
    }

    public function execute(){}

    public function get($request){}
    public function post($request){}
    public function put($request){}
    public function remove($request){}

	public static function resolve($page)
	{
		$Page = null;
		$parts=explode('/',$page);
		$c=count($parts);
        if($c==0)
            $Page = new \OnionSkin\Pages\EditPage();
		switch($parts[0])
		{
			case "index":  $Page = new \OnionSkin\Pages\EditPage(); break;
			case "login":  $Page = new \OnionSkin\Pages\LoginPage(); break;
			case "logout": $Page = new \OnionSkin\Pages\LogoutPage(); break;
			case "category": $Page = new \OnionSkin\Pages\CategoryPage(); break;
			default:
				if(is_numeric($parts[0]))
				{
					if($c===3 && $parts[count($parts)]=="edit")
						$Page = new \OnionSkin\Pages\EditPage();
					elseif($c===2 && $c===1)
						$Page = new \OnionSkin\Pages\ShowPage();
					break;
				}
                $Page = new \OnionSkin\Pages\EditPage();
                break;
		}
		$Page->UrlParts = $parts;
        return $Page;
	}



}