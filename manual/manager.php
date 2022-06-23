<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/manual_header.php");

$query = "select * from user where manager_yn = 'Y'";
$result = sql_query($query);

if($_SESSION['login_name'] != '변지윤' && $_SESSION['login_name'] != '정기영')
{
    echo "잘못된 접근입니다.";
    exit;
}

?>
<script>
function fncSubmit()
{
	$("#fncForm").ajaxSubmit({
		success: function(data)
		{
			console.log(data);
			var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert(result.msg);
    		}
		}
	});
}
</script>

<div class="sub-top text-center">

	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>
<div class="login-box join-view">
    <form id="fncForm" action="./manager_proc.php" method="POST">
    	<h2 class="text-center">담당자 관리</h2>
    	
    	서버관리 메뉴얼 
        <select id="server" name="server">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select><br>
    	고도몰 작업 히스토리
        <select id="godo" name="godo">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select><br>
    	QA 테스트케이스 작성
        <select id="qa" name="qa">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select><br>
    	계정관리
        <select id="account" name="account">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select><br>
    	초기셋팅 메뉴얼 및 도메인 관리
        <select id="setting" name="setting">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select><br>
    	오류 히스토리 관리
        <select id="error" name="error">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select><br>
    	인터렉션 및 코드 메뉴얼
        <select id="code" name="code">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select><br>
    	유지보수 업체 리스트업
        <select id="manage_co" name="manage_co">
        	<?php 
        	$result->data_seek(0);
            for($i = 0; $i < sql_count($result); $i++)
            {
                $row = sql_fetch($result);
                ?>
                	<option value="<?php echo $row['user_name']?>"><?php echo $row['user_name']?></option>
                <?php 
            }
            ?>
        </select>
    	<div>
			<a class="login-btn" href="javascript:fncSubmit();">적용하기</a>
		</div>
    </form>
	
</div>



<?php 
$query = "select * from manager";
$result_ = sql_query($query);
for($i = 0; $i < sql_count($result_); $i++)
{
    $row_ = sql_fetch($result_);
    echo "<script>$('#{$row_['cate']}').val('{$row_['manager']}');</script>";
}
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>