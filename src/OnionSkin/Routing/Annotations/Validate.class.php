<?php

namespace OnionSkin\Routing\Annotations
{
	/**
     * Annotation for Model.
     * 
     * @Annotation
     * @Target({"PROPERTY"})
     * */
	class Validate
	{
        /** @Enum({"email","string","int","long","float","double","telephone"})
         *  @var string
         */
        public $type;

        /**
         * @var string
         */
        public $errorLangCode;
	}
}