$(document).ready(function () {
    loadProfile();
    $.validator.addMethod(
        "regex",
        function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);

    $('#login-form').validate({
        errorElement: "div",
        errorClass: "help-block form-control-feedback invalid",
        validClass: "help-block form-control-feedback success",
        rules: {
            username: {
                minlength: 3,
                required: true
            },
            password: {
                required: true,
                regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/
            }
        },
        highlight: function (element) {
            $(element).removeClass('form-control-success').addClass('form-control-danger').parent().removeClass('has-success').addClass('has-danger');
        },
        success: function (element) {
            element.text('OK!').siblings('.form-control').addClass('valid').removeClass('form-control-danger').addClass('form-control-success')
                .parent().removeClass('has-danger').addClass('has-success');
        }
    });
    $('#register-form').validate({
        errorElement: "div",
        errorClass: "help-block form-control-feedback invalid",
        validClass: "help-block form-control-feedback success",
        rules: {
            username: {
                minlength: 3,
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/
            },
            password2: {
                required: true,
                regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/
            }
        },
        highlight: function (element) {
            $(element).removeClass('form-control-success').addClass('form-control-danger').parent().removeClass('has-success').addClass('has-danger');
        },
        success: function (element) {
            element.text('OK!').siblings('.form-control').addClass('valid').removeClass('form-control-danger').addClass('form-control-success')
                .parent().removeClass('has-danger').addClass('has-success');
        }
    });
});
function getLocalProfile(callback) {
    var profileImgSrc = localStorage.getItem("PROFILE_IMG_SRC");
    var profileName = localStorage.getItem("PROFILE_NAME");
    var profileReAuthEmail = localStorage.getItem("PROFILE_REAUTH_EMAIL");

    if (profileName !== null
            && profileReAuthEmail !== null
            && profileImgSrc !== null) {
        callback(profileImgSrc, profileName, profileReAuthEmail);
    }
}

function loadProfile() {
    if (!supportsHTML5Storage()) { return false; }
    getLocalProfile(function (profileImgSrc, profileName, profileReAuthEmail) {
        $("#profile-img").attr("src", profileImgSrc);
        $("#profile-name").html(profileName);
        $("#reauth-email").html(profileReAuthEmail);
        $("#inputEmail").hide();
        $("#remember").hide();
    });
}
function supportsHTML5Storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}