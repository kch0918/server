 <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function join_mail($user_name2,$user_mail){

        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
        
//             $user_idx_query = "select * from user where user_id  = '$login_id'";
        
//             $user_idx_result = sql_query($user_idx_query);
        
            $fromEmail = "delivery@musign.net";
            $fromName = '서버관리시스템';
            $toName = "";
            $subject = "musign care 회원가입 알림";
            $toEmail = "$user_mail";
            
            $message = "{$user_name2} 담당자님의 회원가입을 알려드립니다. <br/><br>";
            
            $message .= "<a href='https://server.musign.co.kr/'>서버관리시스템 홈페이지 바로가기</a>";
            
                $mail = new PHPMailer(true);
                try {
                    $mail -> SMTPDebug = 0;                               // 디버깅 설정
                    $mail -> isSMTP();                                    // SMTP 사용 설정
                    // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
                    $mail -> Host = "smtp.worksmobile.com";               // 네이버의 smtp 서버
                    $mail -> SMTPAuth = true;                             // SMTP 인증을 사용함
                    $mail -> Username = "delivery@musign.net";           // 메일 계정 (지메일일경우 지메일 계정)
                    $mail -> Password = "casanova1!@";                    // 메일 비밀번호
                    $mail -> SMTPSecure = "ssl";                          // SSL을 사용함 
                    $mail -> Port = 465;                                  // email 보낼때 사용할 포트를 지정
                    $mail -> CharSet = "utf-8"; // 문자셋 인코딩
                    // 보내는 메일
                    $mail -> setFrom($fromEmail, $fromName);
                    // 받는 메일
                    $mail -> addAddress($toEmail, $toName);
//                     $mail -> addAddress("coscoswkd@gmail.com", "1");
//                     $mail -> addAddress("sasasap@naver.com", "2");
//                     $mail -> addAddress("kch0918@hanmail.net", "3");
//                     $mail -> addAddress("jieond@musign.net", "이지언");
//                     $mail -> addAddress(" chaplin@musign.net", "정기영");
//                     $mail -> addAddress("rininini90@musign.net", "이수련");
                    $mail -> addBcc("jino994@musign.net", "김진오");
                    $mail -> addBcc("lsm@musign.net", "이새미");
                    $mail -> addBcc("angelo@musign.net", "지한규");
                    //$mail -> addAddress("test2@teacher21.com", "receive02");
                    //$mail -> addAttachment("../pdf/musign_our_Company.pdf");
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
        
        function musign_mail($user_name2,$user_mail){
            
            require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/PHPMailer.php");
            require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/SMTP.php");
            require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPMailer-master/src/Exception.php");
            require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
            
//             $user_idx_query = "select * from user where user_id  = '{$_SESSION['login_id']}';";
            
//             $user_idx_result = sql_query($user_idx_query);
            
//             $user_idx_row = sql_fetch($user_idx_result);
            
            $fromEmail = "delivery@musign.net";
            $fromName = '서버관리시스템';
            $toName = "";
            $subject = "musign care 회원가입 알림 ";
            $toEmail = "$user_mail";
            
            $message = "{$user_name2} 담당자님의 회원가입을 알려드립니다. <br/><br>";
            
            $message .= "musign care 신청 프로세스<br/><br/>";
            
            $message .= "*서버 이전은 매주 수요일에 진행됩니다.<br/>";
            
            $message .= "해당 일자에 이전 불가할 시 별도 문의 부탁드립니다.<br/><br/>";
            
            $message .= "*신규로 뮤자인 케어 신청 시 필수 준비 사항 및 프로세스 <br/><br/>";
            
            $message .= "1. 웹 호스팅 업체 사이트의 계정 정보 (웹 호스팅 업체 / 아이디 / 패스워드)<br/><br/>";
            
            $message .= "2. FTP (SFTP) 접속 정보 (아이피 / 아이디 / 패스워드)<br/><br/>";
            
            $message .= "3. SSH 접속 정보 (아이피 / 아이디 / 패스워드)<br/><br/>";
            
            $message .= "4. DB 접속정보 (아이피 / 아이디 / 패스워드)<br/><br/>";
            
            $message .= "5. 도메인 구매 업체 계정 정보 (구매 업체 / 아이디 / 패스워드)<br/><br/>";
            
            $message .= "6. 추가로 뮤자인 측에서 접속할 수 있도록 방화벽 허용이 필요<br/><br/>";
            
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
                       $mail -> addAddress("jieond@musign.net", "이지언");
                       $mail -> addAddress(" chaplin@musign.net", "정기영");
                       $mail -> addAddress("coscoswkd@musign.net", "김채현");
                       $mail -> addAddress("rininini90@musign.net", "이수린");
                       $mail -> addAddress("nam1087@musign.net", "남성우");
                       $mail -> addAddress("jino994@musign.net", "김진오");
                       $mail -> addAddress("lsm@musign.net", "이새미");
                //$mail -> addAddress("test2@teacher21.com", "receive02");
                //$mail -> addAttachment("../pdf/musign_our_Company.pdf");
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
