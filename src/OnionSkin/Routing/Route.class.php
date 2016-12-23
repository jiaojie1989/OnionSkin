<?php

namespace OnionSkin\Routing
{
	/**
     * Route short summary.
     *
     * Route description.
     *
     * @version 1.0
     * @author Fry
     */
	class Route
	{
        private $methods;
        /**
         *
         * @var RoutePath[]
         */
        private $paths;
        private $page;
        private $model;

        public function __construct($data)
        {
            $this->methods=explode(";",$data["methods"]);
            $this->paths=explode(";",$data["paths"]);
            $this->page=$data["page"];
        }

        /**
         *  @param Routing\URL  $url
         *  @return bool
         */
        public function contain($url)
        {
            if(in_array($url->method,$this->methods))
            {
                foreach($this->paths as $path)
                {
                    if($path->contain($url))
                        return true;
                }
            }
            return false;
        }
        /**
         * @param Request $request
         */
        public function getMappedModel($request)
        {
            $model= new $this->model;
            $reader = new \Doctrine\Common\Annotations\AnnotationReader();
            $reflClass = new \ReflectionClass($this->model);
            $props   = $reflClass->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
            foreach($props as $prop)
            {
            }
            $classAnnotations = $reader->getClassAnnotations($reflClass);


        }
        private function model_load($model,$prop,$reader,$request)
        {
            $data=$reader->getPropertyAnnotation($prop,"\OnionSkin\Annotations\Post");
            if(!is_null($data))
            {
                $prop->setValue($model,$request->POST[$data->id]);
            }
            $data=$reader->getPropertyAnnotation($prop,"\OnionSkin\Annotations\Get");
            if(!is_null($data))
            {
                $prop->setValue($model,$request->GET[$data->id]);
            }
            $data=$reader->getPropertyAnnotation($prop,"\OnionSkin\Annotations\Path");
            if(!is_null($data))
            {
                $prop->setValue($model,$request->Params[$data->id]);
            }
        }

	}
    class RoutePath
    {
        private $path;
        private $pathRegex;
        private $params=array();
        public function __construct($path)
        {
            $par=array();
            preg_match_all("/\{[a-zA-Z0-9:]*\}/",$path,$par);
            foreach($par as $p)
                $this->params[]=new RoutePathParameter($p);
            $this->path=$path;
            $this->pathRegex=$path;
            $this->pathRegex="/^".str_replace("/","\/",$this->pathRegex)."$/";
            $this->pathRegex=preg_replace("/\{[a-zA-Z0-9:]*\}/","([^\/]*)",$this->pathRegex);
        }

        public function contain($path)
        {
            $par=array();
            preg_match_all($this->pathRegex,$path,$par);
            if(sizeof($par)-1!=sizeof($this->params))
                return false;
            for($i=0;$i<sizeof($par);$i++)
                if(!$this->params[$i]->isValid($par[$i+1]))
                    return false;
            return true;
        }
    }
    class RoutePathParameter
    {
        private $param;
        private $type;
        private $name;
        public function __construct($param)
        {
            $this->param=$param;
            preg_match("/[^{][a-zA-Z0-9]*[^:]/",$param,$this->name);
            preg_match("/(?<=:).[a-zA-Z0-9]*/",$param,$this->type);
        }
        public function isValid($value)
        {
            switch($this->type)
            {
                case "int":
                    return is_int($value);
                case "float":
                    return is_float($value);
                case "double":
                    return is_double($value);
                case "long":
                    return is_long($value);
                case "string":
                default:
                    return is_string($value);

            }
        }
    }
}