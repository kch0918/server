<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");
// cash_recipt % user join
$query = " SELECT *,date_format(submit_date,'%Y-%m-%d') AS submit_date FROM server_checklist where 1";

// 통합검색
if(isset($_POST['search_option']) && $_POST['search_option'] != null && $_POST['search_option'] != "")
{
    $query .= " and {$_POST['search_option']} like '%{$_POST['search_name']}%'";
}

// 조회기간 검색
if(isset($_POST['datepicker1']) && $_POST['datepicker1'] != null && $_POST['datepicker1'] != "")
{
    $query .= " and submit_date {$_POST['submit_date']} BETWEEN '{$_POST['datepicker1']}' and '{$_POST['datepicker2']}'";
}


if(isset($_REQUEST['sort_type']) && $_REQUEST['sort_type'] != null && $_REQUEST['sort_type'] != "" && isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != null && $_REQUEST['order_by'] != "")
{
    $query .= " order by {$_REQUEST['sort_type']} {$_REQUEST['order_by']}";
}
else
{
    $query .= " order by submit_date desc, server_name asc, ip*1 asc";
}


$result_cnt = sql_query($query);

// 페이징
$page = ($_REQUEST['page']) ? $_REQUEST['page']:1;
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
	
	$( '.checkAll' ).click( function() {
        $( '.checkSelect' ).prop( 'checked', this.checked );
      });
	
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

function copy(option) //dudwo 선택복사 추가
	{	
		var idx_arr = [];
        if(option == "all"){
            $('input[name=checkSelect]:checked').each(function(index, el){
                idx_arr.push($(this).val());
            });
        }else{
        	var idx = $('input[name=checkSelect]:checked').val();
            idx_arr = [idx];
        }
        for(var i = 0; i < idx_arr.length; i++){
    		$.ajax({
    			type : "POST", 
    			url : "/admin/server_copy_proc.php",
    			dataType : "text",
    			data : 
    			{
    				idx : idx_arr[i]
    			},
    			async : false,
    			success : function(data) 
    			{
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
        	    		if(i == idx_arr.length - 1){
        	    			alert(result.msg);
	     	    			location.reload();
        	    		}
    	    		} else {
    	    			alert(result.msg);
    		    	}
    			}
    		});
        }
	}
</script>

<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>

<div class="table_list family_list">
	<div class="inner">

		<div class="list_tit p010">
			<strong>Musign 서버 점검 체크 리스트</strong>
		</div>

		<div class="board_search bill_search p010">
			<form id="fncForm" name="fncForm" method="post" action="server_checklist.php">
                <table class="search_top">
                    <tr>
                        <td>검색어</td>
                        <td><select id="search_option" name="search_option" class="search_select">
                            <option value=''>==통합검색==</option>
                            <option value='user_name'>점검자</option>
                            <option value='server_name'>서버이름</option>
                            <option value='ip'>IP주소</option>
                        </select>
                        <select id="listSize" name="listSize" onchange="reSelect('search');">
                    		<option value="10">10개 보기</option>
                    		<option value="50">50개 보기</option>
                    		<option value="100">100개 보기</option>
                    		<option value="300">300개 보기</option>
                    		<option value="500">500개 보기</option>
                    		<option value="1000">1000개 보기</option>
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
				<p>
					전체<span class="numb"><?php echo sql_count($result_cnt);?></span>개
					&nbsp;&nbsp;&nbsp;<input type="button" value="선택 복사" class="Server_copy" onclick="javascript:copy('all');">
				</p>
			</div>
			<table class="table_1 server_table">
				<thead>
					<tr>
						<th></th>
						<th>번호<span id="sort_idx" onclick="reSelect('sort  _idx')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>요청인<span id="user_name" onclick="reSelect('user_name')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>서버명<span id="server_name" onclick="reSelect('server_name')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>IP<span id="ip" onclick="reSelect('ip')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>용량이상<br>유무<span id="volume_chk" onclick="reSelect('volume_chk')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>비고<span id="volume_cmt" onclick="reSelect('volume_cmt')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>점유울이상<br>유무<span id="share_chk" onclick="reSelect('share_chk')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>비고<span id="share_chk_cmt" onclick="reSelect('share_chk_cmt')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>로그이상<br>유무<span id="log_chk" onclick="reSelect('log_chk')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>비고<span id="log_chk_cmt" onclick="reSelect('log_chk_cmt')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>점검일<span id="submit_date" onclick="reSelect('submit_date')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>기능</th>
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
            						<td><input class="checkSelect" type="checkbox" id="checkSelect" name="checkSelect" value="<?php echo $row['idx']?>"/></label></td>
        							<td style="font-size: 13px"><?php echo ($n - $i) - (($page-1) * $listSize)?></td>
            						<td style="font-size: 13px"><?php echo $row['user_name'];?></td>
            						<td style="font-size: 13px"><a href="/admin/server_check.php?idx=<?php echo $row['idx']?>"><?php echo $row['server_name'];?></a></td>
            						<td style="font-size: 13px"><?php echo $row['ip'];?></td>
            						<td style="font-size: 13px"><?php echo $row['volume_chk'];?></td>
            						<td style="font-size: 13px"><?php echo $row['volume_cmt'];?></td>
            						<td style="font-size: 13px"><?php echo $row['share_chk'];?></td>
            						<td style="font-size: 13px"><?php echo $row['share_cmt'];?></td>
            						<td style="font-size: 13px"><?php echo $row['log_chk'];?></td>
            						<td style="font-size: 13px"><?php echo $row['log_cmt'];?></td>
            						<td style="font-size: 13px"><?php echo $row['submit_date'];?></td>
            						<td><input type="button" value="복사" class="Server_copy" onclick="javascript:copy();"></td>
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