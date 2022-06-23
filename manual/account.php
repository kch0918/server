<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/master.php");
require_once($_SERVER['DOCUMENT_ROOT']."/common/manual_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/js/handsontable.php");

$query = "select * from account";
$result = sql_query($query);
$row = sql_fetch($result);

?>
<script>
var listSize = '<?php echo $listSize?>';
var search_name = "<?php echo $_REQUEST['search_name'];?>";
var order_by = "<?php echo $_REQUEST['order_by'];?>";
var sort_type = "<?php echo $_REQUEST['sort_type'];?>";
var page = "<?php echo $page;?>";

var db_a = '<?php echo str_replace('&lt;br&gt;','<br>',$row['a']);?>'.split("|");
var db_b = '<?php echo str_replace('&lt;br&gt;','<br>',$row['b']);?>'.split("|");
var db_c = '<?php echo str_replace('&lt;br&gt;','<br>',$row['c']);?>'.split("|");
var db_d = '<?php echo str_replace('&lt;br&gt;','<br>',$row['d']);?>'.split("|");
var db_e = '<?php echo str_replace('&lt;br&gt;','<br>',$row['e']);?>'.split("|");
var db_f = '<?php echo str_replace('&lt;br&gt;','<br>',$row['f']);?>'.split("|");
var db_g = '<?php echo str_replace('&lt;br&gt;','<br>',$row['g']);?>'.split("|");
var db_h = '<?php echo str_replace('&lt;br&gt;','<br>',$row['h']);?>'.split("|");
var db_i = '<?php echo str_replace('&lt;br&gt;','<br>',$row['i']);?>'.split("|");
var db_j = '<?php echo str_replace('&lt;br&gt;','<br>',$row['j']);?>'.split("|");
var db_k = '<?php echo str_replace('&lt;br&gt;','<br>',$row['k']);?>'.split("|");
var db_l = '<?php echo str_replace('&lt;br&gt;','<br>',$row['l']);?>'.split("|");
var db_m = '<?php echo str_replace('&lt;br&gt;','<br>',$row['m']);?>'.split("|");
var db_n = '<?php echo str_replace('&lt;br&gt;','<br>',$row['n']);?>'.split("|");
var db_o = '<?php echo str_replace('&lt;br&gt;','<br>',$row['o']);?>'.split("|");
var db_p = '<?php echo str_replace('&lt;br&gt;','<br>',$row['p']);?>'.split("|");
var db_q = '<?php echo str_replace('&lt;br&gt;','<br>',$row['q']);?>'.split("|");
var db_r = '<?php echo str_replace('&lt;br&gt;','<br>',$row['r']);?>'.split("|");
var db_s = '<?php echo str_replace('&lt;br&gt;','<br>',$row['s']);?>'.split("|");
var db_t = '<?php echo str_replace('&lt;br&gt;','<br>',$row['t']);?>'.split("|");

$(document).ready(function(){
	viewHot();
	for (z = 0; z < db_a.length-1; z++) 
	{
    	handsontable_add(
    			db_a[z].replace(/<br>/gi, "\n"),
    			db_b[z].replace(/<br>/gi, "\n"),
    			db_c[z].replace(/<br>/gi, "\n"),
    			db_d[z].replace(/<br>/gi, "\n"),
    			db_e[z].replace(/<br>/gi, "\n"),
    			db_f[z].replace(/<br>/gi, "\n"),
    			db_g[z].replace(/<br>/gi, "\n"),
    			db_h[z].replace(/<br>/gi, "\n"),
    			db_i[z].replace(/<br>/gi, "\n"),
    			db_j[z].replace(/<br>/gi, "\n"),
    			db_k[z].replace(/<br>/gi, "\n"),
    			db_l[z].replace(/<br>/gi, "\n"),
    			db_m[z].replace(/<br>/gi, "\n"),
    			db_n[z].replace(/<br>/gi, "\n"),
    			db_o[z].replace(/<br>/gi, "\n"),
    			db_p[z].replace(/<br>/gi, "\n"),
    			db_q[z].replace(/<br>/gi, "\n"),
    			db_r[z].replace(/<br>/gi, "\n"),
    			db_s[z].replace(/<br>/gi, "\n"),
    			db_t[z].replace(/<br>/gi, "\n")
    			);
	}
})

function fncSubmit()
{
	var a; var a_list = ''; a = document.getElementsByClassName("a");
	var b; var b_list = ''; b = document.getElementsByClassName("b");
	var c; var c_list = ''; c = document.getElementsByClassName("c");
	var d; var d_list = ''; d = document.getElementsByClassName("d");
	var e; var e_list = ''; e = document.getElementsByClassName("e");
	var f; var f_list = ''; f = document.getElementsByClassName("f");
	var g; var g_list = ''; g = document.getElementsByClassName("g");
	var h; var h_list = ''; h = document.getElementsByClassName("h");
	var i; var i_list = ''; i = document.getElementsByClassName("i");
	var j; var j_list = ''; j = document.getElementsByClassName("j");
	var k; var k_list = ''; k = document.getElementsByClassName("k");
	var l; var l_list = ''; l = document.getElementsByClassName("l");
	var m; var m_list = ''; m = document.getElementsByClassName("m");
	var n; var n_list = ''; n = document.getElementsByClassName("n");
	var o; var o_list = ''; o = document.getElementsByClassName("o");
	var p; var p_list = ''; p = document.getElementsByClassName("p");
	var q; var q_list = ''; q = document.getElementsByClassName("q");
	var r; var r_list = ''; r = document.getElementsByClassName("r");
	var s; var s_list = ''; s = document.getElementsByClassName("s");
	var t; var t_list = ''; t = document.getElementsByClassName("t");
	for (z = 0; z < a.length; z++) 
	{
		a_list += a[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		b_list += b[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		c_list += c[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		d_list += d[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		e_list += e[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		f_list += f[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		g_list += g[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		h_list += h[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		i_list += i[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		j_list += j[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		k_list += k[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		l_list += l[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		m_list += m[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		n_list += n[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		o_list += o[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		p_list += p[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		q_list += q[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		r_list += r[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		s_list += s[z].innerHTML.replace(/\n/gi, "<br>")+"|";
		t_list += t[z].innerHTML.replace(/\n/gi, "<br>")+"|";
	}
	$.ajax({
		type : "POST", 
		url : "account_modify_proc.php",
		dataType : "text",
		data : 
		{
			a : a_list,
			b : b_list,
			c : c_list,
			d : d_list,
			e : e_list,
			f : f_list,
			g : g_list,
			h : h_list,
			i : i_list,
			j : j_list,
			k : k_list,
			l : l_list,
			m : m_list,
			n : n_list,
			o : o_list,
			p : p_list,
			q : q_list,
			r : r_list,
			s : s_list,
			t : t_list
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
    			alert("저장되었습니다.");
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
	<div class="inner" style="max-width:1850px;">

		<div class="list_tit p010">
			<strong>Musign <?php echo getTitle('manage_co')?></strong>
		</div>

		<div class="main_table family_table acc-wrap">
			<div class="btn-wrap">
				<input type="button" class="add-btn" onclick="handsontable_add()" value="새로운 라인추가"> 
				<input type="button" class="del-btn" onclick="handsontable_del()" value="선택한 라인삭제">

				<?php 
				if(getChmod('account') > 0 || getChmod('manage_co') > 0)
				{
					?><a href="javascript:fncSubmit();" class="writ-btn">수정</a><?php 
				}
				?>
			</div>

			<div id="hot"></div>

			
		</div>
	
	
	</div>
	<!-- // inner -->
</div>
<!-- // family_list -->

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/common/footer.php");
?>