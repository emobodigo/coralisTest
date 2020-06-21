<div class="container">
	<div class="content">
		<div class="login">
			<div class="logo">
				<img src="<?= base_url('img/logo.png') ?>" alt="logo">
				<h2>Coralis Test</h2>
			</div>

			<form action="<?= base_url('authentication/register') ?>" method="post">
				<div>
					<label for="nama">Nama</label>
					<input type="text" name="nama" id="nama" class="input-text" value="<?= set_value('nama') ?>" />
					<small class="form-error"><?= form_error('nama') ?></small>

				</div>
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
				<div>
					<label for="kpassword">Konfirmasi Password</label>
					<input type="password" name="kpassword" id="kpassword" class="input-text" />
				</div>
				<button class="btn-1" type="submit">Register</button>
			</form>
			<div class="or">
				<hr class="line" />
				<span>Atau</span>
				<hr class="line" />
			</div>
			<a href="<?= base_url() ?>authentication" class="btn-2">Login</a>
		</div>
		<footer>
			<p>&copy; By Djohansyah Putra</p>
		</footer>
	</div>
	<div class="presentation">
		<div class="showcase-register">
			<div class="showcase-content">
				<h1 class="text">Register dengan Codeigniter</h2>
			</div>
		</div>
	</div>
</div>
