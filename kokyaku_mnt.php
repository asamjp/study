<?php  
require_once "./lib/db.php";

$name = $_POST["name"];
$email = $_POST["email"];
$usertype = $_POST["usertype"];
$msg = $_POST["msg"];

$sql = "insert into 
            kokyaku_info (
                kokyaku_name, 
                kokyaku_mail, 
                kokyaku_type, 
                kokyaku_bikou
            ) values (
                '".$name."', 
                '".$email."',
                '".$usertype."',
                '".$msg."'
            )";
$db->query($sql);

$sql = "SELECT * FROM `kokyaku_info`";

$slct = select_query($sql);

var_dump($slct)


// echo $name.":".$email;
// echo $email;
// echo $usertype;
// echo $msg;