{extends file="_centered.tpl"}
{block name=title}{$L.sign_in}{/block}
{block name="body"}
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
			{$Form->Start("login-form","Profile\\LoginPage","post",["class"=>"form-signin", "role"=>"form"])}
			{$Form->BindModel("form_login")}
			{$Form->AntiForgeryToken()}
								{$Form->TextBox("username",null,$L.username,["help"=>$H->cat("* ",$L.requiredfield),"input"=>["tabindex"=>"1","required"=>"required","pattern"=>$H->cat([".",$ldim,"3,",$rdim]),"title"=>$L.three_character_minimal]])}
								{$Form->Password("password",null,$L.password,["help"=>$H->cat("* ",$L.requiredfield),"input"=>["tabindex"=>"2","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"6,",$rdim]),"title"=>$L.password_pattern]])}
								{$Form->CheckBox("rememberme",$L.remember_me,["wrapper"=>["class"=>"text-center"],"input"=>["tabindex"=>"3"]])}
    
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">{$L.sign_in}</button>
            {$Form->End()}
            <a href="{$R->Path("Profile\RegisterPage")}" class="forgot-password">
                {$L.never_reg}
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->
{/block}
{block name="js_end" append}
<script src="js_c/login.js"></script>
{/block}
{block name="css" append}
<link type="text/css" rel="stylesheet" href="/styles_c/login.css" />
{/block}