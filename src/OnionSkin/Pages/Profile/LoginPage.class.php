<?php


namespace OnionSkin\Pages\Profile
{
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
        /**
         * @return boolean
         */
        public function execute()
        {
            switch($this->req_metod())
            {
                case "POST":
                    return $this->create();
                case "GET":
                    return $this->get();
                case "PATCH":
                case "PUT":
                    return $this->update();
                case "DELETE":
                    return $this->remove();

            }
            return $this->get();
        }

        public function get($request)
        {
            $this->ok("login/LoginRegister.tpl");
            return true;
        }
        private function create()
        {
            $this->redirect("");
        }

        private function getModel()
        {
            $errors = array();
            $model = new \OnionSkin\Entities\Snippet();
        }
	}
}