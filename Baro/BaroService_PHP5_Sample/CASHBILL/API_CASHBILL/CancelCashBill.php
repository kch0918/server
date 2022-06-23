<?php include '../BaroService_CASHBILL.php'; ?>

	<?php
// 	$CERTKEY = '69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB';			//테스트 인증키
	$CERTKEY = 'EA97736A-C01E-4C9C-A042-7D63FBE1AF97';			//실서버 인증키
	$CorpNum = '8088800950';			                        //바로빌 회원 사업자번호 ('-' 제외, 10자리)
	$ID = 'musign';				                                //바로빌 회원 아이디
	$MgtKey = $_POST['mgt_num'];			                    //연동사부여 문서키
	$CancelType = '1';		                                    //취소사유 : 1-거래취소, 2-오류발행, 3-기타
	$SMSSendYN = False;		                                    //취소 알림문자 전송여부 (발행비용과 별도로 과금됨)
	$MailTitle = '';		                                    //취소 알림메일의 제목 (공백이나 Null의 경우 바로빌 기본값으로 전송됨.)

	$UserIdx = $_POST['user_idx'];
	
	$Result = $BaroService_CASHBILL->CancelCashBill(array(
		'CERTKEY'		=> $CERTKEY,
		'CorpNum'		=> $CorpNum,
		'UserID'		=> $ID,
		'MgtKey'		=> $MgtKey,
		'CancelType'	=> $CancelType,
		'SMSSendYN'		=> $SMSSendYN,
		'MailTitle'		=> $MailTitle,
	))->CancelCashBillResult;
	
	$CancelNTSConfirmDate = date("Y/m/d");
	
	// 성공시, 
	if ($Result == '1')
	{
	    require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
	    
	    $query =
	                "
                        update cash_recipt
                            set
                            cancel_type               =     '{$CancelType}'
                            where mgt_num             =     '{$MgtKey}'
                     ";
	    
	    sql_query($query);
	    ?>
	    {
        	"isSuc":"success",
        	"msg":"저장되었습니다."
        }
	   <?php  
	}
	else
    {	
        echo $Result; 
	    ?> 
	    {
        	"isSuc":"fail",
        	"msg":"관리자에게 문의해주세요."
		}
	    <?php 
	}
	?>
	