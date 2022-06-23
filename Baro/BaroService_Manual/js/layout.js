// json
var methodJson = JSON.parse($.ajax({
	url: 'json/method.json?' + (new Date().getUTCMilliseconds()),
	dataType: 'json',
	async: false
}).responseText);

var objectJson = JSON.parse($.ajax({
	url: 'json/object.json?' + (new Date().getUTCMilliseconds()),
	dataType: 'json',
	async: false
}).responseText);

var codeJson = JSON.parse($.ajax({
	url: 'json/code.json?' + (new Date().getUTCMilliseconds()),
	dataType: 'json',
	async: false
}).responseText);

var manualJson = JSON.parse($.ajax({
	url: 'json/manual.json?' + (new Date().getUTCMilliseconds()),
	dataType: 'json',
	async: false
}).responseText);

var errcodeJson = JSON.parse($.ajax({
	url: 'json/errcode.json?' + (new Date().getUTCMilliseconds()),
	dataType: 'json',
	async: false
}).responseText);

$(document).ready(function () {
	generateMethodTree();

	$(window).on('hashchange', function () {
		if (location.hash == '')
			return;

		var hashs = location.hash.split('#');

		$('.method-tree span.on').removeClass('on');
		var $on = $('.method-tree span[hash=' + location.hash.substr(1, location.hash.length - 1) + ']').addClass('on');

		switch (hashs.length) {
			case 2:
				setApiContent(hashs[1]);
				break;
			case 3:
				$on.parent().parent().show();
				setCategoryContent(hashs[1], hashs[2]);
				break;
			case 4:
				$on.parent().parent().show().parent().parent().show();
				setMethodContent(hashs[1], hashs[2], hashs[3]);
				break;
		}

		$('.manual-contents').scrollTop(0);
	});

	if (location.hash != '')
		$(window).trigger('hashchange');

	$('.body').on('click', 'span[hash]', function () {
		var hash = $(this).parent().attr('id');

		location.hash = $(this).attr('hash');
	});

	bindFuncSearchEvent();
	bindErrCodeEvent();

	$('#FUNC').focus();
});

function generateMethodTree (keyword) {
	var $methodTree = $('.method-tree');

	if (!$methodTree.data('binded')){
		$methodTree.on('click', '.category', function () {
			if ($(this).parent().children('ul').css('display') == 'none')
				$(this).parent().children('ul').slideToggle({
					duration: 100
				});
		});

		$methodTree.on('click', '.arrow', function () {
			$(this).parent().children('ul').slideToggle({
				duration: 100
			});
		});

		$methodTree.data('binded', true);
	}

	var html = '';

	for ( var apiId in methodJson) {
		var api = methodJson[apiId];
		var categoryHtml = '';

		for ( var categoryId in api.category) {
			var category = api.category[categoryId];
			var methodHtml = '';

			for ( var i in category.method){
				var isDeprecated = typeof manualJson[apiId][category.method[i]].deprecatedBy != 'undefined';
				if (typeof keyword != 'undefined'){
					var method = category.method[i];
					var regexpKeyword = new RegExp('(' + keyword + ')', 'i');

					if (!regexpKeyword.test(category.method[i]))
						continue;

					method = method.replace(regexpKeyword, '<span class="highlight">$1</span>');

					methodHtml += '		<li class="method"><span class="method-name' + (isDeprecated ? ' deprecated' : '') + '" hash="' + apiId + '#' + categoryId + '#' + category.method[i] + '">' + method + '</span></li>';
				} else
					methodHtml += '		<li class="method"><span class="method-name' + (isDeprecated ? ' deprecated' : '') + '" hash="' + apiId + '#' + categoryId + '#' + category.method[i] + '">' + category.method[i] + '</span></li>';
			}

			if (methodHtml == '')
				continue;
			
			categoryHtml += '	<li>';
			categoryHtml += '		<span class="category" hash="' + apiId + '#' + categoryId + '">' + category.name + '</span>';
			categoryHtml += '		<div class="arrow"></div>';
			categoryHtml += '		<ul class="last" style="display:' + (typeof keyword == 'undefined' ? 'none' : 'block') + '";>';
			categoryHtml += methodHtml;
			categoryHtml += '		</ul>';
			categoryHtml += '	</li>';
		}

		if (categoryHtml == '')
			continue;
		
		html += '<li>';
		html += '	<span class="category" hash="' + apiId + '">' + api.name + '</span>';
		html += '	<div class="arrow"></div>';
		html += '	<ul style="display:' + (typeof keyword == 'undefined' ? 'none' : 'block') + ';">';
		html += categoryHtml;
		html += '	</ul>';
		html += '</li>';
	}

	$methodTree.find('.tree').html('').append(html);
}

function setApiContent (apiId) {
	var api = methodJson[apiId];

	html = '<h4>' + api.name + '</h4>';

	for ( var categoryId in api.category) {
		var category = api.category[categoryId];

		html += '<div class="dashed"></div>';
		html += '<h5>' + category.name + '</h5>';
		html += '<ul>';

		for ( var i in category.method) {
			var manual = manualJson[apiId][category.method[i]];

			html += '<li id="' + category.method[i] + '">';
			html += '	<span class="method' + (manual.deprecatedBy ? ' deprecated' : '') + '" hash="' + apiId + '#' + categoryId + '#' + category.method[i] + '">' + category.method[i] + '</span>';
			
			if (manual.deprecatedBy) {
			html += '	<span class="gray">(' + manual.deprecatedBy + ' 함수로 대체되었습니다.)</span>';
			}
	
			html += '	<div>' + manual.description + '</div>';
			html += '</li>';
		}

		html += '</ul>';
	}

	html += '<p>&nbsp;</p>';

	$('.manual-contents').addClass('api').html(html);
}

function setCategoryContent (apiId, categoryId) {
	var category = methodJson[apiId].category[categoryId];

	html = '<h4>' + category.name + '</h4>';
	html += '<ul>';

	for ( var i in category.method) {
		var manual = manualJson[apiId][category.method[i]];

		html += '<li id="' + category.method[i] + '">';
		html += '	<span class="method' + (manual.deprecatedBy ? ' deprecated' : '') + '" hash="' + apiId + '#' + categoryId + '#' + category.method[i] + '">' + category.method[i] + '</span>';

		if (manual.deprecatedBy) {
		html += '	<span class="gray">(' + manual.deprecatedBy + ' 함수로 대체되었습니다.)</span>';
		}

		html += '	<div>' + manual.description + '</div>';
		html += '</li>';
	}

	html += '</ul>';
	html += '<p>&nbsp;</p>';

	$('.manual-contents').addClass('api').html(html);
}

function setMethodContent (apiId, categoryId, methodId) {
	var manual = manualJson[apiId][methodId];
	var subObjects = [];
	var subCodes = [];
	var html = '';

	// method
	if (manual.deprecatedBy) {
		html += '<h1><span class="deprecated">' + methodId + (manual.title ? ' ' + manual.title : '') + '</span> <span class="gray">(' + manual.deprecatedBy + ' 함수로 대체되었습니다.)</span></h1>';
	} else {
		html += '<h1>' + methodId + (manual.title ? ' ' + manual.title : '') + '</h1>';
	}

	// description
	html += '<h4>Description</h4>';
	html += '<div>' + manual.description + '</div>';

	// parameter
	html += '<div class="dashed"></div>';
	html += '<h4>Parameter</h4>';
	html += '<div>';
	html += '	<table class="table-parameter">';
	html += '	<colgroup>';
	html += '		<col style="width:30px;" />';
	html += '		<col />';
	html += '		<col />';
	html += '		<col style="width:40px;" />';
	html += '		<col style="width:40px;" />';
	html += '		<col />';
	html += '	</colgroup>';
	html += '	<thead>';
	html += '	<tr>';
	html += '		<th>No</th>';
	html += '		<th>변수명</th>';
	html += '		<th>타입</th>';
	html += '		<th>길이</th>';
	html += '		<th>필수</th>';
	html += '		<th>설명</th>';
	html += '	</tr>';
	html += '	</thead>';
	html += '	<tbody>';

	for (var i = 0; i < manual.parameter.length; i++) {
		html += '	<tr>';
		html += '		<td>' + (i + 1) + '</td>';
		html += '		<td class="l nowrap">' + manual.parameter[i].name + '</td>';
		html += '		<td class="nowrap">' + manual.parameter[i].type + '</td>';
		html += '		<td>' + manual.parameter[i].length + '</td>';
		html += '		<td>' + manual.parameter[i].required + '</td>';

		if (manual.parameter[i].object) {
			var objectName = manual.parameter[i].object;
			if (objectName.indexOf('[]') != -1)
				objectName = objectName.replace('[]', '');

			subObjects.push(objectName);
			html += '	<td class="l"><b class="green">' + manual.parameter[i].object + '</b></td>';
		} else if (manual.parameter[i].code) {
			subCodes.push(manual.parameter[i].code);
			html += '	<td class="l"><b class="green">' + codeJson[manual.parameter[i].code].description + '</b></td>';
		} else
			html += '	<td class="l">' + manual.parameter[i].description + '</td>';

		html += '	</tr>';
	}

	html += '	</tbody>';
	html += '	</table>';
	html += '</div>';

	// return
	html += '<div class="dashed"></div>';
	html += '<h4>Return</h4>';
	html += '<div class="type">반환타입 : <b class="green">' + manual.returnType + '</b></div>';
	html += '<div class="type">반환값</div>';
	html += '<ul>';

	for (var i = 0; i < manual.returnValue.length; i++) {
		html += '	<li>';

		if (manual.returnValue[i].description != '')
			html += '	<b class="value">' + manual.returnValue[i].value + '</b> <span>(' + manual.returnValue[i].description + ')</span></li>';
		else
			html += '	<b>' + manual.returnValue[i].value + '</b>';

		html += '	</li>';
	}

	html += '</ul>';

	if (manual.returnType != '' && !/object|byte|bool|int|long|string/.test(manual.returnType))
		subObjects.push(manual.returnType);

	// object
	var uniqueSubObjects = [];

	for (var i = 0; i < subObjects.length; i++) {
		if (uniqueSubObjects.indexOf(subObjects[i].replace('[]', '')) < 0)
			uniqueSubObjects.push(subObjects[i].replace('[]', ''));
	}

	if (uniqueSubObjects.length > 0) {
		html += '<div class="dashed"></div>';
		html += '<h4>Object</h4>';

		for (var i = 0; i < uniqueSubObjects.length; i++)
			html += generateObjectHtml(uniqueSubObjects[i], subCodes);
	}

	// code
	var uniqueSubCodes = [];

	for (var i = 0; i < subCodes.length; i++) {
		if (uniqueSubCodes.indexOf(subCodes[i]) < 0)
			uniqueSubCodes.push(subCodes[i]);
	}

	if (uniqueSubCodes.length > 0) {
		html += '<div class="dashed"></div>';
		html += '<h4>Code</h4>';

		for (var i = 0; i < uniqueSubCodes.length; i++)
			html += generateCodeHtml(uniqueSubCodes[i]);
	}

	// blank
	html += '<p>&nbsp;</p>';

	$('.manual-contents').html(html);
}

function generateObjectHtml (name, subCodes) {
	var object = objectJson[name];
	if (!object)
		return '';

	var subObjects = [];
	var uniqueSubObjects = [];

	var html = '';
	html += '<div>';
	html += '	<h5 class="green">' + name + '</h5>';
	html += '	<p>' + object.description + '</p>';
	html += '	<table class="table-object">';
	html += '	<colgroup>';
	html += '		<col />';
	html += '		<col />';
	html += '		<col />';
	html += '		<col style="width:40px;" />';
	html += '		<col style="width:40px;" />';
	html += '		<col />';
	html += '	</colgroup>';
	html += '	<thead>';
	html += '	<tr>';
	html += '		<th>필드명</th>';
	html += '		<th>설명</th>';
	html += '		<th>타입</th>';
	html += '		<th>길이</th>';
	html += '		<th>필수</th>';
	html += '		<th>비고</th>';
	html += '	</tr>';
	html += '	</thead>';
	html += '	<tbody>';

	for (var i = 0; i < object.field.length; i++) {
		html += '<tr>';
		html += '	<td class="l nowrap">' + object.field[i].name + '</td>';
		html += '	<td class="l nowrap">' + object.field[i].description + '</td>';
		html += '	<td class="nowrap">' + object.field[i].type + '</td>';
		html += '	<td>' + object.field[i].length + '</td>';
		html += '	<td>' + object.field[i].required + '</td>';

		if (object.field[i].object) {
			var objectName = object.field[i].object;
			if (objectName.indexOf('[]') != -1)
				objectName = objectName.replace('[]', '');

			subObjects.push(objectName);
			html += '<td class="l"><b class="green">' + object.field[i].object + '</b>';

			if (object.field[i].remark != '')
				html += '<br>' + object.field[i].remark;

			html += '</td>';
		} else if (object.field[i].code) {
			subCodes.push(object.field[i].code);
			html += '<td class="l">';
			html +=	'	<b class="green">' + codeJson[object.field[i].code].description + '</b>';
			
			if (object.field[i].remark != '')
				html += '<br>' + object.field[i].remark;

			html += '</td>';
		} else
			html += '<td class="l">' + object.field[i].remark + '</td>';

		html += '</tr>';
	}

	html += '	</tbody>';
	html += '	</table>';
	html += '</div>';

	for (var i = 0; i < subObjects.length; i++) {
		if (uniqueSubObjects.indexOf(subObjects[i].replace('[]', '')) < 0)
			uniqueSubObjects.push(subObjects[i].replace('[]', ''));
	}

	for (var i = 0; i < uniqueSubObjects.length; i++)
		html += generateObjectHtml(uniqueSubObjects[i]);

	return html;
}

function generateCodeHtml (name) {
	var code = codeJson[name];
	if (!code)
		return '';

	var html = '';
	html += '<div>';
	html += '	<h5 class="green">' + code.description + '</h5>';
	html += '	<table class="table-code">';
	html += '	<colgroup>';
	html += '		<col style="width:50px;" />';
	html += '		<col />';
	html += '	</colgroup>';
	html += '	<thead>';
	html += '	<tr>';
	html += '		<th>코드</th>';
	html += '		<th>설명</th>';
	html += '	</tr>';
	html += '	</thead>';
	html += '	<tbody>';

	for (var i = 0; i < code.table.length; i++) {
		html += '<tr>';
		html += '	<td class="nowrap">' + code.table[i].code + '</td>';
		html += '	<td class="l">' + code.table[i].description + '</td>';
		html += '</tr>';
	}

	html += '	</tbody>';
	html += '	</table>';
	html += '</div>';

	return html;
}

function bindFuncSearchEvent () {
	var $errCodeViewer = $('.errcode .viewer');

	$('#FUNC').on('focus', function () {
		$(this).addClass('focus');
	}).on('blur', function () {
		$(this).removeClass('focus');
	}).on('keyup', function (e) {
		if (e.keyCode == 13)
			$('#FUNC_SEARCH').trigger('click');
	});

	$('#FUNC_SEARCH').on('click', function () {
		var keyword = $.trim($('#FUNC').val());

		if (keyword.length > 0)
			generateMethodTree(keyword);
		else {
			generateMethodTree();
			$(window).trigger('hashchange');
		}		
	});
}

function bindErrCodeEvent () {
	var $errCodeViewer = $('.errcode .viewer');

	$('#ERRCODE').on('focus', function () {
		$(this).addClass('focus');
	}).on('blur', function () {
		$(this).removeClass('focus');
	}).on('keyup', function (e) {
		if (e.keyCode == 13)
			$('#ERRCODE_SEARCH').trigger('click');
	});

	$('#ERRCODE_SEARCH').on('click', function () {
		if ($('#ERRCODE').val().length == 0) {
			$('#ERRCODE').focus();
			return;
		}

		var errCode = $('#ERRCODE').val();
		if (errCode.substr(0, 1) != '-') {
			errCode = '-' + errCode;
		}

		$errCodeViewer.find('.code').text(errCode);

		if (errcodeJson[errCode]){
			$errCodeViewer.find('.msg .notfound').hide();
			$errCodeViewer.find('.msg .found').show().find('span').html(errcodeJson[errCode]);
		}else{
			$errCodeViewer.find('.msg .found').hide();
			$errCodeViewer.find('.msg .notfound').show();
		}

		if ($errCodeViewer.css('display').toLowerCase() == 'none')
			$errCodeViewer.show();

		$('#ERRCODE').focus().select();
	});

	$('#ERRCODE_VIEWER_CLOSE').on('click', function () {
		$errCodeViewer.find('.code').text('');
		$errCodeViewer.find('.msg .found span').html('');
		$errCodeViewer.find('.msg .notfound').html('');
		$errCodeViewer.hide();
		$('#ERRCODE').focus();
	});
}

if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function (searchElement) {
		'use strict';
		if (this == null) {
			throw new TypeError();
		}
		var n, k, t = Object(this), len = t.length >>> 0;

		if (len === 0) {
			return -1;
		}
		n = 0;
		if (arguments.length > 1) {
			n = Number(arguments[1]);
			if (n != n) {
				n = 0;
			} else if (n != 0 && n != Infinity && n != -Infinity) {
				n = (n > 0 || -1) * Math.floor(Math.abs(n));
			}
		}
		if (n >= len) {
			return -1;
		}
		for (k = n >= 0 ? n : Math.max(len - Math.abs(n), 0); k < len; k++) {
			if (k in t && t[k] === searchElement) {
				return k;
			}
		}
		return -1;
	};
}