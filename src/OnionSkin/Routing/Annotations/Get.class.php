<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * Map variable from GET params.
     * 
     * @Annotation
     * @Target({"PROPERTY"})
     */
	class Get
	{
        /**
         * @var string
         */
        public $id;
	}
}