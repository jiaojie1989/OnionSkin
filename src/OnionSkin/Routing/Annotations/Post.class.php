<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * Map variable from POST params.
     * 
     * @Annotation
     * @Target({"PROPERTY"})
	 */
	class Post
	{
        /**
         * @var string
         */
        public $id;
	}
}