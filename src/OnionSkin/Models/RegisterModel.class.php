<?php

namespace OnionSkin\Models
{
    use OnionSkin\Routing\Annotations\Post;
    use OnionSkin\Routing\Annotations\Required;
    use OnionSkin\Routing\Annotations\StringLength;
    use OnionSkin\Routing\Annotations\Validate;
	/**
	 * RegisterModel short summary.
	 *
	 * RegisterModel description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class RegisterModel
	{
        /**
         * @var string
         * @Validate(type="string", errorLangCode="errorNotString")
         * @StringLength(min=0, max=64, langCode="errorStringLength")
         * @Post(id="username")
         */
        public $username;

        /**
         * @var string
         * @Validate(type="string", errorLangCode="errorNotString")
         * @StringLength(min=4, max=100, langCode="errorStringLength")
         * @Post(id="password")
         */
        public $password;

        /**
         * @var string
         * @Validate(type="string", errorLangCode="errorNotString")
         * @StringLength(min=4, max=100, langCode="errorStringLength")
         * @Post(id="password2")
         */
        public $passwordAgain;

        /**
         * @var string
         * @Validate(type="email", errorLangCode="errorNotEmail")
         * @Post(id="email")
         */
        public $email;
	}
}