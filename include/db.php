<?php
$link = mysqli_connect('localhost','root','casanova1!@','server');

function sql_query($query) {
    global $link;
    return mysqli_query($link, $query);
}

function sql_fetch($result) {
    return mysqli_fetch_array($result);
}

function sql_count($result) {
    return mysqli_num_rows($result);
}