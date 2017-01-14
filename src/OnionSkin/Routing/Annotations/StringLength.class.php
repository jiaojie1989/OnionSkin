<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * Annotation for Model.
     * 
     * @Annotation
     * @Target({"PROPERTY"})
     */
	class StringLength
	{
        /**
         * @var int
         */
        public $min;

        /**
         * @var int
         */
        public $max;

	}
}