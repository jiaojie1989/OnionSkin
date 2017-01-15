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
                $rr="asc";
                switch($_GET["order"][0]["dir"])
                {
                    case "asc": $rr="asc";
                    case "desc": $rr="desc";
                }
                $sql="SELECT s FROM OnionSkin\Entities\Snippet s WHERE s.accessLevel=2 ORDER BY ".$r." ".$rr."";
                $query=Engine::$DB->createQuery($sql)->setFirstResult($_GET["start"])->setMaxResults($_GET["length"]);
                $total=Engine::$DB->createQuery("SELECT count(s.id) FROM OnionSkin\Entities\Snippet s WHERE s.accessLevel=2")->getSingleScalarResult();
                header ('Content-Type: application/json');
                $data=$query->getResult();
                foreach($data as $d)
                {
                    $d->user=$d->user->username;
                    if($d->folder!=null)
                    $d->folder=$d->folder->id;
                }
                return $this->json(array("draw"=>(int)$_GET["draw"],"recordsTotal"=>$total,"recordsFiltered"=>$total,"data"=>$data));
            }
            $pageid=$request->Params["pageid"];
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
