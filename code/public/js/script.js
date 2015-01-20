$(document).ready(function(){
    //toggles the modal
    $(".md-trigger").click(function(){
        $("#modal-1").toggleClass('md-show'); // because this was too easy, right? or checking if a class exists on the element. also an option.
    });

    //handles the alternate 'close the modal' button
    $(".md-close, .md-overlay").click(function(){
        $("#modal-1").removeClass('md-show'); //delete this class to hide the modal
        modal_triggered = false; //set modal_triggered to false for the statecheck
    });

    $("#signup_button").click(function(){
        $("#signup").slideDown();
        var action = $(this).parents('form').attr("action");
        $(this).parents('form').attr("action", action.replace('login', 'sign/up'));
        $(":submit").val('Register');
    });

        //$('input[type="password"], input[type="text"], input[type="email"]').attr('autocomplete', 'off');

    // Toggles the signup section
    // sets the action to "sign/up"
    // sets Submitbutton to 'Register' and hides the sign up button
    $(".register_button").click(function(){

        $("#signup").css("display", "block");
        $("#login_form :submit").val("Register");
        $("#login_form").attr("action", "sign/up");
        $(".modal-header").text('Register');


    });
    $(".login_button").click(function(){
        $("#signup").css("display", "none");
        $("#login_form :submit").val("Login");
        $("#login_form").attr("action", "login");
        $(".modal-header").text('Login');
    });

    $('.textarea_write').autogrow({
        postGrowCallback: function($this){
            if($this.context.clientHeight > 300){
                $('html, body').animate({
                    scrollTop: $this.offset().top + $this.outerHeight() - $('body').height() + 100
                }, 250);
            }
        }
    });
    
    var ctrlPressed = false;
    $('.textarea_write').keydown(function(e){
        if(e.keyCode == 17 || e.keyCode == 91)
            ctrlPressed = true;
    });
    $('.textarea_write').keyup(function(e){
        if(e.keyCode == 17 || e.keyCode == 91){
            ctrlPressed = false;
            initial_load = true;
            countwords($(this).val());
        }
        
        if(ctrlPressed || (e.keyCode == 8 || e.keyCode == 32 || e.keyCode == 190)){
            initial_load = true;
            countwords($(this).val());
        }
    });

    $('.textarea_write').blur(countwords($(this).val()));
    var regex = /\s+/gi;
    var initial_load = false; // whats the use of this?
    function countwords(wordtext)
    {
        if(initial_load)
        {
            var wordCount = wordtext.trim().replace(regex, ' ').split(' ').length;
            if(wordCount > 1500 || wordCount < 500)
            {
                $('.word-counter span').removeClass('valid');
                $('.text_submit').attr('disabled', 'disabled');
            }
            else
            {
                $('.word-counter span').addClass('valid');
                $('.text_submit').removeAttr('disabled');
            }
            $('.word-counter span').text(wordCount);
        }

    }

    $('.review_container').on('dblclick', function(){
        $('.review-field').removeAttr('disabled');
    });

    $('.review_submit').hover(function(){
        $('.review-field').removeAttr('disabled');
    }, function(){
        $('.review-field').attr('disabled', 'disabled');
    });

    $('.read-panel').hover(function(){

        $(this).children('.author-text').fadeIn();
    },function(){
        $(this).children('.author-text').fadeOut();
    });
    $('.admin-menu-button').click(function(){
        $('.admin_panel').slideToggle('fast');
    });

});
