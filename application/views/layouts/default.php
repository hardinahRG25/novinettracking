<?php
$s = "https://production.telma.net/kurve/mep/calendar";
if (isset($_SERVER['HTTP_REFERER'])) {
    $s = "$_SERVER[HTTP_REFERER]";
}
$s = str_replace("http://", '/', $s);
$s = str_replace("https://", '/', $s);
$pos = strpos(substr($s, 1), '/');
$host = substr($s, 1, $pos);
$kurve_img = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' . $host . '/kurve/grafix/assets/theme3/images/kurve.svg' : 'http://' . $host . base_url() . 'assets/images/kurve.svg');
$link_portal = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' . $host . '/kurve/' : 'https://production.telma.net/kurve/');
?>
<!DOCTYPE html>
<html style="overflow: hidden">
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/novity.jpg"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="x-ua-compatible" content="IE=edge"/>
        <link href="<?php echo base_url() ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/fontawesome/css/fontawesome-all.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/css/style_btn_flottant.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/ghost.css'); ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/css/add.css'); ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/css/ghost-ow.css') ?>" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="<?php echo base_url('assets/css/modal.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/izyModal/css/iziModal.min.css'); ?>">
        <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/toast/toastr.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url() ?>assets/toast/font-awesome.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url() ?>assets/toast/style.css" rel="stylesheet"/>
        <link href='<?php echo base_url() ?>assets/calendar/fullcalendar.css' rel='stylesheet'/>
        <link href='<?php echo base_url() ?>assets/calendar/fullcalendar.print.min.css' rel='stylesheet' media='print'/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/autocomplete/jquery-ui.css"/>
        <link href='<?php echo base_url('assets/calendar/calendar.css'); ?>' rel='stylesheet'/>
        <link href='<?php echo base_url('assets/css/bootstrap-popover-x.css'); ?>' rel='stylesheet'/>
        <link href="<?php echo base_url() ?>assets/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css"/>
        <!-- Daterangepicker -->        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/daterangepicker/daterangepicker.css"/>
        <!-- ssi -->
        <link href='<?php echo base_url() ?>assets/css/ssi/home-style.css' rel='stylesheet'/>
    </head>
    <body>
        <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="z-index: 5;padding: 0px 5px 0px 5px;">
            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>"/>
            <a class="navbar-brand" href="<?php echo base_url('dashboard'); ?>" style="pointer-events: none;
               cursor: default;">
                <img src="<?php echo base_url(); ?>assets/images/novity.jpg" class="img-fluid" width="40"/>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item active" title="Affichage de tableau de bord">
                        <a class="nav-link" href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-home"></i> Accueil</a>
                    </li>
                    <?php if ($usermep['access'] != null && trim($usermep['access']) == "admin") { ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url() . "user_mgt"; ?>"><i class="fa fa-users"></i>
                                Gestion d'utilisateur</a>
                        </li>                  
                    <?php } ?>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active  dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo base_url('assets/images/user.png'); ?>"
                                 style="border-radius: 100px;width: 25px;">
                            &nbsp;&nbsp;<?php echo $usermep['login']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="
                             width: 100%;
                             margin-left: -50px;
                             background: #fffff3;
                             height: 43px;
                             cursor: pointer;
                             ">
                            <a class="dropdown-item" href="<?php echo base_url('logout'); ?>" style=""><i
                                    class="fa fa-power-off"></i> Deconnexion</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <main ng-app="app" id="mainContent">
            <div data-loading
                 style="position: absolute;z-index: 9999;background: rgba(0,0,0,0.1);justify-content: center;align-items: center;width: 100%;height:92%;overflow: hidden;margin-top: 18px;"></div>
            <?php echo $template['body'] ?>
        </main>
        <script type="text/javascript">
            var BASE_URL = "<?php echo base_url(); ?>";
            var CONNECTED = "<?php echo $usermep['login']; ?>";
        </script>

        <script src="<?php echo base_url() ?>assets/calendar/moment.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/calendar/fullcalendar.js"></script>
        <script src="<?php echo base_url() ?>assets/js/popper.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/calendar/locale/fr.js"></script>
        <script src="<?php echo base_url() ?>assets/autocomplete/jquery-ui.min.js"></script>



        <script src="<?php echo base_url() ?>assets/js/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.js" type="text/javascript"></script>

        <script src="<?php echo base_url() ?>assets/sweetalert/sweetalert2.all.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('assets/izyModal/js/iziModal.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/angular/angular.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/angular/angular-sanitize.min.js'); ?>" type="text/javascript"></script>

        <script src="<?php echo base_url() ?>assets/toast/toastr.min.js"></script>
        <script src="<?php echo base_url('assets/toast/script.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/autocompletion.js'); ?>" type="text/javascript"></script>

        <script src="<?php echo base_url('assets/calendar/popper.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/anchorme.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/app/app.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/app/calendar.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/utils/calendar_utils.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/app/user.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/chart.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/loadingoverlay.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-popover-x.js'); ?>" type="text/javascript"></script>
        <!-- Daterangepicker -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript">
            var navbar = $('#navbar').height();
            var heightPrincipal = $(window).height();
            var heightDashboard = heightPrincipal - (navbar + 9);
            var partContent = heightDashboard / 2 - 49;
            $('#dashboardContent').css('height', heightDashboard + "px");
            $(function () {

                if ($(".button-floating")) {
                    $(".button-floating").click(function () {
                        var $wrapper = $("#wrapper");
                        if (!$wrapper.hasClass("button-floating-clicked")) {
                            $wrapper.attr("class", "center");
                            $wrapper.toggleClass("button-floating-clicked-out");
                            $("#floating-btn-icon").attr("class", "fa fa-plus");
                        } else {
                            $("#floating-btn-icon").attr("class", "fa fa-bars");
                        }
                        $wrapper.toggleClass("button-floating-clicked");
                        $(".button-sub").click(function () {
                            var color = $(this).data("color");
                            $wrapper.attr("class", "center button-floating-clicked button-floating-clicked-out");
                            $wrapper.addClass("button-sub-" + color + "-clicked");
                            setTimeout(function () {
                                $(".button-floating").click();
                            }, 1000);
                        });


                    });
                }

                var nav_h = $(".navbar").height();
                var w_h = $(window).height();
                $('.tickets').css("height", (w_h - nav_h - 55) + "px");
                $('.otherView').css("height", (w_h - nav_h - 55) + "px");
                if ($('.to_minus') && $('.to_minus').length > 0) {
                    $('.tickets').css("height", partContent + "px");
                    $('.otherView').css("height", (w_h - nav_h - 80) + "px");
                }

                if ($('.calendar_contrainer') && $('.calendar_contrainer').length > 0) {
                    $('.calendar_contrainer').css("height", (w_h - nav_h - 20) + "px");
                } else {
                    var height = ($('.tickets').height());
                    $('.tickets').slimScroll({
                        height: partContent + "px",
                    });
                    $('.otherView').slimScroll({
                        height: height + "px",
                    });
                }

                $(window).on('resize', function () {
                    var navbar = $('#navbar').height();
                    var heightPrincipal = $(window).height();
                    var heightDashboard = heightPrincipal - (navbar + 9);
                    var partContent = heightDashboard / 2 - 49;
                    $('#dashboardContent').css('height', heightDashboard + "px");
                    var nav_h = $(".navbar").height();
                    var w_h = $(window).height();
                    $('.tickets').css("height", (w_h - nav_h - 55) + "px");
                    $('.otherView').css("height", (w_h - nav_h - 55) + "px");

                    if ($('.to_minus') && $('.to_minus').length > 0) {
                        $('.tickets').css("height", (w_h - nav_h - 80) + "px");
                        $('.otherView').css("height", (w_h - nav_h - 80) + "px");
                    }

                    if ($('.calendar_contrainer') && $('.calendar_contrainer').length > 0) {
                        $('.calendar_contrainer').css("height", (w_h - nav_h - 20) + "px");
                    } else {
                        var height = ($('.tickets').height());
                        $('.tickets').slimScroll({
                            height: partContent + "px",
                        });
                        $('.otherView').slimScroll({
                            height: height + "px"
                        });
                    }
                });
            });
        </script>
    </body>
</html>
