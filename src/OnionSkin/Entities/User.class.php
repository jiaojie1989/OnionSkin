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
	 */
	public $username;
	/**
	 * @Column(type="string", length=256, nullable=false)
	 */
	public $passwordAndSalt;
	/**
     * @Column(type="datetime", name="date_created", nullable=false)
	 */
	public $createdTime;
	/**
	 * @Column(type="boolean", name="is_admin", nullable=false, options = {"default":false})
	 * @var boolean
	 */
	public $admin;

    /**
     * @OneToMany(targetEntity="Snippet",mappedBy="user", cascade={"persist", "remove", "merge"}, fetch="EXTRA_LAZY")
     */
    public $snippets;
    /**
     * @OneToMany(targetEntity="Category",mappedBy="user", cascade={"persist", "remove", "merge"}, fetch="EXTRA_LAZY")
     */
    public $categories;


    /**
     * @PrePersist
     */
    public function prePersistCreatedDateTime()
    {
        $this->createdTime= new \DateTime();
    }

}