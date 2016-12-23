<?php

namespace OnionSkin\Annotations
{
	/**
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