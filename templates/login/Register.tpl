{extends file="_centered.tpl"}
{block name=title}{$L.sign_in}{/block}
{block name="body"}
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card"  alt="Profile" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
			{$Form->Start("register-form","Profile\\RegisterPage","post",["class"=>"form-signin"])}
			{$Form->BindModel("form_register")}
			{$Form->AntiForgeryToken()}
		
								{$Form->TextBox("username",null,$L.username,["input"=>["tabindex"=>"1","required"=>"required","pattern"=>$H->cat([".",$ldim,"3,",$rdim]),"title"=>$L.three_character_minimal]])}
								{$Form->Email("email",null,$L.email,["input"=>["tabindex"=>"2","required"=>"required","title"=>$L.error_email]])}
								{$Form->Password("password",null,$L.password,["input"=>["tabindex"=>"3","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"6,",$rdim]),"title"=>$L.password_pattern]])}
								{$Form->Password("password2",null,$L.password_confirm,["input"=>["tabindex"=>"4","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"6,",$rdim]),"title"=>$L.password_pattern]])}
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">{$L.sign_up}</button>
            {$Form->End()}
        </div><!-- /card-container -->
    </div><!-- /container -->
{/block}
{block name="js_end" append}
<script src="js_c/login.js"></script>
{/block}
{block name="css" append}
<link type="text/css" rel="stylesheet" href="/styles_c/login.css" />
{/block}