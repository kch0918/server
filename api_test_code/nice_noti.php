<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php"); 
//'**********************************************************************************
//' 구매자가 입금하면 결제데이터 통보를 수신하여 DB 처리 하는 부분 입니다.
//' 수신되는 필드에 대한 DB 작업을 수행하십시오.
//' 수신필드 자세한 내용은 메뉴얼 참조
//'**********************************************************************************

@extract($_GET);
@extract($_POST);
@extract($_SERVER);

$PayMethod      = $PayMethod;           //지불수단
$M_ID           = $MID;                 //상점ID
$MallUserID     = $MallUserID;          //회원사 ID
$Amt            = $Amt;                 //금액
$name           = $name;                //구매자명
$GoodsName      = $GoodsName;           //상품명
$TID            = $TID;                 //거래번호
$MOID           = $MOID;                //주문번호
$AuthDate       = $AuthDate;            //입금일시 (yyMMddHHmmss)
$ResultCode     = $ResultCode;          //결과코드 ('4110' 경우 입금통보)
$ResultMsg      = $ResultMsg;           //결과메시지

$VbankNum       = $VbankNum;            //가상계좌번호
$FnCd           = $FnCd;                //가상계좌 은행코드
$VbankName      = $VbankName;           //가상계좌 은행명
$VbankInputName = $VbankInputName;      //입금자 명
$CancelDate     = $CancelDate;          //취소일시

// 가상계좌채번시 현금영수증 자동발급신청이 되었을경우 전달되며 
// RcptTID 에 값이 있는경우만 발급처리 됨
// $RcptTID        = $RcptTID;             //현금영수증 거래번호
// $RcptType       = $RcptType;            //현금 영수증 구분(0:미발행, 1:소득공제용, 2:지출증빙용)
// $RcptAuthCode   = $RcptAuthCode;        //현금영수증 승인번호

echo $PayMethod.'<br>'; 
echo $M_ID.'<br>';
echo $MallUserID.'<br>';
echo $Amt.'<br>';
echo $name.'<br>';
echo $GoodsName.'<br>';
echo $TID.'<br>';
echo $MOID.'<br>';
echo $AuthDate.'<br>';
echo $ResultCode.'<br>';
echo $ResultMsg.'<br>';
echo $VbankNum.'<br>';
echo $FnCd.'<br>';
echo $VbankName.'<br>';
echo $VbankInputName.'<br>';
echo $CancelDate.'<br>';
// echo $RcptTID.'<br>';
// echo $RcptType.'<br>';
// echo $RcptAuthCode.'<br>';

//**********************************************************************************
//이부분에 로그파일 경로를 수정해주세요.
$logfile = fopen("D:\\ㅅ\\서버 프로젝트\\결재로그\\nice_vacct_noti_result.log", "a+" );
//로그는 문제발생시 오류 추적의 중요데이터 이므로 반드시 적용해주시기 바랍니다.
//**********************************************************************************
 
fwrite( $logfile,"************************************************\r\n");
fwrite( $logfile,"PayMethod         : ".$PayMethod."\r\n");
fwrite( $logfile,"MID               : ".$MID."\r\n");
fwrite( $logfile,"MallUserID        : ".$MallUserID."\r\n");
fwrite( $logfile,"Amt               : ".$Amt."\r\n");
fwrite( $logfile,"name              : ".$name."\r\n");
fwrite( $logfile,"GoodsName         : ".$GoodsName."\r\n");
fwrite( $logfile,"TID               : ".$TID."\r\n");
fwrite( $logfile,"MOID              : ".$MOID."\r\n");
fwrite( $logfile,"AuthDate          : ".$AuthDate."\r\n");
fwrite( $logfile,"ResultCode        : ".$ResultCode."\r\n");
fwrite( $logfile,"ResultMsg         : ".$ResultMsg."\r\n");
fwrite( $logfile,"VbankNum          : ".$VbankNum."\r\n");
fwrite( $logfile,"FnCd              : ".$FnCd."\r\n");
fwrite( $logfile,"VbankName         : ".$VbankName."\r\n");
fwrite( $logfile,"VbankInputName    : ".$VbankInputName."\r\n");
// fwrite( $logfile,"RcptTID        : ".$RcptTID."\r\n");
// fwrite( $logfile,"RcptType       : ".$RcptType."\r\n");
// fwrite( $logfile,"RcptAuthCode   : ".$RcptAuthCode."\r\n");
fwrite( $logfile,"CancelDate     : ".$CancelDate."\r\n");
fwrite( $logfile,"************************************************\r\n");

fclose( $logfile );

//가맹점 DB처리
$search_query = "select * from pay_result where tid='{$TID}'";
$search_result = sql_query($search_query);

$search_user_query = "
                        SELECT 
                            aa.*,
                            bb.server_feature,
                            bb.dump_col,
                            cc.*,
                            aa.idx as pay_idx,
                            (CASE aa.paymethod
            					  WHEN 'BANK' THEN '계좌이체'
            				      WHEN 'VBANK'  THEN '가상계좌'
            					  WHEN 'CARD'  THEN '신용카드'
            					  END) AS paymethod_kor,
                            date_format(aa.submit_date, '%Y.%m.%d %H:%i') as date
                            FROM pay_result aa, server_info bb, user cc 
            				WHERE cc.idx = aa.user_idx
                            and bb.idx = cc.server_name
                            and aa.tid = '{$TID}'
                    ";

$search_user_query_result = sql_query($search_user_query);
$search_user_query_row = sql_fetch($search_user_query_result);

if (sql_count($search_result)!=0) {
    
    if ($ResultCode==2001 || $ResultCode==2211) {  
        // 결제취소시 로직
        $query = "update pay_result
                        set
                        paymethod='{$PayMethod}',
                        mid='{$MID}',
                        malluerid='{$MallUserID}',
                        amt='{$Amt}',
                        name='{$name}',
                        goodsname='{$GoodsName}',
                        moid='{$MOID}',
                        authdate='{$AuthDate}',
                        resultmsg='{$ResultMsg}',
                        vbanknum='{$VbankNum}',
                        fncd='{$FnCd}',
                        vbankname='{$VbankName}',
                        vbankinputname='{$VbankInputName}',
                        rcpttid='{$RcptTID}',
                        rcpttype='{$RcptType}',
                        rcptauthcode='{$RcptAuthCode}',
                        cancle_yn ='Y',
                        use_yn='N',
                        cancle_cd='{$ResultCode}',
                        canceldate='{$CancelDate}',
                        chk_date = now()+0
                    where tid = '{$TID}'
                   ";
        
        $user_query ="update user set pay_yn='N' where tid = '{$TID}' ";
        $user_result = sql_query($user_query);
        
        
    }else if($ResultCode==3001 || $ResultCode==4000 || $ResultCode==4100 || $ResultCode==4110){
        echo "<script>alert('ssslffftetst');</script>";
           
        $query = "update pay_result
                        set
                        paymethod='{$PayMethod}',
                        mid='{$MID}',
                        malluerid='{$MallUserID}',
                        amt='{$Amt}',
                        name='{$name}',
                        goodsname='{$GoodsName}',
                        moid='{$MOID}',
                        authdate='{$AuthDate}',
                        resultcode='{$ResultCode}',
                        resultmsg='{$ResultMsg}',
                        vbanknum='{$VbankNum}',
                        fncd='{$FnCd}',
                        vbankname='{$VbankName}',
                        vbankinputname='{$VbankInputName}',
                        rcpttid='{$RcptTID}',
                        rcpttype='{$RcptType}',
                        rcptauthcode='{$RcptAuthCode}',
                        canceldate='{$CancelDate}',
                        chk_date = now()+0
                    where tid = '{$TID}'
                   ";
        
        // 처음 가입해서 결제
        if ($search_user_query_row['pay_yn'] == 'N')
        {
            $user_query =      
                          "
                            update user
                                set
                                date_start ='20220101',
                                date_end   ='20221231',  
                                pay_yn='Y',
                                musign_yn = 'Y'
                            where tid = '{$TID}'
                          ";
        // 연장신청           
        } else {
            $search_query_row = sql_fetch($search_result);
            $user_query ="
                           update user 
                                set 
                                pay_yn='Y',
                                date_start = DATE_FORMAT(NOW() + 0,'%Y%m%d'),
                                date_end   = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL '{$search_query_row['chk_year']}'YEAR), '%Y%m%d')
                            where tid = '{$TID}'
                          ";
        }
            $user_result = sql_query($user_query);
    }
    
    $result = sql_query($query);
    
    if ($result = true)
    {
        echo "OK";                        // 절대로 지우지마세요
    }
    else
    {
        echo "FAIL";                        // 절대로 지우지마세요
    }
}else{
        echo "FAIL";
}

//**************************************************************************************************
//**************************************************************************************************
//결제 데이터 통보 설정 > “OK” 체크박스에 체크한 경우" 만 처리 하시기 바랍니다.
//**************************************************************************************************
//TCP인 경우 OK 문자열 뒤에 라인피드 추가
//위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 NICEPAY로
//리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
//(주의) OK를 리턴하지 않으시면 NICEPAY 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
//기타 다른 형태의 PRINT(out.print)는 하지 않으시기 바랍니다
/*
if ($result = true)
{
            echo "OK";                        // 절대로 지우지마세요
}
else 
{
            echo "FAIL";                        // 절대로 지우지마세요
}
*/
//*************************************************************************************************	
//*************************************************************************************************

?>
