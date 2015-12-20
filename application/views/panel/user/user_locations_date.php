<?php defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Headers : Content-Type");
//header("Access-Control-Allow-Methods : POST, OPTIONS");
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
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

            $.getJSON("http://gpstakipsistemi.ahmetcakirci.com/index.php/panel/user_map_date_list/<?php echo (isset($idusers)?$idusers:0); echo '/'; echo (isset($starttime)?$starttime:0); echo '/'; echo (isset($endtime)?$endtime:0);?>", {}, function(data){
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
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#all">Tüm Liste</a></li>
                            <li><a data-toggle="tab" href="#datefiltre">Tarihli Filtrele</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="all" class="tab-pane fade in active">
                                <div class="list-group"></div>
                            </div>
                            <div id="datefiltre" class="tab-pane fade">
                                <div class="container">
                                    <?php if( $this->session->flashdata('error') ) echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>HATA! </strong>' . $this->session->flashdata('error') . '</div>'; ?>
                                    <?php if( $this->session->flashdata('success') ) echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"">&times;</button>' . $this->session->flashdata('success') . '</div>'; ?>
                                    <form action="<?php echo (isset($idusers)?site_url('panel/user_map_date').'/'.$idusers:0);?>" method="POST">
                                        <div class="form-group">
                                            <label for="dob">Başlangıç Tarihi</label>
                                            <div class="control-input">
                                                <input type="text" id="dob" name="starttime" class="form-control" data-masked-input="99-99-9999" placeholder="DD-MM-YYYY" maxlength="10">
                                                <i class="validation-icon"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="dob">Bitiş Tarihi</label>
                                            <div class="control-input">
                                                <input type="text" id="dob" name="endtime" class="form-control" data-masked-input="99-99-9999" placeholder="DD-MM-YYYY" maxlength="10">
                                                <i class="validation-icon"></i>
                                            </div>
                                        </div>
                                        <button class="btn btn-large btn-primary" type="submit">Tarihe Göre Filtrele</button><?php if ($lists) : ?> <a href="<?php echo (isset($idusers)?site_url('panel/user_locations').'/'.$idusers:0);?>" class="btn btn-info" role="button">Tüm Listeyi Görüntüle</a><?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="map"></div>
                        <div id="content">
                        </div>
                    </div>
                </div>
            </div>
        </div>

</main><!-- #site-content -->

<footer id="site-footer" role="contentinfo">
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="well sidebar-nav">
                        Bu çalışma; Ahmet Yesevi Üniversitesi - Yönetim Bilişim Sistemleri , Yüksek Lisans Dönem projesi olarak Yrd. Doç. Dr. Sami ACAR danışmanlığında, Ahmet ÇAKIRCI tarafından hazırlanmıştır.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer><!-- #site-footer -->

</body>
</html>