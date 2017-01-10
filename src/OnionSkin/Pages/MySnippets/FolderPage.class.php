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
            return $this->ok("main/Folder.tpl");
        }
        public function getJson($request)
        {
            
        }
        public function put($request)
        {

        }
        public function remove($request)
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
            Engine::$DB->remove($current);
            Engine::$DB->flush();
            return $this->json(array(1));
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
                return $this->json(array(0,"error"=>Lang::L("error_not_logged")));
            if(!isset($request->POST["name"]))
                return $this->json(array(0,"error"=>Lang::L("error_folder_name")));
            $current=null;
            if(isset($request->Params["folderid"]))
            {
                $current=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Folder")->findOneBy(array("id"=>$request->Params["folderid"]));
                /**
                 * @var \OnionSkin\Entities\Folder $current
                 */
                if($current==null)
                    return $this->json(array(0,"error"=>Lang::L("error_folder_name")));
                if($current->user->id!=Engine::$User->id)
                    return $this->json(array(0,"error"=>Lang::L("error_folder_name")));
                foreach($current->childsFolders as $v)
                {
                    if($v->name==$request->POST["name"])
                        return $this->json(array(0,"error"=>Lang::L("error_folder_name")));
                }
            }
            $folder=new \OnionSkin\Entities\Folder();
            $folder->user=Engine::$User;
            $folder->parentFolder=$current;
            $folder->name=$_POST["name"];
            Engine::$DB->persist($folder);
            Engine::$DB->flush();
            return $this->json(array(1));
        }
	}
}