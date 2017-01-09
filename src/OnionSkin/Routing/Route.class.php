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
        /**
         * Summary of $methods
         * @var array
         */
        private $methods;
        /**
         *
         * @var RoutePath[]
         */
        private $paths;
        private $page;
        private $model;

        /**
         * Summary of getPage
         * @return mixed
         */
        public function getPage()
        {
            return $this->page;
        }
        /**
         * Summary of getMethods
         * @return array
         */
        public function getMethods()
        {
            return $this->methods;
        }

        public function __construct($data)
        {
            $this->methods=explode(";",$data["methods"]);
            foreach(explode(";",$data["paths"]) as $pa)
                $this->paths[]=new RoutePath($pa);
            if(isset($data["model"]))
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
                            \OnionSkin\Models\Model::MapRequest($request);
                        }
                        return true;
                    }
                }
            }
            return false;
        }
        public function path($vars=null)
        {
            foreach($this->paths as $path)
                if(count($path->getParams())==count($vars))
                    return $path->getPath($vars);
            return $this->paths[0]->getPath($vars);
        }

	}
    class RoutePath
    {
        private $path;
        private $pathRegex;
        private $params=array();

        public function getParams()
        {
            return $this->params;
        }
        /**
         * Summary of __construct
         * @param string $path
         */
        public function __construct($path)
        {
            $par=array();
            preg_match_all("/\{[a-zA-Z0-9:]*\}/",$path,$par);
            foreach($par as $p)
                if(sizeof($p)>0)
                    foreach($p as $pp)
                    $this->params[]=new RoutePathParameter($pp);
            $this->path=$path;
            $this->pathRegex=$path;
            $this->pathRegex="/^".addcslashes($this->pathRegex,'/')."$/";
            //$this->pathRegex="/^".$this->pathRegex."$/";
            $this->pathRegex=preg_replace("/\{[a-zA-Z0-9:]*\}/","([^\/]*)",$this->pathRegex);
        }

        public function getPath($vars=null)
        {
            $path=$this->path;
            if(!is_null($vars))
                foreach($vars as $var)
                    $path=preg_replace("/\{[a-zA-Z0-9:]*\}/",$var,$path,1);
            return $path;
        }
        /**
         * @param Request request
         */
        public function valide($request)
        {
            $par=array();
            if(preg_match_all($this->pathRegex,$request->Path,$par)==0)
                return false;
            if(sizeof($par)-1!=sizeof($this->params))
                return false;
            for($i=0;$i<sizeof($par)-1;$i++)
                if(!$this->params[$i]->valide($par[$i+1][0]))
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
            $ret=array();
            for($i=0;$i<count($this->params);$i++)
                $ret[$this->params[$i]->name]=$request->Params[$i];
            $request->Params=$ret;
        }
    }
    class RoutePathParameter
    {
        private $param;
        private $type;
        public $name;
        public function __construct($param)
        {
            $this->param=$param;
            preg_match("/[^{][a-zA-Z0-9]*[^:]/",$param,$this->name);
            preg_match("/(?<=:).[a-zA-Z0-9]*/",$param,$this->type);
            $this->name=$this->name[0];
            $this->type=$this->type[0];
        }
        public function valide($value)
        {
            switch($this->type)
            {
                case "int":
                    return is_numeric($value);
                case "float":
                    return is_float($value) || is_numeric($value) && ((float) $value != (int) $value);
                case "double":
                    return is_double($value) || is_numeric($value) && ((double) $value != (int) $value);
                case "long":
                    return is_numeric($value) && is_long($value);
                case "string":
                default:
                    return is_string($value);

            }
        }
    }
}