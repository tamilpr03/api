<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//login.php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$data[':username'] = $form_data->username;

 $query = "SELECT * FROM register WHERE username = :username";
 
 $statement = $connect->prepare($query);
 if($statement->execute($data))
 {
  $result = $statement->fetchAll();
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {
    if(password_verify($form_data->password, $row["password"]))
    {
     $output = array(
	 "status" => true,
        "message" => "Successfully Login!",
		"secret" => "This is secret one .. logged in",
		"username" => $row["username"]);
    }
    else
    {
     $output = array(
	 "status" => false,
        "message" => " wrong password!");
    }
   }
  }
  else
  {
   $output = array(
	 "status" => false,
        "message" => "wrong Username!"
);
  }
 }
echo json_encode($output);

?>