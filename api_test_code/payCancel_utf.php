<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$idx = $_REQUEST['idx'];

$query = 
        "
            SELECT
                aa.*,
                bb.server_feature,
                bb.dump_col
            FROM pay_result aa, server_info bb, user cc WHERE
                aa.idx = '${idx}'
                and cc.idx = aa.user_idx
                and bb.idx = cc.server_name
         ";

$result = sql_query($query);
$row = sql_fetch($result);

?>

<!DOCTYPE html>
<html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<head>
<title>NICEPAY CANCEL REQUEST(EUC-KR)</title>
<meta charset="utf-8">
<style>
	html,body {height: 100%;}
	form {overflow: hidden;}
	
    
</style>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script type="text/javascript">

var server_type = "";
var server_feature = "";
var tid = "";
var CancelAmt = "";

function reqCancel(){
	 // ajax 통신 
    $.ajax({
        		type: "get",
        		url: "./cancelResult_utf.php",
        		dataType:"text",
        		data : 
        		{
            		idx : $('input[name=idx]').val(),
		 			server_type : $('input[name=server_type]').val(),
		 			server_feature : $('input[name=server_feature]').val(),
			 	    tid : $('input[name=tid]').val(),
				 	CancelAmt : $('input[name=CancelAmt]').val()
        		},
        		error : function() 
        		{
        			console.log("AJAX ERROR");
        		},
        		success : function(data) 
        		{
        			console.log(data);
        			var result = JSON.parse(data);
        			if(result.msg == "취소 성공")
            		{
        	    		alert(result.msg);
        	    		location.href="https://server.musign.co.kr/admin/cancle.php";
            		}
            		else
            		{
            			alert(result.msg);
            		}
        		}
        	});
		}

    	
</script>
</head>
    <body> 
        <form name="cancelForm" method="post" target="_self" action="cancelResult_utf.php">
        	<table>
        		<tr>
        			<th>신청서버</th>
        			<td><input type="text" name="server_type" value="<?php echo $row['goodsname'];?>" /></td>
        		</tr>
        		<tr>
        			<th>서버설명</th>
        			<td><input type="text" name="server_feature" value="<?php echo $row['server_feature'];?>" /></td>
        		</tr>
        		<tr>
        			<th>원거래 ID</th>
        			<td><input type="text" name="tid" value="<?php echo $row['tid'];?>" /></td>
        		</tr>
        		<tr>
        			<th>취소 금액</th>
        			<td><input type="text" name="CancelAmt" value="<?php echo $row['amt'];?>" /></td>
        		</tr>
        		<tr>
        			<th>부분취소 여부</th>
        			<td>
        				<input type="radio" name="PartialCancelCode" value="0" checked="checked"/> 전체취소
        				<input type="radio" name="PartialCancelCode" value="1"/> 부분취소
        			</td>
        		</tr>
        	</table>
        	<input type="hidden" id="idx" name="idx" value="<?php echo $row['idx']?>">
        	<a href="#" onClick="reqCancel();">요 청</a>
        	<a href="https://server.musign.co.kr/admin/cancle.php" class="btn_blue" >취  소</a>				
        </form>				
    </body>
</html>