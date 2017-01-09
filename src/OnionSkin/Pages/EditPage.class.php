<?php

namespace OnionSkin\Pages;

use OnionSkin\Engine;

class EditPage extends \OnionSkin\Page
{
	public function __construct()
	{
		$this->RequireLogged = false;
		$this->RequireAdmin = false;
	}

    /**
     * @param \OnionSkin\Routing\Request $request
     */
	public function get($request)
	{
        $this->loadSyntax();
        if(!isset($request->Params["id"]))
            return $this->getNew($request);
        else
            return $this->getEdit($request);
	}
    private function getNew($request)
    {
        $this->loadSyntax();
        return $this->ok("main/NoteEdit.tpl");
    }
    private function getEdit($request)
    {
        $Snippet=Engine::$DB->getRepository("\OnionSkin\Entities\Snippet")->find($request->Params["id"]);
        if(!isset($request->Params["name"]) || $request->Params["name"]!=$this->normalize($Snippet->name))
            return $this->redirect("\OnionSkin\Pages\EditPage",303,array($request->Params["id"],$request->Params["name"]));
        if(!isset($_SESSION["form_edit"]))
            $_SESSION["form_edit"]=serialize($Snippet);

        return $this->ok("main/NoteEdit.tpl");
    }

    public function post($request)
    {
        $snippet=new \OnionSkin\Entities\Snippet();
        $syntax=json_decode(file_get_contents("config/languages.json"),true);
        $model=$request->MappedModel;
        /**
         * @var \OnionSkin\Models\SnippetModel $model
         */
        if(sizeof($request->MappedModel->Errors)>0)
        {
            $_SESSION["form_edit"]=serialize($request->MappedModel);
            return $this->redirect("\\OnionSkin\\Pages\\EditPage");
        }
        else
        {
            if(isset($request->Params["id"]))
            {
                $snippet=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Snippet")->find($request->Params["id"]);
                if(!isset($snippet)){
                    $_SESSION["form_edit"]=serialize($request->MappedModel);
                    return $this->redirect("\\OnionSkin\\Pages\\EditPage");
                }
            }
            $snippet->title=$model->name;
            $snippet->text=$model->snippet;
            $snippet->user=Engine::$User;
            if($model->folder!=-1){
                $snippet->folder=Engine::$DB->getRepository("\\OnionSkin\\Entities\\Folder")->findOneBy(array("id"=>$model->folder));
                if(isset($snippet->folder))
                    if($snippet->folder->user->id!=Engine::$User->id)
                        return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            }
            if($model->syntax=="txt" || key_exists($model->syntax,$syntax))
                $snippet->syntax=$model->syntax;
            else
                return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            switch($model->expiration)
            {
                case "10m":
                    $snippet->expirationTime=new \DateTime();
                    $snippet->expirationTime->add(new \DateInterval("PT10M"));
                    break;
                case "1h":
                    $snippet->expirationTime=new \DateTime();
                    $snippet->expirationTime->add(new \DateInterval("PT1H"));
                    break;
                case "1d":
                    $snippet->expirationTime=new \DateTime();
                    $snippet->expirationTime->add(new \DateInterval("P1D"));
                    break;
                case "1w":
                    $snippet->expirationTime=new \DateTime();
                    $snippet->expirationTime->add(new \DateInterval("P1W"));
                    break;
                default:
                    $snippet->expirationTime=null;
                    break;
            }
            switch($model->visibility)
            {
                case 0:
                    $snippet->accessLevel=0;
                    break;
                case 1:
                    $snippet->accessLevel=1;
                    break;
                case 2:
                default:
                    $snippet->accessLevel=2;
                    break;
            }
            Engine::$DB->persist($snippet);
            Engine::$DB->flush();
            $this->redirect("\\OnionSkin\\Pages\\ViewPage",303,array($snippet->id,$this->normalize($snippet->title)));
        }
    }


    private function normalize($str)
    {
        return str_replace(" ","_",$str);
    }

    private function getModel()
    {
        $errors = array();
        $model = new \OnionSkin\Entities\Snippet();
    }
    private function loadSyntax()
    {
        $syntax=json_decode(file_get_contents("config/languages.json"),true);
        \OnionSkin\Engine::$Smarty->assign("syntax_list",$syntax);
    }
}