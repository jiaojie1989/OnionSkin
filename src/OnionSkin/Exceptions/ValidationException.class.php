<?php

namespace OnionSkin\Exceptions
{
	/**
	 * ValidationException short summary.
	 *
	 * ValidationException description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class ValidationException extends \Exception
	{
        public $errors;
        #region Exception Members

        /**
         * Construct the exception
         * Constructs the Exception.
         *
         * @param \OnionSkin\Exceptions\ErrorModel $errors
         * @param string $message The Exception message to throw.
         * @param int $code The Exception code.
         * @param \Throwable $previous The previous exception used for the exception chaining.
         */
        function __construct($errors,$message = "", $code = 0, $previous = NULL)
        {
            parent::__construct($message, $code, $previous);
            $this->errors=$errors;
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