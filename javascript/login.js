$(document).ready(function(){
setTimeout(function(fadeTo){
	$(".MainContainer").fadeTo(250, 1);
	}, 250);
setTimeout(function(fadeTo){
	$(".circle1").fadeTo(150, 1);
	}, 150);
setTimeout(function(fadeTo){
	$(".circle2").fadeTo(350, 1);
	}, 350);
setTimeout(function(fadeTo){
	$(".circle3").fadeTo(550, 1);
	}, 550);
setTimeout(function(fadeTo){
	$(".AdminloginContainer").fadeTo(450, 1);
	}, 150);
setTimeout(function(fadeTo){
	$(".Admintitleplace").fadeTo(500, 1);
	}, 500);
setTimeout(function(fadeTo){
	$(".Admincontents").fadeTo(2600, 1);
	}, 600);
setTimeout(function(fadeTo){
	$(".AdminButton").fadeTo(800, 1);
	}, 800);
setTimeout(function(fadeTo){
	$(".CashierButton").fadeTo(1000, 1);
	}, 1000);
setTimeout(function(fadeTo){
	$(".StockControllerButton").fadeTo(1200, 1);
	}, 1200);
setTimeout(function(fadeIn){
		$('.Admintitleplace').addClass('AdmintitleplaceAfter').removeClass('Admintitleplace');
	}, 2000);
setTimeout(function(){
		$('.Adminicon').addClass('AdminiconAfter').removeClass('Adminicon');
		$('.AdminTitleName').addClass('AdminTitleNameAfter').removeClass('AdminTitleName');
	}, 2600);


});

$(document).ready(function() {
$(".AdminButton").hover(
	function() {
		$(".AdminButton").attr("src", "assets/superadmin.png");
		$(".AdminButtonTitle").fadeIn(700);
	},
	function() {
		$(".AdminButton").attr("src", "assets/superadmin2.png");;
		$(".AdminButtonTitle").fadeOut(1);
	}
);
});

$(document).ready(function() {
$(".CashierButton").hover(
	function() {
		$(".CashierButton").attr("src", "assets/cashier.png");
		$(".CashierButtonTitle").fadeIn(700);
	},
	function() {
		$(".CashierButton").attr("src", "assets/cashier2.png");
		$(".CashierButtonTitle").fadeOut(1);
	}
);
});
$(document).ready(function() {
$(".StockControllerButton").hover(
	function() {
		$(".StockControllerButton").attr("src", "assets/StockController.png");
		$(".StockControllerButtonTitle").fadeIn(700);
	},
	function() {
		$(".StockControllerButton").attr("src", "assets/StockController2.png");
		$(".StockControllerButtonTitle").fadeOut(1);
	}
);
});


const adminemailInput = document.querySelector('.AdminEmail');
const adminemailTitle = document.querySelector('.AdminEmailTitle');

adminemailInput.addEventListener('focus', () => {
	adminemailTitle.style.top = '44%';
	adminemailInput.style.borderBottom = '2px solid #FADE6B';
});

adminemailInput.addEventListener('blur', () => {
	if (adminemailInput.value.trim() === '') {
		adminemailTitle.style.top = '49%';
		adminemailInput.style.borderBottom = '2px solid black';
	}
});

const adminpasswordInput = document.querySelector('.AdminPassword');
const adminpasswordTitle = document.querySelector('.AdminPasswordTitle');

adminpasswordInput.addEventListener('focus', () => {
	adminpasswordTitle.style.top = '56%';
	adminpasswordInput.style.borderBottom = '2px solid #FADE6B';
});

adminpasswordInput.addEventListener('blur', () => {
	if (adminpasswordInput.value.trim() === '') {
		adminpasswordTitle.style.top = '60%';
		adminpasswordInput.style.borderBottom = '2px solid black';
	}
});

$(document).ready(function() {
$(".adminshowPassword").click(function() {
	const adminpasswordField = $(".AdminPassword");
	const adminimg = $(this);

	if (adminpasswordField.attr("type") === "password") {
		adminpasswordField.attr("type", "text");
		adminimg.attr("src", "assets/view.png");
	} else {
		adminpasswordField.attr("type", "password");
		adminimg.attr("src", "assets/hide.png");
	}
});
});


$(function(){
	$(".Admin, .AdminButton").click(function() {
		document.title = "Admin - Login";
		$('.Icon').attr('href', 'assets/superadminicon.png');
		$(".GreetingsContainer").fadeOut(100);
		$(".Admin").fadeOut(100);
		$(".Cashier").fadeOut(100);
		$(".StockController").fadeOut(100);
		$(".CashierloginContainer").fadeOut(100);
		$(".StockControllerloginContainer").fadeOut(100);

		setTimeout(function(fadeTo){
			$(".AdminloginContainer").fadeTo(450, 1);
			}, 150);
		setTimeout(function(fadeTo){
			$(".Admintitleplace").fadeTo(500, 1);
			}, 500);
		setTimeout(function(fadeTo){
			$(".Admincontents").fadeTo(2600, 1);
			}, 1000);
		setTimeout(function(fadeTo){
			$(".AdminButton").fadeTo(800, 1);
			}, 800);
		setTimeout(function(fadeTo){
			$(".CashierButton").fadeTo(1000, 1);
			}, 1000);
		setTimeout(function(fadeTo){
			$(".StockControllerButton").fadeTo(1200, 1);
			}, 1200);
		setTimeout(function(){
			$('.Admintitleplace').addClass('AdmintitleplaceAfter').removeClass('Admintitleplace');
			}, 2000);
		setTimeout(function(fadeIn){
			$('.AdminTitleName').addClass('AdminTitleNameAfter').removeClass('AdminTitleName');
			$('.Adminicon').addClass('AdminiconAfter').removeClass('Adminicon');
			}, 2500);
		});
});



const cashieremailInput = document.querySelector('.CashierEmail');
const cashieremailTitle = document.querySelector('.CashierEmailTitle');

cashieremailInput.addEventListener('focus', () => {
	cashieremailTitle.style.top = '44%';
	cashieremailInput.style.borderBottom= '2px solid #FADE6B';
});

cashieremailInput.addEventListener('blur', () => {
	if (cashieremailInput.value.trim() !== '') {
	
	} else {
	cashieremailTitle.style.top = '49%';
	cashieremailInput.style.borderBottom= '2px solid black';
	}
});
const cashierpasswordInput = document.querySelector('.CashierPassword');
const cashierpasswordTitle = document.querySelector('.CashierPasswordTitle');

cashierpasswordInput.addEventListener('focus', () => {
	cashierpasswordTitle.style.top = '56%';
	cashierpasswordInput.style.borderBottom= '2px solid #FADE6B';
});

cashierpasswordInput.addEventListener('blur', () => {
	if (cashierpasswordInput.value.trim() !== '') {
	
	} else {
	cashierpasswordTitle.style.top = '60%';
	cashierpasswordInput.style.borderBottom= '2px solid black';
	}
});
$(document).ready(function() {
$(".CashiershowPassword").click(function() {
	const cashierpasswordField = $(".CashierPassword");
	const cashierimg = $(this);

	if (cashierpasswordField.attr("type") === "password") {
		cashierpasswordField.attr("type", "text");
		cashierimg.attr("src", "assets/view.png");
	} else {
		cashierpasswordField.attr("type", "password");
		cashierimg.attr("src", "assets/hide.png");
	}
});
});


$(function(){
	$(".Cashier, .CashierButton").click(function() {
		document.title = "Cashier - Login";
		$('.Icon').attr('href', 'assets/cashiericon.png');
		$(".GreetingsContainer").fadeOut(200);
		$(".Admin").fadeOut(100);
		$(".Cashier").fadeOut(100);
		$(".StockController").fadeOut(100);
		$(".AdminloginContainer").fadeOut(100);
		$(".StockControllerloginContainer").fadeOut(100);

		setTimeout(function(fadeTo){
			$(".CashierloginContainer").fadeTo(450, 1);
			}, 150);
		setTimeout(function(fadeTo){
			$(".Cashiertitleplace").fadeTo(500, 1);
			}, 500);
		setTimeout(function(fadeTo){
			$(".Cashiercontents").fadeTo(2600, 1);
			}, 1000);
		setTimeout(function(fadeTo){
			$(".AdminButton").fadeTo(800, 1);
			}, 800);
		setTimeout(function(fadeTo){
			$(".CashierButton").fadeTo(1000, 1);
			}, 1000);
		setTimeout(function(fadeTo){
			$(".StockControllerButton").fadeTo(1200, 1);
			}, 1200);
		setTimeout(function(){
			$('.Cashiertitleplace').addClass('CashiertitleplaceAfter').removeClass('Cashiertitleplace');
			}, 2000);
		setTimeout(function(fadeIn){
			$('.CashierTitleName').addClass('CashierTitleNameAfter').removeClass('CashierTitleName');
			$('.Cashiericon').addClass('CashiericonAfter').removeClass('Cashiericon');
			}, 2500);
		});
});


const stockControlleremailInput = document.querySelector('.StockControllerEmail');
const stockControlleremailTitle = document.querySelector('.StockControllerEmailTitle');

stockControlleremailInput.addEventListener('focus', () => {
	stockControlleremailTitle.style.top = '44%';
	stockControlleremailInput.style.borderBottom= '2px solid #FADE6B';
});

stockControlleremailInput.addEventListener('blur', () => {
	if (stockControlleremailInput.value.trim() !== '') {
	
	} else {
	stockControlleremailTitle.style.top = '49%';
	stockControlleremailInput.style.borderBottom= '2px solid black';
	}
});
const stockControllerpasswordInput = document.querySelector('.StockControllerPassword');
const stockControllerpasswordTitle = document.querySelector('.StockControllerPasswordTitle');

stockControllerpasswordInput.addEventListener('focus', () => {
	stockControllerpasswordTitle.style.top = '56%';
	stockControllerpasswordInput.style.borderBottom= '2px solid #FADE6B';
});

stockControllerpasswordInput.addEventListener('blur', () => {
	if (stockControllerpasswordInput.value.trim() !== '') {
	
	} else {
	stockControllerpasswordTitle.style.top = '60%';
	stockControllerpasswordInput.style.borderBottom= '2px solid black';
	}
});
$(document).ready(function() {
$(".StockControllershowPassword").click(function() {
	const stockControllerpasswordField = $(".StockControllerPassword");
	const stockControllerimg = $(this);

	if (stockControllerpasswordField.attr("type") === "password") {
		stockControllerpasswordField.attr("type", "text");
		stockControllerimg.attr("src", "assets/view.png");
	} else {
		stockControllerpasswordField.attr("type", "password");
		stockControllerimg.attr("src", "assets/hide.png");
	}
});
});


$(function(){
	$(".StockController, .StockControllerButton").click(function() {
		document.title = "Stock Controller - Login";
		$('.Icon').attr('href', 'assets/stockcontrollericon.png');
		$(".GreetingsContainer").fadeOut(200);
		$(".Admin").fadeOut(100);
		$(".Cashier").fadeOut(100);
		$(".StockController").fadeOut(100);
		$(".AdminloginContainer").fadeOut(100);
		$(".CashierloginContainer").fadeOut(100);

		setTimeout(function(fadeTo){
			$(".StockControllerloginContainer").fadeTo(450, 1);
			}, 150);
		setTimeout(function(fadeTo){
			$(".StockControllertitleplace").fadeTo(500, 1);
			}, 500);
		setTimeout(function(fadeTo){
			$(".StockControllercontents").fadeTo(2600, 1);
			}, 1000);
		setTimeout(function(fadeTo){
			$(".AdminButton").fadeTo(800, 1);
			}, 800);
		setTimeout(function(fadeTo){
			$(".CashierButton").fadeTo(1000, 1);
			}, 1000);
		setTimeout(function(fadeTo){
			$(".StockControllerButton").fadeTo(1200, 1);
			}, 1200);
		setTimeout(function(){
			$('.StockControllertitleplace').addClass('StockControllertitleplaceAfter').removeClass('StockControllertitleplace');
			}, 2000);
		setTimeout(function(fadeIn){
			$('.StockControllerTitleName').addClass('StockControllerTitleNameAfter').removeClass('StockControllerTitleName');
			$('.StockControllericon').addClass('StockControllericonAfter').removeClass('StockControllericon');
			}, 2500);
			});
});