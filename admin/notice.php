<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");

$query = "
            select *, 
            date_format(submit_date, '%Y.%m.%d %H:%i') as submit_date
            from notice where 1
         ";

if(isset($_REQUEST['search_name']) && $_REQUEST['search_name'] != null && $_REQUEST['search_name'] != "")
{
    $query .= " and (title like '%{$_REQUEST['search_name']}%')";
}
if(isset($_REQUEST['sort_type']) && $_REQUEST['sort_type'] != null && $_REQUEST['sort_type'] != "" && isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != null && $_REQUEST['order_by'] != "")
{
    $query .= " order by {$_REQUEST['sort_type']} {$_REQUEST['order_by']}";
}
else {
    $query .= " and board_type like '%{$_REQUEST['search_name']}%' order by submit_date desc";
}

$result_cnt = sql_query($query);

// 현재 페이지
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
function goDetail(idx)
{
	location.href="/admin/notice_view.php?idx="+idx;
}
</script>



<div class="sub-top text-center">
	<p class="mtit-sp">Digital Experience platform - musign</p>
	<p class="mtit-big">musign<span class="color-g">care</span></p>
</div>

<div class="table_list family_list">
	<div class="inner">

		<div class="list_tit p010">
			<strong>Musign 공지사항 리스트</strong>
		</div>

		<div class="board_search p010">
			<form id="fncForm" name="fncForm" method="post" action="notice.php">
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
						<th>제목<span id="sort_title" onclick="reSelect('sort_title')"><img src="/img/icon_down.png" class="sort_img"></span></th>
						<th>날짜<span id="sort_submit_date" onclick="reSelect('sort_submit_date')"><img src="/img/icon_down.png" class="sort_img"></span></th>
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
        							<td><?php  echo ($n - $i) - (($page-1) * $listSize)?></td>
            						<td class="text_left">
            						<?php 
            						  if($row['board_type'] == "1" )
            						   {
            						       echo "[일반]";
            						   } else {
            						       echo "[공지]";
            						   }
            						  ?>
            						   <?php 
            					        echo $row['title'];?></td>
            						<td><?php echo $row['submit_date'];?></td>
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
			<a href="/admin/notice_write.php" class="writ-btn">글쓰기</a>
		</div>
	</div>
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>