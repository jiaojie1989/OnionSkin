{extends file="_centered.tpl"}
{block name=title}My Page Title{/block}
{block name="body"}
<div class="container container-table">
    <div class="row vertical-center-row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">{$L.sign_in}</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">{$L.sign_up}</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								{$Form->Start("login-form","Profile\\LoginPage","post",["style"=>"display: block;", "role"=>"form"])}
								{$Form->BindModel("form_login")}
								{$Form->AntiForgeryToken()}
								{$Form->TextBox("username",null,$L.username,["input"=>["tabindex"=>"1","required"=>"required","pattern"=>$H->cat([".",$ldim,"3,",$rdim]),"title"=>$L.three_character_minimal]])}
								{$Form->Password("password",null,$L.password,["input"=>["tabindex"=>"2","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"6,",$rdim]),"title"=>$L.password_pattern]])}
								{$Form->CheckBox("rememberme",$L.remember_me,["wrapper"=>["class"=>"text-center"],"input"=>["tabindex"=>"3"]])}
								{$Form->Submit("login-submit",$L.sign_in,["style"=>"button_middle","input"=>["tabindex"=>"4","class"=>"btn-login"]])}
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="{$R->Path("Profile\\ForgotPasswordPage")}" tabindex="5" class="forgot-password">{$L.forgot_password}</a>
												</div>
											</div>
										</div>
									</div>
								{$Form->End()}
								{$Form->Start("register-form","Profile\\RegisterPage","post", ["role"=>"form","style"=>"display: none;"])}
								{$Form->BindModel("form_register")}
								{$Form->AntiForgeryToken()}
								{$Form->TextBox("username",null,$L.username,["input"=>["tabindex"=>"1","required"=>"required","pattern"=>$H->cat([".",$ldim,"3,",$rdim]),"title"=>$L.three_character_minimal]])}
								{$Form->Email("email",null,$L.email,["input"=>["tabindex"=>"2","required"=>"required"]])}
								{$Form->Password("password",null,$L.password,["input"=>["tabindex"=>"3","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"6,",$rdim]),"title"=>$L.password_pattern]])}
								{$Form->Password("password2",null,$L.password_confirm,["input"=>["tabindex"=>"4","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"6,",$rdim]),"title"=>$L.password_pattern]])}
								{$Form->Submit("register-submit",$L.sign_up,["style"=>"button_middle","input"=>["tabindex"=>"5","class"=>"btn-register"]])}
								{$Form->End()}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{/block}
{block name="js_end" append}
<script src="js_c/login.js"></script>
{/block}