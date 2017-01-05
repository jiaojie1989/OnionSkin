<?php

namespace OnionSkin\Exceptions
{
	/**
	 * ErrorModel short summary.
	 *
	 * ErrorModel description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class ErrorModel
	{
        public $Severe;
        public $LngCode;
        public $LngParams;
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

        public function hasErrors()
        {
            
        }
	}
}