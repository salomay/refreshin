function set_action(param, act)
{
  param.form.act.value = act;
  param.form.target = '_self';
  param.form.submit();
}

function set_action2(param, action, act)
{
  param.form.action = action;
  param.form.act.value = act;
  param.form.target = '_self';
  param.form.submit();
}

function set_action3(param, action, act, target)
{
  param.form.action = action;
  param.form.act.value = act;
  param.form.target = target;
  param.form.submit();
}

function select_all(param)
{
	
    form_length = param.form.length
    for (i=0;i<form_length;i++)
    {
		if (param.form[i].type == 'checkbox')
        {
            param.form[i].checked = param.form['p_all'].checked
        }
    }
}

function check_max_input(param, index, max_length)
{
    if (param.form(index).value.length > max_length)
    {
	    param.form(index).value = param.form(index).value.substring(0,max_length);
    }
}

function disable_form_element(frm, str_element)
{
	elements = str_element.split(',');
	for (i=0; i < elements.length; i++)
	{
		frm[elements[i]].disabled = true;
	}
}

function enable_form_element(frm, str_element)
{
	elements = str_element.split(',');
	for (i=0; i < elements.length; i++)
	{
		frm[elements[i]].disabled = false;
	}
}


function jump_url(url)
{ 
    document.location = url;
}

function over(element) {
element.style.borderStyle= "solid";
element.style.borderWidth = "1px";
element.style.borderColor = "#000000";
element.style.backgroundColor = "#F1F1F1";
element.style.cursor = "hand";
}

function out(element) {
element.style.borderColor = "#CCCCCC";
element.style.backgroundColor = "#CCCCCC"
element.style.cursor = "default";
}

function cmdExec(cmd,opt,halaman) {
if (opt==null) halaman.document.execCommand(cmd);
  else halaman.document.execCommand(cmd,"",opt);
//pageHTML.document.execCommand(cmd,"",opt);
halaman.focus();
}

function createLink(halaman) {
cmdExec("CreateLink",halaman);
}

function insert(what,halaman)
{
   //DBG(1, 'insert(' + what + ')');
   // Chose action based on what is being inserted.
   switch(what)
   {
   case "table":
      strPage = "dlg_ins_table.html";
      strAttr = "status:no;dialogWidth:340px;dialogHeight:360px;help:no";
      break;
   case "smile":
      strPage = "dlg_ins_smile.html";
      strAttr = "status:no;dialogWidth:300px;dialogHeight:350px;help:no";
      break;
   case "char":
      strPage = "dlg_ins_char.html";
      strAttr = "status:no;dialogWidth:450px;dialogHeight:290px;help:no";
      break;
   case "image":
      strPage = "dlg_ins_image.php";
      strAttr = "status:no;dialogWidth:400px;dialogHeight:200px;help:no";' '
      break;
   case "about":
      strPage = "dlg_about.html";
      strAttr = "status:no;dialogWidth:500px;dialogHeight:405px;help:no";' '
      break;
   }

   // run the dialog that implements this type of element
   html = showModalDialog(strPage, window, strAttr);

   // and insert any result into the document.
   if (html) {
      insertHtml(html,halaman);
   }
}

// insertHtml(): Insert the supplied HTML into the current position
// within the document.
function insertHtml(html,halaman)
{
   halaman.focus();
   var sel = halaman.document.selection.createRange();
   // don't try to insert HTML into a control selection (ie. image or table)
   if (halaman.document.selection.type == 'Control') {
      return;
   }
   sel.pasteHTML(html);
}

function myConcat(separator,text) {
	while (text.indexOf('.') != -1) text = text.replace('.','');
	while (text.indexOf('-') != -1) text = text.replace('-','');
	while (text.indexOf(',') != -1) text = text.replace(',','');
	result=""; // initialize list
	hasil="";
	j=0;
	// iterate through arguments
	for (var i=text.length; i>=0; i--) {
	j++;
		if ((j % 3)==1 && (j>1) && (i!=0)) {
			result += text.charAt(i) + separator;
		}
		else 
		{
			result += text.charAt(i);
		}
	}
	for (var i=result.length; i>=0; i--) {
		hasil += result.charAt(i);
	}
	return hasil;
}

function Sambung(kalimat)
{
	re = "\.";
	nama = kalimat.split(re);
	aku="";
	for (i=0;i<nama.length;i++)
	{
		aku += nama[i];
	}
	return aku;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

/* AJAX FUNCTION */

function createRequestObject(){
	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		/* Create the object using MSIE's method */
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		/* Create the object using other browser's method */
		request_o = new XMLHttpRequest();
	}
	return request_o; //return the object
}

var xmlhttp = createXMLRequestObject();

function createXMLRequestObject(){
	var xmlhttp = false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		//alert ("You are using Microsoft Internet Explorer.");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			//alert ("You are using Microsoft Internet Explorer");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
		//alert ("You are not using Microsoft Internet Explorer");
	}
	return xmlhttp;
}

/* JAVASCRIPT COOKIES */
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
/* END OF COOKIE */

// RESIZE
function resize(){  
	var frame = document.getElementById("frame1");  
	var htmlwidth = 600;//document.body.parentNode.scrollWidth;  
	//var htmlwidth = 1024;
	//var windowwidth = 
	/*window.innerWidth-1004;  */
	var windowwidth=600;
	if ( htmlwidth < windowwidth ) {  
		frame.style.width = windowwidth + "px";
	}else{  
		frame.style.width = htmlwidth + "px";
	}  
} 
