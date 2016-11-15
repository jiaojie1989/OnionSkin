<?php

namespace OnionSkin\Pages;

public class EditPage extends \OnionSkin\Page
{
	public function __construct()
	{
		$this->RequireLogged = true;
		$this->RequireAdmin = false;
	}
	
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
	}
	
	private function get()
	{
		
	}
}