<div class="container">
	<div class="content">
		<div class="login">
			<div class="logo">
				<img src="<?= base_url('img/logo.png'); ?>" alt="logo">
				<h2>Coralis Test</h2>
			</div>
			<?= $this->session->flashdata('mssg') ?>
			<form action="<?= base_url('authentication') ?>" method="post">
				<div>
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="input-text" value="<?= set_value('email') ?>" />
					<small class="form-error"><?= form_error('email') ?></small>
				</div>
				<div>
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="input-text" />
					<small class="form-error"><?= form_error('password') ?></small>
				</div>
				<button class="btn-1" type="submit">Login</button>
			</form>
			<div class="link">
				<a href="<?= base_url('authentication/forgetPasswordView') ?>">Lupa Password?</a>
			</div>
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
