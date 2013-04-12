function showBookData(bookId){
	var pars = "module=books&func=showBookData&bookId=" + bookId;
	wait();
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: showBookData_response,
		onFailure: showBookData_failure
	});
}

function showBookData_failure(){

}

function showBookData_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('theme_content', json.content).innerHTML;
}

function catalogue(order,filter,init,filterValue,history){
	var pars = "module=books&func=catalogue&order=" + order + "&filter=" + filter + '&init=' + init + "&filterValue=" + filterValue + "&history=" + history;
	wait();
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: catalogue_response,
		onFailure: catalogue_failure
	});
}

function catalogue_failure(){
}

function catalogue_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('theme_content', json.content).innerHTML;
}

function wait(){
	Element.update('theme_content', '<center><img src="modules/books/pnimages/wait.gif" /></center>').innerHTML;
}

function addPrefer(bookId){
	var pars = "module=books&func=addPrefer&bookId=" + bookId;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: addPrefer_response,
		onFailure: addPrefer_failure
	});
}

function addPrefer_failure(){
}

function addPrefer_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('prefered', json.content).innerHTML;
}


function delPrefer(bookId){
	var pars = "module=books&func=delPrefer&bookId=" + bookId;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: delPrefer_response,
		onFailure: delPrefer_failure
	});
}

function delPrefer_failure(){
}

function delPrefer_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	$('bookPrefered_' + json.bookId).toggle();
}

function addComment(bookId,history){
	var pars = "module=books&func=addComment&bookId=" + bookId + "&history=" + history;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: addComment_response,
		onFailure: addComment_failure
	});
}

function addComment_failure(){
}

function addComment_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('theme_content', json.content).innerHTML;
}

function sendComment(){
	var f = document.sendC;
	var pars = "module=books&func=sendComment&bookId=" + f.bookId.value + "&commentText=" + f.commentText.value + "&history=" + f.history.value;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: sendComment_response,
		onFailure: sendComment_failure
	});
}

function sendComment_failure(){
}

function sendComment_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('theme_content', json.content).innerHTML;
}

function collections(bookId){
	var pars = "module=books&func=collections";
	wait();
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: collections_response,
		onFailure: collections_failure
	});
}

function collections_failure(){
}

function collections_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('theme_content', json.content).innerHTML;
}

function searchReload(filter,filterValue,order){
	var pars = "module=books&func=searchReload&filter=" + filter + "&filterValue=" + filterValue + "&order=" + order;
	Element.update('searchIcon', '<img src="modules/books/pnimages/wait.gif" />').innerHTML;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: searchReload_response,
		onFailure: searchReload_failure
	});
}

function searchReload_failure(){
}

function searchReload_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('search', json.content).innerHTML;
}


function autocomplete(filter,value,order){
	if(value.length > 1){
		var pars = "module=books&func=autocomplete&value=" + value + "&filter=" + filter + "&order=" + order;
		var myAjax = new Ajax.Request("ajax.php", 
		{
			method: 'get', 
			parameters: pars, 
			onComplete: autocomplete_response,
			onFailure: autocomplete_failure
		});
	}else{
		hideAutoCompete();
	}
}

function autocomplete_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	if(json.count > 0){
		showAutoCompete();
		Element.update('autocompletediv', json.values).innerHTML;
	}else{
		hideAutoCompete();
	}
}

function autocomplete_failure(){

}

function hideAutoCompete(){
	$('autocompletediv').style.visibility = "hidden";
}

function showAutoCompete(){
	$('autocompletediv').style.visibility = "visible";
}

function add(value){
	document.searchForm.filterValue.value = value;
	Element.update('autocompletediv', '').innerHTML;
	$('autocompletediv').style.visibility = "hidden";
}

classic1 = new Image();
classic1.src = "../llibre/themes/classic/view.png";
workbook1 = new Image();
workbook1.src = "../llibre/themes/workbook/view.png";
modern1 = new Image();
modern1.src = "../llibre/themes/modern/view.png";
marble1 = new Image();
marble1.src = "../llibre/themes/marble/view.png";
leaves1 = new Image();
leaves1.src = "../llibre/themes/leaves/view.png";
stars1 = new Image();
stars1.src = "../llibre/themes/stars/view.png";


function changeImg(img1,img2){
	img1.src = eval(img2+'1').src;
}

function manage(bookId){
	var pars = "module=books&func=manage";
	wait();
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: manage_response,
		onFailure: manage_failure
	});
}

function manage_failure(){

}

function manage_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('theme_content', json.content).innerHTML;
}

function allowUser(task,userName){
	var pars = "module=books&func=showCreators&task=" + task + "&userName=" + userName;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: allowUser_response,
		onFailure: allowUser_failure
	});
}

function allowUser_failure(){
}

function allowUser_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('creatorsList', json.content).innerHTML;
}

function createNewBook(){
	var f=document.forms["newBook"];
	var error = false;
	if(f.tllibre.value == '' && f.importBook.checked == false){
		alert(noBookTitle);
		error = true;
	}
	if(f.importBook.checked && f.importFile.value == '' && !error){
		alert(noImportFile);
		error = true;
	}
	if(f.mailxtec.value == '' && !error){
		alert(noAdminUser);
		error = true;
	}
	if(!f.confirm[1].checked && !error){
		alert(noRulesAccepted);
		error = true;
	}
	if(!error){
		f.submit();
	}
}

function editExistingBook(){
	var f=document.forms["editBook"];
	var error = false;
	if(f.bookTitle.value == ''){
		alert(noBookTitle);
		error = true;
	}
	if(f.bookAdminName.value == '' && !error){
		alert(noAdminUser);
		error = true;
	}
	if(!error){
		f.submit();
	}
}

function exportBook(){
	if(document.forms["newBook"].importBook.checked){
		Element.removeClassName('importFile', 'pn-hide');
	}else{
		Element.addClassName('importFile', 'pn-hide');
	}
	$('mainBookInfo').toggle();
}

function editDescriptor(did){
	var pars = "module=books&func=editDescriptor&did=" + did;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: editDescriptor_response,
		onFailure: editDescriptor_failure
	});
}

function editDescriptor_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('descriptor_' + json.did, json.content).innerHTML;
}

function editDescriptor_failure(){

}

function updateDescriptor(did, value){
	var pars = "module=books&func=updateDescriptor&did=" + did + "&value=" + value;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: updateDescriptor_response,
		onFailure: updateDescriptor_failure
	});
}

function updateDescriptor_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('descriptor_' + json.did, json.content).innerHTML;
}

function updateDescriptor_failure(){
	
}

function deleteDescriptor(did){
	var pars = "module=books&func=deleteDescriptor&did=" + did;
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: deleteDescriptor_response,
		onFailure: deleteDescriptor_failure
	});
}

function deleteDescriptor_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	$('row_' + json.did).toggle();
}

function deleteDescriptor_failure(){
	
}

function descriptors(){
    var pars = "module=books&func=descriptors";
    wait();
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: descriptors_response,
		onFailure: descriptors_failure
	});
}

function descriptors_response(req){
	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('theme_content', json.content).innerHTML;
}

function descriptors_failure(){
	
}
