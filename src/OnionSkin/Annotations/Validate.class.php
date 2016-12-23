<?php

namespace OnionSkin\Annotations
{
	/**
     * @Annotation
     * @Target({"PROPERTY"})
     * */
	class Validate
	{
        /** @Enum({"email","string","int","long","float","double","telephone"})*/
        public $type;

        /**
         * @var string
         */
        public $errorLangCode;
	}
}