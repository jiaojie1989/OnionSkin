<?php

namespace OnionSkin\Models
{
	/**
	 * Login short summary.
	 *
	 * Login description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class LoginModel
	{
        /**
         * @var string
         * @stringLength(min=0, max=64, langCode="errorStringLength")
         * @post(id="username")
         */
        public $username;

        /**
         * @var string
         * @stringLength(min=4, max=100, langCode="errorStringLength")
         * @post(id="password")
         */
        public $password;
	}
}