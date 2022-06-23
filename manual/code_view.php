<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/manual_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");


$query = "select * from code where idx = {$_REQUEST['idx']}";
$result = sql_query($query);
$row = sql_fetch($result);
?>
<script>
function del(idx, board)
{
	$.ajax({
		type : "POST", 
		url : "board_delete.php",
		dataType : "text",
		data : 
		{
			idx : idx,
			board : 'code'
		},
		error : function() 
		{
			console.log("AJAX ERROR");
		},
		success : function(data) 
		{
			console.log(data);
			var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert("삭제되었습니다.");
    			location.href="code.php";
    		}
    		else
    		{
    			alert(result.msg);
    		}
		}
	});
}
function fncSubmit(act)
{
	if(act == "submit")
	{
    	var validationFlag = "Y";
    	$(".notEmpty").each(function()
    	{
    		if ($(this).val() == "") 
    		{
    			alert(this.dataset.name+"을(를) 입력해주세요.");
    			$(this).focus();
    			validationFlag = "N";
    			return false;
    		}
    	});
    	if(validationFlag == "Y")
    	{
    		$("#fncForm").attr("action", "code_modify_proc.php");
    		$("#fncForm").ajaxSubmit({
    			success: function(data)
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    	    		if(result.isSuc == "success")
    	    		{
    	    			alert("저장되었습니다.");
    	    			window.onbeforeunload = function(e) {} 
    	    			location.href="code.php";
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});
    	}
	}
	else
	{
		$("#fncForm").attr("action", "code_preview.php");
		var gsWin = window.open("about:blank", "winName");
		var frm = document.fncForm;
		frm.target="winName";
		frm.submit();
	}
}
</script>

<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>

<div class="table_list family_list">
	<div class="inner">

		<div class="list_tit p010">
			<strong>Musign <?php echo getTitle('code')?></strong>
		</div>

		<div class="main_table family_table p010">
			<form id="fncForm" name="fncForm" method="POST" action="" onSubmit="return false;">
				<input type="hidden" id="idx" name="idx" value="<?php echo $_REQUEST['idx']?>">
    			<table class="table_1">
    				<tbody>
    					<tr>
        					<th>제목</th>
        					<td><input type="text" data-name="제목" id="title" name="title" class="notEmpty" value="<?php echo $row['title']?>"></td>
    					</tr>
    					<tr>
        					<th>css</th>
        					<td><textarea id="css" name="css" style="width:100%; height:300px;"><?php echo $row['css']?></textarea></td>
    					</tr>
    					<tr>
        					<th>html</th>
        					<td><textarea id="html" name="html" style="width:100%; height:300px;"><?php echo $row['html']?></textarea></td>
    					</tr>
    					<tr>
        					<th>script</th>
        					<td><textarea id="script" name="script" style="width:100%; height:300px;"><?php echo $row['script']?></textarea></td>
    					</tr>
    					<tr>
        					<th>백엔드 코드</th>
        					<td><textarea id="back" name="back" style="width:100%; height:300px;"><?php echo $row['back']?></textarea></td>
    					</tr>
    				</tbody>
    			</table>
			</form>
			<?php 
			if(getChmod('code') > 0 || $_SESSION['login_name'] == "변지윤" || $_SESSION['login_name'] == "정기영")
			{
			    ?>
			    <a href="javascript:fncSubmit('submit');" class="writ-btn">완료</a>
			    <a href="javascript:del('<?php echo $_REQUEST['idx']?>', '<?php echo $_REQUEST['board']?>');" class="writ-btn">삭제하기</a>
			    <?php 
			}
			?>
			<a href="javascript:fncSubmit('preview');" class="writ-btn">미리보기</a>
		</div>
	
	
	</div>
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>