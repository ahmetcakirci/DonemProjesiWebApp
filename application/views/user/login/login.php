<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-8">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-8">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-8">
			<div class="page-header">
				<h1>Giriş Paneli</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="email">EMail</label>
					<input type="text" class="form-control" id="email" name="email" placeholder="EMail Adress">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Giriş Yap">
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->