<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 

$server_name = htmlspecialchars(addslashes($_POST['server_name']));
$query = "select * from server_info where server_type = '{$server_name}'";





$result = sql_query($query);
$emparray = array();
while($row = mysqli_fetch_assoc($result))
{
    $emparray[] = $row;
}
echo json_encode($emparray);


?>
