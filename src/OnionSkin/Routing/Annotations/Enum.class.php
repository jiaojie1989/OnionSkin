<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * Annotation for Model.
     *
     * 
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