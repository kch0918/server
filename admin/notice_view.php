<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = "select * from notice where idx = {$_REQUEST['idx']}";
$result = sql_query($query);
$row = sql_fetch($result);

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
			<strong>Musign 공지사항 글수정</strong>
		</div>

		<div class="main_table family_table p010">
			<form id="fncForm" name="fncForm" method="POST" action="notice_modify_proc.php" onSubmit="return false;">
    			<table class="table_1">
    				<tbody>
    					<tr>
    						<th>공지타입</th>
    						<td>
        						<select id="choose_board_type" name="board_type">
        						<?php 
        				        $board_type = array('공지','일반');
        					       foreach($board_type as $k=>$v){
        					           
                                        if($row['board_type']==$k){
                                            echo "<option value='".$k."' selected>".$v."</option>";
                                        } else {
                                            echo "<option value='".$k."'>".$v."</option>";
                                        }
                                    }
                              ?>
    						</td>
    					</tr>
    					<tr>
        					<th>제목</th>
        					
        					
                             </select>
        					<td><input type="text" data-name="제목" id="no_title" name="no_title" class="notEmpty" value="<?php echo $row['title']?>">
                    		</td>
    					</tr>
    					<tr>
        					<th>내용</th>
        					<td><textarea data-name="내용" id="no_content" name="no_content" class="notEmpty"><?php echo $row['content']?></textarea></td>
    					</tr>
    				</tbody>
    			</table> 
    			<input type="hidden" id="idx" name="idx" value="<?php echo $row['idx']?>">
			</form>

			<a href="javascript:fncSubmit();" class="writ-btn">완료</a>
		</div>
	
	
	</div>
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>