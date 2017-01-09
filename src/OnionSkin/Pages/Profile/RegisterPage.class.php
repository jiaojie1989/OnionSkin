<?php

namespace OnionSkin\Pages\Profile
{
    use \OnionSkin\Engine;
    use \OnionSkin\Lang;
    use OnionSkin\Entities\User;
	/**
	 * RegisterPage short summary.
	 *
	 * RegisterPage description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class RegisterPage extends \OnionSkin\Page
	{
        /**
         *
         * @param  $request
         *
         * @return void
         */
        function get($request)
        {
            return parent::get($request);
        }

        /**
         *
         * @param \OnionSkin\Routing\Request $request
         *
         * @return void
         */
        function post($request)
        {
            if(Engine::$User!=null)
                $this->redirect("@/");
            $model=$request->MappedModel;
             /**
              * @var \OnionSkin\Models\RegisterModel $model
              */
             $user=Engine::$DB->getRepository("\\OnionSkin\\Entities\\User")->findOneBy(array("username"=>$model->username));
             if(isset($user))
                 $model->Errors["username"]=Lang::L("error_username_taken");
             if($model->password!=$model->passwordAgain)
                 $model->Errors["password"]=Lang::L("error_password_not_match");
             $user=new User();
             $user->username=$model->username;
             $user->email=$model->email;
             $user->createPassword($model->password);
             Engine::$DB->persist($user);
             Engine::$DB->flush();
             if(sizeof($request->MappedModel->Errors)>0)
             {
                 $model->password=null;
                 $model->passwordAgain=null;
                 $_SESSION["form_register"]=serialize($request->MappedModel);
                 $this->redirect("\\OnionSkin\\Pages\\Profile\\RegisterPage");
             }
             else
             {
                 $_SESSION["User"]=$user->id;
                 $this->redirect("@/");
             }
        }

    }
}