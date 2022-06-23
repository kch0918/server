<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = "select * from server_info ";
$result = sql_query($query);

?>
<script>
function fncSubmit()
{
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
	
	var server_f_arr="";
	$('.server_feature').each(function(){ 
		server_f_arr = server_f_arr+$(this).val()+'@';
	})
	$("#server_feature_arr").val(server_f_arr);

	

		$("#fncForm").ajaxSubmit({
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert(result.msg);
	    			location.reload();
	    		}
			}
		});
	
}

function choose_server(idx){
	var server_name = idx;
	$.ajax({
		type : "POST", 
		url : "/admin/price_management_ajax.php",
		dataType : "text",
		data : 
		{
			server_name : server_name
		},
		error : function() 
		{
			console.log("AJAX ERROR");
		},
		success : function(data) 
		{
			console.log(data);
			$("#server_info").empty();
			
			var result = JSON.parse(data);
			var inner ="";
				inner ="";
				inner +='<div>';
				inner +='서버 타입 : <input type="text" class="notEmpty" id="server_type" name="server_type" value="'+result[0].server_type+'">';
				inner +='</div>';
				inner +='<div>';
				inner +='서버 비용 : <input type="text" class="notEmpty" id="server_price" name="server_price" value="'+comma(result[0].server_price)+'">';
				inner +='</div>';
				if (result[0].server_feature!=null) {
					var feature_arr = result[0].server_feature.split('@');
					for (var i = 0; i < feature_arr.length-1; i++) {
						inner +='<div>';
						inner +='서버 특징'+(i+1)+' : <input type="text" class="server_feature notEmpty" id="server_feature_'+(i+1)+'" name="server_feature_'+i+1+'" value="'+feature_arr[i]+'">';
						inner +='</div>';
					}
				}else{
					inner +='<div>';
					
					inner +='</div>';
				}
				$("#server_info").append(inner);
				$("#server_idx").val(result[0].idx);
		}
	});
}

window.onload  = function() {
	var server_name="";
	$('.server_name').each(function(){ 
		server_name = $(this).val();
		return false;
	})
    choose_server(server_name);
}

$(window).ready(function(){
	var btn = $("#price_management .cell1 input");
	btn.eq(0).addClass("on");
	btn.click(function(){
		btn.removeClass("on");
		$(this).addClass("on");
	});
});

</script>

<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>

<div id="price_management" class="login-box join-view price_manage">

	<form id="fncForm" action="./price_management_proc.php" method="POST">
		<h2 class="text-center">가격 관리</h2>
		<div class="cellbox">
			<div class="cell cell1">	
				<?php 
				for ($i = 0; $i < sql_count($result); $i++) {
					$row = sql_fetch($result);   
				?>
					<input class="server_name" type="button" value="<?php echo $row['server_type']?>" onclick="choose_server('<?php echo $row['server_type']?>');">
				<?php     
				}
				?>
				<input type="hidden" id="server_idx" name="server_idx" value="">
				<input type="hidden" id="server_feature_arr" name="server_feature_arr">
			</div>
			<!-- // cell1 -->
			<div id="server_info" class="cell cell2">
			
			</div>
			<!-- // cell2 -->
		</div>
		<div class="modify_btn price_btn">
			<a class="del-btn" href="http://server.musign.co.kr/admin/price_management.php">취소</a>
			<a class="login-btn" href="javascript:fncSubmit();">수정</a>
		</div>
		<!-- // modify_btn -->
	</form>

</div>



<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>