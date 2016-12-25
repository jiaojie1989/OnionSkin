<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * @Annotation
     * @Target({"PROPERTY"})
     */
	class NumericRange
	{
        /**
         * @var double
         */
        public $min;

        /**
         * @var double
         */
        public $max;
	}
}