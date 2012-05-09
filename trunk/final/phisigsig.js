function toggleview(elementid) {
	var change = document.getElementById(elementid);
	if (change.style.display == "block") {
		change.style.display="none";
	}
	else {change.style.display='block';}
}

function addcheck() {
	if (document.adduser.newuser.value == "" || document.adduser.newpw.value == "") {
		alert('Please enter both a username and password.');
		return false;
	}
}

function usercheck() {
	if (document.login.username.value == "" || document.login.pw.value == "") {
		alert('Please enter both a username and password.');
		return false;
	}
}

function changecheck() {
	if (document.login.username.value == "" && document.login.pw.value == "") {
		alert('You must change something. Please fill out at least one field.');
		return false;
	}
}

function blogcheck() {
	if (document.blog.title.value == "" || document.blog.content.value == "") {
		alert('Please fill out all fields.');
		return false;
	}
}

function blogvalue(newval) {
	document.blog.action.value=newval;
}