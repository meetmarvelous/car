<?php 
require_once("includes/config.php");
// code user email availability
if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
		echo "error : You did not enter a valid email.";
	}
	else {
		$sql = "SELECT EmailId FROM tblusers WHERE EmailId='$email'";
		$query = mysqli_query($con, $sql);
		if(mysqli_num_rows($query) > 0) {
			echo "<span style='color:red'> Email already exists.</span>";
			echo "<script>$('#submit').prop('disabled',true);</script>";
		} else {
			echo "<span style='color:green'> Email available for Registration.</span>";
			echo "<script>$('#submit').prop('disabled',false);</script>";
		}
	}
}
?>