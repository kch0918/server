<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>ChangeNTSSendOption - 국세청 전송설정 변경</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = '';				//바로빌 회원 아이디
	$NTSSendOption = array(
		'TaxationOption' 			=> 1,		//과세, 영세 국세청 전송설정 : 1-발행 익일 자동전송, 2-발행 즉시 전송
		'TaxationAddTaxAllowYN' 	=> 1,		//과세, 영세 가산세 허용여부 : 1-허용, 0-차단
		'TaxExemptionOption' 		=> 1,		//면세 국세청 전송설정 : 1-발행 익일 자동전송, 2-발행 즉시 전송, 3-수동 전송
		'TaxExemptionAddTaxAllowYN' => 1		//면세 가산세 허용여부 : 1-허용, 0-차단
	);

	$Result = $BaroService_TI->ChangeNTSSendOption(array(
		'CERTKEY'			=> $CERTKEY,
		'CorpNum'			=> $CorpNum,
		'ID'				=> $ID,
		'NTSSendOption'		=> $NTSSendOption
	))->ChangeNTSSendOptionResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
