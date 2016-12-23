$(document).ready(function () {
    $(".auto_grow").keyup(function () {
        if(this.scrollHeight>250){
        this.style.height = 5 + "px"; 
        this.style.height = (this.scrollHeight + 20) + "px";
        }
    });
});