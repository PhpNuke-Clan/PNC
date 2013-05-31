var theSelection = false;

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

var baseHeight = 0;

b_help = "Bold: [b]text[/b]";
i_help = "Italic: [i]text[/i]";
u_help = "Underline: [u]text[/u]";
quote_help = "Quote: [quote]text[/quote]";
code_help = "Code: [code]code[/code]";
spoil_help = "Spoiler: [spoil]text[/spoil]";
img_help = "Insert Image: [img]http://image path[/img]";
url_help = "Insert URL: [url]http://www.tactic.be[/url] or [url=http://www.tactic.be]Freddies site[/url]";
fc_help = "Font Color: [color=red]text[/color] You can use HTML color=#FF0000";
fs_help = "Font Size: [size=10]Small Text[/size]";
ft_help = "Font Type: [font=Tahoma]text[/font]";
rtl_help = "Make message box align from Right to Left";
ltr_help = "Make message box align from Left to Right";
mail_help = "Insert Email: [email]forum@tactic.be[/email]";
grad_help="Insert gradient text (Internet Explorer Only)";
right_help="set text align to right: [align=right]text[/align]";
left_help="set text align to left: [align=left]text[/align]";
center_help="set text align to center: [align=center]text[/align]";
justify_help="justify text: [align=justify]text[/align]";
marqr_help="Marque text to Right: [marq=right]text[/marq]";
marql_help="Marque text to Left: [marq=left]text[/marq]";
marqu_help="Marque text to up: [marq=up]text[/marq]";
marqd_help="Marque text to down: [marq=down]text[/marq]";
stream_help="Insert stream file: [stream]File URL[/stream]";
ram_help="Insert Real Media file: [ram]File URL[/ram]";
web_help="Insert Web Page into the post : [web]Page URL[/web]";
plain_help="Remove BBCodes from the selected text";
hr_help="Insert Line Break [hr]";
video_help="Insert video file: [video width=# height=#]file URL[/video]";
flash_help="Insert flash file: [flash width=# height=#]flash URL[/flash]";
fade_help = "Fade text: [fade]text[/fade] (Internet Explorer Only)";
list_help = "Ordered list: [list|=1|a]text[/list] Tip: you can use [*] to insert bullet";
strike_help = "Strike text: [s]text[/s]";
sup_help = "Superscript: [sup]text[/sup]";
sub_help = "Subscript: [sub]text[/sub]";
symbol_help = "Insert Symbol Into Post";
youtube_help = "Post a youtube-movie";
googlevid_help = "Post a google video";

var Quote = 0;
var Bold  = 0;
var Italic = 0;
var Underline = 0;
var Code = 0;
var flash = 0;
var fc = 0;
var fs = 0;
var ft = 0;
var center = 0;
var right = 0;
var left = 0;
var justify = 0;
var fade = 0;
var marqd = 0;
var marqu = 0;
var marql = 0;
var marqr = 0;
var mail = 0;
var web = 0;
var video = 0;
var stream = 0;
var ram = 0;
var hr = 0;
var grad = 0;
var plain = 0;
var List = 0;
var Strikeout = 0;
var Spoiler = 0;
var superscript = 0;
var subscript = 0;
var symbol = 0;
var youtube = 0;
var GVideo = 0;

// Fix a bug involving the TextRange object in IE. From
// http://www.frostjedi.com/terra/scripts/demo/caretBug.html
// (script by TerraFrost modified by reddog)
function initInsertions() {
	document.preview.signature.focus();
	if (is_ie && typeof(baseHeight) != 'number') baseHeight = document.selection.createRange().duplicate().boundingHeight;
}

function BBCplain() {
theSelection = document.selection.createRange().text;
                if (theSelection != '') {
                       temp = theSelection;
                       temp = temp.replace(/\[FLASH=([^\]]*)\]WIDTH=[0-9]{0,4} HEIGHT=[0-9]{0,4}\[\/FLASH\]/gi,"$1");
          temp = temp.replace(/\[VIDEO=([^\]]*)\]WIDTH=[0-9]{0,4} HEIGHT=[0-9]{0,4}\[\/VIDEO\]/gi,"$1");
  document.selection.createRange().text = temp.replace(/\[[^\]]*\]/gi,"");
      }
}

function BBCgrad() {
    var oSelect,oSelectRange;
    document.preview.signature.focus();
    oSelect = document.selection;
    oSelectRange = oSelect.createRange();
    if (oSelectRange.text.length < 1) { alert("Select text first");
return;
}
    if (oSelectRange.text.length > 120) {
      alert("This only works for less than 120 letters");
      return;
    }
    showModalDialog("modules/Forums/bbcode_box/grad.htm",oSelectRange,"help:no; center:yes; status:no; dialogHeight:50px; dialogWidth:50px");
}

function BBChr() {
	ToAdd = "[hr]";
	PostWrite(ToAdd);
}

function BBCram() {
        var FoundErrors = '';
        var enterURL   = prompt("Please write real media file URL","http://");
        if (!enterURL) {
                FoundErrors += " You didn't write the file URL.";
        }
 	var enterW   = prompt("Enter the real media file width", "220");
	if (!enterW)    {
		FoundErrors += " You didn't enter the real media file width.";
	}
	var enterH   = prompt("Enter the real media file height", "140");
	if (!enterH)    {
		FoundErrors += " You didn't enter the real media file height.";
	}
	if (FoundErrors)  {
		alert("Error:"+FoundErrors);
		return;
	}
	var ToAdd = "[ram width="+enterW+" height="+enterH+"]"+enterURL+"[/ram]";
	PostWrite(ToAdd);
}

function BBCstream() {
        var FoundErrors = '';
        var enterURL   = prompt("Please write stream file URL","http://");
        if (!enterURL) {
                FoundErrors += " You didn't write the file URL.";
        }
        if (FoundErrors) {
                alert("Error:"+FoundErrors);
                return;
        }
        var ToAdd = "[stream]"+enterURL+"[/stream]";
        PostWrite(ToAdd);
}

function BBCvideo() {
	var FoundErrors = '';
	var enterURL   = prompt("Please Enter the video file URL", "http://");
	if (!enterURL)    {
		FoundErrors += " You didn't write the file URL.";
	}
		var enterW   = prompt("Enter the video file width", "400");
	if (!enterW)    {
		FoundErrors += " You didn't enter the video file width.";
	}
	var enterH   = prompt("Enter the video file height", "350");
	if (!enterH)    {
		FoundErrors += " You didn't enter the video file height.";
	}
	if (FoundErrors)  {
		alert("Error:"+FoundErrors);
		return;
	}
	var ToAdd = "[video width="+enterW+" height="+enterH+"]"+enterURL+"[/video]";
	PostWrite(ToAdd);
}

function BBCweb() {
        var FoundErrors = '';
        var enterURL   = prompt("Please enter page URL","http://");
        if (!enterURL) {
                FoundErrors += "You didn't write the page URL";
        }
        if (FoundErrors) {
                alert("Error :"+FoundErrors);
                return;
        }
        var ToAdd = "[web]"+enterURL+"[/web]";
        document.preview.signature.value+=ToAdd;
        document.preview.signature.focus();
}

function BBCmail() {
        var FoundErrors = '';
        var entermail   = prompt("Enter the Email Address","");
        if (!entermail) {
                FoundErrors += " You didn't write the Email Address.";
        }
        if (FoundErrors) {
                alert("Error:"+FoundErrors);
                return;
        }
        var ToAdd = "[email]"+entermail+"[/email]";
        PostWrite(ToAdd);
}

function BBCstrike() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[s]" + theSelection + "[/s]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[s]", "[/s]");
		return;
	}
	if (Strikeout == 0) {
		ToAdd = "[s]";
		document.strik.src = "modules/Forums/bbcode_box/images/strike1.gif";
		Strikeout = 1;
	} else {
		ToAdd = "[/s]";
		document.strik.src = "modules/Forums/bbcode_box/images/strike.gif";
		Strikeout = 0;
	}
	PostWrite(ToAdd);
}

function BBCspoil() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[spoil]" + theSelection + "[/spoil]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[spoil]", "[/spoil]");
		return;
	}
	if (Spoiler == 0) {
		ToAdd = "[spoil]";
		document.spoil.src = "modules/Forums/bbcode_box/images/spoil1.gif";
		Spoiler = 1;
	} else {
		ToAdd = "[/spoil]";
		document.spoil.src = "modules/Forums/bbcode_box/images/spoil.gif";
		Spoiler = 0;
	}
	PostWrite(ToAdd);
}

function BBCmarqu() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[marq=up]" + theSelection + "[/marq]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[marq=up]", "[/marq]");
		return;
	}
	if (marqu == 0) {
		ToAdd = "[marq=up]";
		document.preview.marqu.src = "modules/Forums/bbcode_box/images/marqu1.gif";
		marqu = 1;
	} else {
		ToAdd = "[/marq]";
		document.preview.marqu.src = "modules/Forums/bbcode_box/images/marqu.gif";
		marqu = 0;
	}
	PostWrite(ToAdd);
}

function BBCmarql() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[marq=left]" + theSelection + "[/marq]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[marq=left]", "[/marq]");
		return;
	}
	if (marql == 0) {
		ToAdd = "[marq=left]";
		document.preview.marql.src = "modules/Forums/bbcode_box/images/marql1.gif";
		marql = 1;
	} else {
		ToAdd = "[/marq]";
		document.preview.marql.src = "modules/Forums/bbcode_box/images/marql.gif";
		marql = 0;
	}
	PostWrite(ToAdd);
}

function BBCmarqr() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[marq=right]" + theSelection + "[/marq]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[marq=right]", "[/marq]");
		return;
	}
	if (marqr == 0) {
		ToAdd = "[marq=right]";
		document.preview.marqr.src = "modules/Forums/bbcode_box/images/marqr1.gif";
		marqr = 1;
	} else {
		ToAdd = "[/marq]";
		document.preview.marqr.src = "modules/Forums/bbcode_box/images/marqr.gif";
		marqr = 0;
	}
	PostWrite(ToAdd);
}

function BBCdir(dirc) {
       document.preview.signature.dir=(dirc);
}

function BBCfade() {
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[fade]" + theSelection + "[/fade]";
		document.preview.signature.focus();
		return;
		}
	}
	if (fade == 0) {
		ToAdd = "[fade]";
		document.preview.fade.src = "modules/Forums/bbcode_box/images/fade1.gif";
		fade = 1;
	} else {
		ToAdd = "[/fade]";
		document.preview.fade.src = "modules/Forums/bbcode_box/images/fade.gif";
		fade = 0;
	}
	PostWrite(ToAdd);
}

function BBCjustify() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[align=justify]" + theSelection + "[/align]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[align=justify]", "[/align]");
		return;
	}
	if (justify == 0) {
		ToAdd = "[align=justify]";
		document.preview.justify.src = "modules/Forums/bbcode_box/images/justify1.gif";
		justify = 1;
	} else {
		ToAdd = "[/align]";
		document.preview.justify.src = "modules/Forums/bbcode_box/images/justify.gif";
		justify = 0;
	}
	PostWrite(ToAdd);
}

function BBCleft() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[align=left]" + theSelection + "[/align]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[align=left]", "[/align]");
		return;
	}
	if (left == 0) {
		ToAdd = "[align=left]";
		document.preview.left.src = "modules/Forums/bbcode_box/images/left1.gif";
		left = 1;
	} else {
		ToAdd = "[/align]";
		document.preview.left.src = "modules/Forums/bbcode_box/images/left.gif";
		left = 0;
	}
	PostWrite(ToAdd);
}

function BBCright() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[align=right]" + theSelection + "[/align]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[align=right]", "[/align]");
		return;
	}
	if (right == 0) {
		ToAdd = "[align=right]";
		document.preview.right.src = "modules/Forums/bbcode_box/images/right1.gif";
		right = 1;
	} else {
		ToAdd = "[/align]";
		document.preview.right.src = "modules/Forums/bbcode_box/images/right.gif";
		right = 0;
	}
	PostWrite(ToAdd);
}

function BBCcenter() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[align=center]" + theSelection + "[/align]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[align=center]", "[/align]");
		return;
	}
	if (center == 0) {
		ToAdd = "[align=center]";
		document.preview.center.src = "modules/Forums/bbcode_box/images/center1.gif";
		center = 1;
	} else {
		ToAdd = "[/align]";
		document.preview.center.src = "modules/Forums/bbcode_box/images/center.gif";
		center = 0;
	}
	PostWrite(ToAdd);
}

function BBCft() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[font="+document.preview.ft.value+"]" + theSelection + "[/font]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[font="+document.preview.ft.value+"]", "[/font]");
		return;
	}
	ToAdd = "[font="+document.preview.ft.value+"]"+" "+"[/font]";
	PostWrite(ToAdd);
}

function BBCfs() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[size="+document.preview.fs.value+"]" + theSelection + "[/size]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[size="+document.preview.fs.value+"]", "[/size]");
		return;
	}
	ToAdd = "[size="+document.preview.fs.value+"]"+" "+"[/size]";
	PostWrite(ToAdd);
}

function BBCfc() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[color="+document.preview.fc.value+"]" + theSelection + "[/color]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[color="+document.preview.fc.value+"]", "[/color]");
		return;
	}
	ToAdd = "[color="+document.preview.fc.value+"]"+" "+"[/color]";
	PostWrite(ToAdd);
}

function BBCmarqd() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[marq=down]" + theSelection + "[/marq]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[marq=down]", "[/marq]");
		return;
	}
	if (marqd == 0) {
		ToAdd = "[marq=down]";
		document.preview.marqd.src = "modules/Forums/bbcode_box/images/marqd1.gif";
		marqd = 1;
	} else {
		ToAdd = "[/marq]";
		document.preview.marqd.src = "modules/Forums/bbcode_box/images/marqd.gif";
		marqd = 0;
	}
	PostWrite(ToAdd);
}

function BBCflash() {
	var FoundErrors = '';
	var enterURL   = prompt("Enter the flash file URL", "http://");
	if (!enterURL)    {
		FoundErrors += " You didn't write the flash file URL.";
	}
	var enterW   = prompt("Enter the flash width", "250");
	if (!enterW)    {
		FoundErrors += " You didn't write the flash width.";
	}
	var enterH   = prompt("Enter the flash height", "250");
	if (!enterH)    {
		FoundErrors += " You didn't write the flash height.";
	}
	if (FoundErrors)  {
		alert("Error:"+FoundErrors);
		return;
	}
	var ToAdd = "[flash width="+enterW+" height="+enterH+"]"+enterURL+"[/flash]";
	PostWrite(ToAdd);
}

function BBCGVideo() {
	var FoundErrors = '';
	var enterURL   = prompt("Enter the movie URL", "http://");
	if (!enterURL)    {
		FoundErrors += " You didn't write the file URL";
	}
	if (FoundErrors)  {
		alert("Error:"+FoundErrors);
		return;
	}
	var ToAdd = "[GVideo]"+enterURL+"[/GVideo]";
	PostWrite(ToAdd);
}

function BBCyoutube() {
	var FoundErrors = '';
	var enterURL   = prompt("Enter the movie URL", "http://");
	if (!enterURL)    {
		FoundErrors += " You didn't write the file URL";
	}
	if (FoundErrors)  {
		alert("Error:"+FoundErrors);
		return;
	}
	var ToAdd = "[youtube]"+enterURL+"[/youtube]";
	PostWrite(ToAdd);
}

function helpline(help) {
	document.preview.helpbox.value = eval(help + "_help");
	document.preview.helpbox.readOnly = "true";
}

function checkForm() {
	formErrors = false;    
	if (document.preview.signature.value.length < 2) {
		formErrors = "You must enter a message when posting";
	}
	if (formErrors) {
		alert(formErrors);
		return false;
	} else {
		//formObj.preview.disabled = true;
		//formObj.submit.disabled = true;
		return true;
	}
}

function emoticon(text) {
	var txtarea = document.preview.signature;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		if (baseHeight != txtarea.caretPos.boundingHeight) {
			txtarea.focus();
			storeCaret(txtarea);
		}
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else
	if (txtarea.selectionEnd && (txtarea.selectionStart | txtarea.selectionStart == 0))
	{ 
		mozWrap(txtarea, text, "");
		return;
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.preview.signature;

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
}

function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

function PostWrite(text) {
	if (document.preview.signature.createTextRange && document.preview.signature.caretPos) {
		var caretPos = document.preview.signature.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?	text + ' ' : text;
	}
	else document.preview.signature.value += text;
	document.preview.signature.focus(caretPos)
}

function BBCsup() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[sup]" + theSelection + "[/sup]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[sup]", "[/sup]");
		return;
	}
	if (superscript == 0) {
		ToAdd = "[sup]";
		document.supscript.src = "modules/Forums/bbcode_box/images/sup1.gif";
		superscript = 1;
	} else {
		ToAdd = "[/sup]";
		document.supscript.src = "modules/Forums/bbcode_box/images/sup.gif";
		superscript = 0;
	}
	PostWrite(ToAdd);
}

function BBCsub() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[sub]" + theSelection + "[/sub]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[sub]", "[/sub]");
		return;
	}
	if (subscript == 0) {
		ToAdd = "[sub]";
		document.subs.src = "modules/Forums/bbcode_box/images/sub1.gif";
		subscript = 1;
	} else {
		ToAdd = "[/sub]";
		document.subs.src = "modules/Forums/bbcode_box/images/sub.gif";
		subscript = 0;
	}
	PostWrite(ToAdd);
}

function BBCcode() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[code]" + theSelection + "[/code]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[code]", "[/code]");
		return;
	}	
	if (Code == 0) {
		ToAdd = "[code]";
		document.preview.code.src = "modules/Forums/bbcode_box/images/code1.gif";
		Code = 1;
	} else {
		ToAdd = "[/code]";
		document.preview.code.src = "modules/Forums/bbcode_box/images/code.gif";
		Code = 0;
	}
	PostWrite(ToAdd);
}

function BBCquote() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[quote]" + theSelection + "[/quote]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[quote]", "[/quote]");
		return;
	}
	if (Quote == 0) {
		ToAdd = "[quote]";
		document.preview.quote.src = "modules/Forums/bbcode_box/images/quote1.gif";
		Quote = 1;
	} else {
		ToAdd = "[/quote]";
		document.preview.quote.src = "modules/Forums/bbcode_box/images/quote.gif";
		Quote = 0;
	}
	PostWrite(ToAdd);
}

function BBClist() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[list]" + theSelection + "[/list]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[list]", "[/list]");
		return;
	}
	if (List == 0) {
		ToAdd = "[list]";
		document.listdf.src = "modules/Forums/bbcode_box/images/list1.gif";
		List = 1;
	} else {
		ToAdd = "[/list]";
		document.listdf.src = "modules/Forums/bbcode_box/images/list.gif";
		List = 0;
	}
	PostWrite(ToAdd);
}

function BBCbold() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[b]" + theSelection + "[/b]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[b]", "[/b]");
		return;
	}
	if (Bold == 0) {
		ToAdd = "[b]";
		document.preview.bold.src = "modules/Forums/bbcode_box/images/bold1.gif";
		Bold = 1;
	} else {
		ToAdd = "[/b]";
		document.preview.bold.src = "modules/Forums/bbcode_box/images/bold.gif";
		Bold = 0;
	}
	PostWrite(ToAdd);
}

function BBCitalic() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[i]" + theSelection + "[/i]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[i]", "[/i]");
		return;
	}
	if (Italic == 0) {
		ToAdd = "[i]";
		document.preview.italic.src = "modules/Forums/bbcode_box/images/italic1.gif";
		Italic = 1;
	} else {
		ToAdd = "[/i]";
		document.preview.italic.src = "modules/Forums/bbcode_box/images/italic.gif";
		Italic = 0;
	}
	PostWrite(ToAdd);
}

function BBCunder() {
	var txtarea = document.preview.signature;
	
	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (theSelection != '') {
		document.selection.createRange().text = "[u]" + theSelection + "[/u]";
		document.preview.signature.focus();
		return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, "[u]", "[/u]");
		return;
	}
	if (Underline == 0) {
		ToAdd = "[u]";
		document.preview.under.src = "modules/Forums/bbcode_box/images/under1.gif";
		Underline = 1;
	} else {
		ToAdd = "[/u]";
		document.preview.under.src = "modules/Forums/bbcode_box/images/under.gif";
		Underline = 0;
	}
	PostWrite(ToAdd);
}

function BBCurl() {
	var FoundErrors = '';
	var enterURL   = prompt("Enter the URL", "http://");
	var enterTITLE = prompt("Enter the page name", "Web Page Name");
	if (!enterURL)    {
		FoundErrors += " You didn't write the URL.";
	}
	if (!enterTITLE)  {
		FoundErrors += " You didn't write the page name.";
	}
	if (FoundErrors)  {
		alert("Error:"+FoundErrors);
		return;
	}
	var ToAdd = "[url="+enterURL+"]"+enterTITLE+"[/url]";
	PostWrite(ToAdd);
}

function BBCimg() {
	var FoundErrors = '';
	var enterURL   = prompt("Enter the image URL","http://");
	if (!enterURL) {
		FoundErrors += "You didn't write the image URL";
	}
	if (FoundErrors) {
		alert("Error :"+FoundErrors);
		return;
	}
	var ToAdd = "[img]"+enterURL+"[/img]";
	document.preview.signature.value+=ToAdd;
	document.preview.signature.focus();
}

function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2) 
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}