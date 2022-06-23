<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
$user_query = "select * from user where user_id = '{$_SESSION['login_id']}'";
$user_result = sql_query($user_query);
$user_row = sql_fetch($user_result);


$server_info_query="select * from server_info where server_type = '{$user_row['server_name']}'";
$server_info_result =sql_query($server_info_query);
$server_info_row = sql_fetch($server_info_result);



/*
 *******************************************************
 * <결제요청 파라미터>
 * 결제시 Form 에 보내는 결제요청 파라미터입니다.
 * 샘플페이지에서는 기본(필수) 파라미터만 예시되어 있으며,
 * 추가 가능한 옵션 파라미터는 연동메뉴얼을 참고하세요.
 *******************************************************
 */
$merchantKey = "a9Mw0kcxO9/p6vqXJZg227dIbFIuLMD7AI/WlnBK8kPlG022KuOBdlnfCer8Ihh1+OPeB3KACSDpwYIifNY5sg==";
// $merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
$MID         = "{$user_row['user_id']}"; // 상점아이디
$goodsName   = "{$user_row['server_name']}"; // 결제상품명
$price       = "{$server_info_row['server_price']}"; // 결제상품금액
$buyerName   = "{$user_row['user_name']}"; // 구매자명
$buyerTel	 = "{$user_row['user_phone']}"; // 구매자연락처
$buyerEmail  = "{$user_row['user_email']}"; // 구매자메일주소
$moid        = "{$server_info_row['idx']}"; // 상품주문번호
$returnURL	 = $_SERVER['DOCUMENT_ROOT']."/api_test_code/payResult.php"; // 결과페이지(절대경로) - 모바일 결제창 전용

/*
 *******************************************************
 * <해쉬암호화> (수정하지 마세요)
 * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
 *******************************************************
 */
$ediDate = date("YmdHis");
$hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));



?>
<script src="https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js" type="text/javascript"></script>
<script type="text/javascript">
//결제창 최초 요청시 실행됩니다.
function nicepayStart(){
	if(checkPlatform(window.navigator.userAgent) == "mobile"){//모바일 결제창 진입
		document.payForm.action = "https://web.nicepay.co.kr/v3/v3Payment.jsp";
		document.payForm.submit();
	}else{//PC 결제창 진입
		goPay(document.payForm);
	}
}

//[PC 결제창 전용]결제 최종 요청시 실행됩니다. <<'nicepaySubmit()' 이름 수정 불가능>>
function nicepaySubmit(){
	document.payForm.submit();
}

//[PC 결제창 전용]결제창 종료 함수 <<'nicepayClose()' 이름 수정 불가능>>
function nicepayClose(){
	alert("결제가 취소 되었습니다");
}

//pc, mobile 구분(가이드를 위한 샘플 함수입니다.)
function checkPlatform(ua) {
	if(ua === undefined) {
		ua = window.navigator.userAgent;
	}
	
	ua = ua.toLowerCase();
	var platform = {};
	var matched = {};
	var userPlatform = "pc";
	var platform_match = /(ipad)/.exec(ua) || /(ipod)/.exec(ua) 
		|| /(windows phone)/.exec(ua) || /(iphone)/.exec(ua) 
		|| /(kindle)/.exec(ua) || /(silk)/.exec(ua) || /(android)/.exec(ua) 
		|| /(win)/.exec(ua) || /(mac)/.exec(ua) || /(linux)/.exec(ua)
		|| /(cros)/.exec(ua) || /(playbook)/.exec(ua)
		|| /(bb)/.exec(ua) || /(blackberry)/.exec(ua)
		|| [];
	
	matched.platform = platform_match[0] || "";
	
	if(matched.platform) {
		platform[matched.platform] = true;
	}
	
	if(platform.android || platform.bb || platform.blackberry
			|| platform.ipad || platform.iphone 
			|| platform.ipod || platform.kindle 
			|| platform.playbook || platform.silk
			|| platform["windows phone"]) {
		userPlatform = "mobile";
	}
	
	if(platform.cros || platform.mac || platform.linux || platform.win) {
		userPlatform = "pc";
	}
	
	return userPlatform;
}
</script>



<script>
$(function(){
	$(window).ready(function(){
		$(".myp-payment .myp-rchk").click(function(){
			$(".myp-payment .myp-rchk").removeClass("on");
			$(this).addClass("on");
		});
	});
})

function do_pay(){
	if ( !$("#finalCheck").prop('checked')){
		alert('결제진행 동의를 해주세요.');
	}else{ //동의시		
		$.ajax({
			type : "POST", 
			url : "/mypage/do_pay_proc.php",
			dataType : "text",
			data : 
			{
				pay_check : 'Y'
			},
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				console.log(data);
				location.reload();
			}
		});
	}	
}
function price_choose(idx){
	var price = $(idx).next().find('span').text();
	price = price.slice(0,-1);
	$('.pay').text(price);
}




</script>
<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>
<div class="mypage-top">
	<div class="myp-grid">
		<h2 class="text-center">Mypage</h2>
		<div class="mytop-wr">
			<p class="color-g mytop-tit"><span>Welcome!</span></p>
			<div class="table mytop-ta">
				<div>
					<p class="mytop-name">
						<strong><?php echo $user_row['user_co']?></strong>의 <br><strong><?php echo $user_row['user_name']?></strong>담당자님, 반갑습니다.
					</p>
					<div class="myn-bot">
						<h5 class="myn-btit">서버 담당자</h5>
						<p class="ser-name">정기영 책임</p>
						<p class="ser-te">Tel. <span class="ser-tel">070-8645-0123</span></p>
						<p class="ser-te">E-mail. <span class="ser-tel">chaplin@musign.net</span></p>
					</div>
				</div>
				<div class="myr-divwr">
					<div class="myr-div">
						<div>
							<h5>고객 정보 <a href="../member/modify_view.php?idx=<?php echo $user_row['idx']?>" class="mod-btn">수정</a></h5>
							<ul class="cli-info">
								<li><b>업체명</b><span class=""><?php echo $user_row['user_co']?></span></li>
								<li><b>담당자</b><span class=""><?php echo $user_row['user_name']?></span></li>
								<li><b>연락처</b><span class=""><?php echo $user_row['user_phone']?></span></li>
							</ul>
						</div>
						<div>
							<h5>웹사이트 정보</h5>
							<ul class="cli-info">
								<li><b>사이트</b><span class=""><?php echo $user_row['url_tx']?></span></li>
								<li><b>URL</b><a href="" class=""><?php echo $user_row['url']?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
if ($user_row['pay_yn']=='Y') {
?>
    <div class="service_info">
    	<div class="inner">
    
    		<div class="twra">
    			<div class="tbox">
    				<p class="tt tt1">
    					<span>musign <em>family care service</em></span>를<br>
    					이용해주셔서 감사합니다.
    				</p>
    				<p class="tt tt2">
    					귀사의 성공적인 비즈니스와 웹 환경을<br>
    					제공하기 위해 항상 노력하겠습니다.  				
    				</p>
    			</div>
    		</div>
    
    		<div class="info">
    			<div class="cbox">
    				<div class="imgwra">
    					<img src="/img/info_img.png">
    				</div>
    				<div class="cont">
    					<p class="info_tit">서비스 이용내역</p>
    					<ul>
    						<li>
    							<strong>업체명</strong>
    							<p>㈜<?php echo $user_row['user_co']?></p>
    						</li>
    						<li>
    							<strong>URL</strong>
    							<p><?php echo $user_row['url']?></p>
    						</li>
    						<li>
    							<strong>담당자</strong>
    							<p><?php echo $user_row['user_name']?></p>
    						</li>
    						<li>
    							<strong>이용서버</strong>
    							<p><?php echo $server_info_row['server_type']?></p>
    						</li>
    						<li>
    							<strong>서버스 이용기간 </strong>
    							<p>
    								<?php 
    								$start_date=date('Y-m-d',strtotime($user_row['date_start']));
    								$end_date=date('Y-m-d',strtotime($user_row['date_end']));
    								
    								$start_date_new = new DateTime($start_date);
    								$end_date_new = new DateTime($end_date);
    								
    								$left_date = date_diff($start_date_new, $end_date_new);
    								
    								?>
    							
    								<?php echo $start_date?> ~ <?php echo $end_date?>
    								<span>
    									<em><?php echo $left_date ->days;?>일후 만료</em>
    									서비스 이용 마감기한 한달 전 갱신 안내메일이 발송됩니다.
    								</span>
    							</p>
    						</li>
    					</ul>
    				</div>
    			</div>
    		</div>
    
    	</div>
    </div>
<?php 
}else{
?>
    <div class="mypage-div">
    	<div class="myp-grid">
    		<p class="myp-tit"><?php echo $user_row['user_co']?> 사의 추천 서버 안내</p>
    		<div class="myp-rec">
    			귀사의 사이트는 <span class="rec-span">기업 사이트, 브랜드 사이트</span>로 <span class="rec-span"><?php echo $user_row['server_name']?> 서버</span> 사용을 추천드립니다.
    		</div>
    	</div>
    </div>
    
    <div class="mypage-div">
    	<div class="myp-grid">
    		<p class="myp-tit"><?php echo $server_info_row['server_type']?></p>
    		
    		<div class="myp-payment">
    			<div class="cell cell1">
    				<p class="myp-ptit"><?php echo $server_info_row['server_type']?>의 특징</p>
    				<ul>
						<?php 
						$server_feature_arr = explode('@',$server_info_row['server_feature']);
						for ($i = 0; $i < count($server_feature_arr)-1; $i++) {
						?>
							<li><strong>0<?php echo $i+1?></strong><?php echo $server_feature_arr[$i]?></li>
						<?php 
						}						
						?>
    				</ul>
    			</div>
    			<!-- // cell 1 -->
    			
    			<div class="cell cell2">
    				<p class="myp-ptit">서비스선택</p>
    				<ul>
    					<li>
    						<p class="myp-rchk on">
    							<input id="mypService1" type="radio" name="rchk1" value="" onclick="price_choose(this);">
    							<label for="mypService1" >
    								1년 이용권
    								<span><?php echo number_format($server_info_row['server_price'])?>원</span>
    							</label>
    						</p>
    					</li>
    					<li>
    						<p class="myp-rchk">
    							<input id="mypService2" type="radio" name="rchk1" value="" onclick="price_choose(this);">
    							<label for="mypService2">
    								2년 이용권
    								<span><?php echo number_format($server_info_row['server_price']*2)?>원</span>
    							</label>
    						</p>
    					</li>
    					<li>
    						<p class="myp-rchk">
    							<input id="mypService3" type="radio" name="rchk1" value="" onclick="price_choose(this);">
    							<label for="mypService3">
    								3년 이용권
    								<span><?php echo number_format($server_info_row['server_price']*3)?>원</span>
    							</label>
    						</p>
    					</li>
    				</ul>
    			</div>
    			<!-- // cell 2 -->
    			
    			<div class="payment">
    				<p>결제 금액 <span class="pay"><?php echo number_format($server_info_row['server_price'])?></span>원</p>
    			</div>
    			<!-- // payment -->
    
    			<div class="payment-final">
    				<div class="cell cell1">
    				<p class="final-chk">
    					<input id="finalCheck" type="checkbox" name="finalCheck">
    					<label class="check_s" for="finalCheck">위 상품의 구매조건 확인 및 결제진행에 동의합니다.</label>
    				</p>
    				</div>
    				<div class="cell cell2">
    					<button id="finalBtn" onclick="do_pay();">결제하기</button>
    				</div>
    			</div>
    			<!-- // payment_final -->
    
    		</div>
    		<!-- // myp-service -->
    
    	</div>
    </div>
<?php 
}
?>

<div class="mypage-div">
	<div class="myp-grid">
		<p class="myp-tit">Musign family care service  </p>
		<div class="myp-service p010">
			<ul>
				<li>
					<img src="/img/mypage_i1.png" alt="musgin">
					<strong>Server Management</strong>
					<p>
						서버 전담팀 운영<br>
						맨투맨
					</p>
				</li>

				<li>
					<img src="/img/mypage_i2.png" alt="musgin">
					<strong>Quick Reaction </strong>
					<p>긴급상황 대응</p>
				</li>

				<li>
					<img src="/img/mypage_i3.png" alt="musgin">
					<strong>Free Installation</strong>
					<p>
						웹사이트 환경
						무료 설치 지원				
					</p>
				</li>

				<li>
					<img src="/img/mypage_i4.png" alt="musgin">
					<strong>Installation Support</strong>
					<p>
						SSL 설치 지원
						(SSL 구매비용 별도)					
					</p>
				</li>

				<li>
					<img src="/img/mypage_i5.png" alt="musgin">
					<strong>Installation Support</strong>
					<p>주기적 백업 지원</p>
				</li>

				<li>
					<img src="/img/mypage_i6.png" alt="musgin">
					<strong>Server Previous</strong>
					<p>서버 및 DB 이전 지원</p>
				</li>

				<li>
					<img src="/img/mypage_i7.png" alt="musgin">
					<strong>Version Management</strong>
					<p>
						소프트웨어 버전
						최신화 관리					
					</p>
				</li>

			</ul>
		</div>
	</div>
</div>

<?php 
$query = "
select *,
date_format(submit_date, '%Y.%m.%d') as submit_date
from notice where 1
";

$query .= " order by submit_date";

$result_cnt = sql_query($query);

$page = ($_REQUEST['page'])?$_REQUEST['page']:1;
$listSize = 20;

$list = $listSize;
$block = 5;
$pageNum = ceil(sql_count($result_cnt)/$list); // 총 페이지
$blockNum = ceil($pageNum/$block); // 총 블록
$nowBlock = ceil($page/$block);

$s_page = ($nowBlock * $block) - ($block-1);
if ($s_page <= 1) {
    $s_page = 1;
}
$e_page = $nowBlock*$block;
if ($pageNum <= $e_page) {
    $e_page = $pageNum;
}

$n = sql_count($result_cnt);

?>
<script>
var page = "<?php echo $page;?>";
$(document).ready(function(){
	$("#p_"+page).addClass("active");
})
function pageMove(page)
{
	$("#page").val(page);
	toAjax();
}
function toAjax()
{
	var queryString = $("form[name=fncForm]").serialize();
    $.ajax({
        type : 'get',
        url : 'index.php?'+queryString,
        error: function(xhr, status, error){
            alert(error);
        },
        success : function(data){
            console.log(data);
            var result = $(".main_table").html(data).find('.main_table').html();
            $('.main_table').html(result);
        }
    });
}
function goDetail(idx)
{
	location.href="/admin/notice_view.php?idx="+idx;
}
</script>

<div class="mypage-div table_list notice_list">
	<div class="myp-grid">
		<p class="myp-tit">공지사항</p>

		<div class="main_table notice_table p010">
			<div class="pick_list_num">
				<p>전체<span class="numb"><?php echo sql_count($result_cnt);?></span>개</p>
			</div>
			<form id="fncForm" name="fncForm" method="get" action="index.php">
                <input type="hidden" id="page" name="page" value="<?php echo $page?>">
            </form>
			<table class="table_1">
				<thead>
					<tr>
						<th>번호</th>
						<th>제목</th>
						<th>날짜</th>
					</tr>
				</thead>
				<tbody>
					<?php 
                        $s_point = ($page-1) * $list;
                        $result = sql_query($query." limit {$s_point},{$list}");
                        for ($i=0; $i<sql_count($result); $i++)
                        {
                            $row = sql_fetch($result);
                            ?>
            					<tr onclick="goDetail(<?php echo $row['idx']?>)">
            						<td><?php echo ($n - $i) - (($page-1) * $listSize)?></td><!-- 번호 -->
            						<td><?php echo $row['title'];?></td>
            						<td><?php echo $row['submit_date'];?></td>
            					</tr>
                            <?php 
                        }
                        ?>
				</tbody>
			</table>

			<div class="pagenation">
				<div class="nb">
					<ul>
						<?php 
						if(1 < $page)
						{
						    ?>
        					<li class="prev_" onclick="pageMove(<?=$s_page-1?>)"><a></a></li>
                            <?php 
                        }
                        $pagingCnt = 0;
                        if($e_page != 0)
                        {
                            for ($p=$s_page; $p<=$e_page; $p++)
                            {
                                $pagingCnt ++;
                                ?>
                                <li onclick="pageMove(<?=$p?>)" id="p_<?=$p?>"><?=$p?></li>
                         	    <?php
                            }
                        }
                        else
                        {
                            ?>
                            <li onclick="pageMove(1)">1</li>
                            <?php
                        }
                        if($pageNum != $page && $pageNum > 5)
                        {
                            if($pagingCnt > 4)
                            {
                                if($e_page+1 > $pageNum)
                                {
                                    ?>
                                    <li class="next_" onclick="pageMove(<?=$pageNum?>)"><a></a></li>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <li class="next_" onclick="pageMove(<?=$e_page+1?>)"><a></a></li>
                                    <?php
                                }
                            }
                        }
						?>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>


<?php require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php"); ?>