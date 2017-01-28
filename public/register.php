<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $first_name = '';
  $last_name = '';
  $email = '';
  $username = '';
  $errors = array();
  $created_at;

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

  if(is_post_request()){
    // Confirm that POST values are present before accessing them.
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // First name validation

    if (is_blank($_POST['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 255]) || !check_name($_POST['first_name'])) {
      $errors[] = "First name must be between 2 and 255 characters and include only small or capital letters, spaces and/or following symbols: - , . '.";
    }
    
    // Last name validation
    
    if (is_blank($_POST['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 255]) || !check_name($_POST['last_name'])) {
      $errors[] = "Last name must be between 2 and 255 characters and include only small or capital letters, spaces and/or following symbols: - , . '.";
    }

    // E-mail validation
    
    if (is_blank($_POST['email'])) {
      $errors[] = "E-mail cannot be blank.";
    } elseif (!has_length($_POST['email'], ['min' => 0, 'max' => 255]) || !check_email($_POST['email'])) {
      $errors[] = "E-mail must be between 0 and 255 characters and include only small or capital letters, numbers and/or following symbols: _  . @.";
    } elseif (!has_valid_email_format($_POST['email'])) {
      $errors[] = "E-mail must have a correct format.";
    }
    
    // Username validation 

    if (is_blank($_POST['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($_POST['username'], ['min' => 8, 'max' => 255]) || !check_name($_POST['username'])) {
      $errors[] = "Username must be between 8 and 255 characters and include only small or capital letters, numbers and/or following symbols: _ .";
    } 

  
    // if there were no errors, submit data to database

      // Write SQL INSERT statement
    if(empty($errors)){


      $sql = "SELECT * FROM users WHERE username ='".$username."'";
      $result = db_query($db, $sql);

      if (db_num_rows($result) != 0) {

        $errors[] = "Username already exists.";
      } else {

       $created_at = date("Y-m-d H:i:s");

       $sql = "INSERT INTO users ";
      $sql .= "(first_name, last_name, email, username,created_at) ";
      $sql .= "VALUES (";
      $sql .= "'" . $first_name . "',";
      $sql .= "'" . $last_name . "',";
      $sql .= "'" . $email . "',";
      $sql .= "'" . $username . "',";
      $sql .= "'" . $created_at . "'";
      $sql .= ")";


      // For INSERT statments, $result is just true/false
       $result = db_query($db, $sql);
       if($result) {
       db_free_result($result);
       db_close($db);

      //   TODO redirect user to success page
       redirect_to('registration_success.php');
       exit;
       } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
         echo db_error($db);
         db_free_result($result);
         db_close($db);
        exit;
       }
      
       }
     }
   }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php  
  // TODO: display any form errors here
  // Hint: private/functions.php can help
  
  echo display_errors($errors);
  
  ?>
   
  <!-- TODO: HTML form goes here -->

  <form action="register.php" method="post">
  First name:<br>
  <input type="text" name="first_name" value="<?php echo $first_name; ?>">
  <br>
  Last name:<br>
  <input type="text" name="last_name" value="<?php echo $last_name; ?>">
  <br>
  E-mail:<br>
  <input type="text" name="email" value="<?php echo $email; ?>">
  <br>
  Username:<br>
  <input type="text" name="username" value="<?php echo $username; ?>">
  <br><br>
  <input type="submit" value="Submit">
</form>

  <?php
    
  ?>

  

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
