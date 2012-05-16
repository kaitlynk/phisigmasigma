setInterval(fetch, 200);
function fetch() {
	$.post("getnotifications.php", process);
}

function process(data) {
	if(data != "") {
		var result = $.parseJSON(data);
		$('.notification_center').html('<p>' + result.notification + '</p>');
		$('.new_notification').slideDown().delay(4000).slideUp();
		var oldVal = $('.notification_count').html();
		var newVal = parseFloat(oldVal) + 1;
		$('.notification_count').html(newVal).removeClass('notification_count').addClass('notification_count_new');
		$('#notifications').prepend('<p>' + result.notification + '</p><p class="time">' + result.date + '</p>');
	}
}