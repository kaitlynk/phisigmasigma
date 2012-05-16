<?php session_start();
include_once('db.inc');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Phi Sigma Sigma</title>
<script type="text/javascript" src="https://use.typekit.com/ahu5nxd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="phisigsig.js"></script>
</head>
<body>
	<?
	include('header.php');
	?>
	<div class="pink"></div>
	<div class="blue"></div>
	<div class="center_module">
	<div class="module">
			<?php
				$id = $_POST['editid'];
				$eventq = $mysql->query("SELECT* FROM events WHERE id='".$id."'");
				$event = $eventq->fetch_row();
				$dateq = date_create($event[3]);
				$date = date_format($dateq, 'l, F j, Y');
				$hour = date_format($dateq,'H');
				$mins = date_format($dateq,'i');
				$year = date_format($dateq, 'Y');
				$ampm = date_format($dateq, 'tt');
				if ($hour > 12) {
					$hour -= 12;
				}
			?>

			<form name='editevent' action='admin.php' method='post' enctype = 'multipart/form-data'>
				<h4>
					Title 
				</h4>
				<p>
					<input type='text' name='eventname' maxlength='50' size='50' value='<?php echo $event[1]?>' class='text'>
				</p>
				<h4>
					Location 
				</h4>
				<p>
					<input type='text' name='eventloc' maxlength='100' size='100' value='<?php echo $event[2]?>' class='text'>
				</p>
				<h4>
					Date <form name = 'dateofe' method = 'POST' action = 'mainck.php'>
					<p>
						<select name = 'month' onchange = 'return ajaxfunc(this.value);' class="month">
							<option value = '01'>January</option>
							<option value = '02'>February</option>
							<option value = '03'>March</option>
							<option value = '04'>April</option>
							<option value = '05'>May</option>
							<option value = '06'>June</option>
							<option value = '07'>July</option>
							<option value = '08'>August</option>
							<option value = '09'>September</option>
							<option value = '10'>October</option>
							<option value = '11'>November</option>
							<option value = '12'>December</option>
						</select>
						<select name = 'date' id = 'date' class="day">
							<?php
								for ($i = 1; $i < 31; $i++) {
									echo "<option value = '".$i."'>".$i."</option>";
								}
							?>
						</select>
						<input type = 'text' name = 'year' maxlength = '4' size = '4' class='yeartext' value='<?php echo $year; ?>'>
						(originally on <?php echo $date; ?>)
					</p>
					</h4>
						<h4>Time</h4>
						<p>
						<input type = 'text' name = 'hour' maxlength = '2' size = '2' class='timetxt' id = 'hour' value='<?php echo $hour; ?>'>
						<input type = 'text' name = 'mins' maxlength = '2' size = '2' class='timetxt' id = 'mins' value='<?php echo $mins; ?>'>
						<?php if ($ampm == 'AM') {
							echo "<select name = 'ampm' class='ampm'>
								<option value = 'AM' selected='selected'>AM</option>
								<option value = 'PM'>PM</option>
							</select></p>";
							}
							else {
								echo "<select name = 'ampm' class='ampm'>
									<option value = 'AM'>AM</option>
									<option value = 'PM' selected='selected'>PM</option>
								</select></p>";
							}
						?>
						<h4>New Photo</h4> 
						<p>
							<input type = 'file' name = 'eventpic' accept = 'image/*'>
						</p>
						<p>
							<input type='checkbox' name='public' value='public'/> Public Event
						</p>
					<p>
						<input type='hidden' name='editedid' value='<?php echo $event[0]?>'>
					</p>
					<p>
						<input type='hidden' name='edited' value='edited'>
					</p>
					<p>
						<input type='submit' value='Edit Event' class='button' onclick='return checkedite();'>
					</p>
				</h4>
			</form> 
		</div>
		</div>
	</div>
</body>
</html>