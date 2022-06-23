<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_EDOC.php'; ?>
<p>CheckChargeable - 요금 단가 확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$CType = 1;				//1:문서발행 2:발행+SMS전송 5:SMS전송 6:FAX전송 7:LMS전송 8:MMS전송
	$DocType = 3;			//CType이 1,2 인 경우 = 1:세금계산서 2:계산서 3:거래명세서 4:입금표 5:청구서 6:견적서 7:영수증 8:발주서 9:현금영수증
							//CType이 5,6,7,8 인 경우 = 1

	$Result = $BaroService_EDOC->CheckChargeable(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'CType'			=> $CType,
		'DocType'		=> $DocType
	))->CheckChargeableResult;

	echo $Result;
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
