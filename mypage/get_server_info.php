<?php

require($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$server_type=$_POST['server_type'];


$query = "SELECT * FROM server_info WHERE server_type like '%{$server_type}%'";
$result = sql_query($query);
$emparray = array();


while($row = mysqli_fetch_assoc($result))
{
    $emparray[] = $row;
}
echo json_encode($emparray);


?>