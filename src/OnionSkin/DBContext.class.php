<?php
namespace OnionSkin;

class DBContext {
	private $conn;
	
	public function __construct()
	{
		try {
			$conn = new PDO();
			$conn->setAttribute(PDO:ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		}
		catch(PDOException  e)
		{
			Bootstrap::fail(500,$e->getMessage());
		}
	}
	
	public function debug($var)
	{
		if($var)
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		else
			$conn->setAttribute(PDO:ATTR_ERRMODE, PDO::ERRMODE_SILENT);
	}
}