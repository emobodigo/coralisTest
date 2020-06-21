<div class="container">
	<div class="content">
		<div class="login">
			<div class="logo">
				<img src="<?= base_url('img/logo.png'); ?>" alt="logo">
				<h3>Coralis Test</h3>
			</div>
			<?= $this->session->flashdata('mssg') ?>
			<h2 class="session-sukses"><?= $this->session->userdata('passReset') ?></h2>
			<form action="<?= base_url('authentication/viewForPasswordChange') ?>" method="post">
				<div>
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="input-text" />
					<small class="form-error"><?= form_error('password') ?></small>
				</div>
				<div>
					<label for="kpassword">Ulangi Password</label>
					<input type="password" name="kpassword" id="kpassword" class="input-text" />
					<small class="form-error"><?= form_error('kpassword') ?></small>
				</div>
				<button class="btn-1" type="submit">Konfirmasi</button>
			</form>
		</div>
		<footer>
			<p>&copy; By Djohansyah Putra</p>
		</footer>
	</div>
	<div class="presentation">
		<div class="showcase">
			<div class="showcase-content">
				<h1 class="text">Login dengan Codeigniter</h2>
			</div>
		</div>
	</div>
</div>
