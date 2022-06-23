<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/manual_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

?>
<script>
window.onbeforeunload = function(e) {return "벗어나시겠습니까?";} 
$(document).ready(function(){
})
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
    		$("#fncForm").attr("action", "code_write_proc.php");
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
    			<table class="table_1">
    				<tbody>
    					<tr>
        					<th>제목</th>
        					<td><input type="text" data-name="제목" id="title" name="title" class="notEmpty"></td>
    					</tr>
    					<tr>
        					<th>css</th>
        					<td><textarea id="css" name="css" style="width:100%; height:300px;"></textarea></td>
    					</tr>
    					<tr>
        					<th>html</th>
        					<td><textarea id="html" name="html" style="width:100%; height:300px;"></textarea></td>
    					</tr>
    					<tr>
        					<th>script</th>
        					<td><textarea id="script" name="script" style="width:100%; height:300px;"></textarea></td>
    					</tr>
    					<tr>
        					<th>백엔드 코드</th>
        					<td><textarea id="back" name="back" style="width:100%; height:300px;"></textarea></td>
    					</tr>
    				</tbody>
    			</table>
			</form>
			<?php 
			if(getChmod('code') > 0 || $_SESSION['login_name'] == "변지윤" || $_SESSION['login_name'] == "정기영" || $_SESSION['login_name'] == "임보라")
			{
			    ?><a href="javascript:fncSubmit('submit');" class="writ-btn">완료</a><?php 
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