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
	class RegisterModel extends Model
	{
        function __construct()
        {
            parent::__construct("\\OnionSkin\\Pages\\Profile\\RegisterPage");
        }

        /**
         * @var string
         * @Validate(type="string")
         * @StringLength(min=0, max=64)
         * @Post(id="username")
         */
        public $username;

        /**
         * @var string
         * @Validate(type="string")
         * @StringLength(min=4, max=100)
         * @Post(id="password")
         */
        public $password;

        /**
         * @var string
         * @Validate(type="string")
         * @StringLength(min=4, max=100)
         * @Post(id="password2")
         */
        public $passwordAgain;

        /**
         * @var string
         * @Validate(type="email")
         * @Post(id="email")
         */
        public $email;

        function __sleep()
        {
            $arr=parent::__sleep();
            $arr=array_merge($arr,array("username","password","passwordAgain","email"));
            return $arr;
        }
	}
}