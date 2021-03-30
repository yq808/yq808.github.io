$(window).scroll(function() {
	if ($(this).scrollTop() > 201) {
		$("#nav-header").addClass("active");
	} else {
		$("#nav-header").removeClass("active");
	}
});

document.querySelector("#email-form").onsubmit = function() {
	var email = document.querySelector("#sub-email").value.trim();
	var emailReg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	if (/^$/.test(email)) {
		document.querySelector("#subscription-msg").innerHTML = "Email cannot be empty.";
	} else if (emailReg.test(email) == false) {
		document.querySelector("#subscription-msg").innerHTML = "You have provided an invalid email.";
	} else {
		document.querySelector("#subscription-msg").innerHTML = "You have been successfully signed up for the mailing list!";
	}

	return false;
}