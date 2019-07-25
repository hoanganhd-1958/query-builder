<a class="btn btn-primary" href="/">users list</a>
<div class="form_wrapper">
	<form action="/query-builder/index.php?controller=users&action=postEdit" method="post" class="form" id="form">
		<span class="form__header">Edit User</span>
		<input type="hidden" name="id"
			value="<?= $_GET['id'] ?>">
		<div class="form__item">
			<label for="name" class="label">Your Name</label>
			<span class="input-validate"></span>
			<input type="text" class="input" name="name" id="name" placeholder="Enter your name"
				value="<?= $data['username'] ?>">
			<span class="focus-input"></span>
		</div>
		<div class="form__item">
			<label for="email" class="label">Email</label>
			<span class="input-validate"></span>
			<input type="text" class="input" name="email" id="email" placeholder="Enter your email address"
				value="<?= $data['email'] ?>">
			<span class="focus-input"></span>
		</div>
		<div class="form__item">
			<label for="password" class="label">Password</label>
			<span class="input-validate"></span>
			<input type="password" class="input" name="password" id="password" placeholder="Enter your password">
			<span class="focus-input"></span>
		</div>
		<div class="form__item">
			<label for="password_again" class="label">Confirm Password</label>
			<span class="input-validate"></span>
			<input type="password" class="input" name="password_again" id="password_again"
				placeholder="Confirm password">
			<span class="focus-input"></span>
		</div>
		<div class="form__submit">
			<div class="overflow">
			</div>
			<input type="submit" name="submit" class="btnSubmit" value="Edit">
		</div>
	</form>
</div>