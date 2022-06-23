<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = 
        "
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
                and cc.manager_yn = 'N'
                and bb.idx = cc.server_name
        ";

//검색
if(isset($_POST['search_name']) && $_POST['search_name'] != null && $_POST['search_name'] != "")
{
    $query .= " and (user_id like '%{$_REQUEST['search_name']}%'
                or user_co like '%{$_REQUEST['search_name']}%'
                or user_name like '%{$_REQUEST['search_name']}%'
                or user_phone like '%{$_REQUEST['search_name']}%' )";
}

if(isset($_POST['sort_type']) && $_POST['sort_type'] != null && $_POST['sort_type'] != "" && isset($_POST['order_by']) && $_POST['order_by'] != null && $_POST['order_by'] != "")
{
    $query .= " order by {$_POST['sort_type']} {$_POST['order_by']}";
}
else
{
    $query .= " order by date desc";
}

$result_cnt = sql_query($query);

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
var listSize = '<?php echo $listSize?>';
var search_name = "<?php echo $_REQUEST['search_name'];?>";
var order_by = "<?php echo $_REQUEST['order_by'];?>";
var sort_type = "<?php echo $_REQUEST['sort_type'];?>";
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
var user_idx = "";
function goDetail(idx, user_idx)
{
	user_idx = user_idx;
	if(!confirm("취소하시겠습니까?")){

		return;
	}
	   // ajax 호출 
	   $.ajax({
   		type: "post",
   		url: "/api_test_code/payCancle.php",
   		dataType:"text",
   		data : 
   		{
       			idx : idx
   		},
   		error : function() 
   		{
   			console.log("AJAX ERROR");
   		},
   		success : function(data) 
   		{
   			console.log(data);
   			var result = JSON.parse(data)[0];
   			console.log(result);
   			var dump_col = "";
   			if(result.dump_col){
				dump_col = result.dump_col;
   			}
   			$("input[name=goodsname]").val(result.goodsname);
   			$("input[name=server_feature]").val(result.server_feature + dump_col);
   			$("input[name=tid]").val(result.tid);
   			$("input[name=amt]").val(result.amt);
   		}
   	});
	$(".layer-popup").show();
// 	location.href="/api_test_code/cancelResult_utf.php?idx="+idx;
// 	location.href="/api_test_code/payCancle.php?idx="+idx;
}
</script>

<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>
<div class="table_list family_list">
	<div class="inner">

		<div class="list_tit p010">
			<strong>Musign 결제내역 리스트</strong>
		</div>

		<div class="board_search p010">
			<form id="fncForm" name="fncForm" method="post" action="cancle.php">
            	<select id="listSize" name="listSize" onchange="reSelect('search');">
            		<option value="10">10개 보기</option>
            		<option value="50">50개 보기</option>
            		<option value="100">100개 보기</option>
            		<option value="300">300개 보기</option>
            		<option value="500">500개 보기</option>
            		<option value="1000">1000개 보기</option>
            	</select>
            	<input type="text" id="search_name" name="search_name" onkeydown="javascript:enter_check();" placeholder="검색어를 입력하세요.">
				<button class="board_btn" type="button" onclick="reSelect('search')"></button>
            	<input type="hidden" id="order_by" name="order_by" value="<?php echo $_REQUEST['order_by'];?>">
                <input type="hidden" id="sort_type" name="sort_type" value="<?php echo $_REQUEST['sort_type'];?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page?>">
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
						<th>회사명<span id="sort_user_co" onclick="reSelect('sort_user_co')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>아이디<span id="sort_user_name" onclick="reSelect('sort_user_name')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>담당자<span id="sort_user_name" onclick="reSelect('sort_user_name')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>연락처<span id="sort_user_phone" onclick="reSelect('sort_user_phone')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>결제수단<span id="sort_paymethod" onclick="reSelect('sort_paymethod')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>이용권기간<span id="sort_paymethod" onclick="reSelect('chk_year')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>서버마감기한<span id="sort_date_end" onclick="reSelect('sort_date_end')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>결제날짜<span id="sort_submit_date" onclick="reSelect('sort_submit_date')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>결제상태<span id="sort_cancle_yn" onclick="reSelect('sort_cancle_yn')"><img src="/img/icon_down.png" class="sort_img"></span></th>
					</tr>
				</thead>
				<tbody>
					<?php 
                        $s_point = ($page-1) * $list;
                        $result = sql_query($query." limit {$s_point},{$list}");
                        for ($i=0; $i<sql_count($result); $i++)
                        {
                            
                            $row = sql_fetch($result)
                            ?>
            					<tr>
            						<td><?php echo ($n - $i) - (($page-1) * $listSize)?></td>
            						<td><?php echo $row['user_co'];?></td>
            						<td><?php echo $row['user_id'];?></td>
            						<td><?php echo $row['user_name'];?></td>
            						<td><?php echo $row['user_phone'];?></td>
            						<td><?php echo $row['paymethod_kor'];?></td>
            						<?php 
            						if($row['chk_year'] != null) {
            						?>
            						<td><?php echo $row['chk_year'];?> 년</td>
            						<?php 
            						} else {
            						?>
            						<td></td>
            						<?php 
            						}
            						?>
            						<td><?php echo $row['date_end'];?></td>
            						<td><?php echo $row['date'];?></td>
            						<td>
										<?php 
										  if ($row['cancle_yn']=='N') {
										?>
											<input type="button" value="결제취소" onclick="goDetail(<?php echo $row['pay_idx']?>, <?php echo $row['idx']?>)" class="payment_cancel">
										<?php 
										  } else {      
										?>
											<input type="button" value="취소완료" class="payment_finished">
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

<!-- payCancel  -->
<script type="text/javascript">

var server_type = "";
var server_feature = "";
var tid = "";
var CancelAmt = "";

function reqCancel(){
    // ajax 통신 
    $.ajax({
        		type: "get",
        		url: "/api_test_code/cancelResult_utf.php",
        		dataType:"text",
        		data : 
        		{
            		idx : user_idx,
		 			server_type : $('input[name=goodsname]').val(),
		 			server_feature : $('input[name=server_feature]').val(),
			 	    tid : $('input[name=tid]').val(),
				 	CancelAmt : $('input[name=amt]').val()
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
        	    		location.href="http://server.musign.co.kr/admin/cancle.php";
            		}
            		else
            		{
            			alert(result.msg);
            		}
        		}
        	});
	$(".layer-popup").hide();
}
</script>

<div class="cancel-modify-popup layer-popup">
	<div class="cell">
		<div class="inner">

			<div class="cancel-modify-wrap">
				<form name="cancelForm" method="post" target="_self" action="cancelResult.php">
					<table>
						<tr>
							<th>신청서버</th>
							<td><input type="text" name="goodsname"  /></td>
						</tr>
						<tr>
							<th>서버설명</th>
							<td><input type="text" name="server_feature" readonly/></td>
						</tr>
						<tr>
							<th>원거래 ID</th>
							<td><input type="text" name="tid" readonly/></td>
						</tr>
						<tr>
							<th>취소 금액</th>
							<td><input type="text" name="amt"  /></td>
						</tr>
						<tr class="cancel-choice">
							<th>부분취소 여부</th>
							<td>
								<span>
									<input type="radio" name="PartialCancelCode" value="0" checked="checked"/>
									전체취소
								</span>
							</td>
						</tr>
					</table>
					<input type="hidden" id="idx" name="idx">
					<div class="popup-btn-wrap">
						<a href="#" onClick="reqCancel();" class="popup-btn-1">요 청</a>
						<a href="http://server.musign.co.kr/admin/cancle.php" class="popup-close btn_blue popup-btn-2" >취  소</a>	
					</div>
				</form>	
			</div>	

		</div>
	</div>
</div>



<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>