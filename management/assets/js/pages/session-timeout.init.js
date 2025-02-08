/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Session Timeout Js File
*/

$.sessionTimeout({
	keepAliveUrl: 'pages-starter.html',
	logoutButton:'Logout',
	logoutUrl: 'logout.php',
	redirUrl: 'logout.php',
	warnAfter: 3000,
	redirAfter: 30000,
	countdownMessage: 'Oturumun kapatılmasına {timer} saniye kaldı.'
});

$('#session-timeout-dialog  [data-dismiss=modal]').attr("data-bs-dismiss", "modal");