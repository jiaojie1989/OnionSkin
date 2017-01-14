<?php

namespace OnionSkin\Exceptions
{
	/**
	 */
	class ErrorModel
	{
        /** @var bool
         */
        public $Severe;

        /** @var string
         */
        public $LngCode;

        /** @var string[]
         */
        public $LngParams;

        /** @var string
         */
        public $Reason;
        /**
         *
         * @param bool $severe
         * @param string $variable
         * @param string $lngCode
         */
        public function __construct($severe,$lngCode,$lngParams=array(),$reason=null)
        {
            $this->Severe=$severe;
            $this->LngCode=$lngCode;
            $this->LngParams=$lngParams;
            $this->Reason=$reason;
        }

	}
}