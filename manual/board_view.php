<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/manual_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = "select * from {$_REQUEST['board']} where idx = '{$_REQUEST['idx']}'";
$result = sql_query($query);
$row = sql_fetch($result);
?>
<script>
var board = '<?php echo $_REQEST['board']?>';
function del(idx, board)
{
	$.ajax({
		type : "POST", 
		url : "board_delete.php",
		dataType : "text",
		data : 
		{
			idx : idx,
			board : board
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
    			location.href="board.php?board="+board;
    		}
    		else
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

<div class="table_list family_list">
	<div class="inner">

		<div class="list_tit p010">
			<strong>Musign <?php echo getTitle($_REQUEST['board'])?></strong>
		</div>

		<div class="main_table family_table p010">
			<input type="hidden" id="idx" name="idx" value="<?php echo $_REQUEST['idx']?>">
			<table class="table_1">
				<tbody>
					<tr>
    					<th>제목</th>
    					<td><?php echo $row['title']?></td>
					</tr>
					<tr>
    					<th colspan="2">내용</th>
					</tr>
					<tr>
    					<td colspan="2"><?php echo $row['content']?></td>
					</tr>
				</tbody>
			</table>
			<?php 
			if(getChmod($_REQUEST['board']) > 0 || $_SESSION['login_name'] == "변지윤" || $_SESSION['login_name'] == "정기영")
			{
			    ?>
			    	<a href="board_modify.php?idx=<?php echo $_REQUEST['idx']?>&board=<?php echo $_REQUEST['board']?>" class="writ-btn">수정하기</a>
			    	<a href="javascript:del('<?php echo $_REQUEST['idx']?>', '<?php echo $_REQUEST['board']?>');" class="writ-btn">삭제하기</a>
			    <?php 
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