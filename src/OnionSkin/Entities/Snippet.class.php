<?php

namespace OnionSkin\Entities;

/**
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
	private $id;
	/**
	 * @Column(type="string", length=128, nullable=false)
	 */
	private $title;
	/**
     * @Column(type="string", length=4294967295, nullable=false)
	 */
	private $text;
	/**
	 * @Column(type="datetime",name="date_added",nullable=false)
	 */
	private $createdTime;
	/**
	 * @Column(type="datetime",name="date_modified",nullable=false)
	 */
	private $modifiedTime;
	/**
     * @Column(type="binary", length=3)
	 */
	private $accessLevel;

	/**
	 * @ManyToOne(targetEntity="Category", fetch="LAZY")
	 */
	private $category;
	/**
	 * @ManyToOne(targetEntity="User", fetch="LAZY")
	 */
	private $user;

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
}