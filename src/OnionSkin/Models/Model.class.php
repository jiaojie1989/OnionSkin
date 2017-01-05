<?php

namespace OnionSkin\Models
{
    use OnionSkin\Exceptions\ErrorModel;
    use OnionSkin\Exceptions\ValidationException;
    /**
     * Model short summary.
     *
     * Model description.
     *
     * @version 1.0
     * @author Fry
     */
    abstract class Model
    {
        public $Page;

        public $refPOST=array(),$refGET=array();

        public $Errors=array();

        public $AntiForgetoryToken;

        function __construct($Page) {
            $this->Page=$Page;
        }
        public function validateAntiForgetoryToken($Page)
        {
            $this->AntiForgetoryToken=$_POST["csrf_token"];
            if(!isset($_SESSION["csrf"]))
                return false;
            foreach($_SESSION["csrf"] as $key=>$csrf)
            {
                if($csrf["validity"]<time())
                    unset($_SESSION["csrf"][$key]);
                if($this->Page==$csrf["page"] && $this->AntiForgetoryToken==$csrf["token"])
                {
                    unset($_SESSION["csrf"][$key]);
                    return true;
                }
            }
            return false;
        }

        /**
         * @var \Doctrine\Common\Annotations\CachedReader
         */
        private static $reader;

        /**
         * @param mixed $model
         * @param \OnionSkin\Routing\Request $request
         */
        public static function MapRequest($request)
        {
            if(is_null(self::$reader))
            {
                self::$reader = new \Doctrine\Common\Annotations\CachedReader(new \Doctrine\Common\Annotations\AnnotationReader(),new \Doctrine\Common\Cache\ApcCache(),true);
            }
            $reflClass = new \ReflectionClass($request->MappedModel);
            $props   = $reflClass->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
            foreach($props as $prop)
            {
                self::paramLoad($request->MappedModel,$prop,$request);
                $val=self::paramValidation($request->MappedModel,$prop,$request);
                if($val!=null)
                    throw new ValidationException($val);
            }
        }
        /**
         * @param mixed $model
         * @param \ReflectionProperty $param
         * @param \OnionSkin\Routing\Request $request
         */
        private static function paramLoad($model,$param,$request)
        {
            $data=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Post");
            if(!is_null($data))
            {
                $model->refPOST[$data->id]=$param->name;
                $param->setValue($model,$request->POST[$data->id]);
            }
            $data=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Get");
            if(!is_null($data))
            {
                $model->refGET[$data->id]=$param->name;
                $param->setValue($model,$request->GET[$data->id]);
            }
            $data=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Path");
            if(!is_null($data))
            {
                $param->setValue($model,$request->Params[$data->id]);
            }
        }

        /**
         * @param mixed $model
         * @param \ReflectionProperty $param
         * @param \OnionSkin\Routing\Request $request
         */
        private static function paramValidation($model,$param,$request)
        {
            $data=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Validate");
            if(!is_null($data))
            {
                switch($data->type)
                {
                    case "string":
                        if(is_string($data->{$param->name}))
                        {
                            $data2=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\StringLength");
                            if(!is_null($data2))
                                if($data2->max >= strlen($model->{$param->name}) && $data2->min <= strlen($model->{$param->name}))
                                    return new ErrorModel(false,"error_string_length",array($data2->min,$data2->max),"String length not match");
                            else
                                return null;
                        }
                        else
                            return new ErrorModel(false,"error_not_a_string",array(),"Value isnt string");
                    case "email":
                        if(filter_var($model->{$param->name},FILTER_VALIDATE_EMAIL))
                            return new ErrorModel(false,"error_email",array(),"Invalid email");
                    case "int":
                        if(filter_var($model->{$param->name},FILTER_VALIDATE_INT))
                        {
                            $data2=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\NumericRange");
                            if(!is_null($data2))
                                if($data2->max >= $model->{$param->name} && $data2->min <= $model->{$param->name})
                                    return new ErrorModel(false,"error_int_range",array($data2->min,$data2->max),"Value");
                            else
                                return null;
                        }
                        else
                            return new ErrorModel(false,"error_int_invalid",array(),"Value ".$model->{$param->name}." is not int.");
                }
            }
            return null;
        }

    }

}