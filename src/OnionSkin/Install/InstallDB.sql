CREATE DATABASE IF NOT EXISTS %db%;
CREATE TABLE IF NOT EXISTS 'Users'
{
	id int NOT NULL PRIMARY KEY,
	username varchar(255) NOT NULL UNIQUE,
	passwordAndSalt varchar(255) NOT NULL,
	createdTime timestamp DEFAULT NOW(),
	admin bit(1) DEFAULT b'0'
} ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS 'Categories'
{
	id int NOT NULL PRIMARY KEY,
	name varchar(255) NOT NULL,
	ownerID int NOT NULL,
	parentCategoryID int
} ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS 'Snippets'
{
	id int NOT NULL PRIMARY KEY,
	title varchar(255),
	text longtext NOT NULL,
	ownerID int NOT NULL,
	categoryID int,
	createdTime timestamp DEFAULT NOW(),
	modifiedTime timestamp DEFAULT NOW(),
	accessLevel 
} ENGINE=InnoDB DEFAULT CHARSET=utf8;