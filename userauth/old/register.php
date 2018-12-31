<?php

//register.php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));



if(empty($form_data->username))
{
 $output = array('message' => "username is Required");
}
else
{
 $data[':username'] = $form_data->username;
}



if(empty($form_data->name))
{
 $output = array('message' => "Name is Required");
}
else
{
 $data[':name'] = $form_data->name;
}

if(empty($form_data->email))
{
 $output = array('message' => "Email is Required");
}
else
{
 if(!filter_var($form_data->email, FILTER_VALIDATE_EMAIL))
 {
  $output = array('message' => "Invalid Email Format");
 }
 else
 {
  $data[':email'] = $form_data->email;
 }
}

if(empty($form_data->password))
{
 $output = array('message' => "Password is Required");
}
else
{
 $data[':password'] = password_hash($form_data->password, PASSWORD_DEFAULT);
}

if(empty($error))
{
 $query = "
 INSERT INTO register (name, username, email, password) VALUES (:name, :username, :email, :password)
 ";
 $statement = $connect->prepare($query);
 if($statement->execute($data))
 {
  $output = array('message' => "Successfully register");
 }
}
else
{
$output = array('message' => "Successfully register");
}



echo json_encode($output);


?>