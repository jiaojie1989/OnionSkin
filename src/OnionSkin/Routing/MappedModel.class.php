<?php

namespace OnionSkin\Routing
{
	/**
	 * URL short summary.
	 *
	 * URL description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class MappedModel
	{
        /**
         * @var \Doctrine\Common\Annotations\CachedReader
         */
        private static $reader;

        /**
         * @param mixed $model
         * @param Request $request
         */
        public static function MapModel($request)
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
                if(!self::paramValidation($request->MappedModel,$prop,$request))
                    throw new \Exception();
            }
        }
        /**
         * @param mixed $model
         * @param \ReflectionProperty $param
         * @param Request $request
         */
        private static function paramLoad($model,$param,$request)
        {
            $data=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Post");
            if(!is_null($data))
            {
                $param->setValue($model,$request->POST[$data->id]);
            }
            $data=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\Get");
            if(!is_null($data))
            {
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
         * @param Request $request
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
                                return $data2->max >= strlen($model->{$param->name}) && $data2->min <= strlen($model->{$param->name});
                            else
                                return true;
                        }
                        else
                            return false;
                    case "email":
                        return filter_var($model->{$param->name},FILTER_VALIDATE_EMAIL);
                    case "int":
                        if(filter_var($model->{$param->name},FILTER_VALIDATE_INT))
                        {
                            $data2=self::$reader->getPropertyAnnotation($param,"\OnionSkin\Routing\Annotations\NumericRange");
                            if(!is_null($data2))
                                return $data2->max >= $model->{$param->name} && $data2->min <= $model->{$param->name};
                            else
                                return true;
                        }
                        else
                            return false;
                }
            }
            return true;
        }

	}
}