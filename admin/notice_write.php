<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

?>
<script>
function fncSubmit()
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
		$("#fncForm").ajaxSubmit({
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			location.href="notice.php";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}
			}
		});
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
			<strong>Musign 공지사항 글쓰기</strong>
		</div>

		<div class="main_table family_table p010">
			<form id="fncForm" name="fncForm" method="POST" action="notice_write_proc.php" onSubmit="return false;">
    			<table class="table_1">
    				<tbody>
    					<tr>
    						<th>공지타입</th>
    						<td>
        						<select id="choose_board_type" name="board_type">
                        			<option value="일반">일반</option>
                        			<option value="공지">공지</option>
                    			</select>
    						</td>
    					</tr>
    					<tr>
        					<th>제목</th>
        					<td><input type="text" data-name="제목" id="no_title" name="no_title" class="notEmpty"></td>
    					</tr>
    					<tr>
        					<th>내용</th>
        					<td><textarea data-name="내용" id="no_content" name="no_content" class="notEmpty"></textarea></td>
    					</tr>
    				</tbody>
    			</table>
			</form>

			<a href="javascript:fncSubmit();" class="writ-btn">등록</a>
		</div>
	
	
	</div>
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>