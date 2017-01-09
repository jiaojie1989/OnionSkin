<?php

namespace OnionSkin\Models
{
    use OnionSkin\Routing\Annotations\Post;
    use OnionSkin\Routing\Annotations\Required;
    use OnionSkin\Routing\Annotations\StringLength;
    use OnionSkin\Routing\Annotations\Validate;
	/**
	 * Login short summary.
	 *
	 * Login description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class LoginModel extends Model
	{
        function __construct()
        {
            parent::__construct("\\OnionSkin\\Pages\\Profile\\LoginPage");
        }
        /**
         * @var string
         * @StringLength(min=3, max=64)
         * @Validate(type="string")
         * @Post(id="username")
         */
        public $username;

        /**
         * @var string
         * @StringLength(min=4, max=100)
         * @Validate(type="string")
         * @Post(id="password")
         */
        public $password;

        function __sleep()
        {
            $arr=parent::__sleep();
            $arr=array_merge($arr,array("username","password"));
            return $arr;
        }
	}
}