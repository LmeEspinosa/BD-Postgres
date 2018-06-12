$( document ).ready(function(){
    setClicksEvents();
});


function setClicksEvents(){
    $("#register-link").click(()=>{
        hideFirstShowSecond("login","register");
    });

    $("#register-link2").click(()=>{
        hideFirstShowSecond("password-change","register");
    });

    $("#login-link").click(()=>{
        hideFirstShowSecond("register","login");
    });

    $("#login-link2").click(()=>{
        hideFirstShowSecond("password-change","login");
    });

    $("#password-link").click(()=>{
        hideFirstShowSecond("login","password-change");
    });

    $("#password-link2").click(()=>{
        hideFirstShowSecond("register","password-change");
    });
}

function hideFirstShowSecond(hide,show){
    $("#" + hide).animate({opacity:"0"},300).promise().done(()=>{
        $("#" + hide).css("display","none").promise().done(()=>{
            $("#" + show).css("display","flex").promise().done(()=>{
                $("#" + show).animate({opacity:"1"},300);
            })
        })
    });
}

function hideAllElements(){
    $("#register").css("opacity","0").promise().done(()=>{
        $("#register").css("display","none");
    });
    $("#login").css("opacity","0").promise().done(()=>{
        $("#login").css("display","none");
    });
}

function showElementById(show){
    return $("#" + show).css("display","flex").promise().done(()=>{
        $("#" + show).animate({opacity:"1"},300);
    })
}

function hideElementById(){
    $("#" + hide).animate({opacity:"0"},300).promise().done(()=>{
        $("#" + hide).css("display","none");
    });
}