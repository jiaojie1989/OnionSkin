<?php

namespace OnionSkin\Pages\MySnippets
{
    use OnionSkin\Engine;
    use Doctrine\DataTables;
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
            if(strpos($_SERVER['HTTP_ACCEPT'], 'json') !== false)
            {
                if(!is_numeric($_GET["length"]) ||!is_numeric($_GET["start"]) || !is_numeric($_GET["order"][0]["column"]) || ($_GET["order"][0]["dir"]!="asc" && $_GET["order"][0]["dir"]!="desc"))
                    return $this->json(array()); //HACK
                $r="s.title";
                switch($_GET["order"][0]["column"])
                {
                    case "1": $r="s.createdTime";
                    case "2": $r="s.syntax";
                }
                $sql="SELECT s FROM OnionSkin\Entities\Snippet s WHERE s.user=".Engine::$User->id." ORDER BY ".$r." ".$_GET["order"][0]["dir"]."";
                $query=Engine::$DB->createQuery($sql)->setFirstResult($_GET["start"])->setMaxResults($_GET["length"]);
                $total=Engine::$DB->createQuery("SELECT count(s.id) FROM OnionSkin\Entities\Snippet s WHERE s.user=".Engine::$User->id)->getSingleScalarResult();
                header ('Content-Type', 'application/json');
                $data=$query->getResult();
                foreach($data as $d)
                {
                    $d->user=$d->user->username;
                    if($d->folder!=null)
                        $d->folder=$d->folder->id;
                }
                return $this->json(array("draw"=>(int)$_GET["draw"],"recordsTotal"=>$total,"recordsFiltered"=>$total,"data"=>$data));
            }
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