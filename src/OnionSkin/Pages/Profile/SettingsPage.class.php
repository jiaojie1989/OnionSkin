<?php

namespace OnionSkin\Pages\Profile
{
    use OnionSkin\Engine;
	/**
	 * SettingsPage short summary.
	 *
	 * SettingsPage description.
	 *
	 * @version 1.0
	 * @author Fry
	 */
	class SettingsPage extends \OnionSkin\Page
	{
        public function get($request)
        {
            if(!isset(Engine::$User))
                return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            return $this->ok("main/Settings.tpl");
        }
        public function post($request)
        {
            if(!isset(Engine::$User) || !in_array($request->POST["style"],array("light","dark")))
                return $this->redirect("\\OnionSkin\\Pages\\EditPage");
            Engine::$User->style=$request->POST["style"];
            Engine::$DB->persist(Engine::$User);
            Engine::$DB->flush();

            return $this->redirect("\\OnionSkin\\Pages\\Profile\\SettingsPage");
        }
	}
}