<?php

namespace OnionSkin\Pages {
    use \OnionSkin\Engine;
	/**
     * ViewPage short summary.
     *
     * ViewPage description.
     *
     * @version 1.0
     * @author Fry
     */
	class ViewPage extends \OnionSkin\Page
	{
        public function get($request)
        {
            if(!isset($request->Params["id"]))
                return $this->redirect("@/");
            $snippet=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Snippet")->findOneBy(array("id"=>$request->Params["id"]));
            /**
             * @var \OnionSkin\Entities\Snippet $snippet
             */
            if(!isset($snippet)
                || (!isset(Engine::$User) && $snippet->accessLevel==0) ||
                   ($snippet->accessLevel==0 || $snippet->user->id !=Engine::$User->id ))
                return $this->redirect("@/");
            Engine::$Smarty->assign("snippet",$snippet);
            return $this->ok("main/NoteView.tpl");
        }
	}
}