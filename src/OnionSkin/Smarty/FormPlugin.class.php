<?php

namespace OnionSkin\Smarty
{
    use OnionSkin\Routing\Router;
	/**
	 * FormPlugin short summary.
	 *
	 * FormPlugin description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class FormPlugin
	{
        /**
         * @var string
         */
        private $page;
        /**
         * @var \OnionSkin\Models\Model
         */
        private $model;
        /**
         * @var string
         */
        private $method;

        private $labelCls=null;

        private $controlCls=null;

        private $inner_wrapperAttr=null;
        /**
         * Summary of AntiForgeryToken
         * @return string
         */
        public function AntiForgeryToken()
        {
            if(!isset($_SESSION["csrf"]))
                $_SESSION["csrf"]=array();
            $token=bin2hex(random_bytes(32));
            $_SESSION["csrf"][]= array("page"=>$this->page, "token"=>$token, "validity"=>time()+60*30);
            return '<input type="hidden" name="csrf_token" value="'.$token.'" />';
        }
        /**
         *
         * @param \OnionSkin\Models\Model $Model
         */
        public function BindModel($model_cookie)
        {
            if(isset($_SESSION[$model_cookie]))
            {
                $this->model=unserialize($_SESSION[$model_cookie]);
                unset($_SESSION[$model_cookie]);
            }
        }
        /**
         * @param string $id
         * @param string $Page
         * @param string $method
         * @param array $attr
         * @return string
         */
        public function Start($id,$Page,$method,$attr=array(),$paths=array())
        {
            $this->page="\\OnionSkin\\Pages\\".$Page;
            $this->method=$method;
            $ret='<form id="'.$id.'" action="'.Router::Path($this->page,$paths,strtoupper($method)).'" method="'.$method.'"';
            foreach($attr as $key=>$value)
            {
                if($key=="class" && strpos($value, 'form-horizontal') !== false)
                {
                    $this->labelCls="col-sm-2";
                    $this->inner_wrapperAttr="col-sm-10";
                    $this->controlCls="col-sm-offset-2 col-sm-10";
                }
                $ret.=' '.$key.'="'.$value.'"';
            }

            return $ret.'>';
        }
        /**
         * Summary of End
         * @return string
         */
        public function End()
        {
            $this->page=null;
            $this->model=null;
            $this->method=null;
            return "</form>";
        }
        private function defInput($type,$id,$label=null,$placeholder=null,$data=array())
        {
            $ret="";
            $dataInput=$data["input"];
            $v=null;
            $feed="";
            if(isset($this->model))
                if($this->method=="post")
                {
                    $v=$this->model->Errors[$this->model->refPOST[$id]];
                }
                else
                    $v=$this->model->Errors[$this->model->refGET[$id]];
            if($v!=null)
            {
                $dataInput=$this->appendThings($dataInput,"class","form-control form-control-danger");
                $data["wrapper"]=$this->appendThings($data["wrapper"],"class","has-danger");
            }
            else
                $v="";
            $feed.=$this->feedback($v,$data["error"]);

            $ret.=$this->divStart($data["wrapper"]);
            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            if($this->inner_wrapperAttr!=null)
                $ret.='<div class="'.$this->inner_wrapperAttr.'">';
            $dataInput=$this->appendThings($dataInput,"class","form-control");
            $ret.=$this->input($id,$type,$placeholder,$dataInput);
            $ret.=$feed;
            if(isset($data["help"]))
            {
                $ret.=$this->help($data["help"],$data["helper"]);
            }
            if($this->inner_wrapperAttr!=null)
                $ret.='</div>';
            $ret.=$this->divEnd();
            return $ret;
        }
        public function Select($id,$options,$label=null,$data=array(),$value="")
        {
            $ret="";
            $dataInput=$data["select"];
            $v=null;
            $feed="";
            if(isset($this->model))
                if($this->method=="post")
                {
                    $v=$this->model->Errors[$this->model->refPOST[$id]];
                }
                else
                    $v=$this->model->Errors[$this->model->refGET[$id]];
            if($v!=null)
            {
                $data["wrapper"]=$this->appendThings($data["wrapper"],"class","has-error has-feedback");
                $feed='<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>';
            }
            else
                $v="";
            $feed.=$this->feedback($v,$data["error"]);

            $ret.=$this->divStart($data["wrapper"]);
            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            if($this->inner_wrapperAttr!=null)
                $ret.='<div class="'.$this->inner_wrapperAttr.'">';
            $dataInput=$this->appendThings($dataInput,"class","form-control");

            if(isset($this->model))
                if($this->method=="get" && isset($this->model->refGET[$id]))
                {
                    $value=$this->model->{$this->model->refGET[$id]};
                }
                elseif($this->method=="post" && isset($this->model->refPOST[$id]))
                {
                    $value=$this->model->{$this->model->refPOST[$id]};
                }
            $ret.='<select id="'.$id.'" name="'.$id.'"';
            if(is_array($dataInput))
                foreach($dataInput as $key=>$val)
                    if($key!="label" && $key!="wrapper" && $key!="help")
                        $ret.=' '.$key.'="'.$val.'"';
            $ret.=">";
            foreach($options as $key=>$val)
            {
                $sel="";
                if(is_array($val))
                {
                    if($value==$val[0])
                        $sel=' selected="selected"';
                    $ret.='<option '.$sel.' value="'.$val[0].'" >'.$val[1].'</option>';
                    continue;
                }
                if($value==$key)
                    $sel=' selected="selected"';
                $ret.='<option'.$sel.' value="'.$key.'" >'.htmlspecialchars($val).'</option>';
            }
            $ret.="</select>";
            $ret.=$feed;
            if(isset($data["help"]))
            {
                $ret.=$this->help($data["help"],$data["helper"]);
            }
            if($this->inner_wrapperAttr!=null)
                $ret.='</div>';
            $ret.=$this->divEnd();
            return $ret;
        }
        public function TextArea($id,$label=null,$placeholder=null,$data=array())
        {
            $ret="";
            $dataInput=$data["textarea"];
            $v=null;
            $feed="";
            if(isset($this->model))
                if($this->method=="post")
                {
                    $v=$this->model->Errors[$this->model->refPOST[$id]];
                }
                else
                    $v=$this->model->Errors[$this->model->refGET[$id]];
            if($v!=null)
            {
                $data["wrapper"]=$this->appendThings($data["wrapper"],"class","has-error has-feedback");
                $feed='<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>';
            }
            else
                $v="";
            $feed.=$this->feedback($v,$data["error"]);

            $ret.=$this->divStart($data["wrapper"]);
            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            if($this->inner_wrapperAttr!=null)
                $ret.='<div class="'.$this->inner_wrapperAttr.'">';
            $dataInput=$this->appendThings($dataInput,"class","form-control auto_grow");
            $dataInput=$this->appendThings($dataInput,"rows","3");

            $value="";
            if(isset($this->model))
                if($this->method=="get" && isset($this->model->refGET[$id]))
                {
                    $value=$this->model->{$this->model->refGET[$id]};
                }
                elseif($this->method=="post" && isset($this->model->refPOST[$id]))
                {
                    $value=$this->model->{$this->model->refPOST[$id]};
                }
            $ret.='<textarea id="'.$id.'" name="'.$id.'"';
            if(is_string($placeholder))
                $ret.=' placeholder="'.$placeholder.'"';
            if(is_array($dataInput))
                foreach($dataInput as $key=>$val)
                    if($key!="label" && $key!="wrapper" && $key!="help")
                        $ret.=' '.$key.'="'.$val.'"';
            $ret.=">".$value."</textarea>";
            $ret.=$feed;
            if(isset($data["help"]))
            {
                $ret.=$this->help($data["help"],$data["helper"]);
            }
            if($this->inner_wrapperAttr!=null)
                $ret.='</div>';
            $ret.=$this->divEnd();
            return $ret;
        }
        public function TextBox($id,$label=null,$placeholder=null,$data=array())
        {
            return $this->defInput("text",$id,$label,$placeholder,$data);
        }
        public function Email($id,$label=null,$placeholder=null,$data=array())
        {
            return $this->defInput("email",$id,$label,$placeholder,$data);
        }
        public function Password($id,$label=null,$placeholder=null,$data=array())
        {
            return $this->defInput("password",$id,$label,$placeholder,$data);
        }
        public function Button($id,$value,$data=array())
        {
            $ret="";
            $data=$this->appendThings($data,"class","btn");
            $data=$this->appendThings($data,"value",$value);
            $data=$this->appendThings($data,"type","submit");
            if($this->controlCls!=null)
                $ret.='<div class="'.$this->controlCls.'">';
            $ret.='<button id="'.$id.'" name="'.$id.'"';
            if(is_array($data))
                foreach($data as $key=>$val)
                    $ret.=' '.$key.'="'.$val.'"';
            $ret.=">".$value."</button>";
            if($this->controlCls!=null)
                $ret.='</div>';
            return $ret;
        }
        public function Submit($id,$value=null,$data=array())
        {
            $ret="";
            $ret.=$this->divStart($data["wrapper"]);

            if($this->controlCls!=null)
                $ret.='<div class="'.$this->controlCls.'">';

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
                case "link":
                    $dataInput=$this->appendThings($dataInput,"class","btn-link btn");
                    $dataInput=$this->appendThings($dataInput,"value",$value);
                    return $this->input($id,"submit",null,$dataInput);
            }

            if($this->controlCls!=null)
                $ret.='</div>';
            $ret.=$this->divEnd();
            return $ret;
        }
        public function CheckBox($id,$label=null,$data=array())
        {
            $ret="";
            $ret.=$this->divStart($data["wrapper"]);

            $dataInput=$data["input"];
            if($this->controlCls!=null)
                $ret.='<div class="'.$this->controlCls.'">';

            $ret.='<div class="checkbox">'.$this->input($id,"checkbox",null,$dataInput).' ';

            if(!is_null($label))
                if(isset($data) && isset($data["label"]))
                    $ret.=$this->label($id,$label,$data["label"]);
                else
                    $ret.=$this->label($id,$label);

            if($this->controlCls!=null)
                $ret.='</div>';
            $ret.='</div>'.$this->divEnd();
            return $ret;
        }
        private function divStart($attr=null)
        {
            $return="<div";
            $attr=$this->appendThings($attr,"class","form-group row");
            foreach($attr as $key=>$value)
                $return.=' '.$key.'="'.$value.'"';
            return $return.">";
        }
        private function divEnd()
        {
            return "</div>";
        }

        private function label($id,$label,$data=array())
        {
            $ret='<label for="'.$id.'"';
            if($this->labelCls!=null)
                $data=$this->appendThings($data,"class",$this->labelCls);
            if(is_array($data))
                foreach($data as $key=>$value)
                    $ret.=' '.$key.'="'.$value.'"';
            return $ret.">".$label."</label>";
        }
        private function input($id,$type,$placeholder=null,$data=array())
        {
            if(isset($this->model))
                if($this->method=="get" && isset($this->model->refGET[$id]))
                {
                    $data["value"]=$this->model->{$this->model->refGET[$id]};
                }
                elseif($this->method=="post" && isset($this->model->refPOST[$id]))
                {
                    $data["value"]=$this->model->{$this->model->refPOST[$id]};
                }
            $ret='<input id="'.$id.'" name="'.$id.'" type="'.$type.'"';
            if(is_string($placeholder))
                $ret.=' placeholder="'.$placeholder.'"';
            if(is_array($data))
                foreach($data as $key=>$value)
                    if($key!="label" && $key!="wrapper")
                        $ret.=' '.$key.'="'.htmlspecialchars($value).'"';
            return $ret."/>";
        }
        private function feedback($txt,$data=array())
        {
            $ret="<div  ";
            $data=$this->appendThings($data,"class","help-block form-control-feedback");
            foreach($data as $key=>$value)
                if($key!="label" && $key!="wrapper")
                    $ret.=' '.$key.'="'.$value.'"';
            $ret.=">".$txt;

            return $ret."</div>";
        }
        private function help($txt,$data=array())
        {
            $ret="<small";
            $data=$this->appendThings($data,"class"," help-block text-muted form-text");
            foreach($data as $key=>$value)
                if($key!="label" && $key!="wrapper" && $key!="help")
                    $ret.=' '.$key.'="'.$value.'"';
            $ret.=">".$txt;
            return $ret."</small>";
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