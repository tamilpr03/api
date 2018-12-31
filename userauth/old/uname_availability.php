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
     $output = array("message" => "username exist");
  }
  else
  {
	  
	  
	  
	  
   //$output = array("message" => "available");
  }
 }
echo json_encode($output);

?>