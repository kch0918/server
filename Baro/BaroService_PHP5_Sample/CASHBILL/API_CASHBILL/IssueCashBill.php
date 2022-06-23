<?php include '../BaroService_CASHBILL.php'; ?>
	
	<?php
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';			               //인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';		                   //실서버 인증키
	$CorpNum = '8088800950';			                                       //바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = 'musign';			                                 	               //바로빌 회원 아이디
	$MgtKey = '';                                                              //연동사부여 문서키
	$SMSSendYN = false;		                                                   //발행 알림문자 전송여부 (발행비용과 별도로 과금됨)
	$MailTitle = '현금영수증';		                                               //발행 알림메일의 제목 (공백이나 Null의 경우 바로빌 기본값으로 전송됨.)
	
	$Result = $BaroService_CASHBILL->IssueCashBill(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'UserID'		=> $ID,
		'MgtKey'		=> $MgtKey,
		'SMSSendYN'		=> $SMSSendYN,
		'MailTitle'		=> $MailTitle
	))->IssueCashBillResult;

	echo $Result;
	?>