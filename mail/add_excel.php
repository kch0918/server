<scriptsrc="https://polyfillio/v3/polyfilljs?features=fetch"></script>
<divid="wrap_all">
<div>
	<div>
상품엑셀업로드<input type='file' id='excel_upload' >
    	    <a href="javascript:excel_submit('goods');">저장</a>  
	</div>
</div>
</div>

<script>
function excel_submit()
{
	if(document.querySelector("#excel_upload").value == '')
	{
		alert("파일이 등록되지 않았습니다.");
		return false;
	}

	var formData = new FormData();
	formData.append("excel_upload[]", document.querySelector("#excel_upload").files[0]);
	
	fetch("/mail/goods_excel_upload.php",{
		method: "POST",
		body: formData
	}).then(function(response){
		if(response.ok){ return response.text(); }
	}).then(function(result){
		console.log(result);
	});
}
</script>
