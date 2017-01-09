<?php

namespace OnionSkin\Smarty
{
	/**
	 * PaginationPlugin short summary.
	 *
	 * PaginationPlugin description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class PaginationPlugin
	{
        public $page,$first,$last,$data=array(),$current;

        public function __construct($page,$id,$total,$pageSize=50)
        {
            $this->page=$page;

            $pages=ceil($total/$pageSize);
            if($pages==0)
                $pages=1;
            if($id>$pages || $id<1)
                $id=$pages;
            $this->current=$id;
            if($id+3<$pages)
                $this->last=$pages;
            if($id-3>1)
                $this->first=1;
            $s=(($id-3)<1)?1:$id-3;
            $e=(($id+3)>$pages)?$pages:$id+3;
            for($i=$s;$i<=$e;$i++)
                $this->data[]=$i;
            if(count($this->data)<=1)
                $this->data=array();

        }
	}
}