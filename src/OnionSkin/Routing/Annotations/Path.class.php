<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * Map variable from Path params.
     *
     * @Annotation
     * @Target({"PROPERTY"})
     */
	class Path
	{
        /**
         * @var string
         */
        public $id;
	}
}