<?php include '../../_include/top.php'; ?>
<?php include '../BaroService_CASHBILL.php'; ?>
<p>DeleteCashBill - 삭제</p>
<div class="result">

	<?php
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';			//인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';			//실서버 인증키
	$CorpNum = '8088800950';			                        //바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = 'musign';			                                    //바로빌 회원 아이디
	$MgtKey = '9-334-30';		                               //연동사부여 문서키

	$Result = $BaroService_CASHBILL->DeleteCashBill(array(
		'CERTKEY'	=> $CERTKEY,
		'CorpNum'	=> $CorpNum,
		'UserID'	=> $ID,
		'MgtKey'	=> $MgtKey
	))->DeleteCashBillResult;
	
	echo $Result;
	?>
</div>

{
	"isSuc":"success",
	"msg":"<?php echo $Result?>"
}

<?php include '../../_include/bottom.php'; ?>
