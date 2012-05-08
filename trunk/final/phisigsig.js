function users() {
	var change = document.getElementById('allusers');
	if (change.style.display == 'none') {
		change.style.display='block';
	}
	else {change.style.display='none';}
}

function adduser() {
	alert('hi');
	alert(document.adduser.newuser.value);
	if (document.adduser.newuser.value == "" || document.adduser.newpw.value == "") {
		alert('Please enter both the username and password.');
		return false;
	}
}