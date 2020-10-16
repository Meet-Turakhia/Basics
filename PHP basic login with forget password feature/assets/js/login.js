$("#registerbtn").click(function () {
    $("#registerform").show();
    $("#loginform").hide();
    $("#forgotform").hide();
});

$("#loginbtn").click(function () {
    $("#registerform").hide();
    $("#loginform").show();
    $("#forgotform").hide();

});

$("#forgotbtn").click(function () {
    $("#registerform").hide();
    $("#loginform").hide();
    $("#forgotform").show();

});

