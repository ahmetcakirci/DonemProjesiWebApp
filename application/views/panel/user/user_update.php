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
        <?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($success)) : ?>
            <div class="col-md-12">
                <div class="alert alert-success" role="success">
                    <?= $success ?>
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
                    <?= form_open() ?>
                    <div class="form-group">
                        <label for="usr">Kullanıcı Adı:</label>
                        <input type="text"  name="name" value="<?php echo $user[0]->name;?>" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Kullanıcı Soyadı:</label>
                        <input type="text"  name="surname" value="<?php echo $user[0]->surname;?>"  class="form-control" id="surname">
                    </div>
                    <div class="form-group">
                        <label for="usr">EMail Adresi:</label>
                        <input type="email"  name="email" value="<?php echo $user[0]->email;?>"  class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="usr">IMEI Numarası:</label>
                        <input type="text"  name="imei" value="<?php echo $user[0]->imei;?>"  class="form-control" id="imei">
                    </div>
                    <button class="btn btn-large btn-primary" type="submit">Kullanıcı Düzenle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>