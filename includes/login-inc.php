<?php

//checking if the user clicked the [Submit] button
if (isset($_POST['submit'])) {

	require 'database.php';

	$username = $_POST['username'];
	$password = $_POST['password'];

	//checking if the username or password are empty
	if (empty($username) || empty($password)) {
		header("Location: ../index.php?error=emptyfields");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE username = ?"; //using a question mark because a prepred statement will be used
		$stmt = mysqli_stmt_init($conn);

		//running the sql statement to be sure that it works in the database
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../index.php?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			//checking if we get the result back and put it into an associative array
			if ($row = mysqli_fetch_assoc($result)) {
					$passCheck = password_verify($password, $row['password']);
					//checking if the passwords match
					if ($passCheck == false) {
						header("Location: ../index.php?error=wrongpassword");
						exit();
					} elseif ($passCheck == true) {
						session_start();
						$_SESSION['sessionId'] = $row['id'];
						$_SESSION['sessionUser'] = $row['username'];
						//not saving a password because it is sensitive information

						header("Location: ../index.php?success=loggedin");
						exit();

					} else {
						header("Location: ../index.php?error=wrongpassword");
						exit();
					}

			} else {
				header("Location: ../index.php?error=nouserfound");
				exit();
			}
		}
	}

} else {
	header("Location: ../index.php?error=accessforbidden");
	exit();
}

?>
