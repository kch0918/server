<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/manual_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = "select * from {$_REQUEST['board']} where idx = '{$_REQUEST['idx']}'";
$result = sql_query($query);
$row = sql_fetch($result);
?>
<script>
var board = "<?php echo $_REQUEST['board']?>";
var idx = '<?php echo $_REQUEST['idx']?>';
window.onbeforeunload = function(e) {return "벗어나시겠습니까?";} 
$(document).ready(function(){
	CKEDITOR.replace('contents');
})
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
		CKEDITOR.instances.contents.updateElement();
		$("#fncForm").ajaxSubmit({
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			window.onbeforeunload = function(e) {} 
	    			location.href="board_view.php?idx="+idx+"&board="+board;
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
			<strong>Musign <?php echo getTitle($_REQUEST['board'])?></strong>
		</div>

		<div class="main_table family_table p010">
			<form id="fncForm" name="fncForm" method="POST" action="board_modify_proc.php" onSubmit="return false;">
				<input type="hidden" id="idx" name="idx" value="<?php echo $_REQUEST['idx']?>">
				<input type="hidden" id="board" name="board" value="<?php echo $_REQUEST['board']?>">
    			<table class="table_1">
    				<tbody>
    					<tr>
        					<th>제목</th>
        					<td><input type="text" data-name="제목" id="title" name="title" class="notEmpty" value="<?php echo $row['title']?>"></td>
    					</tr>
    					<tr>
        					<th>내용</th>
        					<td><textarea data-name="내용" id="contents" name="contents"><?php echo $row['content']?></textarea></td>
    					</tr>
    				</tbody>
    			</table>
			</form>
			<?php 
			if(getChmod($_REQUEST['board']) > 0 || $_SESSION['login_name'] == "변지윤" || $_SESSION['login_name'] == "정기영")
			{
			    ?><a href="javascript:fncSubmit();" class="writ-btn">완료</a><?php 
			}
			?>
		</div>
	
	
	</div>
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>