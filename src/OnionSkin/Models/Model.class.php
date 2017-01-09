<?php

namespace OnionSkin\Models
{
    use OnionSkin\Exceptions\ErrorModel;
    use OnionSkin\Exceptions\ValidationException;
    use Doctrine\Common\Annotations\AnnotationRegistry;
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

        function __sleep()
        {
            return array("refPOST","refGET","Errors","Page");
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
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/Get.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/Post.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/Path.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/NumericRange.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/Required.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/StringLength.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/Validate.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/Enum.class.php");
                AnnotationRegistry::registerFile("src/OnionSkin/Routing/Annotations/PostValidate.class.php");
                self::$reader = new \Doctrine\Common\Annotations\CachedReader(new \Doctrine\Common\Annotations\AnnotationReader(),new \Doctrine\Common\Cache\ArrayCache(),true);
            }
            $reflClass = new \ReflectionClass($request->MappedModel);
            $props   = $reflClass->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
            foreach($props as $prop)
            {
                self::paramLoad($request->MappedModel,$prop,$request);
                $val=self::paramValidation($request->MappedModel,$prop,$request);
                if($val!=null)
                {
                    $r=\OnionSkin\Lang::GetLang()[$val->LngCode];
                    foreach($val->LngParams as $key=>$value)
                        $r=str_replace('{'.$key.'}',$value,$r);
                    $request->MappedModel->Errors[$prop->name]=$r;
                    throw new ValidationException($val);
                }
            }
            $funcs = $reflClass->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach($funcs as $func)
            {
                /**
                 * @var \ReflectionMethod $func
                 */
                $data=self::$reader->getMethodAnnotation($func,"\OnionSkin\Routing\Annotations\PostValidate");
                if(!isset($data))
                    continue;
                $val=$func->invoke($request->MappedModel);
                if($val!=null)
                {
                    $r=\OnionSkin\Lang::GetLang()[$val->LngCode];
                    foreach($val->LngParams as $key=>$value)
                        $r=str_replace('{'.$key.'}',$value,$r);
                    $request->MappedModel->Errors[$func->name]=$r;
                    throw new ValidationException($val);
                }
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
            $req=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Required");
            if(!isset($req) && !isset($model->{$param->name}))
                return null;
            if(!is_null($data))
            {
                switch($data->type)
                {
                    case "string":
                        if(is_string($model->{$param->name}))
                        {
                            $data2=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\StringLength");
                            if(!is_null($data2))
                                if($data2->max < strlen($model->{$param->name}) || $data2->min > strlen($model->{$param->name}))
                                    return new ErrorModel(false,"error_string_length",array($data2->min,$data2->max),"String length not match");
                            $data2=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Enum");
                            if(!is_null($data2))
                                if(!in_array($model->{$param->name},$data2->values))
                                    return new ErrorModel(false,"error_string_enum",array($data2->values),"String is not in enum");

                        }
                        else
                            return new ErrorModel(false,"error_not_a_string",array(),"Value isnt string");

                        return null;
                    case "email":
                        if(!filter_var($model->{$param->name},FILTER_VALIDATE_EMAIL))
                            return new ErrorModel(false,"error_email",array(),"Invalid email");
                        else
                            return null;
                    case "int":
                        if(filter_var($model->{$param->name},FILTER_VALIDATE_INT))
                        {
                            $data2=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\NumericRange");
                            if(!is_null($data2))
                                if($data2->max > $model->{$param->name} && $data2->min < $model->{$param->name})
                                    return new ErrorModel(false,"error_int_range",array($data2->min,$data2->max),"Value");
                            else
                                return null;
                        }
                        else
                            return new ErrorModel(false,"error_int_invalid",array(),"Value ".$model->{$param->name}." is not int.");
                        return null;
                }
            }
            return null;
        }

    }

}