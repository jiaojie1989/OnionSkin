<?php

namespace OnionSkin\Entities;

public class Category {
	private $id;
	private $name;
	
	private $userID;
	private $parentCategoryID;
	
	private const SELECT_BY_ID = "SELECT * FROM Category AS c WHERE c.id==:id";
	private const SELECT_BY_USER = "SELECT * FROM Category AS c WHERE c.userID==:userID";
	private const SELECT_BY_PARENT = "SELECT * FROM Category AS c WHERE c.parentCategoryID==:categoryID";
	private const REMOVE = "DELETE FROM Category AS c WHERE c.id==:id";
	private const UPDATE = "UPDATE Category AS c SET c.name=:name,c.parentCategoryID=:parentCategoryID WHERE c.id==:id";
	private const INSERT = "INSERT INTO Category AS c (c.name,c.parentCategoryID,c.userID) OUTPUT Inserted.id VALUES (:name,:parentCategoryID, :userID)";
	
	
	public function getUser()
	{
		return OnionSkin\Bootstrap::DB->find(User,$this->userID);
	}
	
	public function getParent()
	{
		return OnionSkin\Bootstrap::DB->find(Category,$this->categoryID);
	}
	
	public function countSnippets()
	{
		
	}
	
	public function getSnippets()
	{
		
	}
	
}