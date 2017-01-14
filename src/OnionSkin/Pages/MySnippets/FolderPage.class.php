<?php

namespace OnionSkin\Pages\MySnippets
{
    use OnionSkin\Lang;
    use OnionSkin\Engine;
	/**
	 * FolderPage short summary.
	 *
	 * FolderPage description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class FolderPage extends \OnionSkin\Page
	{
        public function get($request)
        {
            if(!isset(Engine::$User))
                return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            $f=null;
            if(isset($request->Params["folderid"][0])){
                $f=$request->Params["folderid"][0];
                if(!is_numeric($f))
                    return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            }

            $folder=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Folder")->findOneBy(array("id"=>$f));
            $childs=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Folder")->findBy(array("user"=>Engine::$User,"parentFolder"=>$f));
            $snippets=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Snippet")->findBy(array("user"=>Engine::$User,"folder"=>$f));
            Engine::$Smarty->assign("folder",$folder);
            Engine::$Smarty->assign("childs",$childs);
            Engine::$Smarty->assign("snippets",$snippets);
            return $this->ok("main/Folder.tpl");
        }
        public function put($request)
        {

        }
        public function delete($request)
        {
            if(!isset(Engine::$User))
                return $this->json(array(0,"error"=>Lang::L("error_not_logged")));
            if(!isset($request->Params["folderid"]))
                return $this->json(array(0,"error"=>Lang::L("error_folder_name")));
            $current=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Folder")->findOneBy(array("id"=>$request->Params["folderid"]));
            if($current==null)
                return $this->json(array(0,"error"=>Lang::L("error_folder_name")));
            if($current->user->id!=Engine::$User->id)
                return $this->json(array(0,"error"=>Lang::L("error_folder_name")));
                /**
                 * @var \OnionSkin\Entities\Folder $current
                 */
            if(isset($current->parentFolder))
                $c=$current->parentFolder->id;

            Engine::$DB->remove($current);
            Engine::$DB->flush();
            if(isset($c))
                return $this->redirect("\\OnionSkin\\Pages\\MySnippets\\FolderPage",303,array($c));
            else
                return $this->redirect("\\OnionSkin\\Pages\\MySnippets\\FolderPage",303);
        }
        /**
         * @param \OnionSkin\Entities\Folder $folder
         */
        private function rem($folder)
        {
            foreach($folder->childsFolders as $f)
            {
                $this->rem($f);
            }
            foreach($folder->snippets as $s)
            {
                Engine::$DB->remove($s);
            }
            Engine::$DB->remove($folder);
        }
        public function post($request)
        {
            if(!isset(Engine::$User))
                return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            if(!isset($request->POST["value"]))
                return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            $current=null;
            if(isset($request->Params["folderid"][0]))
            {
                $current=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Folder")->findOneBy(array("id"=>$request->Params["folderid"][0]));
                /**
                 * @var \OnionSkin\Entities\Folder $current
                 */
                if($current==null)
                    return $this->redirect("\\OnionSkin\\Pages\\EditPage");
                if($current->user->id!=Engine::$User->id)
                    return $this->redirect("\\OnionSkin\\Pages\\EditPage");
                foreach($current->childsFolders as $v)
                {
                    if($v->name==$request->POST["value"])
                        return $this->redirect("\\OnionSkin\\Pages\\EditPage");
                }
            }
            $folder=new \OnionSkin\Entities\Folder();
            $folder->user=Engine::$User;
            $folder->parentFolder=$current;
            $folder->name=strip_tags($_POST["value"]);
            Engine::$DB->persist($folder);
            Engine::$DB->flush();
            if(isset($current))
                return $this->redirect("\\OnionSkin\\Pages\\MySnippets\\FolderPage",303,array($current->id));
            return $this->redirect("\\OnionSkin\\Pages\\MySnippets\\FolderPage");
        }
	}
}
