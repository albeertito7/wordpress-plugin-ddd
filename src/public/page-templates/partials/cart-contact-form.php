<?php

$home_url = get_home_url();

?>

<style>
    form#contact_feedback {
    }
</style>

<!-- Cart Contact Feedback Form -->
<form id="contact_feedback">

</form>

<!-- Contact pop-up styles -->
<style>
    .contact-modal-wrapper {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 999999;
        overflow: auto;
        background-color: rgba(67, 67, 67, 0.8);
    }
    button.cross {
        background: transparent;
        position: absolute;
        outline: none;
        top: 15px;
        right: 20px;
        color: black;
        -webkit-text-stroke: 1px white;
        padding: 0;
    }
    button.cross > i {
        font-size: 25px;
    }
    button.cross:hover {
        transition: 0.2s;
        transform: scale(1.1);
    }
    #contact-modal {
        max-width: 800px;
        width: 87%;
        position: relative;
        overflow: hidden;
        margin: 120px auto;
        border-radius: 5px;
        /*background: white;*/
    }
    .contact-modal-header {
        background: white;
        background-size: cover;
        padding: 20px 20px;
        text-align: center;
        color: white;
    }
    .contact-modal-body {
        color: black;
        padding: 40px 40px;
        background: white;
    }
    .contact-modal-body-wrapper {
        max-width: 600px;
        margin: 0 auto;
    }
    #contactForm {
        color: black !important;
        font-size: 14px !important;
    }
    #contactForm > label > input {
        display: block;
        width: 100%;
        color: black !important;
        background: #e9e9e9 !important;
    }
    #contactForm > label > textarea {
        display: block;
        resize: vertical;
        width: 100%;
        min-height: 27px;
        color: black !important;
        background: #e9e9e9 !important;
    }
    #contactForm > label > input, #contactForm > label > textarea {
        border: 0;
        border-bottom: 1px solid black;
    }
    #contactForm > label > input::placeholder, #contactForm > label > textarea::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: black;
        position: relative;
        top: -5px;
        opacity: 1; /* Firefox */
    }
    #contactForm > *, #contactForm > label > * {
        margin-bottom: 30px;
    }
    #contactForm > p, #contactForm > label > textarea {
        margin-bottom: 10px;
    }
    #contactForm:last-child {
        margin-bottom: 0;
    }
    #contactForm button[type=submit] {
        display: block;
        margin-left: auto;
        color: white;
        font-weight: bold;
        padding: 8px 40px;
        border-radius: 8px;
        background-color: #0c6ca0;
    }
    .contact-modal-footer {
        position: relative;
        padding: 20px 20px;
        background: white;
        text-align: center;
    }
    .contact-modal-footer:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: lightgrey;
    }
</style>

<!-- Contact modal main wrapper -->
<div class="contact-modal-wrapper">

    <!-- Contact Modal -->
    <div id="contact-modal">

        <!-- Close button -->
        <button type="button" class="cross">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>

        <!-- Contact modal header -->
        <div class="contact-modal-header">

            <!-- Text header -->
            <h4></h4>

        </div> <!-- .contact-modal-header -->

        <!-- Contact modal body -->
        <div class="contact-modal-body">

            <!-- Contact form -->
            <form id="contactForm" class="contact-modal-body-wrapper" novalidate="novalidate">

                <label>
                    <input type="text" name="contact_name" placeholder="Full Name"/>
                </label>
                <label>
                    <input type="text" name="contact_tel" placeholder="Phone"/>
                </label>
                <label>
                    <input type="text" name="contact_email" placeholder="Email"/>
                </label>

                <label>
                    <textarea type="text" name="contact_message" placeholder="Comments" rows="1" cols="40"></textarea>
                </label>

                <button type="submit"><?php _e("Send", "entities"); ?></button>

            </form> <!-- #contactForm -->
        </div> <!-- .contact-modal-body -->

        <!-- Contact modal footer -->
        <div class="contact-modal-footer">

        </div> <!-- .contact-modal-footer -->

    </div> <!-- #contact-modal -->
</div> <!-- .contact-modal-wrapper -->

<!-- Contact pop-up js -->
<script type="application/javascript">
    (function ($) {
        /* Show the contact form pop-up */
        $(".contact_feedback").click(function (event) {
            event.preventDefault();
            //$(".contact-modal-wrapper").css("display", "block");
            $(".contact-modal-wrapper").fadeIn();
        });

        /* Hide the contact form pop-up */
        $("#contact-modal > button.cross").click(function () {
            //$(".contact-modal-wrapper").css("display", "none");
            $(".contact-modal-wrapper").fadeOut();
        });

        /* Submit contact form */
        $("#contactForm button[type=submit").on("click", function (event) {
            event.preventDefault();
            /*if ($(this).valid()) {

            } else {
                window.alert("contactForm not valid");
            }*/
            $.ajax({
                url: my_vars.ajaxurl,
                type: "post",
                dataType: "json",
                data: {
                    action: "entities_comments_controller",
                    type: "addComment",
                    author: "asdf asdf",
                    email: "asdf@gmail.com",
                    phone: "adsf",
                    message: "asdf",
                }
            }).done(function(response) {
                window.alert("done contact");
            }).fail(function (response) {
                window.alert("fail contact");
            }).always(function() {
                window.alert("always contact");
            });
        });
    }(jQuery));
</script>
