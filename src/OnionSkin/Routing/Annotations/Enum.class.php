<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * @Annotation
     * @Target({"PROPERTY"})
     */
	class Enum
	{
        /**
         * @var array
         */
        public $values;
	}
}