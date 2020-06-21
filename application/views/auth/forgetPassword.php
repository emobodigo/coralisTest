<div class="container">
	<div class="content">
		<div class="login">
			<div class="logo">
				<img src="<?= base_url('img/logo.png'); ?>" alt="logo">
				<h2>Coralis Test</h2>
			</div>
			<?= $this->session->flashdata('mssg') ?>
			<p class="session-sukses">Masukkan email anda untuk reset Password</p>
			<form action="<?= base_url('authentication/forgetPasswordView') ?>" method="post">
				<div>
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="input-text" value="<?= set_value('email') ?>" />
					<small class="form-error"><?= form_error('email') ?></small>
				</div>

				<button class="btn-1" type="submit">Konfirmasi</button>
			</form>

			<div class="or">
				<hr class="line" />
				<span>Atau</span>
				<hr class="line" />
			</div>
			<a href="<?= base_url('authentication/register') ?>" class="btn-2">Register</a>
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
