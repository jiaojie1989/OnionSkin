<?php

namespace OnionSkin\Entities;

/**
 * @Entity
 * @Table(name="categories")
 * @HasLifecycleCallbacks
 */
class Category {
	/**
     * @var int
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     * @Column(type="integer", name="category_id", nullable=false, options = {"unsigned"=true})
     */
	private $id;
	/**
	 * @Column(type="string", name="category_name", length=128, nullable=false)
	 */
	private $name;

	/**
	 * @ManyToOne(targetEntity="User", fetch="LAZY")
	 */
	private $user;
	/**
     * @ManyToOne(targetEntity="Category", fetch="LAZY")
	 */
	private $parentCategory;
    /**
     * @OneToMany(targetEntity="Category",mappedBy="parentCategory", fetch="EXTRA_LAZY")
     */
    private $childsCategories;

}