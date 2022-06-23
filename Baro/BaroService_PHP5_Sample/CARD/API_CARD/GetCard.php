<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CARD.php'; ?>
<p>GetCard - 등록한 카드번호 조회</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	$CorpNum = '';			//바로빌 회원 사업자번호 ('-' 제외, 10자리)

	$Result = $BaroService_CARD->GetCard(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum
	))->GetCardResult;
	
	if (array_key_exists('Card',$Result) && !is_array($Result->Card) && $Result->Card->CardNum < 0){ //실패
		echo $Result->Card->CardNum;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
