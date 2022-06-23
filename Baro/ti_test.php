

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta property="og:type" content="website">
	
	<meta property="og:image" content="http://image.barobill.co.kr/v7/og/og.png">
	<meta property="og:url" content="http://testbed.barobill.co.kr">
	<title>전자세금계산서 바로빌</title>
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:100,300,400&display=swap&subset=korean">
	<link rel="stylesheet" href="/Baro/css/barobill.css?v7"/>
	<link rel="stylesheet" href="/Baro/css/layout.css?v7"/>	
	<link rel="stylesheet" href="/Baro/css/content.css?v7"/>	
	<link rel="stylesheet" href="/Baro/css/dti.css?v7"/>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113640820-1"></script>

	<!-- external -->
	<script type="text/javascript" src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

</head>
<body id="TEB" class="chrome">






	<div class="wrapper">
<div>
    <div id="area-title">
    	
    	<h1>
    		매출 작성
    	</h1>

    	
    </div>

<div id="area-content" class="area-content">
<script>
function registInvoice(){
	var form_name = document.form_w;
	form_name.submit();
}
</script>
	

	<form name="form_w" method="post" enctype="multipart/form-data" action="/Baro/BaroService_PHP5_Sample/TI/API_TI/RegistAndIssueTaxInvoice.php">
	<input type="hidden" name="my_code" value="69CFCA67-CFBA-4B42-8276-A0A0EFD13ABB">
	<input type="hidden" name="LMT" value="0" ><input type="hidden" name="LMF" value="1" ><input type="hidden" name="LMC" value="0" ><input type="hidden" name="InvoiceKey" value="" ><input type="hidden" name="Role" value="1" ><input type="hidden" name="IssueType" value="0" ><input type="hidden" name="ModifyCode" value="0" ><input type="hidden" id="OriWriteDT" value="" ><input type="hidden" name="InvoicerContactID1" value="musign" ><input type="hidden" name="InvoiceeContactID1" value="" ><input type="hidden" name="TrusterContactID1" value="" >

	<div id="Invoice-Write-TaxType">
		<input type="hidden" name="TaxCalcType" value="2" >
<div class="box-container p10 pl15 pr15 mb15">
	<b class="mr10">과세형태 :</b>
	
	<label><input type="radio" name="TaxType" id="TaxType1" class="rb" value="1" checked onclick="changeTaxType(1);"> 과세(10%)</label>&nbsp;&nbsp;
	
	<label><input type="radio" name="TaxType" id="TaxType2" class="rb" value="2"  onclick="changeTaxType(2);"> 영세(0%)</label>&nbsp;&nbsp;			
	
	<label><input type="radio" name="TaxType" id="TaxType3" class="rb" value="3"  onclick="changeTaxType(3);"> 면세(세액없음)</label>		
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b class="mr10">공급받는자 구분 :</b>
	<label><input type="radio" name="InvoiceeType" id="InvoiceeType1" class="rb" value="1" checked onclick="changeInvoiceeType(1);"> 사업자</label>&nbsp;&nbsp;
	<label><input type="radio" name="InvoiceeType" id="InvoiceeType2" class="rb" value="2"  onclick="changeInvoiceeType(2);"> 개인</label>&nbsp;&nbsp;
	<label><input type="radio" name="InvoiceeType" id="InvoiceeType3" class="rb" value="3"  onclick="changeInvoiceeType(3);"> 외국인</label>
	

	<div style="position:absolute;top:50%;right:15px;margin-top:-13px;">
		<a class="btn btn-blue3" onclick="openCheckCstat();">휴폐업조회</a>
	</div>
</div>

	</div>		
	<div id="Invoice-Write-Form">
		<div class="invoice-write invoice-write-red">
			<div class="form-container">
	<table class="table-invoice">
		<colgroup>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
			<col style="width:2.94117647058824%;"/>
			
		</colgroup>
		<thead>
		<tr>
			<th colspan="16" rowspan="2" class="a_c bg-n bb0 br0"><span class="f22 b ls0" id="FormTitleName">전자세금계산서</span></th>
			<td colspan="4" rowspan="2" class="a_c bb0 br0">공 급 자<br/>(보 관 용)</td>
			<td colspan="2" rowspan="2" class="bb0 br0">&nbsp;</td>
			<td colspan="4" class="a_r bb0 br0">책번호 : </td>
			<td colspan="3" class="a_c bb0 br0"><input type="text" name="Kwon" class="  form-s" value="" style="width:100%;" maxlength="4" tabindex="1"></td>
			<td colspan="1" class="a_c bb0 br0">권</td>
			<td colspan="3" class="a_c bb0 br0"><input type="text" name="Ho" class="  form-s" value="" style="width:100%;" maxlength="4" tabindex="2"></td>
			<td colspan="1" class="a_c bb0 br0">호</td>
		</tr>
		<tr>
			<td colspan="4" class="a_r bb0 br0">일련번호 : </td>
			<td colspan="8" class="a_c bb0 br0"><input type="text" name="SerialNum" class="  form-s" value="" style="width:100%;" maxlength="27" tabindex="3"></td>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th colspan="1" rowspan="6" class="a_c bt1 bb0 invoicer title">공<br/>급<br/>자</th>
			<th colspan="3" class="a_c bt1 invoicer">등록번호</th>
			<td colspan="8" class="a_c bt1 invoicer"><input type="text" name="InvoicerCorpNum" class=" readonly a_c valignm form-s" value="808-88-00950" style="width:100%;" maxlength="14" readonly tabindex="4"></td>
			<th colspan="3" class="a_c bt1 invoicer">종사업장</th>
			<td colspan="2" class="a_c bt1 br0 invoicer"><input type="text" name="InvoicerTaxRegID" class="  form-s" value="" style="width:100%;" maxlength="4" tabindex="5"></td>
			<th colspan="1" rowspan="6" class="a_c bt1 bb0 invoicee title">공<br/>급<br/>받<br/>는<br/>자</th>
			<th colspan="3" class="a_c bt1 invoicee">등록번호</th>
			<td colspan="8" class="a_l bt1 invoicee"><input type="text" name="InvoiceeCorpNum" class=" a_c valignm form-s" value="" style="width:153px;" maxlength="14" tabindex="14"><a href="#" onclick="return false;" class="ClientChanger InvoiceeChanger ml3"><img src="http://image.barobill.co.kr/v7/icon/icon_mglass2.gif" class="valignm"></a></td>
			<th colspan="3" class="a_c bt1 invoicee">종사업장</th>
			<td colspan="2" class="a_c bt1 br0 invoicee"><input type="text" name="InvoiceeTaxRegID" class="  form-s" value="" style="width:100%;" maxlength="4" tabindex="15"></td>
		</tr>
		<tr>
			<th colspan="3" class="a_c invoicer">상호</th>
			<td colspan="8" class="a_c invoicer"><textarea name="InvoicerCorpName" class="scroll " style="width:100%;height:100%;" maxlength="200" tabindex="6">뮤자인</textarea></td>
			<th colspan="1" class="a_c invoicer">성<br/>명</th>
			<td colspan="4" class="a_c br0 invoicer"><textarea name="InvoicerCEOName" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="7">이호걸</textarea></td>
			<th colspan="3" class="a_c invoicee">상호</th>
			<td colspan="8" class="a_c invoicee"><textarea name="InvoiceeCorpName" class="scroll " style="width:100%;height:100%;" maxlength="200" tabindex="16"></textarea></td>
			<th colspan="1" class="a_c invoicee">성<br/>명</th>
			<td colspan="4" class="a_c br0 invoicee"><textarea name="InvoiceeCEOName" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="17"></textarea></td>
		</tr>
		<tr>
			<th colspan="3" class="a_c invoicer">사업장<br/>주소</th>
			<td colspan="13" class="a_c br0 invoicer"><textarea name="InvoicerAddr" class="scroll " style="width:100%;height:100%;" maxlength="300" tabindex="8">서울특별시 강동구 성안로 156 우주빌딩</textarea></td>
			<th colspan="3" class="a_c invoicee">사업장<br/>주소</th>
			<td colspan="13" class="a_c br0 invoicee"><textarea name="InvoiceeAddr" class="scroll " style="width:100%;height:100%;" maxlength="300" tabindex="18"></textarea></td>
		</tr>
		<tr>
			<th colspan="3" class="a_c invoicer">업태</th>
			<td colspan="6" class="a_c invoicer"><textarea name="InvoicerBizType" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="9">정보서비스업</textarea></td>
			<th colspan="2" class="a_c invoicer">종목</th>
			<td colspan="5" class="a_c br0 invoicer"><textarea name="InvoicerBizClass" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="10">전자상거래업</textarea></td>
			<th colspan="3" class="a_c invoicee">업태</th>
			<td colspan="6" class="a_c invoicee"><textarea name="InvoiceeBizType" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="19"></textarea></td>
			<th colspan="2" class="a_c invoicee">종목</th>
			<td colspan="5" class="a_c br0 invoicee"><textarea name="InvoiceeBizClass" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="20"></textarea></td>
		</tr>
		<tr>
			<th colspan="3" class="a_c invoicer">담당자</th>
			<td colspan="6" class="a_c invoicer"><input type="text" name="InvoicerContactName1" class="  form-s" value="문동현" style="width:100%;" maxlength="100" tabindex="11"></td>
			<th colspan="2" class="a_c invoicer">연락처</th>
			<td colspan="5" class="a_c br0 invoicer"><input type="text" name="InvoicerTEL1" class="  form-s" value="02-476-6740" style="width:100%;" maxlength="20" tabindex="12"></td>
			<th colspan="3" class="a_c invoicee">담당자</th>
			<td colspan="6" class="a_c invoicee"><input type="text" name="InvoiceeContactName1" class="  form-s" value="" style="width:100%;" maxlength="100" tabindex="21"></td>
			<th colspan="2" class="a_c invoicee">연락처</th>
			<td colspan="5" class="a_c br0 invoicee"><input type="text" name="InvoiceeTEL1" class="  form-s" value="" style="width:100%;" maxlength="20" tabindex="22"></td>
		</tr>
		<tr>
			<th colspan="3" class="a_c bb0 invoicer">이메일</th>
			<td colspan="13" class="a_c br0 bb0 invoicer"><input type="text" name="InvoicerEmail1" class=" eng_only form-s" value="mdh0088@musign.net" style="width:100%;" maxlength="100" tabindex="13"></td>
			<th colspan="3" class="a_c bb0 invoicee">이메일</th>
			<td colspan="13" class="a_c br0 bb0 invoicee"><input type="text" name="InvoiceeEmail1" class=" eng_only form-s" value="" style="width:100%;" maxlength="100" tabindex="23"></td>
		</tr>
		</tbody>
		
		<tbody>
		<tr>
			<th colspan="4" class="a_c bt1">작성일자&nbsp;<a href="#" onclick="$('#Invoice-Write-Form').find('input[name=WriteDT]').focus();return false;"><img src="http://image.barobill.co.kr/v7/component/dtp-icon.gif" id="WriteDTIcon" class="valignt"/></a></th>
			<th colspan="16" class="a_c bt1 tt0">공급가액</th>
			<th colspan="14" class="a_c bt1 br0 tt1" style="display:;">세액</th>
		</tr>
		<tr>
			<td colspan="4" class="a_c bb0"><input type="text" name="WriteDT" class="form-s a_c datepicker-input" IconYN="0" value="2020-04-06" style="width:100%;" maxlength="10" tabindex="25"></td>
			<td colspan="16" class="a_c bb0 tt0"><input type="text" name="AmountTotal" class=" readonly a_r form-s" value="" style="width:100%;" readonly maxlength="18" ></td>
			<td colspan="14" class="a_c bb0 br0 tt1" style="display:;"><input type="text" name="TaxTotal" class=" readonly a_r form-s" value="" style="width:100%;" readonly maxlength="18" ></td>
		</tr>
		</tbody>
		<tbody>
		<tr>
			<th colspan="4" class="a_c bt1">비고1</th>
			<td colspan="29" class="a_c bt1"><input type="text" name="Remark1" class="  form-s" value="" style="width:100%;" maxlength="150" tabindex="26"></td>
			<td class="a_c bt1 br0"><a href="#" onclick="addRemark();return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_plus2.gif"></a></td>
		</tr>
		<tr id="Remark2" class="none">
			<th colspan="4" class="a_c">비고2</th>
			<td colspan="29" class="a_c"><input type="text" name="Remark2" class="  form-s" value="" style="width:100%;" maxlength="150" tabindex="27"></td>
			<td class="a_c br0"><a href="#" onclick="removeRemark(2);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_minus.gif"></a></td>
		</tr>
		<tr id="Remark3" class="none">
			<th colspan="4" class="a_c">비고3</th>
			<td colspan="29" class="a_c"><input type="text" name="Remark3" class="  form-s" value="" style="width:100%;" maxlength="150" tabindex="28"></td>
			<td class="a_c br0"><a href="#" onclick="removeRemark(3);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_minus.gif"></a></td>
		</tr>
		</tbody>
		<tbody>
		<tr>
			<th colspan="4" class="a_c bb0">작성방법</th>
			<td colspan="30" class="br0 bb0 pl10">
				<label><input type="radio" name="WriteType" id="WriteType4" class="rb" value="4" checked onclick="changeWriteType(4);"> 직접입력</label>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="WriteType" id="WriteType1" class="rb" value="1"  onclick="changeWriteType(1);"> 수량단가</label>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="WriteType" id="WriteType2" class="rb" value="2"  onclick="changeWriteType(2);"> 공급가액</label>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="WriteType" id="WriteType3" class="rb" value="3"  onclick="changeWriteType(3);"> 합계금액</label>
				&nbsp;
				<input type="text" name="TotalAmountInput" id="TotalAmountInput" class=" readonly  form-s" value="" style="width:100px;" disabled maxlength="12" tabindex="29" onkeyup="if(event.keyCode==13){setAmountFromTotalAmount();}"><a class="btn btn-s btn-gray3" onclick="setAmountFromTotalAmount();" >입력</a>
			</td>
		</tr>
		</tbody>
		<tbody id="Detail" class="invoice-items">
		<tr>
			<th colspan="1" class="a_c bt1">월<input type="hidden" name="DetailJSON" value="" ></th>
			<th colspan="1" class="a_c bt1">일</th>
			<th colspan="8" class="a_c bt1">품목</th>
			<th colspan="5" class="a_c bt1">규격</th>
			<th colspan="3" class="a_c bt1 tt2">수량</th>
			<th colspan="3" class="a_c bt1 tt3">단가</th>
			<th colspan="4" class="a_c bt1 tt4">공급가액</th>
			<th colspan="4" class="a_c bt1 tt5" style="display:;">세액</th>
			<th colspan="4" class="a_c bt1">비고</th>
			<th colspan="1" class="a_c bt1 br0"><a href="#" onclick="addItem();return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_plus2.gif"></a></th>
		</tr>
		
		<tr>
			<td colspan="1" class="a_c "><input type="text" name="PurchaseDT1" class=" readonly a_c pl0 pr0 form-s" value="4" style="width:100%;" maxlength="2" tabindex="50" readonly></td>
			<td colspan="1" class="a_c "><input type="text" name="PurchaseDT2" class=" a_c pl0 pr0 form-s" value="" style="width:100%;" maxlength="2" tabindex="50"></td>
			<td colspan="8" class="a_c ">
				<textarea name="ItemName" class="scroll valignm" style="width:155px;height:100%;" maxlength="100" tabindex="50"></textarea>
				<a href="#" onclick="changeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_mglass2.gif" class="valignm"></a>
			</td>
			<td colspan="5" class="a_c "><textarea name="Spec" class="scroll " style="width:100%;height:100%;" maxlength="60" tabindex="50"></textarea></td>
			<td colspan="3" class="a_c  tt2"><input type="text" name="Qty" class=" a_r form-s" value="" style="width:100%;" maxlength="12" tabindex="50"></td>
			<td colspan="3" class="a_c  tt3"><input type="text" name="UnitCost" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c  tt4"><input type="text" name="Amount" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c  tt5" style="display:;"><input type="text" name="Tax" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c "><textarea name="Remark" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="50"></textarea></td>
			<td colspan="1" class="a_c br0 "><a href="#" onclick="removeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_delete.gif"></a></td>
		</tr>
		
		<tr>
			<td colspan="1" class="a_c "><input type="text" name="PurchaseDT1" class=" readonly a_c pl0 pr0 form-s" value="4" style="width:100%;" maxlength="2" tabindex="50" readonly></td>
			<td colspan="1" class="a_c "><input type="text" name="PurchaseDT2" class=" a_c pl0 pr0 form-s" value="" style="width:100%;" maxlength="2" tabindex="50"></td>
			<td colspan="8" class="a_c ">
				<textarea name="ItemName" class="scroll valignm" style="width:155px;height:100%;" maxlength="100" tabindex="50"></textarea>
				<a href="#" onclick="changeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_mglass2.gif" class="valignm"></a>
			</td>
			<td colspan="5" class="a_c "><textarea name="Spec" class="scroll " style="width:100%;height:100%;" maxlength="60" tabindex="50"></textarea></td>
			<td colspan="3" class="a_c  tt2"><input type="text" name="Qty" class=" a_r form-s" value="" style="width:100%;" maxlength="12" tabindex="50"></td>
			<td colspan="3" class="a_c  tt3"><input type="text" name="UnitCost" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c  tt4"><input type="text" name="Amount" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c  tt5" style="display:;"><input type="text" name="Tax" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c "><textarea name="Remark" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="50"></textarea></td>
			<td colspan="1" class="a_c br0 "><a href="#" onclick="removeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_delete.gif"></a></td>
		</tr>
		
		<tr>
			<td colspan="1" class="a_c "><input type="text" name="PurchaseDT1" class=" readonly a_c pl0 pr0 form-s" value="4" style="width:100%;" maxlength="2" tabindex="50" readonly></td>
			<td colspan="1" class="a_c "><input type="text" name="PurchaseDT2" class=" a_c pl0 pr0 form-s" value="" style="width:100%;" maxlength="2" tabindex="50"></td>
			<td colspan="8" class="a_c ">
				<textarea name="ItemName" class="scroll valignm" style="width:155px;height:100%;" maxlength="100" tabindex="50"></textarea>
				<a href="#" onclick="changeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_mglass2.gif" class="valignm"></a>
			</td>
			<td colspan="5" class="a_c "><textarea name="Spec" class="scroll " style="width:100%;height:100%;" maxlength="60" tabindex="50"></textarea></td>
			<td colspan="3" class="a_c  tt2"><input type="text" name="Qty" class=" a_r form-s" value="" style="width:100%;" maxlength="12" tabindex="50"></td>
			<td colspan="3" class="a_c  tt3"><input type="text" name="UnitCost" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c  tt4"><input type="text" name="Amount" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c  tt5" style="display:;"><input type="text" name="Tax" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c "><textarea name="Remark" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="50"></textarea></td>
			<td colspan="1" class="a_c br0 "><a href="#" onclick="removeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_delete.gif"></a></td>
		</tr>
		
		<tr>
			<td colspan="1" class="a_c bb0"><input type="text" name="PurchaseDT1" class=" readonly a_c pl0 pr0 form-s" value="4" style="width:100%;" maxlength="2" tabindex="50" readonly></td>
			<td colspan="1" class="a_c bb0"><input type="text" name="PurchaseDT2" class=" a_c pl0 pr0 form-s" value="" style="width:100%;" maxlength="2" tabindex="50"></td>
			<td colspan="8" class="a_c bb0">
				<textarea name="ItemName" class="scroll valignm" style="width:155px;height:100%;" maxlength="100" tabindex="50"></textarea>
				<a href="#" onclick="changeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_mglass2.gif" class="valignm"></a>
			</td>
			<td colspan="5" class="a_c bb0"><textarea name="Spec" class="scroll " style="width:100%;height:100%;" maxlength="60" tabindex="50"></textarea></td>
			<td colspan="3" class="a_c bb0 tt2"><input type="text" name="Qty" class=" a_r form-s" value="" style="width:100%;" maxlength="12" tabindex="50"></td>
			<td colspan="3" class="a_c bb0 tt3"><input type="text" name="UnitCost" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c bb0 tt4"><input type="text" name="Amount" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c bb0 tt5" style="display:;"><input type="text" name="Tax" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="50"></td>
			<td colspan="4" class="a_c bb0"><textarea name="Remark" class="scroll " style="width:100%;height:100%;" maxlength="100" tabindex="50"></textarea></td>
			<td colspan="1" class="a_c br0 bb0"><a href="#" onclick="removeItem(this);return false;"><img src="http://image.barobill.co.kr/v7/icon/icon_delete.gif"></a></td>
		</tr>
		
		</tbody>
		<tbody>
		<tr>
			<th colspan="9" class="a_c bt1">합계금액</th>
			<th colspan="4" class="a_c bt1 black n">현금</th>
			<th colspan="4" class="a_c bt1 black n">수표</th>
			<th colspan="4" class="a_c bt1 black n">어음</th>
			<th colspan="4" class="a_c bt1 black n">외상미수금</th>
			<td colspan="9" rowspan="2" class="a_c bt1 br0 bb0">
					이 금액을
					&nbsp;
					<label><input type="radio" name="PurposeType" id="PurposeType1" class="rb" value="1"  > 영수</label>
					&nbsp;
					<label><input type="radio" name="PurposeType" id="PurposeType2" class="rb" value="2" checked > 청구</label>
					&nbsp;
					함.
				</ul>
			</td>
		</tr>
		<tr>
			<td colspan="9" class="a_c bb0"><input type="text" name="TotalAmount" class=" readonly a_r form-s" value="" style="width:100%;" readonly maxlength="18"></td>
			<td colspan="4" class="a_c bb0"><input type="text" name="Cash" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="51"></td>
			<td colspan="4" class="a_c bb0"><input type="text" name="ChkBill" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="52"></td>
			<td colspan="4" class="a_c bb0"><input type="text" name="Note" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="53"></td>
			<td colspan="4" class="a_c bb0"><input type="text" name="Credit" class=" a_r form-s" value="" style="width:100%;" maxlength="18" tabindex="54"></td>
		</tr>
		</tbody>
	</table>

	
</div>
		</div>
	</div>
	<br/>	
	<div id="Invoice-Write-Info">
		<input type="hidden" name="LinkedInvoiceJSON" value="" >
 
<table class="table-content table-style2">
<colgroup>
	<col style="width:15%;"/>
	<col style="width:9%;"/>
	<col/>
</colgroup>
<tbody>

<tr>
	<th colspan="2">[발행예정] 발행방법</th>
	<td>			
		<label class="blue3"><input type="radio" name="IssueTiming" id="IssueTiming1" class="rb" value="1" checked > 공급자 직접발행</label>
		&nbsp;&nbsp;
		<label class="red3"><input type="radio" name="IssueTiming" id="IssueTiming2" class="rb" value="2"  registed="0"> 공급받는자 승인시 자동발행</label>		
		&nbsp;&nbsp;
		<a class="btn btn-s btn-gray2" onclick="openCertificate();">공인인증서 등록</a>
	</td>
</tr>

<tr>
	<th class="bd-r" rowspan="2">전자문서첨부</th>
	<th class="a_c">
		자동작성
	</th>
	<td>
		<label><input type="checkbox" name="AutoWriteDealInvoiceYN" id="AutoWriteDealInvoiceYN" value="1"  > 관련 거래명세서도 자동으로 작성합니다.</label>
	</td>
</tr>

<tr>
	
	<th class="th a_c">
		<a class="btn btn-s" onclick="openLinkEDoc();">문서찾기</a>
	</th>
	<td>
		<div id="LinkedInvoice">
			<ul class="list-with-seperator">
			
			</ul>
		</div>
	</td>
</tr>

<tr>
	<th class="bd-r">첨부파일</th>
	<th class="th a_c">
		<input type="file" id="AttachFileInput" class="  form-s" style="width:200px;" button text="파일찾기">

	</th>
	<td class="pr10">
		
		<div class="attach-file-upload-container">
			<div id="AttachedFile">
				
			</div>
			<div id="AttachFile"></div>
		</div>
		<input type="hidden" name="AttachedFileJSON" value="" >
	</td>
</tr>

<tr>
	<th colspan="2">첨부문서</th>
	<td>
		<label><input type="checkbox" name="BusinessLicenseYN" id="BusinessLicenseYN" value="1"  registed="0"> 사업자등록증을 첨부합니다.</label>
		<a class="btn btn-s btn-gray2" onclick="openAttachImg('BLICENSE');">등록</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input type="checkbox" name="BankBookYN" id="BankBookYN" value="1"  registed="0"> 통장사본을 첨부합니다.</label>
		<a class="btn btn-s btn-gray2" onclick="openAttachImg('BANKBOOK');">등록</a>
	</td>
</tr>

<tr>
	<th colspan="2">부가알림 서비스<br/><a class="blue3" href="#" onclick="showAddSendEmail();return false;">[확인메일]</a>, <a class="blue3" href="#" onclick="showASPEmail();return false;">[타ASP전송]</a></th>
	<td>
		
		<p>
			<span class="badge mr5" style="width:80px;">문자전송</span>
			<label class="mr5"><input type="checkbox" name="InvoicerSMSSendYN" id="InvoicerSMSSendYN" value="1"  onclick="changeSMSSendYN();"> 발송여부</label>
			<input type="text" name="InvoiceeHP1_1" class=" readonly  form-s" value="" style="width:40px;" readonly maxlength="3" tabindex="100">
			-
			<input type="text" name="InvoiceeHP1_2" class=" readonly  form-s" value="" style="width:40px;" readonly maxlength="4" tabindex="101">
			-
			<input type="text" name="InvoiceeHP1_3" class=" readonly  form-s" value="" style="width:40px;" readonly maxlength="4" tabindex="102">
		</p>
		
		<p class="mt5">
			<span class="badge mr5" style="width:80px;">팩스전송</span>
			<label class="mr5"><input type="checkbox" name="FaxSendYN" id="FaxSendYN" value="1"  onclick="changeFaxSendYN();"> 발송여부</label>
			<input type="text" name="FaxReceiveNum_1" class=" readonly  form-s" value="" style="width:40px;" readonly maxlength="3" tabindex="102">
			-
			<input type="text" name="FaxReceiveNum_2" class=" readonly  form-s" value="" style="width:40px;" readonly maxlength="4" tabindex="103">
			-
			<input type="text" name="FaxReceiveNum_3" class=" readonly  form-s" value="" style="width:40px;" readonly maxlength="4" tabindex="104">
		</p>
		
		<div id="AddSendEmailContainer" class="none">
			
			<br/>
			
			<div id="AddSendEmail">
				
				<p>
					<span class="badge mr5" style="width:80px;">확인메일</span>
					<input type="text" name="AddSendContact" class=" kor form-s" value="" style="width:140px;"  tabindex="105" placeholder="담당자명">&nbsp;<input type="text" name="AddSendEmail" class=" eng_only form-s" value="" style="width:250px;"  tabindex="105" placeholder="이메일">
					<a class="btn btn-s btn-gray3" onclick="addAddSendEmail();">추가</a>
					<a class="btn btn-s btn-gray3" onclick="removeAddSendEmail(this);">삭제</a>
				</p>
				
			</div>
			<span class="desc">* 추가로 담당자에게 확인메일이 발송되며, 승인권한이 없습니다.</span>
			<input type="hidden" name="AddSendEmailJSON" value="" >
		</div>
		
		<div id="ASPEmail" class="none">
			
			<br/>
			
			<span class="badge mr5" style="width:80px;">타ASP</span>
			<input type="text" name="ASPEmail" class="  form-s" value="" style="width:394px;"  tabindex="106" placeholder="이메일">
			<a class="btn btn-s btn-gray3" onclick="openASPEmail();">선택</a>
			<a class="btn btn-s btn-gray3" onclick="hideASPEmail();">삭제</a>
			<br/>
			<span class="desc">* 매입자가 이용하는 ASP 서비스 업체로 전자(세금)계산서를 발행하여 매입내역을 확인할 수 있습니다.</span>
		</div>
		
	</td>
</tr>

<tr>
	<th colspan="2">메모<br/><span class="f11 n gray3">(공급받는자에게 보이지 않음)</span></th>
	<td><textarea name="InvoicerMemo" class="scroll " style="width:570px;height:45px;" maxlength="150" tabindex="107"></textarea></td>
</tr>

</tbody>
</table>

	</div>

	<br/>

	<div class="a_c">
		
		<a class="btn btn-xl btn-red" onclick="registInvoice();">&nbsp;&nbsp;발&nbsp;행&nbsp;&nbsp;</a>

	</div>

	</form>

</div>



		<div class="clearb"></div>
	</div>
</div>


</body>
</html>
