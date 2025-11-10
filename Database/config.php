<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'ql_ban_sua';
$port = 3306;

$con = mysqli_connect($host, $user, $pass, $db, $port);

if(!$con){
    echo"Kết nối thất bại";
}
// else{
//     var_dump($con);
// }
?>