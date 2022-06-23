<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

// cash_recipt % user join
$query =
            "   
                 SELECT     
            			 aa.tid,
            			 aa.user_name,
            			 aa.user_name,
                         aa.user_email,
            			 bb.*,
            			 FLOOR(bb.amount) AS amount,
            			 FLOOR(bb.tax) AS tax,
            			 date_format(bb.submit_date,'%Y-%m-%d %H:%i:%S') AS submit_date
                 FROM invoice_payment bb
                 JOIN user aa
                 ON bb.cust_no = aa.idx
                 WHERE aa.manager_yn = 'N'
            ";

// 통합검색
if(isset($_POST['search_option']) && $_POST['search_option'] != null && $_POST['search_option'] != "")
{
    $query .= " and {$_POST['search_option']} like '%{$_POST['search_name']}%'";
}

// 조회기간 검색
if(isset($_POST['datepicker1']) && $_POST['datepicker1'] != null && $_POST['datepicker1'] != "")
{
    $query .= " and bb.submit_date {$_POST['submit_date']} BETWEEN '{$_POST['datepicker1']}' and '{$_POST['datepicker2']}'";
}


if(isset($_REQUEST['sort_type']) && $_REQUEST['sort_type'] != null && $_REQUEST['sort_type'] != "" && isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != null && $_REQUEST['order_by'] != "")
{
    $query .= " order by {$_REQUEST['sort_type']} {$_REQUEST['order_by']}";
}
else
{
    $query .= " order by submit_date desc";
}


$result_cnt = sql_query($query);

// 페이징
$page = ($_REQUEST['page'])?$_REQUEST['page']:1;
if(!isset($_REQUEST['listSize']))
{
    $listSize = 10;
}
else
{
    $listSize = $_REQUEST['listSize'];
}

$list = $listSize;
$block = 5;
$pageNum = ceil(sql_count($result_cnt)/$list);      // 총 페이지
$blockNum = ceil($pageNum/$block);                  // 총 블록
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
var listSize = '<?php echo $listSize?>';
var search_name = "<?php echo $_POST['search_name'];?>";
var search_option = "<?php echo $_POST['search_option']?>";
var order_by = "<?php echo $_POST['order_by'];?>";
var sort_type = "<?php echo $_POST['sort_type'];?>";
var page = "<?php echo $page;?>";

$(document).ready(function(){
	$("#p_"+page).addClass("active");
	$("#search_name").val(search_name);
	if(order_by == "desc")
	{
		$("#sort_"+sort_type).html('<img src="/img/icon_up.png" class="sort_img">');
	}
	else if(order_by == "asc")
	{
		$("#sort_"+sort_type).html('<img src="/img/icon_down.png" class="sort_img">');
	}
	if(listSize != "")
	{
		$("#listSize").val(listSize);
	}
	if(search_option != "")
	{
		$("#search_option").val(search_option);
	}
})

$(document).ready(function(){
  var checkBox = $('.search_top .chkbox2');
  $.each(checkBox, function(){
    $(this).click(function(){
      checkBox.removeClass('active');
      $(this).addClass('active');
    });
  });
})

function reSelect(act)
{
	if(act.indexOf("sort_") > -1)
	{
		var sort_type = act.replace("sort_", "");
		$("#sort_type").val(sort_type);
		var order_by = "";
		if($("#"+act).html() == '<img src="/img/icon_down.png" class="sort_img">')
		{
			order_by = "desc";
		}
		else if($("#"+act).html() == '<img src="/img/icon_up.png" class="sort_img">')
		{
			order_by = "asc";
		}
		$("#order_by").val(order_by);			
	}
	$("#page").val(1);
	$("#fncForm").submit();
}
function enter_check()
{
	if(event.keyCode == 13){
		reSelect('search');
		return;
	}
}
function pageMove(page)
{
	$("#page").val(page);
	$("#fncForm").submit();
}

//datepicker
$.datepicker.setDefaults({
    dateFormat: 'yy-mm',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear: true,
    yearSuffix: '년'
  });

$(function() {
    $("#datepicker1, #datepicker2").datepicker({
        dateFormat: 'yymmdd'
    });
});

//기간 계산
function setSearchDate(start){

            var num = start.substring(0,1);
            var str = start.substring(1,2);

            var today = new Date();
    		var year =  today.getFullYear();
			//var month = today.getMonth() + 1;
			//var day = today.getDate();
            
            
            var endDate = $.datepicker.formatDate('yymmdd', today);
            $('#datepicker2').val(endDate);
            
            if(str == 'd'){
                today.setDate(today.getDate() - num);
            }else if (str == 'w'){
                today.setDate(today.getDate() - (num*7));
            }else if (str == 'm'){
                today.setMonth(today.getMonth() - num);
                today.setDate(today.getDate() + 1);
            }else if (str == 'y'){
            	today.setYear(year - num); 
            	today.setMonth(today.getMonth());
                today.setDate(today.getDate());
            }

            var startDate = $.datepicker.formatDate('yymmdd', today);
            $('#datepicker1').val(startDate);
                    
            // 종료일은 시작일 이전 날짜 선택하지 못하도록 비활성화
            $("#datepicker2").datepicker( "option", "minDate", startDate );
            
            // 시작일은 종료일 이후 날짜 선택하지 못하도록 비활성화
            $("#datepicker1").datepicker( "option", "maxDate", endDate );

        }

//발급 취소
function goTaxCancle(mgt_num,cust_no)
{
	
	if(!confirm("발급을 취소하시겠습니까?")){
		return;
	}
	   // ajax 호출 
	   $.ajax({
   		type: "post",
   		url: "/Baro/BaroService_PHP5_Sample/TI/API_TI/ProcTaxInvoice.php",
   		dataType:"text",
   		data : 
   		{
       		mgt_num : mgt_num,
       		cust_no : cust_no
   		},
   		error : function() 
   		{
   			console.log("AJAX ERROR");
   		},
   		success : function(data) 
   		{
   			console.log(data);
   			var result = JSON.parse(data);
   			if(result.msg == "취소 성공")
    		{
	    		alert(result.msg);
	    		location.reload();
    		}
    		else
    		{
    			alert(result.msg);
    		}

   		}
   	});
}

//세금계산서 메일 재발송
function goTaxResend(mgt_num,user_email)
{
	if(!confirm("메일을 재발송 하시겠습니까?")){
		return;
	}
	   // ajax 호출 
	   $.ajax({
   		type: "post",
   		url: "/Baro/BaroService_PHP5_Sample/TI/API_TI/ReSendEmail.php",
   		dataType:"text",
   		data : 
   		{
       		mgt_num    : mgt_num,
       		user_email : user_email
   		},
   		error : function() 
   		{
   			console.log("AJAX ERROR");
   		},
   		success : function(data) 
   		{
   			console.log(data);
   			var result = JSON.parse(data);
   			if(result.msg == "메일 재발송 성공")
    		{
	    		alert(result.msg);
	    		location.reload();
    		}
    		else
    		{
    			alert(result.msg);
    		}

   		}
   	});
}


</script>

<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>

<div class="table_list family_list">
	<div class="inner">

		<div class="list_tit p010">
			<strong>Musign 세금 계산서 리스트</strong>
		</div>

		<div class="board_search bill_search p010">
			<form id="fncForm" name="fncForm" method="post" action="taxbills_list.php">
                <table class="search_top">
                    <tr>
                        <td>검색어</td>
                        <td><select id="search_option" name="search_option" class="search_select">
                            <option value=''>==통합검색==</option>
                            <option value='aa.user_name'>요청인</option>
                            <option value='bb.corp_num'>사업자번호</option>
                            <option value='aa.user_co'>회사명</option>
                            <option value='bb.ceo_name'>대표자명</option>
                        </select>
                        <input type="text" id="search_name" name="search_name" placeholder="검색어를 입력하세요." value="<?php echo $_POST['search_name']?>" onkeydown="javascript:enter_check();"></td>
                    </tr>
                    <tr>
                        <td>조회기간</td>
                        <td>
                            <input type="hidden" id="order_by" name="order_by" value="<?php echo $_POST['order_by'];?>">
                            <input type="hidden" id="page" name="page" value="<?php echo $page?>"><input autocomplete="off" type="text" id="datepicker1" name="datepicker1" value="<?php echo $_POST['datepicker1']?>"> ~
                            <input autocomplete="off" type="text" id="datepicker2" name="datepicker2" value="<?php echo $_POST['datepicker2']?>">
                            <!-- 기간별 조회 -->
                            <span class="chkbox2">
                                <input type="button" name="dateType" id="dateType1" onclick="setSearchDate('1d')"/ value="1일">
                            </span>
                            <span class="chkbox2">
                                <input type="button" name="dateType" id="dateType3" onclick="setSearchDate('1w')"/ value="1주"></span>
                            <span class="chkbox2">
                                <input type="button" name="dateType" id="dateType4" onclick="setSearchDate('2w')"/ value="2주"></span>
                            <span class="chkbox2">
                                <input type="button" name="dateType" id="dateType5" onclick="setSearchDate('1m')"/ value="1개월"></span>
                            <span class="chkbox2">
                                <input type="button" name="dateType" id="dateType6" onclick="setSearchDate('3m')"/ value="3개월"></span>
                            <span class="chkbox2">
                                <input type="button" name="dateType" id="dateType7" onclick="setSearchDate('1y')"/ value="1년"></span>
                        </td>
                    </tr>
                </table>
                <input type="button" class="bt_search" value="검색" onclick="reSelect('search')"></input>
            </form>
		</div>
		
		<div class="main_table family_table p010">
			<div class="pick_list_num">
				<p>전체<span class="numb"><?php echo sql_count($result_cnt);?></span>개</p>
			</div>
			<table class="table_1">
				<thead>
					<tr>
						<th>번호<span id="sort_idx" onclick="reSelect('sort_idx')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>발행요청일<span id="submit_date" onclick="reSelect('submit_date')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>주문번호<span id="tid" onclick="reSelect('tid')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>요청인<span id="user_name" onclick="reSelect('user_name')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>사업자정보<span id="corp_num" onclick="reSelect('corp_num')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>총금액<span id="total_amout" onclick="reSelect('total_amout')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>공급가액<span id="amount" onclick="reSelect('amount')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>부가가치세<span id="tax" onclick="reSelect('tax')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>결제상태</th>
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
                            
            					<tr>
        							<td style="font-size: 14px"><?php echo ($n - $i) - (($page-1) * $listSize)?></td>
            						<td style="font-size: 14px"><?php echo $row['submit_date'];?></td>
            						<td style="font-size: 14px"><?php echo $row['mgt_num'];?></td>
            						<td style="font-size: 14px"><?php echo $row['user_name'];?></td>
            						<td style="font-size: 14px"  class="text_left">
            						  사업자번호 : <?php echo $row['corp_num'];?><br/>
            							회  사  명 : <?php echo $row['corp_name'];?><br/>
            							대 표 자 명 : <?php echo $row['ceo_name'];?><br/>
            							업       태 : <?php echo $row['biz_type'];?><br/>
            							종       목 : <?php echo $row['biz_class'];?><br/>
            							주       소 : <?php echo $row['addr'];?><br/>
            							발행 이메일: <?php echo $row['email'];?><br/>
            						</td>
            						<td style="font-size: 14px"><?php echo number_format($row['total_amount']);?>원</td>
            						<td style="font-size: 14px"><?php echo number_format($row['amount']);?>원</td>
            						<td style="font-size: 14px"><?php echo number_format($row['tax']);?>원</td>
            						<td style="font-size: 14px">
							      	<?php 
										  if ($row['cancel_type'] == '1') {
										?>
											<input type="button" value="취소완료" class="cancle_finished payment_finished">
											<input type="button" onclick='goTaxResend("<?php echo $row['mgt_num']?>","<?php echo $row['user_email']?>")' name="resend" value="재발송" class="payment_finished" style="display: inline-block">
										<?php 
										  } else {      
										?>
											<input type="button" class="payment_cancel" onclick='goTaxCancle("<?php echo $row['mgt_num']?>","<?php echo $row['cust_no']?>")' name="cancel" value="취소" style="display: inline-block">
											<input type="button" onclick='goTaxResend("<?php echo $row['mgt_num']?>","<?php echo $row['user_email']?>")' name="resend" value="재발송" class="payment_finished" style="display: inline-block">
										<?php 
										  }
										?>
									</td>
            					</tr>
                            <?php 
                        }
                        ?>
    				</tbody>
    			</table>
            		<!-- 페이징  -->
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
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>