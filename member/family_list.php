<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = 
         "
            SELECT *, 
                date_format(submit_date, '%Y.%m.%d %H:%i') as submit_date, 
                date_format(date_end, '%Y.%m.%d') as date_end, 
                if(per_yn = 'Y', '승인', '신청') as per_yn,
                TO_DAYS(now()) - TO_DAYS(date_format(date_end, '%Y.%m.%d')) as dday,
    	       (CASE user.server_name
    		      WHEN '1'  THEN 'AWS_t3.small'
    			  WHEN '2'  THEN 'AWS_t3.medium'
    			  WHEN '3'  THEN 'AWS_t3.large'
    		      WHEN '4'  THEN 'AWS_t3.xlarge'
    			  WHEN '5'  THEN 'AWS_t3.2xlarge'
    			  WHEN '6'  THEN 'AWS_c5.large'
    		      WHEN '7'  THEN 'AWS_c5.xlarge'
                  WHEN '8'  THEN 'AWS_r5.large'
                  WHEN '9'  THEN '해지/이전'
                  WHEN '10' THEN 'test'
    			  END) AS user_server
            FROM user where 1
          ";


if(isset($_REQUEST['search_name']) && $_REQUEST['search_name'] != null && $_REQUEST['search_name'] != "")
{
    $query .= " and (user_id like '%{$_REQUEST['search_name']}%'            
                or user_co like '%{$_REQUEST['search_name']}%' 
                or user_name like '%{$_REQUEST['search_name']}%'
                or user_phone like '%{$_REQUEST['search_name']}%'             
                )";
}
    $query .= " and manager_yn != 'Y'"; //관리자페이지는 노출하지않기위함.
    
if(isset($_REQUEST['sort_type']) && $_REQUEST['sort_type'] != null && $_REQUEST['sort_type'] != "" && isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != null && $_REQUEST['order_by'] != "")
{
    $query .= " order by {$_REQUEST['sort_type']} {$_REQUEST['order_by']}";
}
else
{
    $query .= " order by submit_date desc, aws_cloud";
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

	var container = $(".table_1 tbody tr");
	for(var i = 0; i < container.length; i++){	
		container[i].addEventListener('click', function(ev){
			var idx = ev.target.parentElement.dataset.idx;
			if(ev.target.className != "confirm_n"){
				location.href="/member/modify_view.php?idx="+idx;
			}
		})
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
	$("#productForm").submit();
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
	$("#productForm").submit();
}
function agree(idx, co, per)
{
	var ment = "";
	var per_yn = "";
	if(per == "승인")
	{
		per_yn = "N";
		ment = " 업체의 승인상태를 취소하시겠습니까?";
	}
	else
	{
		per_yn = "Y";
		ment = " 업체를 승인하시겠습니까?";
	}
	var con = confirm(co+ment);
	if(con)
	{
		$.ajax({
			type : "POST", 
			url : "changePer.php",
			dataType : "text",
			data : 
			{
				idx : idx,
				per_yn : per_yn
			},
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert('변경되었습니다.');
	    			location.reload();
	    		}
	    		else
	    		{
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

		<div class="f_top">
			<div class="manager_wrap">
				<div class="tbox p010">
					<p class="m_">서버 담당자</p>
					<p class="m_name">정기영님</p>
				</div>
			</div>
		</div>

		<div class="list_tit p010">
			<strong>Musign User 리스트</strong>
		</div>

		<div class="board_search p010">
			<form id="productForm" name="productForm" method="post" action="family_list.php">
            	<select id="listSize" name="listSize" onchange="reSelect('search');">
            		<option value="10">20개 보기</option>
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
						<th>아이디<span id="sort_user_id" onclick="reSelect('sort_user_id')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>사용서버<span id="sort_server_name" onclick="reSelect('sort_server_name')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>클라우드<span id="sort_aws_cloud" onclick="reSelect('sort_aws_cloud')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>회사명<span id="sort_user_co" onclick="reSelect('sort_user_co')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>담당자<span id="sort_user_name" onclick="reSelect('sort_user_name')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>연락처<span id="sort_user_phone" onclick="reSelect('sort_user_phone')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>가입일<span id="sort_submit_date" onclick="reSelect('sort_submit_date')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>만료일<span id="sort_date_end" onclick="reSelect('sort_date_end')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>승인상태<span id="sort_per_yn" onclick="reSelect('sort_per_yn')"><img src="/img/icon_down.png" class="sort_img"></span></th>
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
            					<tr data-idx="<?php echo $row['idx']?>">
            						<td class="text_left"><?php echo $row['user_id'];?></td><!-- 아이디 -->
            						<td><?php echo $row['user_server'];?></td><!-- 사용서버 -->
            						<td><?php echo $row['aws_cloud'];?></td><!-- 해당클라우드 -->
            						<td class="text_left"><?php echo $row['user_co'];?></td><!-- 회사명 -->
            						<td><?php echo $row['user_name'];?></td><!-- 성함 -->
            						<td><?php echo $row['user_phone'];?></td><!-- 핸드폰번호 -->
            						<td><?php echo $row['submit_date'];?></td><!-- 가입일 -->
            						<td>
            							<?php 
            							if($row['date_end'] != '' && $row['date_end'] != null)
            							{
                							if($row['dday'] >= -30)
                							{
                							    if($row['dday'] > 0)
                							    {
                							        $row['dday'] = "+".$row['dday'];
                							    }
                							    ?><span style="color:red;"><?php echo "~".$row['date_end']."("."D-".$row['dday'].")";?></span><?php 
                							}
                							else
                							{
                							    ?><span style=""><?php echo "~".$row['date_end']."("."D-".$row['dday'].")";?></span><?php
                							}
            							}
            							else
            							{
            							    echo "미등록";
            							}
                                        ?>
            						</td><!-- 만료일 -->
            						
            						<td><!-- 승인상태 -->
        								<?php 
        								if($row['per_yn'] == "승인")
        								{
        								    ?><span class="confirm_n" style="cursor:pointer;" onclick="agree(<?php echo $row['idx']?>, '<?php echo $row['user_co']?>', '<?php echo $row['per_yn']?>');"><?php echo $row['per_yn'];?></span><?php
        								    }
        								    else
        								    {
        								        ?><span class="confirm_n" style="color:red; cursor:pointer;" onclick="agree(<?php echo $row['idx']?>, '<?php echo $row['user_co']?>', '<?php echo $row['per_yn']?>');"><?php echo $row['per_yn'];?></span><?php 
        								    }
        								?>
            						</td>
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
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>