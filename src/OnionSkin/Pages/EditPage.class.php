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
				switch($this->req_accept())
				{
					case "*/*":
					default:
						break;
					case "application/json":
				
					break;
				}
				break;
			case "GET":
				return $this->get();
			case "PATCH":
			case "PUT":
				return $this->update();
			case "DELETE":
			
		}
        return $this->get();
	}
	
	private function get()
	{
        $this->ok("main/NoteNew.tpl");
        return true;
	}
}