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
								{$Form->BindModel($Request->MappedModel)}
								{$Form->AntiForgeryToken()}
								{$Form->TextBox("username",null,$L.username,["input"=>["tabindex"=>"1","required"=>"required","pattern"=>$H->cat([".",$ldim,"6,",$rdim]),"title"=>$L.six_character_minimal]])}
								{$Form->Password("password",null,$L.password,["input"=>["tabindex"=>"2","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"8,",$rdim]),"title"=>$L.password_pattern]])}
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
								{$Form->BindModel($Request->MappedModel)}
								{$Form->AntiForgeryToken()}
								{$Form->TextBox("username",null,$L.username,["input"=>["tabindex"=>"1","required"=>"required","pattern"=>$H->cat([".",$ldim,"6,",$rdim]),"title"=>$L.six_character_minimal]])}
								{$Form->Email("email",null,$L.email,["input"=>["tabindex"=>"2","required"=>"required"]])}
								{$Form->Password("password",null,$L.password,["input"=>["tabindex"=>"3","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"8,",$rdim]),"title"=>$L.password_pattern]])}
								{$Form->Password("password",null,$L.password_confirm,["input"=>["tabindex"=>"4","required"=>"required","pattern"=>$H->cat(["(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).",$ldim,"8,",$rdim]),"title"=>$L.password_pattern]])}
								{$Form->Submit("register-submit",$L.sign_up,["style"=>"button_middle","input"=>["tabindex"=>"5","class"=>"btn-register"]])}
								{$Form->End()}
								<form id="register-form" action="{$R->Path("Profile\\RegisterPage")}" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="{$L.username}" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="{$L.email}" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="{$L.password}">
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="{$L.password_confirm}">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="{$L.sign_up}">
											</div>
										</div>
									</div>
								</form>
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