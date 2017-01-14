<?php

namespace OnionSkin\Smarty
{
    use OnionSkin\Routing\Router;
	/**
	 * HelperPlugin short summary.
	 *
	 * HelperPlugin description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class HelperPlugin
    {
        public function cat(...$array)
        {
            $ret="";
            if(is_array($array[0])&& sizeof($array)==1)
                $array=$array[0];
            foreach($array as $value)
                $ret.=$value;
            return $ret;
        }
        public function arrayAdd($array,$key,$value)
        {
            $array[$key]=$value;
            return $array;
        }
        public function arrayAddBegin($array,$key,$value)
        {
            $array=array($key=>$value)+$array;
            return $array;
        }
        /**
         * @param \OnionSkin\Entities\Folder $folder
         */
        public function breadcrumb($folder,$class="")
        {
            $ret=' <ul class="breadcrumb bg-trans "'.$class.'>';
            if($folder==null)
                $ret.='<li class="breadcrumb-item active"><a class=" " href="'.Router::Path("\OnionSkin\Pages\MySnippets\FolderPage",array()).'">..</a></li>';
            else
            {
                $ret.=$this->bread($folder->parentFolder);
                $ret.='<li class="breadcrumb-item active"><a class=" " href="'.Router::Path("\OnionSkin\Pages\MySnippets\FolderPage",array($folder->id,$folder->name)).'">'.$folder->name.'</a></li>';
            }
            $ret.="</ul>";
            return $ret;
        }
        public function breadcrumbS($snippet,$class="")
        {
            $ret=' <ul class="breadcrumb bg-trans "'.$class.'>';
            $ret.=$this->bread($snippet->folder);
            $ret.='<li class="breadcrumb-item active">'.$snippet->title.'</li>';
            $ret.="</ul>";
            return $ret;
        }
        /**
         * @param \OnionSkin\Entities\Folder $folder
         */
        private function bread($folder)
        {
            $ret="";
            if($folder==null)
                $ret.='<li class="breadcrumb-item"><a class="" href="'.Router::Path("\OnionSkin\Pages\MySnippets\FolderPage",array()).'">..</a></li>';
            else
            {
                $ret.='<li class="breadcrumb-item"><a  href="'.Router::Path("\OnionSkin\Pages\MySnippets\FolderPage",array($folder->id,$folder->name)).'">'.$folder->name.'</a></li>';
                $ret=$this->bread($folder->parentFolder).$ret;
            }
            return $ret;
        }
        public function Normalize($str)
        {
            return str_replace(" ","_", str_replace(".","_",$str));
        }
    }
}