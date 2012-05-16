function addcheck() {
	if (document.adduser.newuser.value == "" || document.adduser.newpw.value == "") {
		alert('Please enter all fields.');
		return false;
	}
}

function usercheck() {
	if (document.login.username.value == "" || document.login.pw.value == "") {
		alert('Please enter both a username and password.');
		return false;
	}
}

function checkedite() {
	if (document.editevent.eventname.value == "" || document.editevent.eventloc.value == "" || document.editevent.year.value == "" || document.editevent.hour.value == "" || document.editevent.mins.value == "") {
		alert('Please enter all fields.');
		return false;
	}
}

function changecheck() {
	if (document.login.changeuser.value == "" && document.login.changepw.value == "" && document.login.changefirst.value == "" && document.login.changelast.value == "") {
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

function eventcheck() {
	var hr = document.getElementById("hour").value;
	var mins = document.getElementById("mins").value;
	if (document.addevent.eventname.value == "" || document.addevent.eventloc.value == "" || document.addevent.year.value == "" || hr == "" || mins == "") {
		alert('Please fill out all fields.');
		return false;
	}
}

function blogvalue(newval) {
	document.blog.action.value=newval;
}

function addabi() {
	var url = document.blog.imgurl.value;
	var content = document.blog.content.value;
	var radio = document.blog.imgsize;
	var width;
	for (var i = 0; i < radio.length; i++) {
		if (radio[i].checked) {
			size = radio[i].value;
		}
	}
	if (size == "large") {
		width = 600;
	}
	else if (size == "medium") {
		width = 400;
	}
	else {
		width = 200;
	}
	content = content + " <img src='" + url + "' width='" + width + "'> ";
	document.blog.content.value = content;
}

function addbr() {
	var content = document.blog.content.value;
	content = content + " <br>";
	document.blog.content.value = content;
}

function getSelText() {
	var txt = '';
	if (window.getSelection) {
		txt = window.getSelection();
	}
	else if (document.getSelection) {
		txt = document.getSelection;
	}
	else if (document.selection) {
		txt = document.selection;
	}
	else return;
	return txt;
}

function addb() {
	var content = document.blog.content.value;
	content = content + " <b>Bold text here</b> ";
	document.blog.content.value = content;
}

function addi() {
	var content = document.blog.content.value;
	content = content + " <b>Italicized text here</b> ";
	document.blog.content.value = content;
}

function addu() {
	var content = document.blog.content.value;
	content = content + " <u>Underlined text here</u> ";
	document.blog.content.value = content;
}

function ajaxfunc(id) {
	var httpxml;
	try {
		httpxml = new XMLHttpRequest();
	}
	
	catch (e) {
		try {
			httpxml = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				httpxml = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {
				alert("This browser is not compatible with AJAX.");
				return false;
			}
		}
	}

	function state() {
		if (httpxml.readyState == 4) {
			array = eval(httpxml.responseText);
			for (var j = document.getElementById("date").options.length - 1; j >= 0; j--) {
				document.getElementById("date").options.remove(j);
			}
			for (var i = 0; i < array.length; i++) {
				var opt = document.createElement("OPTION");
				opt.text = array[i];
				opt.value = array[i];
				document.getElementById("date").options.add(opt);
			}
		}
	}
	
	var url = "dates.php";
	url = url+"?id="+id;
	httpxml.onreadystatechange = state;
	httpxml.open("GET", url, true);
	httpxml.send(null);
}