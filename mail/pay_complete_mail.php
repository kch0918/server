 <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");

pay_complete_mail();

function pay_complete_mail(){

        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
      
        
            $user_idx_query = "select * from user where user_id  = '{$_SESSION['login_id']}'";
            $user_idx_result = sql_query($user_idx_query);
        
            $user_idx_row = sql_fetch($user_idx_result);
            $user_email = $user_idx_row['user_email'];
            $user_name = $user_idx_row['user_name'];
            $user_co = $user_idx_row['user_co'];
            
            $fromEmail = "delivery@musign.net";
            $fromName = '서버관리시스템';
            $toName = "";
            $subject = "musign care 결제 알림";
            $toEmail = "coscoswkd@musign.net";
            
            $message = "{$user_co} 고객사의  {$user_name} 담당자님  뮤자인케어 결제가 완료되었음을 알려드립니다. <br/><br>";
            
            $message .= "<a href='https://server.musign.co.kr/member/login.php'>서버관리시스템 홈페이지 바로가기</a>";
            
                $mail = new PHPMailer(true);
                try {
                    $mail -> SMTPDebug = 0;                               // 디버깅 설정
                    $mail -> isSMTP();                                    // SMTP 사용 설정
                    // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
                    $mail -> Host = "smtp.worksmobile.com";               // 네이버의 smtp 서버
                    $mail -> SMTPAuth = true;                             // SMTP 인증을 사용함
                    $mail -> Username = "delivery@musign.net";           // 메일 계정 (지메일일경우 지메일 계정)
                    $mail -> Password = "ehdehddlqkqh1";                    // 메일 비밀번호
                    $mail -> SMTPSecure = "ssl";                          // SSL을 사용함 
                    $mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정
                    $mail -> CharSet = "utf-8"; // 문자셋 인코딩
                    // 보내는 메일
                    $mail -> setFrom($fromEmail, $fromName);
                    // 받는 메일
                    $mail -> addAddress($toEmail, $toName);
                    /* $mail -> addAddress("chaplin@musign.net", "정기영");
                    $mail -> addAddress("rininini90@musign.net", "이수련"); */
                    $mail -> addAddress("jino994@musign.net", "김진오");
                    $mail -> addAddress("coscoswkd@musign.net", "김채현"); 
                    $mail -> addAddress("lsm@musign.net", "이새미"); 
                    $mail -> addAddress("angelo@musign.net", "지한규");
                    // 첨부파일
                    //     $mail -> addAttachment("./test1.zip");
                    //     $mail -> addAttachment("./test2.jpg");
                    // 메일 내용
                    $mail -> isHTML(true); // HTML 태그 사용 여부
                    $mail -> Subject = $subject;  // 메일 제목
                    if($message == "")
                    {
                        $message = "  ";
                    }
                    $mail -> Body = $message;     // 메일 내용
                    // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
                    // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
                    $mail -> SMTPOptions = array(
                        //         "tls" => array(
                        //             "verify_peer" => false
                        //             , "verify_peer_name" => false
                        //             , "allow_self_signed" => true
                        //         )
                    );
                    // 메일 전송
                    $mail -> send();
                } catch (Exception $e) {          
                    ?>
                        {
                            "isSuc":"fail",
                            "msg": "<?php echo $mail -> ErrorInfo;?>"
                        }
                    <?php 
                }
        }           
?>
