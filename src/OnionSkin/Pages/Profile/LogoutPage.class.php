<?php

namespace OnionSkin\Pages\Profile
{
    
    class LogoutPage extends \OnionSkin\Page
    {
        /**
         *
         * @param  $request 
         *
         * @return void
         */
        function post($request)
        {
            unset($_SESSION["User"]);
            $this->redirect("@/");
        }

    }
}