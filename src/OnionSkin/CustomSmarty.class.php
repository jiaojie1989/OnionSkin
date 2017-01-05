<?php

namespace OnionSkin
{
	/**
	 * CustomSmarty short summary.
	 *
	 * CustomSmarty description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class CustomSmarty extends \Smarty
	{
        function __construct()
        {
            parent::__construct();
            $this->setTemplateDir('templates/');
            $this->setCompileDir('templates_c/');
            $this->setConfigDir('configs/');
            $this->setCacheDir('cache/');
            $this->caching = \Smarty::CACHING_LIFETIME_CURRENT;
            $this->assign('app_name', 'OnionSkin');
            $this->assign("L",Lang::GetLang());
            $this->assign("ldim","{"); // Best way to avoid smarty parsing of { and }
            $this->assign("rdim","}");
            $this->assign("R",new RouterPlugin());
            $this->assign("H",new HelperPlugin());
            $this->assign("Form",new FormPlugin());
            $this->error_reporting = E_ALL & ~E_NOTICE;
        }

	}
    class HelperPlugin
    {
        public function cat($array)
        {
            $ret="";
            foreach($array as $key=>$value)
                $ret.=$value;
            return $ret;
        }
    }
    class RouterPlugin
    {
        public function Path($page,$vars=null)
        {
            return Routing\Router::Path("\\OnionSkin\\Pages\\".$page,$vars);
        }
        public function Route()
        {

        }
    }
    class FormPlugin
    {
        private $page;
        private $model;
        public function AntiForgeryToken()
        {
            if(!isset($_SESSION["csrf"]))
                $_SESSION["csrf"]=array();
            $token=bin2hex(random_bytes(32));
<<<<<<< HEAD
            $_SESSION["csrf"][]= array("page"=>$this->page, "token"=>$token, "validity"=>time()+60*30);
=======
            $_SESSION["csrf"][]= array("page"=>get_class($Page), "token"=>$token, "validity"=>time()+60*180);
>>>>>>> origin/develop
            return '<input type="hidden" name="csrf_token" value="'.$token.'" />';
        }
        public function BindModel($Model)
        {
            $this->model=$Model;
        }

        public function Start($id,$Page,$method,$attr=null)
        {
            $this->page="\\OnionSkin\\Pages\\".$Page;
            $ret='<form id="'.$id.'" action="'.Routing\Router::Path($this->page).'" method="'.$method.'"';
            if(is_array($attr))
                foreach($attr as $key=>$value)
                        $ret.=' '.$key.'="'.$value.'"';

            return $ret.'>';
        }
        public function End()
        {
            $this->page=null;
            $this->model=null;
            return "</form>";
        }
        public function TextBox($id,$label=null,$placeholder=null,$data=array())
        {
            $ret="";
            if(isset($data["wrapper"]))
                $ret.=$this->divStart($data["wrapper"]);
            else
                $ret.=$this->divStart();

            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            $dataInput=$data["input"];
            $dataInput=$this->appendThings($dataInput,"class","form-control");
            $ret.=$this->input($id,"text",$placeholder,$dataInput);

            $ret.=$this->divEnd();
            return $ret;
        }
        public function Email($id,$label=null,$placeholder=null,$data=array())
        {
            $ret="";
            if(isset($data["wrapper"]))
                $ret.=$this->divStart($data["wrapper"]);
            else
                $ret.=$this->divStart();

            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            $dataInput=$data["input"];
            $dataInput=$this->appendThings($dataInput,"class","form-control");
            $ret.=$this->input($id,"email",$placeholder,$dataInput);

            $ret.=$this->divEnd();
            return $ret;
        }
        public function Password($id,$label=null,$placeholder=null,$data=array())
        {
            $ret="";
            if(isset($data["wrapper"]))
                $ret.=$this->divStart($data["wrapper"]);
            else
                $ret.=$this->divStart();

            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            $dataInput=$data["input"];
            $dataInput=$this->appendThings($dataInput,"class","form-control");
            $ret.=$this->input($id,"password",$placeholder,$dataInput);

            $ret.=$this->divEnd();
            return $ret;
        }
        public function Submit($id,$value=null,$data=array())
        {
            $ret="";
            if(isset($data["wrapper"]))
                $ret.=$this->divStart($data["wrapper"]);
            else
                $ret.=$this->divStart();


            $dataInput=$data["input"];
            $style="button_middle";
            if(isset($data["style"]))
                $style=$data["style"];
            switch($style)
            {
                case "button_middle":
                    $dataInput=$this->appendThings($dataInput,"class","form-control btn");
                    $dataInput=$this->appendThings($dataInput,"value",$value);
                    $ret.='<div class="row"><div class="col-sm-6 col-sm-offset-3">';
                    $ret.=$this->input($id,"submit",null,$dataInput);
                    $ret.="</div></div>";
                    break;
            }

            $ret.=$this->divEnd();
            return $ret;
        }
        public function CheckBox($id,$label=null,$data=array())
        {
            $ret="";
            if(isset($data["wrapper"]))
                $ret.=$this->divStart($data["wrapper"]);
            else
                $ret.=$this->divStart();

            $dataInput=$data["input"];
            $ret.=$this->input($id,"checkbox",null,$dataInput).' ';

            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            $ret.=$this->divEnd();
            return $ret;
        }
        private function divStart($attr=null)
        {
            $return="<div";
            $attr=$this->appendThings($attr,"class","form-group");
            foreach($attr as $key=>$value)
               $return.=' '.$key.'="'.$value.'"';
            return $return.">";
        }
        private function divEnd()
        {
            return "</div>";
        }

        private function label($id,$label,$data=null)
        {
            $ret='<label for="'.$id.'"';
            if(is_array($data))
                foreach($data as $key=>$value)
                    $ret.=' '.$key.'="'.$value.'"';
            return $ret.">".$label."</label>";
        }
        private function input($id,$type,$placeholder=null,$data=null)
        {
            $ret='<input id="'.$id.'" name="'.$id.'" type="'.$type.'"';
            if(is_string($placeholder))
                $ret.=' placeholder="'.$placeholder.'"';
            if(is_array($data))
                foreach($data as $key=>$value)
                    if($key!="label" && $key!="wrapper")
                        $ret.=' '.$key.'="'.$value.'"';
            return $ret."/>";
        }
        function appendThings(/* map[string,mixed] */ $array, /* string */ $key, /* string */ $value) {
            if(!isset($array))
                $array=array();
            if(!isset($array[$key]))
                $array[$key]=$value;
            else
                $array[$key].=' '.$value;
            return $array;
        }
    }
}