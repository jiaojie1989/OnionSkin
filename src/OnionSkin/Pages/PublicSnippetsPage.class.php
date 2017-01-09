<?php

namespace OnionSkin\Pages
{
    use \OnionSkin\Engine;
	/**
	 * PublicSnippets short summary.
	 *
	 * PublicSnippets description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class PublicSnippetsPage extends \OnionSkin\Page
	{
        public function get($request)
        {
            $pageid=$request->Param["pageid"];
            if(!isset($pageid))
                $pageid=1;
            if($pageid<1)
                return $this->redirect("PublicSnippetsPage");
            $sql="SELECT s FROM OnionSkin\Entities\Snippet s WHERE s.accessLevel=2 ORDER BY s.createdTime DESC";
            $query=Engine::$DB->createQuery($sql)->setFirstResult(($pageid-1)*50)->setMaxResults(50);
            $pager=new \Doctrine\ORM\Tools\Pagination\Paginator($query);
            if($pageid>count($pager) && count($pager)>1)
                return $this->redirect("PublicSnippetsPage");
            Engine::$Smarty->assign("pagination",new \OnionSkin\Smarty\PaginationPlugin("PublicSnippetsPage",$pageid,count($pager)));
            Engine::$Smarty->assign("snippets",$pager);
            return $this->ok("main/PublicSnippets.tpl");
        }
	}
}