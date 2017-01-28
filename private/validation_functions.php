<?php

  // is_blank('abcd')
  function is_blank($value='') {
    // TODO
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    // TODO
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    } elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    } else {
      return true;
    }

  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // TODO
    return filter_var($value, FILTER_VALIDATE_EMAIL);

  }

  function check_name($field_name){
      
      return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $field_name);
        
  } 

  function check_username($field_name){
      
      return preg_match('/\A[A-Za-z0-9\_]+\Z/', $field_name);
       
  }

  function check_email($field_name){
      
      return preg_match('/\A[A-Za-z0-9\_\@\.]+\Z/', $field_name);
    

  }






?>
