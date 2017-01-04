<?php

namespace OnionSkin\Pages;

class EditPage extends \OnionSkin\Page
{
	public function __construct()
	{
		$this->RequireLogged = false;
		$this->RequireAdmin = false;
	}
	/**
	 * @return boolean
	 */
	public function execute()
	{
		switch($this->req_metod())
		{
			case "POST":
                return $this->create();
			case "GET":
				return $this->get();
			case "PATCH":
			case "PUT":
				return $this->update();
			case "DELETE":
                return $this->remove();

		}
        return $this->get();
	}

	public function get($request)
	{
        $this->loadSyntax();
        $this->ok("main/NoteEdit.tpl");
        return true;
	}
    private function create()
    {
        $this->redirect("");
    }

    private function getModel()
    {
        $errors = array();
        $model = new \OnionSkin\Entities\Snippet();
    }
    private function loadSyntax()
    {
        $syntax=json_decode(file_get_contents("config/languages.json"));
        \OnionSkin\Engine::$Smarty->assign("syntax_list",$syntax);
    }
}