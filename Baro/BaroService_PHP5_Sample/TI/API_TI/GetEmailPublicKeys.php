<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_TI.php'; ?>
<p>GetEmailPublicKeys - ASP업체 Email 목록확인</p>
<div class="result">
	<?php
	$CERTKEY = '';			//인증키
	
	$Result = $BaroService_TI->GetEmailPublicKeys(array(
		'CERTKEY'	=> $CERTKEY				
	))->GetEmailPublicKeysResult->EMAILPUBLICKEY;

	if (!is_array($Result) && $Result->PK < 0){ //실패
		echo $Result->PK;
	}else{ //성공
		echo '<pre>';
		print_r($Result);
		echo '</pre>';
	}
	?>
</div>
<?php include '../../_include/bottom.php'; ?>
