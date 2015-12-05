<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <div class="col-md-12">
        <?php if (validation_errors()) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors() ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="span3">
                <?php $this->load->view('panel/panel_menu');?>
            </div><!--/span-->
            <div class="span9">
                <div class="jumbotron">
                    <?php if( $this->session->flashdata('error') ) echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>HATA! </strong>' . $this->session->flashdata('error') . '</div>'; ?>
                    <?php if( $this->session->flashdata('success') ) echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"">&times;</button>' . $this->session->flashdata('success') . '</div>'; ?>
                    <form action="<?php echo site_url('panel/user_search'); ?>" method="POST">
                        <div class="form-group">
                            <label for="pwd">Kullanıcı Ara (EMail)</label>
                            <input type="email"  name="email"  class="form-control" id="email">
                        </div>
                    <button class="btn btn-large btn-primary" type="submit">Kullanıcı Ara</button> <?php if ($lists) : ?> <a href="user_lists" class="btn btn-info" role="button">Tüm Listeyi Görüntüle</a><?php endif; ?>
                    <div class="panel panel-info">
                        <div class="panel-footer">Kullanıcı Listesi</div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Adı</th>
                                    <th>Soyadı</th>
                                    <th>Email Adresi</th>
                                    <th>Durum</th>
                                    <th>Web Kullanıcısı</th>
                                    <th>Hareketleri Görüntüle</th>
                                    <th>Sil</th>
                                    <th>Düzenle</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($user_lists)>0){
                                    $i=1;
                                    foreach( $user_lists as $index => $row){
                                        $id="";
                                        foreach ($row as $rows=>$values){
                                             if($rows=='idusers'){ echo '<tr><td>'.$i.'</td>'; $id=$values;}
                                             if($rows=='name'){ echo '<td>'.$values.'</td>';}
                                             if($rows=='surname'){ echo '<td>'.$values.'</td>';}
                                             if($rows=='email'){ echo '<td>'.$values.'</td>';}
                                             if($rows=='status'){ echo '<td><a href="user_status/'.$id.($values==1?"/0":"/1").'"><span class="label label-';echo ($values==1?"success":"danger");echo'">';echo ($values==1?"Aktif":"Pasif");echo'</span></a></td>';}
                                             if($rows=='web'){ echo '<td><a href="user_web/'.$id.($values==1?"/0":"/1").'"><span class="label label-';echo ($values==1?"success":"danger");echo'">';echo ($values==1?"Aktif":"Pasif");echo'</span></a></td>';}
                                             if($rows=='web'){ echo '<td><button type="button" class="btn btn-default btn-sm"><a href="user_locations/'.$id.'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></button></td>';}
                                             if($rows=='web'){ echo '<td><button type="button" class="btn btn-default btn-sm"><a href="user_delete/'.$id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a></button></td>';}
                                             if($rows=='web'){ echo '<td><button type="button" class="btn btn-default btn-sm"><a href="user_update/'.$id.'"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></a></button></td></tr>';}
                                        }
                                        $i++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <?= $links;?>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>