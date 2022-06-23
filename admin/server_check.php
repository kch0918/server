<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/login_check.php");

$idx = $_REQUEST['idx'];

$query = "select * from server_checklist where idx = '$idx'";
$result = sql_query($query);
$row = sql_fetch($result);


$sv_query = "select idx,server_type from server_info";
$sv_result = sql_query($sv_query);

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
<script>

var dp = jQuery.noConflict();

var server_name = "<?php echo $row['server_name']?>";
var phone_regExp = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})[0-9]{3,4}[0-9]{4}$/;
var email_regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
var id_regExp = /^[a-zA-Z0-9]{4,20}$/;
$(function(){
	$(".agree-popup-1").hide();
	$(".agree-bg").click(function(){
		$(".agree-popup-1").hide();
		$(".agree-div").html("");
	});
	dp.datepicker.setDefaults({
		showButtonPanel: true,
		currentText: "오늘 날짜",
		closeText: "닫기",
		nextText: "다음 달",
		prevText: "이전 달",
		changeYear: true,
		changeMonth: true,
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        dateFormat: "yymmdd"
	});
	dp(".datepicker").datepicker();
})

function fncSubmit()
{
	//이름 유효성
	var user_name = $('#user_name').val();
	if ( isEmpty(user_name)) {
		alert("이름를 입력해주세요.");
		$("#user_name").val('');
		$("#user_name").focus();
		return;
	}
	
	//ip 유효성
	var ip = $('#ip').val();
	if ( isEmpty(ip)) {
		alert("IP를 입력해주세요.");
		$("#ip").val('');
		$("#ip").focus();
		return;
	}
 
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
	    			alert(result.msg);
	    			location.href = "http://server.musign.co.kr/admin/server_checklist.php";
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
<div class="login-box join-view">
	<form id="fncForm" action="server_check_proc.php">
	<input type="hidden" name="idx" value="<?php echo $row['idx']?>">
	<h2 class="text-center modify_h2">server edit</h2>
	<div class="login-wr modify">

<div class="agree-popup">
	<div class="agree-bg"></div>
	<div class="agree-cont">
		<div class="close-btn">
			<img src="/img/close-btn.png" alt="닫기"/>
		</div>
		<div class="agree-div">

		</div>
	</div>
</div>
    		<div class="join-box">
    			<p class="join-intit">서버 점검 항목 입력</p>
    			<select id="server_name" name="server_name">
    					<option value="">---선택하세요---</option>
    					<?php 
    					for($i = 0; $i < sql_count($sv_result); $i++){
    					    $sv_row = sql_fetch($sv_result);
    					?>
    					<option value="<?php echo $sv_row['server_type']?>"><?php echo $sv_row['server_type']?></option>
    					<?php    
    					}
    					?>
    				</select>
				<br/><p class="join-intit">서버 점검자</p>
    			<div class="join-input">
    				<input type="text" class="" id="user_name" name="user_name" placeholder="점검자" value="<?php echo $row['user_name']?>"/>
    			</div><br/>
				<p class="join-intit">서버 IP</p>
    			<div class="join-input">
    				<input type="text" class="" id="ip" name="ip" placeholder="IP 주소" value="<?php echo $row['ip']?>"/>
    			</div><br/>
				<p class="join-intit">용량 이상 유무</p>
    			<div class="join-input">
    				<label><input type="radio" class="" id="" name="volume_chk" value="O"/>O</label>
    				<label><input type="radio" class="" id="" name="volume_chk" value="X"/>X</label>
    			</div><br/>
				<p class="join-intit">비고 </p>
    			<div class="join-input">
    				<input type="text" class="" id="volume_cmt" name="volume_cmt" placeholder="비고" value="<?php echo $row['volume_cmt']?>"/>
    			</div><br/>
				<p class="join-intit">점유율 이상 유무</p>
    			<div class="join-input">
    				<label><input type="radio" class="" id="" name="share_chk" value="O"/>O</label>
    				<label><input type="radio" class="" id="" name="share_chk" value="X"/>X</label>
    			</div><br/>
    			<p class="join-intit">비고 </p>
    			<div class="join-input">
    				<input type="text" class="" id="volume_cmt" name="share_cmt" placeholder="비고" value="<?php echo $row['share_cmt']?>"/>
    			</div><br/>
    			<p class="join-intit">점유율 이상 유무</p>
    			<div class="join-input">
    				<label><input type="radio" class="" id="" name="log_chk" value="O"/>O</label>
    				<label><input type="radio" class="" id="" name="log_chk" value="X"/>X</label>
    			</div><br/>
				<p class="join-intit">비고 </p>
    			<div class="join-input">
    				<input type="text" class="" id="log_cmt" name="log_cmt" placeholder="비고" value="<?php echo $row['log_cmt']?>"/>
    			</div><br/>
				<p class="join-intit">서버 점검일</p>
    			<div class="join-input">
    				<input type="text" class="datepicker" id="submit_date" name="submit_date" placeholder="서버 점검일" value="<?php echo $row['submit_date']?>"/>
    			</div>
    		</div>
	
	<div class="modify_btn price_btn">
			<a class="del-btn" href="server_checklist.php">취소</a>
			<a class="login-btn" href="javascript:fncSubmit();">확인</a>
		</div>
	</div>
	</form>
</div>

<div class="agree-popup-1 joine-popup">
	<div class="tb-">
    	<div class="inner">
        	<div class="agree-bg"></div>
        	<div class="agree-cont">
        		<div class="joine-div">
        			<img src="/img/join-icon01.png" alt="회원수정 완료 아이콘"/>
        			<p class="color-g joine-tit">수정 되었습니다.</p>
        			<div><a href="/" class="login-btn">메인페이지 이동</a></div>
        		</div>
        	</div>
    	</div>
	</div>
</div>

<script>/*	dudwo추가	*/
document.addEventListener('DOMContentLoaded', function(){
	var server_name = '<?php echo $row['server_name']?>',
		volume_chk = '<?php echo $row['volume_chk']?>',
		share_chk = '<?php echo $row['share_chk']?>',
		log_chk = '<?php echo $row['log_chk']?>';
	var cont = document.querySelector("#fncForm");
	cont.querySelector("select[name=server_name]").value = server_name;
	cont.querySelector("input[name=volume_chk][value="+nChk(volume_chk)+"]").checked = true;
	cont.querySelector("input[name=share_chk][value="+nChk(share_chk)+"]").checked = true;
	cont.querySelector("input[name=log_chk][value='"+nChk(log_chk)+"']").checked = true;

	function nChk(str){
		return (str == "") ? "X" : str;
	}
});
</script>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>