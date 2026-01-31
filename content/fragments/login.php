<div class="MainContainer">
	<div class="circle1"></div>
	<div class="circle2"></div>
	<div class="circle3"></div>

	<div class="AdminloginContainer">
		<div class="Admintitleplace">
			<img class="Adminicon" src="<?= ROOT_URL ?>assets/darkProfile.svg" height="100%" width="100%">
			<p class="AdminTitleName">d.h azada tire supply</p>
		</div>
		<div class="Admincontents">
			<div class="AdminSign_in"><strong>Sign in to</strong></div>
			<p class="AdminSign_in_continue">D.H Azada Tire Supply Admin Portal</p>
			<form class="AdminLoginForm" action="/customer/content/pages/homePage.php" method="POST">
				<label for="Email" class="AdminEmailTitle">Username or Email</label>
				<input type="text" class="AdminEmail" name="Email" required>

				<label for="Password" class="AdminPasswordTitle">Password</label>
				<input type="password" class="AdminPassword" name="Password" required>
				<img class="AdminshowPassword" src="<?= ROOT_URL ?>assets\hide.png" alt=".JPG" height="100%" width="100%">

				<button class="AdminLoginbtn" type="submit">Login</button>
			</form>
		</div>
	</div>
</div>