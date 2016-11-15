<?php

namespace OnionSkin/Entities;

class User {
	private $id=null;
	private $username;
	private $passwordAndSalt;
	private $createdTime;
	private $admin;
	
	private const SELECT_BY_USERNAME = "SELECT * FROM Users AS u WHERE u.username==:username";
	private const SELECT_BY_ID = "SELECT * FROM Users AS u WHERE u.id==:id";
	private const CREATE = "INSERT INTO Users AS u (u.username,u.passwordAndSalt,u.admin) OUTPUT Inserted.id VALUES (:username,:passwordAndSalt,:admin)";
	private const REMOVE = "";
	private const UPDATE = "";
	
	
	public function persist($pdo)
	{
		if(is_null($this->id))
			$stmt = $pdo->prepare(USER::CREATE);
		else
			$stmt = $pdo->prepare(USER::UPDATE);
		$stmt->bindParam(":username",$this->username);
		$stmt->bindParam(":passwordAndSalt",$this->passwordAndSalt);
		$stmt->bindParam(":id",$this->id);
		$stmt->bindParam(":admin",$this->admin);
		if($stmt->execute())
		{
			$var=$stmt->fetch();
			if(count($var)>0)
				$this->id=$var[0]; //TODO: Testing
		}
		
	}
	public function remove($pdo)
	{
		$stmt = $pdo->prepare(USER::REMOVE);
		$stmt->bindParam(":id",$this->id);
		$stmt->execute();
	}
	public function find($pdo,$id)
	{
		$stmt = $pdo->prepare(USER::SELECT_BY_ID);
		$stmt->bindParam(":id",$this->id);
		$stmt->execute();
	}
	public function findByUsername($pdo,$username)
	{
		$stmt = $pdo->prepare(USER::SELECT_BY_USERNAME);
		$stmt->bindParam(":username",$this->username);
		$stmt->execute();
	}
	
	
	public function load($row)
	{
		
	}
	
	public function setPassword($password)
	{
		$options = [
			'cost' => 30
		];
		$this->passwordAndSalt = password_hash($password, PASSWORD_BCRYPT,$options);
	}
	
	public function comparePassword($password)
	{
		return password_verify($password,$this->passwordAndSalt);
	}
	
	
	public function setAdmin($admin)
	{
		if(!is_bool($admin))
			throw new InvalidArgumentException();
		$this->admin=$admin;
	}
	
	public function getAdmin()
	{
		return $this->admin;
	}
	
	public function setCreatedTime($createdTime)
	{
		if(!is_numeric($createdTime))
			throw new InvalidArgumentException();
		$this->createdTime=$createdTime;
	}
	
	public function getCreatedTime()
	{
		return $this->createdTime;
	}
}