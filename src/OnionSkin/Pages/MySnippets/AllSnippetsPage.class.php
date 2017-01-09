<?php

namespace OnionSkin\Pages\MySnippets
{
    use OnionSkin\Engine;
	/**
	 * AllSnippetsPage short summary.
	 *
	 * AllSnippetsPage description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class AllSnippetsPage extends \OnionSkin\Page
	{
        
        public function get($request)
        {
            $pageid=$request->Param["pageid"];
            if(!isset($pageid))
                $pageid=1;
            if($pageid<1)
                return $this->redirect("PublicSnippetsPage");
            $sql="SELECT s FROM OnionSkin\Entities\Snippet s WHERE s.user=".Engine::$User->id." ORDER BY s.createdTime DESC";
            $query=Engine::$DB->createQuery($sql)->setFirstResult(($pageid-1)*50)->setMaxResults(50);
            $pager=new \Doctrine\ORM\Tools\Pagination\Paginator($query);
            if($pageid>count($pager) && count($pager)>1)
                return $this->redirect("MySnippets\\AllSnippetsPage");
            Engine::$Smarty->assign("pagination",new \OnionSkin\Smarty\PaginationPlugin("MySnippets\\AllSnippetsPage",$pageid,count($pager)));
            Engine::$Smarty->assign("snippets",$pager);
            return $this->ok("main/MySnippets.tpl");
        }
	}
}