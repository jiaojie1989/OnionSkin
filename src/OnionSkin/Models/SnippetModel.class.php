<?php

namespace OnionSkin\Models
{
    use OnionSkin\Routing\Annotations\Post;
    use OnionSkin\Routing\Annotations\Required;
    use OnionSkin\Routing\Annotations\StringLength;
    use OnionSkin\Routing\Annotations\NumericRange;
    use OnionSkin\Routing\Annotations\Validate;
    use OnionSkin\Routing\Annotations\Enum;
    use OnionSkin\Routing\Annotations\PostValidate;
	/**
	 * SnippetModel short summary.
	 *
	 * SnippetModel description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class SnippetModel extends Model
	{
        function __construct()
        {
            parent::__construct("\\OnionSkin\\Pages\\EditPage");
        }
        /**
         * @var string
         * @StringLength(min=3, max=64)
         * @Validate(type="string")
         * @Post(id="name")
         * @Required
         */
        public $name;
        /**
         * @var string
         * @StringLength(min=1, max=4294967295)
         * @Validate(type="string")
         * @Post(id="snippet")
         * @Required
         */
        public $snippet;

        /**
         * @var string
         * @StringLength(min=1, max=10)
         * @Validate(type="string")
         * @Post(id="syntax")
         */
        public $syntax;

        /**
         * @var int
         * @NumericRange(min=-1.0, max=2147483647.0)
         * @Validate(type="int")
         * @Post(id="folder")
         */
        public $folder;

        /**
         * @var int
         * @NumericRange(min=0.0, max=2.0)
         * @Validate(type="int")
         * @Post(id="visibility")
         * @Required
         */
        public $visibility;

        /**
         * @var string
         * @Enum(values={"never","10m","1h","1d","1w"})
         * @StringLength(min=2, max=6)
         * @Validate(type="string")
         * @Post(id="expiration")
         * @Required
         */
        public $expiration;

        /**
         * @PostValidate
         */
        public function expiration()
        {
            $syntax=json_decode(file_get_contents("config/languages.json"),true);
            if(!array_key_exists($this->syntax,$syntax) && $this->syntax!="txt")
                return new \OnionSkin\Exceptions\ErrorModel(false,"error_unknown_syntax",array(),"Unknown syntax of langugage");
            return null;
        }

	}
}