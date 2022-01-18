<?php

  if (isset($_POST['submit'])) {
    //add database connection
    require 'database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($username) || empty($password) || empty($confirmPassword)) {
      header("Location: ../register.php?error=emptyfields&username=". $username);
      exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*/", $username)) {
      header("Location: ../register.php?error=invalidusername&username=". $username);
      exit();
    } elseif ($password !== $confirmPassword) {
      header("Location: ../register.php?error=passwordsdonotmatch&username=". $username);
      exit();

    } else {
      $sql = "SELECT username FROM users WHERE username = ?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../register.php?error=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt); //used for fetching data from the database
        $rowCount = mysqli_stmt_num_rows($stmt);

        if($rowCount > 0) {
          header("Location: ../register.php?error=usernametaken");
          exit();
        } else {

					//checking if the SQL statement matches
          $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
          $stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)) {
		        header("Location: ../register.php?error=sqlerror");
		        exit();
		      } else {

						//using the bcrypt algorithm because this is designed to change overtime.
						//The length of the result from using this identifier can change over time
						$hashedPass = password_hash($password, PASSWORD_DEFAULT);

						mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPass);
						/*
						==> mysqli_stmt_bind_param($stmt, "ss", $username, $password);
						wrong because password needs to be hashed. This is sensitive information so we do not want to store it in the database
						*/
		        mysqli_stmt_execute($stmt);
						header("Location: ../register.php?success=registered");
		        exit();
						//not needed because this is used only if you fetch data from the database
		        //mysqli_stmt_store_result($stmt);
		      }
        }
      }
    }
		//closing the statement and the database connection
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
  }

 ?>
