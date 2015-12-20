<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="span3">
                 <?php $this->load->view('panel/panel_menu');?>
            </div><!--/span-->
            <div class="span9">
                <div class="jumbotron">
                    <center><img src="<?= base_url('assets/img/logo.png') ?>"> </center>
                </div>
            </div>
        </div>
    </div>
</div>