<?php

namespace OnionSkin\Exceptions
{
	/**
	 */
	class ValidationException extends \Exception
	{
        /**
         * @var \OnionSkin\Exceptions\ErrorModel
         */
        public $error;
        #region Exception Members

        /**
         * Construct the exception
         * Constructs the Exception.
         *
         * @param \OnionSkin\Exceptions\ErrorModel $error
         * @param string $message The Exception message to throw.
         * @param int $code The Exception code.
         * @param \Throwable $previous The previous exception used for the exception chaining.
         */
        function __construct($error,$message = "", $code = 0, $previous = NULL)
        {
            parent::__construct($message, $code, $previous);
            $this->error=$error;
        }

        /**
         * String representation of the exception
         * Returns the string representation of the exception.
         *
         * @return string
         */
        function __toString()
        {
            return parent::__toString();
        }

        #endregion
    }
}