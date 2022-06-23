<?php include '../BaroService_TI.php'; ?>
	<?php
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';			//인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';			//실서버 인증키
	$CorpNum = '8088800950';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$MgtKey  = $_POST['mgt_num'];			//연동사부여 문서키
	$ToEmailAddress = $_POST['user_email'];	//수신자 메일 주소

	$Result = $BaroService_TI->ReSendEmail(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'MgtKey'		=> $MgtKey,
		'ToEmailAddress'=> $ToEmailAddress
	))->ReSendEmailResult;
	
	// 성공시,
	if ($Result == '1')
	{
	    ?>
	    {
        	"isSuc":"success",
        	"msg":"메세지가 재발송 되었습니다."
        }
	   <?php  
	}
	else
    {	
	    ?> 
	    {
        	"isSuc":"fail",
        	"msg":"관리자에게 문의해주세요."
		}
	    <?php 
	}
	?>
