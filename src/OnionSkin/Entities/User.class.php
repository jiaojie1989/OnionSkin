<?php

namespace OnionSkin\Entities;

/**
 * @Entity
 * @Table(name="users")
 * @HasLifecycleCallbacks
 */
class User {
	/**
     * @var int
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     * @Column(type="integer", name="user_id", nullable=false, options = {"unsigned":true})
     */
	public $id;
	/**
     * @Column(type="string", length=64, nullable=false, unique=true)
     * @var string
     */
	public $username;
	/**
     * @Column(type="string", length=128, nullable=false, unique=true)
     * @var string
     */
	public $email;
	/**
     * @Column(type="string", length=256, nullable=false)
     * @var string
     */
	public $passwordAndSalt;
	/**
     * @Column(type="datetime", name="date_created", nullable=false)
     * @var \DateTime
     */
	public $createdTime;
	/**
     * @Column(type="boolean", name="is_admin", nullable=false, options = {"default":false})
     * @var boolean
     */
	public $admin=false;

    /**
     * @OneToMany(targetEntity="Folder",mappedBy="user", cascade={"persist", "remove", "merge"}, fetch="EXTRA_LAZY")
     * @var Folder[]
     */
    public $folders;


    /**
     * @PrePersist
     */
    public function prePersistCreatedDateTime()
    {
        $this->createdTime= new \DateTime();
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

        if(is_null($this->passwordAndSalt))
        $errors->addError(false,"passwordAndSalt","errorPasswordNull");
        elseif(!is_string($this->passwordAndSalt))
        $errors->addError(false,"passwordAndSalt","errorPasswordNotString");
        elseif(strlen($this->passwordAndSalt)>256)
        $errors->addError(false,"passwordAndSalt","errorPasswordLenght");

        if(is_null($this->username))
        $errors->addError(false,"username","errorUsernameNull");
        elseif(!is_string($this->username))
        $errors->addError(false,"username","errorUsernameNotString");
        elseif(strlen($this->username)>64)
        $errors->addError(false,"username","errorUsernameLenght");





        if($errors->hasErrors())
        throw new \OnionSkin\Exceptions\ValidationException($errors,"Errors during validation of snippet");*/
    }

    public function createPassword($password)
    {
        $salt = "";
        $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i < 22; $i++)
            $salt .= $salt_chars[array_rand($salt_chars)];
        $this->passwordAndSalt = crypt($password, sprintf('$2y$%02d$', 10) . $salt);
    }
    public function comparePassword($password)
    {
        return crypt($password,$this->passwordAndSalt)==$this->passwordAndSalt;
    }
    public function foldersToArray()
    {
        $array=array();
        $array[]=array("-1","/");
        foreach($this->folders as $value)
            /**
             * @var Folder $value
             * */
            if($value->parentFolder==null)
                $this->folders($array,$value," ");
        return $array;
    }
    /**
     * Summary of folders
     * @param array $id
     * @param Folder $folder
     */
    private function folders($array,$folder,$prefix)
    {
        $array[]=array($folder->id,$prefix.$folder->name);
        foreach($folder->childsFolders as $value)
            $this->folders($array,$value,$prefix." ");
    }
}