<?php defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers : Content-Type");
header("Access-Control-Allow-Methods : POST, OPTIONS");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAZARLAMA GPS TAKİP SİSTEMİ</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        var map;
        var arrMarkers = [];
        var arrInfoWindows = [];

        function mapInit(){

            var centerCoord = new google.maps.LatLng(39.0112237, 35.3061574);
            var mapOptions = {
                zoom: 6,
                center: centerCoord,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map"), mapOptions);

            $.getJSON("http://gpstakipsistemi.ahmetcakirci.com/index.php/panel/user_map_lists/<?php echo (isset($idusers)?$idusers:0);?>", {}, function(data){
                $.each(data.places, function(i, item){
                    $(".list-group").append('<a href="#" class="list-group-item" rel="' + i + '">' + item.title + '</a>');

                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(item.lat, item.lng),
                        map: map,
                        title: item.title
                    });

                    arrMarkers[i] = marker;

                    var infowindow = new google.maps.InfoWindow({
                        content: "<h3>"+ item.title +"</h3><p>"+ item.description +"</p>"
                    });

                    arrInfoWindows[i] = infowindow;

                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open(map, marker);
                    });
                });
            });
        }

        $(function(){

            mapInit();

            $(".list-group a").live("click", function(){
                var i = $(this).attr("rel");
                arrInfoWindows[i].open(map, arrMarkers[i]);
            });
        });
    </script>
    <style type="text/css" media="screen">
        img { border: 0; }
        #map{
            width: 1000px;
            height: 500px;
        }

        #content {
            top: 10px;
            left: 1000px;
            margin: 30px;
        }

    </style>
    <!-- css -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<header id="site-header">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= site_url(); ?>">GPS TAKİP SİSTEMİ</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['name']) && $_SESSION['logged_in'] === true) : ?>
                        <li><a href="">Merhaba <b><?= $_SESSION['name'].' '.$_SESSION['surname'] ?></b></a></li>
                        <li><a href="<?= site_url('login/logout') ?>">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div><!-- .navbar-collapse -->
        </div><!-- .container-fluid -->
    </nav><!-- .navbar -->
</header><!-- #site-header -->

<main id="site-content" role="main">

    <?php if (isset($_SESSION)) : ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php //var_dump($_SESSION); ?>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->
    <?php endif; ?>

    <div class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="span3">
                <?php $this->load->view('panel/panel_menu');?>
            </div><!--/span-->
            <div class="span9">
                <div class="jumbotron">
                    <div class="list-group"></div>
                    <div id="map"></div>
                    <div id="content">

                </div>
            </div>
        </div>
    </div>
</div>

</main><!-- #site-content -->

<footer id="site-footer" role="contentinfo">
</footer><!-- #site-footer -->


</body>
</html>