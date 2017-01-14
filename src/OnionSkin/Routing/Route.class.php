<?php

namespace OnionSkin\Routing
{
	/**
     * 
     */
	class Route
	{
        /**
         * @var string[]
         */
        private $methods;
        /**
         *
         * @var RoutePath[]
         */
        private $paths;

        /**
         * @var string
         */
        private $page;

        /**
         * @var string
         */
        private $model;

        /**
         * Return defined page as string (namespace + classname)
         * @return string
         */
        public function getPage()
        {
            return $this->page;
        }

        /**
         * @return string[]
         */
        public function getMethods()
        {
            return $this->methods;
        }

        /**
         * @param string[] $data
         */
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

    /**
     *
     */
    class RoutePath
    {
        /**
         * @var string
         */
        private $path;

        /**
         * @var string
         */
        private $pathRegex;

        /**
         * @var RoutePathParameter[]
         */
        private $params=array();


        /**
         * @return RoutePathParameter[]
         */
        public function getParams()
        {
            return $this->params;
        }

        /**
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

        /**
         * Return path.
         * @param string[] $vars
         * @return string
         */
        public function getPath($vars=null)
        {
            $path=$this->path;
            if(!is_null($vars))
                foreach($vars as $var)
                    $path=preg_replace("/\{[a-zA-Z0-9:]*\}/",$var,$path,1);
            return $path;
        }

        /**
         * Validate request
         * @param Request request
         * @return boolean
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
         * Route request.
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

    /**
     * Parameter of path.
     */
    class RoutePathParameter
    {
        /**
         * @var string
         */
        private $param;

        /**
         * @var string Enum["int","float","double","long","string"]
         */
        private $type;

        /**
         * @var string
         */
        public $name;

        /**
         * @param string $param
         */
        public function __construct($param)
        {
            $this->param=$param;
            $matched_name=array();
            $matched_type=array();
            preg_match("/[^{][a-zA-Z0-9]*[^:]/",$param,$matched_name);
            preg_match("/(?<=:).[a-zA-Z0-9]*/",$param,$matched_type);
            $this->name=$matched_name[0];
            $this->type=$matched_type[0];
        }

        /**
         * Validate value based on parameter type.
         * @param mixed $value
         * @return boolean
         */
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