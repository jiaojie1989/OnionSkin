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
            foreach(explode(";",$data["paths"]) as $pa)
                $this->paths[]=new RoutePath($pa);
            $this->model=$data["model"];
            $this->page=$data["page"];
        }

        /**
         *  @param Request  $request
         *  @return bool
         */
        public function valide($request)
        {
            if(in_array($request->Method,$this->methods))
            {
                foreach($this->paths as $path)
                {
                    if($path->valide($request))
                        return true;
                }
            }
            return false;
        }
        /**
         *  @param Request  $request
         *  @return bool
         */
        public function route($request)
        {
            if(in_array($request->Method,$this->methods))
            {
                foreach($this->paths as $path)
                {
                    if($path->valide($request)){
                        $path->route($request);
                        $request->Page=new $this->page;
                        if(!is_null($this->model))
                        {
                            $request->MappedModel=new $this->model;
                            MappedModel::MapModel($request);
                        }
                    }
                }
            }
            return false;
        }

	}
    class RoutePath
    {
        private $path;
        private $pathRegex;
        private $params=array();
        /**
         * Summary of __construct
         * @param string $path
         */
        public function __construct($path)
        {
            $par=array();
            preg_match_all("/\{[a-zA-Z0-9:]*\}/",$path,$par);
            foreach($par as $p)
                $this->params[]=new RoutePathParameter($p);
            $this->path=$path;
            $this->pathRegex=$path;
            $this->pathRegex="/^".addcslashes($this->pathRegex,'/')."$/";
            $this->pathRegex=preg_replace("/\{[a-zA-Z0-9:]*\}/","([^\/]*)",$this->pathRegex);
        }

        public function valide($request)
        {
            $par=array();
            preg_match_all($this->pathRegex,$path,$par);
            if(sizeof($par)-1!=sizeof($this->params))
                return false;
            for($i=0;$i<sizeof($par);$i++)
                if(!$this->params[$i]->valide($par[$i+1]))
                    return false;
            return true;
        }
        /**
         * @param Request $request
         */
        public function route($request)
        {
            preg_match_all($this->pathRegex,$request->Path,$request->Params);
            $request->Params=array_slice($request->Params,1);
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
        public function valide($value)
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