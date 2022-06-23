<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

$title = htmlspecialchars(addslashes($_REQUEST['no_title']));
$content = htmlspecialchars(addslashes($_REQUEST['no_content']));

if($_REQUEST['board_type'] == "공지") {
    $query = 
              "
                insert into notice set 
                    title = '{$title}', 
                    content = '{$content}',
                    board_type = '0', 
                    submit_date = now()+0
              ";
    
    sql_query($query);
    
} else {
    $query =
    "
                insert into notice set
                    title = '{$title}',
                    content = '{$content}',
                    board_type = '1',
                    submit_date = now()+0
              ";
    
    sql_query($query);
}

?>
{
	"isSuc":"success"
}
