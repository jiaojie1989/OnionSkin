<?php


namespace OnionSkin\Pages\Profile
{
    use OnionSkin\Engine;
    use OnionSkin\Lang;
	/**
     * LoginPage short summary.
     *
     * LoginPage description.
     *
     * @version 1.0
     * @author Fry
     */
	class LoginPage extends \OnionSkin\Page
	{
        public function __construct()
        {
            $this->RequireLogged = false;
            $this->RequireAdmin = false;
        }

        public function post($request)
        {
            if(Engine::$User!=null)
                $this->redirect("@/");
            $model=$request->MappedModel;
            /**
             * @var \OnionSkin\Models\LoginModel $model
             */
            $user=Engine::$DB->getRepository("\\OnionSkin\\Entities\\User")->findOneBy(array("username"=>$model->username));
            /**
             * @var \OnionSkin\Entities\User $user
             */
            if(!isset($user))
                $model->Errors["username"]=Lang::L("error_username_wrong");
            elseif(!$user->comparePassword($model->password))
                $model->Errors["password"]=Lang::L("error_password_wrong");
            if(sizeof($request->MappedModel->Errors)>0)
            {
                $model->password=null;
                $_SESSION["form_login"]=serialize($model);
                $this->redirect("\\OnionSkin\\Pages\\Profile\\LoginPage");
            }
            else
            {
                $_SESSION["User"]=$user->id;
                $this->redirect("@/");
            }
        }

        public function get($request)
        {
            if(Engine::$User!=null)
                $this->redirect("@/");
            $this->ok("login/LoginRegister.tpl");
            return true;
        }

        private function getModel()
        {
            $errors = array();
            $model = new \OnionSkin\Entities\Snippet();
        }
	}
}