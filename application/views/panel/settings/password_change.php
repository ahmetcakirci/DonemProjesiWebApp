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
        <div class="row-fluid">
            <div class="span3">
                <?php $this->load->view('panel/panel_menu');?>
            </div><!--/span-->
            <div class="span9">
                <div class="jumbotron">
                    <?= form_open() ?>
                        <div class="form-group">
                            <label for="usr">Yeni Parola:</label>
                            <input type="password"  name="newpassword" class="form-control" id="newpassword">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Parola Tekrar:</label>
                            <input type="password"  name="repassword" class="form-control" id="repassword">
                        </div>
                        <button class="btn btn-large btn-primary" type="submit">Parola Değiştir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>