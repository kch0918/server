<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.css">
<script src="https://cdn.jsdelivr.net/npm/handsontable@latest/dist/handsontable.full.min.js"></script>
<script>
var dataObject = [
	 
];
function handsontable_add()
{
	var resultData = dataObject;
	resultData.push(
			{
				"유지보수 여부": '',
				"프로젝트명": '',
				"접속URL": '',
				"서버": '',
				"호스팅업체": '',
				"호스팅ID": '',
				"호스팅PW": '',
				"도메인업체": '',
				"도메인ID": '',
				"도메인PW": '',
				"FTP 호스트": '',
				"FTP ID": '',
				"FTP PW": '',
				"DB 호스트": '',
				"DB ID": '',
				"DB PW": '',
				"관리자 ID": '',
				"관리자 PW": '',
				"기타 접속정보": '',
				"비고": ''
			  }
			)
	dataObject = resultData;
	$("#hot").html('');
	viewHot();
}
function handsontable_add(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t)
{
	var resultData = dataObject;
	resultData.push(
			{
				"유지보수 여부": a,
				"프로젝트명": b,
				"접속URL": c,
				"서버": d,
				"호스팅업체": e,
				"호스팅ID": f,
				"호스팅PW": g,
				"도메인업체": h,
				"도메인ID": i,
				"도메인PW": j,
				"FTP 호스트": k,
				"FTP ID": l,
				"FTP PW": m,
				"DB 호스트": n,
				"DB ID": o,
				"DB PW": p,
				"관리자 ID": q,
				"관리자 PW": r,
				"기타 접속정보": s,
				"비고": t
			  }
			)
	dataObject = resultData;
	$("#hot").html('');
	viewHot();
}
var clickValue = new Array();
$(document).ready(function(){
    $("#hot").click( function() {
    	clickValue = new Array();
    	imsi = $(".wtSpreader:first").find(".htCore").find("tbody").find("tr").find(".ht__highlight").find(".relative").find(".rowHeader");
    
    	imsi.each(function(){ 
    		clickValue.push($(this).html());
    	})
    });
})
function handsontable_del()
{
	if(clickValue.length == 0)
	{
		alert("삭제할 라인을 선택해주세요.");
		return;
	}
	var resultData = dataObject;
	resultData.splice(clickValue[0]-1,clickValue.length);
	dataObject = resultData;
	$("#hot").html('');
	viewHot();
	clickValue = new Array();
}
function viewHot()
{
		var flagRenderer = function (instance, td, row, col, prop, value, cellProperties) {
		  var currencyCode = value;
		  while (td.firstChild) {
		    td.removeChild(td.firstChild);
		  }
		  if (currencyCodes.indexOf(currencyCode) > -1) {
		    var flagElement = document.createElement('DIV');
		    flagElement.className = 'flag ' + currencyCode.toLowerCase();
		    td.appendChild(flagElement);
		  } else {
		    var textNode = document.createTextNode(value === null ? '' : value);

		    td.appendChild(textNode);
		  }
		};
		var hotElement = document.querySelector('#hot');
		var hotElementContainer = hotElement.parentNode;
		var hotSettings = {
		  data: dataObject,
		  renderAllRows: true,
		  columns: [
		    {
		        data: '유지보수 여부',
		        type: 'text',
		        width: 40,
		        className : 'a'
		    },
		    {
		        data: '프로젝트명',
		        type: 'text',
		        width: 40,
		        className : 'b'
		    },
		    {
		        data: '접속URL',
		        type: 'text',
		        width: 40,
		        className : 'c'
		    },
		    {
		        data: '서버',
		        type: 'text',
		        width: 40,
		        className : 'd'
		    },
		    {
		        data: '호스팅업체',
		        type: 'text',
		        width: 40,
		        className : 'e'
		    },
		    {
		        data: '호스팅ID',
		        type: 'text',
		        width: 40,
		        className : 'f'
		    },
		    {
		        data: '호스팅PW',
		        type: 'text',
		        width: 40,
		        className : 'g'
		    },
		    {
		        data: '도메인업체',
		        type: 'text',
		        width: 40,
		        className : 'h'
		    },
		    {
		        data: '도메인ID',
		        type: 'text',
		        width: 40,
		        className : 'i'
		    },
		    {
		        data: '도메인PW',
		        type: 'text',
		        width: 40,
		        className : 'j'
		    },
		    {
		        data: 'FTP 호스트',
		        type: 'text',
		        width: 40,
		        className : 'k'
		    },
		    {
		        data: 'FTP ID',
		        type: 'text',
		        width: 40,
		        className : 'l'
		    },
		    {
		        data: 'FTP PW',
		        type: 'text',
		        width: 40,
		        className : 'm'
		    },
		    {
		        data: 'DB 호스트',
		        type: 'text',
		        width: 40,
		        className : 'n'
		    },
		    {
		        data: 'DB ID',
		        type: 'text',
		        width: 40,
		        className : 'o'
		    },
		    {
		        data: 'DB PW',
		        type: 'text',
		        width: 40,
		        className : 'p'
		    },
		    {
		        data: '관리자 ID',
		        type: 'text',
		        width: 40,
		        className : 'q'
		    },
		    {
		        data: '관리자 PW',
		        type: 'text',
		        width: 40,
		        className : 'r'
		    },
		    {
		        data: '기타 접속정보',
		        type: 'text',
		        width: 40,
		        className : 's'
		    },
		    {
		        data: '비고',
		        type: 'text',
		        width: 40,
		        className : 't'
		    }
		    

		  ],
		  stretchH: 'all',
		  width: 1850,
		  autoWrapRow: true,
		  height: 487,
		  maxRows: 999,
		  rowHeaders: true,
		  colHeaders: [
			  "유지보수 여부",
				"프로젝트명",
				"접속URL",
				"서버",
				"호스팅업체",
				"호스팅ID",
				"호스팅PW",
				"도메인업체",
				"도메인ID",
				"도메인PW",
				"FTP 호스트",
				"FTP ID",
				"FTP PW",
				"DB 호스트",
				"DB ID",
				"DB PW",
				"관리자 ID",
				"관리자 PW",
				"기타 접속정보",
				"비고"
		  ]
		};
		var hot = new Handsontable(hotElement, hotSettings);
		$("#hot-display-license-info").hide();
}

</script>