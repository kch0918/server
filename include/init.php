<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once($_SERVER['DOCUMENT_ROOT']."/include/db.php");


session_start();
sql_query("set names utf8;");
function alert($data)
{
    echo "<script>alert('{$data}');</script>";
}
function console($data)
{
    echo "<script>console.log('{$data}');</script>";
}
function href($data)
{
    echo "<script>location.href='{$data}';</script>";
}
function insLog($data)
{
    sql_query("insert into log set content = '{$data}', submit_date = now()+0");
}
function getChmod($cate)
{
    $query_chmod = "select count(*) as cnt from manager where cate = '{$cate}' and manager = '{$_SESSION['login_name']}'";
    $result_chmod = sql_query($query_chmod);
    $row_chmod = sql_fetch($result_chmod);
    
    return $row_chmod['cnt'];
}
function getTitle($board)
{
    $t = "";
    if($board == "server")
    {
        $t = "서버 관리 매뉴얼";
    }
    if($board == "godo")
    {
        $t = "고도몰 작업 히스토리";
    }
    if($board == "qa")
    {
        $t = "QA 테스트케이스";
    }
    if($board == "account")
    {
        $t = "계정관리";
    }
    if($board == "setting")
    {
        $t = "초기셋팅 매뉴얼 및 도메인 관리";
    }
    if($board == "error")
    {
        $t = "오류 히스토리 관리";
    }
    if($board == "code")
    {
        $t = "인터렉션 및 코드 매뉴얼";
    }
    if($board == "manage_co")
    {
        $t = "계정/유지보수 업체 리스트업";
    }
    return $t;
}
?>
