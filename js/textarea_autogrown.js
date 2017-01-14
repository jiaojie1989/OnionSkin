$(document).ready(function () {
    $(".auto_grow").keyup(function () {
        if(this.scrollHeight>250){
        this.style.height = 5 + "px"; 
        this.style.height = (this.scrollHeight + 20) + "px";
        }
    });

    $('#form-edit').validate({
        errorElement: "div",
        errorClass: "help-block form-control-feedback invalid",
        validClass: "help-block form-control-feedback success",
        rules: {
            name: {
                minlength: 1,
                required: true
            },
            snippet: {
                required: true,
                minlength: 1
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