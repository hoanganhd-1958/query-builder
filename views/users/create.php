<a class="btn btn-primary" href="/">users list</a>
<div class="form_wrapper">
	<form action="/query-builder/index.php?controller=users&action=postCreate" method="post" class="form" id="form">
		<span class="form__header">Create User</span>
		<div class="form__item">
			<label for="name" class="label">Your Name</label>
			<span class="input-validate"></span>
			<input type="text" class="input" name="name" id="name" value="" placeholder="Enter your name">
			<span class="focus-input"></span>
		</div>
		<div class="form__item">
			<label for="email" class="label">Email</label>
			<span class="input-validate"></span>
			<input type="text" class="input" name="email" id="email" value="" placeholder="Enter your email address">
			<span class="focus-input"></span>
		</div>
		<div class="form__item">
			<label for="password" class="label">Password</label>
			<span class="input-validate"></span>
			<input type="password" class="input" name="password" id="password" value=""
				placeholder="Enter your password">
			<span class="focus-input"></span>
		</div>
		<div class="form__item">
			<label for="password_again" class="label">Confirm Password</label>
			<span class="input-validate"></span>
			<input type="password" class="input" name="password_again" id="password_again" value=""
				placeholder="Confirm password">
			<span class="focus-input"></span>
		</div>
		<div class="form__submit">
			<div class="overflow">
			</div>
			<input type="submit" name="submit" class="btnSubmit" value="Sign up">
		</div>
	</form>
</div>