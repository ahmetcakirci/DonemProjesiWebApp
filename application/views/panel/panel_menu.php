<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="well sidebar-nav">
    <?php
    $aktif="";
    if($this->uri->segment(2)=="panel")
        $aktif="1";

    if($this->uri->segment(2)=="user_add")
        $aktif="2";

    if($this->uri->segment(2)=="user_lists")
        $aktif="3";
    else if($this->uri->segment(2)=="user_search")
        $aktif="3";


    if($this->uri->segment(2)=="password_change")
        $aktif="4";
    ?>
    <ul class="nav nav-pills nav-stacked">
        <li class="nav-header">Kullanıcılar</li>
        <li <?php if($aktif=="2") echo "class=\"active\"";?> ><a href="<?php echo site_url('panel/user_add'); ?>">Kullanıcı Ekle </a></li>
        <li <?php if($aktif=="3") echo "class=\"active\"";?>><a href="<?php echo site_url('panel/user_lists'); ?>">Kullancılar Listesi</a></li>
        <li class="nav-header">Ayarlar</li>
        <li <?php if($aktif=="4") echo "class=\"active\"";?>><a href="<?php echo site_url('panel/password_change'); ?>">Şifre Değiştir</a></li>
    </ul>
</div><!--/.well -->
