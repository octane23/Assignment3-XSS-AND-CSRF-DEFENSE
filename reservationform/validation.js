function validateForm() {
	var name = document.getElementById("name").value;
	var matric_no = document.getElementById("matric_no").value;
	var current_address = document.getElementById("current_address").value;
	var home_address = document.getElementById("home_address").value;
	var email = document.getElementById("email").value;
	var mobile_no = document.getElementById("mobile_no").value;
	var home_no = document.getElementById("home_no").value;

	var name_regex = /^[a-zA-Z\s]+$/;
	var matric_no_regex = /^[0-9]{10}$/;
	var phone_regex = /^[0-9]{10}$/;

	if (!name_regex.test(name)) {
		document.getElementById("name_error").innerHTML = "Please enter a valid name";
		return false;
	} else {
		document.getElementById("name_error").innerHTML = "";
	}

	if (!matric_no_regex.test(matric_no)) {
		document.getElementById("matric_no_error").innerHTML = "Please enter a valid matric no (10 digits)";
		return false;
	} else {
		document.getElementById("matric_no_error").innerHTML = "";
	}

	if (current_address.trim() == "") {
		document.getElementById("current_address_error").innerHTML = "Please enter your current address";
		return false;
	} else {
		document.getElementById("current_address_error").innerHTML = "";
	}

	if (home_address.trim() == "") {
		document.getElementById("home_address_error").innerHTML = "Please enter your home address";
		return false;
	} else {
		document.getElementById("home_address_error").innerHTML = "";
	}

	if (email.indexOf("@gmail") == -1 || email.indexOf(".") == -1) {
		document.getElementById("email_error").innerHTML = "Please enter a valid email address";
		return false;
	} else {
		document.getElementById("email_error").innerHTML = "";
	}

	if (!phone_regex.test(mobile_no)) {
		document.getElementById("mobile_no_error").innerHTML = "Please enter a valid mobile phone no (10 digits)";
		return false;
	} else {
		document.getElementById("mobile_no_error").innerHTML = "";
	}

	if (!phone_regex.test(home_no)) {
		document.getElementById("home_no_error").innerHTML = "Please enter a valid home phone no (10 digits)";
		return false;
	} else {
		document.getElementById("home_no_error").innerHTML = "";
	}
}
