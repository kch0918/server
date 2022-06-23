<?php include '../BaroService_CORPSTATE.php'; ?>
	<?php
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';			//인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';			//실서버 인증키
	$CorpNum = '8088800950';			                        //바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$CheckCorpNum = $_POST['identity'];		                    //확인할 사업자번호

	$Result = $BaroService_CORPSTATE->GetCorpState(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'CheckCorpNum'	=> $CheckCorpNum
	))->GetCorpStateResult;

	if ($Result->State < 0){ //실패
// 		echo $Result->State;
	?>
		 {
        	"isSuc":"fail",
        	"msg":"사업자번호를 확인해주세요."
		}
		
	<?php
	
	}
	else
	{ //성공
	    ?>
 		{
	        "isSuc":"success",
	        "msg":"사업자번호가 확인되었습니다.."
	    }
	    <?php 
// 		echo '<pre>';
// 		print_r($Result);
// 		echo '</pre>';
	}
	?>
