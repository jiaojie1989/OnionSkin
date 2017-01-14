<?php

namespace OnionSkin\Entities;

/**
 * Folder entity for persistace.
 * 
 * @Entity
 * @Table(name="folders")
 * @HasLifecycleCallbacks
 */
class Folder {
	/**
     * @var int
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     * @Column(type="integer", name="folder_id", nullable=false, options = {"unsigned"=true})
     */
	public $id;
	/**
	 * @Column(type="string", name="folder_name", length=128, nullable=false)
     * @var string
	 */
	public $name;

	/**
     * @ManyToOne(targetEntity="User", fetch="LAZY")
     * @JoinColumn(name="user_id", referencedColumnName="user_id", nullable=false)
     * @var User
	 */
	public $user;
	/**
     * @ManyToOne(targetEntity="Folder", fetch="LAZY")
     * @JoinColumn(name="parentFolder_id", referencedColumnName="folder_id", nullable=true)
     * @var Folder
	 */
	public $parentFolder;
    /**
     * @OneToMany(targetEntity="Folder",mappedBy="parentFolder", fetch="EXTRA_LAZY")
     * @var Folder[]
     */
    public $childsFolders;
    /**
     * @OneToMany(targetEntity="Snippet",mappedBy="folder", fetch="EXTRA_LAZY")
     * @var Snippet[]
     */
    public $snippets;
	/**
     * @Column(type="datetime",name="date_added",nullable=false)
     */
	public $createdTime;
	/**
     * @Column(type="datetime",name="date_modified",nullable=false)
     */
	public $modifiedTime;

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

    public function parent()
    {
        return $this->parentFolder;
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

        if(is_null($this->name))
            $errors->addError(false,"name","errorNameNull");
        elseif(!is_string($this->name))
            $errors->addError(false,"name","errorNameNotString");
        elseif(strlen($this->name)>128)
            $errors->addError(false,"name","errorNameLenght");

        if(is_null($this->user))
            $errors->addError(true,"text","errorUserNull");

        if(!is_null($this->parentFolder) && $this->parentFolder->user->id==$this->user->id)
            $errors->addError(true,"user","errorUserNotMatchParent");



        if($errors->hasErrors())
            throw new \OnionSkin\Exceptions\ValidationException($errors,"Errors during validation of snippet");*/
    }

}