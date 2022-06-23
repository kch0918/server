<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function call_move_mail($user_name,$user_email){

        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
        
        
           $user_idx_query = "select * from user where user_id  = '{$_SESSION['login_id']}';";
        
            $user_idx_result = sql_query($user_idx_query);
            $user_idx_row = sql_fetch($user_idx_result);
            
            $user_name = $user_idx_row['user_name'];
            $user_email = $user_idx_row['user_email'];
            $hope_date     = $user_idx_row['hope_date'];
            $hope_date2     = $user_idx_row['hope_date2'];
            
            $fromEmail = "coscoswkd@musign.net";
            $fromName = '서버관리시스템';
            $toName = "{$user_name}";
            $subject = "musign care 서비스 해지/이전 알림";
            $toEmail = "{$user_email}";
            
            $message  = "안녕하세요 디지털 에이전시 뮤자인입니다.<br/><br/> 뮤자인 케어 서비스 해지 및 서버 이전 관련 안내드립니다. <br/><br/>";
            
            $message .= "희망 서버 이전  날짜는  {$hope_date}일 혹은 {$hope_date2}일 입니다. <br/><br/>";
            
            $message .= "{$hope_date}일 혹은 {$hope_date2}일 두 희망 날짜 중에 이전 가능한 날짜를 회신드리도록 하겠습니다.<br/><br/><br/>";
            
            $message .= "[고객사 필수 진행 사항 ]<br/>";
            
            $message .= "서버 이전을 하기 전에 고객사 측에서 최대한 빠른 시일 내에 타 호스팅 업체 회원 가입과 함께 원하시는 서버 구매를<br/>";
            
            $message .= "진행해 주시면 됩니다. (타 호스팅 업체에 서버 구매하실 때 OS만 설치 옵션으로 선택 부탁드립니다) <br/><br/><br/>";
            
            $message .= "전체 항목의 답변 작성 부탁드립니다.<br/><br/>";
            
            $message .= "*계정 정보 <br/><br/>";
            
            $message .= "*1. 웹 호스팅 구매 업체 계정 정보 (구매 업체 / 아이디 / 패스워드) : <br/><br/>";
            
            $message .= "*2. FTP 비밀번호 / DB 비밀번호 (구매 시 설정) : <br/><br/>";
            
            $message .= "*3. 도메인 구입 업체 계정 정보 (구입 업체 / 아이디 / 패스워드) : <br/><br/><br/>";
            
            $message .= "타 호스팅 업체에 서버 구매 후 *계정 정보를 메일로 회신 부탁드립니다. <br/><br/>";
            
            $message .= "위에 *계정 정보를 빠른 시일 내에 전달해 주셔야 서버 이전이 원활하게 진행됨을 양해 부탁드립니다. <br/><br/>";
            
            $message .= "추가 문의 사항은 회신 부탁드리겠습니다.<br/><br/>";
            
            $message .= "감사합니다.<br/><br/>";
            
            $message .= "<a href='https://server.musign.co.kr/'>서버관리시스템 홈페이지 바로가기</a>";
            
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
             /*        $mail -> addAddress("jieond@musign.net", "이지언");
                    $mail -> addAddress(" chaplin@musign.net", "정기영");
                    $mail -> addAddress("rininini90@musign.net", "이수련"); */
                    $mail -> addBcc("jino994@musign.net", "김진오");
                    $mail -> addBcc("lsm@musign.net", "이새미");
                    $mail -> addBcc("angelo@musign.net", "지한규");
                    // $mail -> addAttachment("../pdf/musign_our_Company.pdf");
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
                            "msg": <?php echo $mail -> ErrorInfo; ?>
                        }
                    <?php 
                }
                
        }           
?>
