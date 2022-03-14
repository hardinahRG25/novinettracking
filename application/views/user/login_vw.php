<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/novity.jpg'); ?>" />
    <title>NoviNet | Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/login.css">
</head>
<style>
    .login {
        border-top: 2px solid #3ac3b3 !important;
    }

    .login_fields__submit input {
        border: 2px solid #3ac3b3 !important;
        color: #3ac3b3 !important;
    }
</style>

<body>
    <form action="<?php echo base_url('UserManagement/do_login'); ?>" method="POST">
        <div class='login'>
            <input type="hidden" name="requested" value="" />
            <div class='login_title'>
                <span>NoviNet | <strong>Authentification</strong></span>
                <p class="error"><?php echo $this->session->flashdata('display_message_error'); ?></p>
            </div>

            <div class='login_fields'>
                <div class='login_fields__user'>
                    <div class='icon'>
                        <img src="<?php echo base_url(); ?>assets/login/user_icon_copy.png" alt="" />
                    </div>
                    <input placeholder="Email" type='text' name='username'>
                    <div class='validation'>
                        <img src="<?php echo base_url(); ?>assets/login/tick.png" alt="" />
                    </div>
                </div>
                <div class='login_fields__password'>
                    <div class='icon'>
                        <img src="<?php echo base_url(); ?>assets/login/lock_icon_copy.png" alt="" />
                    </div>
                    <input placeholder='Mot de passe' type='password' name='password'>
                    <div class='validation'>
                        <img src="<?php echo base_url(); ?>/assets/login/tick.png" alt="" />
                    </div>
                </div>

                <div class='login_fields__submit'>
                    <input type='submit' value='Se Connecter' style="width: 100%">
                </div>
            </div>

            <div class='success'>
                <h2>Authentication Success</h2>
                <p>Welcome back</p>
            </div>
            <div class='disclaimer'>
                <p style="color: #aaa">Si vous n'etes pas encore inscrit dans l'application, veuillez contacter le responsable</p>
            </div>
        </div>
    </form>
    <div class='authent'>
        <a href="<?php echo base_url(); ?>assets/login/puff.svg"></a>
        <p>Authenticating...</p>
    </div>
    <script src="<?php echo base_url(); ?>assets/login/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/login/jquery-ui.min.js" type="text/javascript"></script>
    <script type='text/javascript'>
        $('input[type="submit"]').click(function() {
            $('.login').addClass('test');
            setTimeout(function() {
                $('.login').addClass('testtwo');
            }, 300);
            setTimeout(function() {
                $(".authent").show().animate({
                    right: -320
                }, {
                    easing: 'easeOutQuint',
                    duration: 600,
                    queue: false
                });
                $(".authent").animate({
                    opacity: 1
                }, {
                    duration: 200,
                    queue: false
                }).addClass('visible');
            }, 500);
            setTimeout(function() {
                $(".authent").show().animate({
                    right: 90
                }, {
                    easing: 'easeOutQuint',
                    duration: 600,
                    queue: false
                });
                $(".authent").animate({
                    opacity: 0
                }, {
                    duration: 200,
                    queue: false
                }).addClass('visible');
                $('.login').removeClass('testtwo');
            }, 2500);
            setTimeout(function() {
                $('.login').removeClass('test');
                $('.login div').fadeOut(123);
            }, 2800);
            setTimeout(function() {
                $('.success').fadeIn();
            }, 3200);
        });

        $('input[type="text"],input[type="password"]').focus(function() {
            $(this).prev().animate({
                'opacity': '1'
            }, 200);
        });
        $('input[type="text"],input[type="password"]').blur(function() {
            $(this).prev().animate({
                'opacity': '.5'
            }, 200);
        });

        $('input[type="text"],input[type="password"]').keyup(function() {
            if (!$(this).val() === '') {
                $(this).next().animate({
                    'opacity': '1',
                    'right': '30'
                }, 200);
            } else {
                $(this).next().animate({
                    'opacity': '0',
                    'right': '20'
                }, 200);
            }
        });

        var open = 0;
        $('.tab').click(function() {
            $(this).fadeOut(200, function() {
                $(this).parent().animate({
                    'left': '0'
                });
            });
        });
    </script>
</body>

</html>