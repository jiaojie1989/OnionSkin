<?php

namespace OnionSkin\Entities;

/**
 * Snippet entity for persistence.
 * 
 * @Entity
 * @Table(name="snippets")
 * @HasLifecycleCallbacks
 */
class Snippet
{

	/**
     * @var int
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     * @Column(type="integer", name="snippet_id", nullable=false, options = {"unsigned"=true})
     */
	public $id;
	/**
	 * @Column(type="string", length=128, nullable=false)
	 */
	public $title;
	/**
     * @Column(type="string", length=128, nullable=false)
     */
	public $syntax;
	/**
     * @Column(type="string", length=4294967295, nullable=false)
	 */
	public $text;
	/**
	 * @Column(type="datetime",name="date_added",nullable=false)
	 */
	public $createdTime;
	/**
	 * @Column(type="datetime",name="date_modified",nullable=false)
	 */
	public $modifiedTime;

    /**
     * @Column(type="datetime",name="date_expiration",nullable=true)
     * @var \DateTime
     */
    public $expirationTime;
	/**
     * 0 = private
     * 1 = link
     * 2 = public
     * @Column(type="smallint", options = {"unsigned"=true} )
	 */
	public $accessLevel;

	/**
     * @ManyToOne(targetEntity="Folder", fetch="LAZY")
     * @JoinColumn(name="folder_id", referencedColumnName="folder_id", nullable=true)
     * @var Folder
     * */
	public $folder;
	/**
     * @ManyToOne(targetEntity="User", fetch="LAZY")
     * @JoinColumn(name="user_id", referencedColumnName="user_id", nullable=true)
     * @var User
     */
	public $user;

    /**
     * @PrePersist
     */
    public function onPrePersistSetDateTime()
    {
        $this->createdTime=new \DateTime();
        $this->modifiedTime= new \DateTime();
    }
    /**
     * @PreUpdate
     */
    public function onPreUpdateSetDateTime()
    {
        $this->modifiedTime=new \DateTime();
    }

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function validate()
    {/*
        $errors=new \OnionSkin\Exceptions\ErrorModel();
        if(!is_int($this->id) && !is_null($this->id))
            $errors->addError(true,"id","","ID is of type:"+gettype($this->id));

        if(is_null($this->title))
            $errors->addError(false,"title","errorTitleNull");
        elseif(!is_string($this->title))
            $errors->addError(false,"title","errorTitleNotString");
        elseif(strlen($this->title)>128)
            $errors->addError(false,"title","errorTitleLenght");

        if(is_null($this->text))
            $errors->addError(false,"text","errorTextNull");
        elseif(!is_string($this->text))
            $errors->addError(false,"text","errorTextNotString");
        elseif(strlen($this->text)>4294967295)
            $errors->addError(false,"text","errorTextLenght");

        if($this->accessLevel !=01 && $this->accessLevel !=10 && $this->accessLevel!=00)
            $errors->addError(false,"accessLevel","errorAccessLevel");



        if($errors->hasErrors())
            throw new \OnionSkin\Exceptions\ValidationException($errors,"Errors during validation of snippet");*/
    }

    public function isOwner()
    {
        $user=\OnionSkin\Engine::$User;
        if(!isset($user))
            return false;
        return $this->user->id==$user->id;
    }
}