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
     $output = array("status" => false, "message" => "username exist");
  }
  else
  {  
	  
if(empty($form_data->username))
{
 $output = array("status" => false, "message" => "username is Required");
}else if(empty($form_data->name))
{
 $output = array("status" => false,"message" => "Name is Required");
}else if(empty($form_data->email))
{
 $output = array("status" => false, "message" => "Email is Required");
}else if(!filter_var($form_data->email, FILTER_VALIDATE_EMAIL))
 {
  $output = array("status" => false,"message" => "Invalid Email Format");
 }else if(empty($form_data->password))
{
 $output = array("status" => false,"message" => "Password is Required");
}else
{
 $data[':username'] = $form_data->username;

 $data[':name'] = $form_data->name;

  $data[':email'] = $form_data->email;

 $data[':password'] = password_hash($form_data->password, PASSWORD_DEFAULT);

 $query = "
 INSERT INTO register (name, username, email, password) VALUES (:name, :username, :email, :password)
 ";
 $statement = $connect->prepare($query);
 if($statement->execute($data))
 {
  $output = array("status" => true,"message" => "Successfully register");
 }
}
   //$output = array("message" => "available");
  }
 }
echo json_encode($output);

?>