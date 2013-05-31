<script language="JavaScript" type="text/javascript">
<!--
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

<!-- BEGIN switch_advanced_qr -->

b_help = "Bold: [b]text[/b]";
i_help = "Italic: [i]text[/i]";
u_help = "Underline: [u]text[/u]";
quote_help = "Quote: [quote]text[/quote]";
code_help = "Code: [code]code[/code]";
php_help = "PHP: [php]code[/php]";
spoil_help = "Spoiler: [spoil]text[/spoil]";
img_help = "Insert Image: [img]http://image path[/img]";
url_help = "Insert URL: [url]http://hvmdesign.com[/url] or [url=http://hvmdesign.com]High Velocity Media[/url]";
fc_help = "Font Color: [color=red]text[/color] You can use HTML color=#FF0000";
fs_help = "Font Size: [size=10]Small Text[/size]";
ft_help = "Font Type: [font=Tahoma]text[/font]";
rtl_help = "Make message box align from Right to Left";
ltr_help = "Make message box align from Left to Right";
mail_help = "Insert Email: [email]forum@hvmdesign.com[/email]";
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
googlevid_help="Insert Google Video URL: [GVideo]GVideo URL[/GVideo]";
youtube_help="Insert Youtube URL: [youtube]Youtube URL[/youtube]";

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
var PHP = 0;
var youtube = 0;
var GVideo = 0;

// Fix a bug involving the TextRange object in IE. From
// http://www.frostjedi.com/terra/scripts/demo/caretBug.html
// (script by TerraFrost modified by reddog)
function initInsertions() {
    document.post.message.focus();
    var baseHeight;
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
    document.post.message.focus();
    oSelect = document.selection;
    oSelectRange = oSelect.createRange();
    if (oSelectRange.text.length < 1) { alert("Please select the text first");
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

function BBCGVideo() {
   var FoundErrors = '';
   var enterURL   = prompt("Give the URL of the page containing the Google movie", "http://");
   if (!enterURL)    {
      FoundErrors += "You did not give a URL";
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
   var enterURL   = prompt("Give the URL of the page containing the YouTube movie", "http://");
   if (!enterURL)    {
      FoundErrors += "You did not give a URL";
   }
   if (FoundErrors)  {
      alert("Error:"+FoundErrors);
      return;
   }
   var ToAdd = "[youtube]"+enterURL+"[/youtube]";
   PostWrite(ToAdd);
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
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[s]" + theSelection + "[/s]";
        document.post.message.focus();
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
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[spoil]" + theSelection + "[/spoil]";
        document.post.message.focus();
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
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[marq=up]" + theSelection + "[/marq]";
        document.post.message.focus();
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
        document.post.marqu.src = "modules/Forums/bbcode_box/images/marqu1.gif";
        marqu = 1;
    } else {
        ToAdd = "[/marq]";
        document.post.marqu.src = "modules/Forums/bbcode_box/images/marqu.gif";
        marqu = 0;
    }
    PostWrite(ToAdd);
}

function BBCmarql() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[marq=left]" + theSelection + "[/marq]";
        document.post.message.focus();
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
        document.post.marql.src = "modules/Forums/bbcode_box/images/marql1.gif";
        marql = 1;
    } else {
        ToAdd = "[/marq]";
        document.post.marql.src = "modules/Forums/bbcode_box/images/marql.gif";
        marql = 0;
    }
    PostWrite(ToAdd);
}

function BBCmarqr() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[marq=right]" + theSelection + "[/marq]";
        document.post.message.focus();
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
        document.post.marqr.src = "modules/Forums/bbcode_box/images/marqr1.gif";
        marqr = 1;
    } else {
        ToAdd = "[/marq]";
        document.post.marqr.src = "modules/Forums/bbcode_box/images/marqr.gif";
        marqr = 0;
    }
    PostWrite(ToAdd);
}

function BBCdir(dirc) {
       document.post.message.dir=(dirc);
}

function BBCfade() {
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[fade]" + theSelection + "[/fade]";
        document.post.message.focus();
        return;
        }
    }
    if (fade == 0) {
        ToAdd = "[fade]";
        document.post.fade.src = "modules/Forums/bbcode_box/images/fade1.gif";
        fade = 1;
    } else {
        ToAdd = "[/fade]";
        document.post.fade.src = "modules/Forums/bbcode_box/images/fade.gif";
        fade = 0;
    }
    PostWrite(ToAdd);
}

function BBCjustify() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[align=justify]" + theSelection + "[/align]";
        document.post.message.focus();
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
        document.post.justify.src = "modules/Forums/bbcode_box/images/justify1.gif";
        justify = 1;
    } else {
        ToAdd = "[/align]";
        document.post.justify.src = "modules/Forums/bbcode_box/images/justify.gif";
        justify = 0;
    }
    PostWrite(ToAdd);
}

function BBCleft() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[align=left]" + theSelection + "[/align]";
        document.post.message.focus();
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
        document.post.left.src = "modules/Forums/bbcode_box/images/left1.gif";
        left = 1;
    } else {
        ToAdd = "[/align]";
        document.post.left.src = "modules/Forums/bbcode_box/images/left.gif";
        left = 0;
    }
    PostWrite(ToAdd);
}

function BBCright() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[align=right]" + theSelection + "[/align]";
        document.post.message.focus();
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
        document.post.right.src = "modules/Forums/bbcode_box/images/right1.gif";
        right = 1;
    } else {
        ToAdd = "[/align]";
        document.post.right.src = "modules/Forums/bbcode_box/images/right.gif";
        right = 0;
    }
    PostWrite(ToAdd);
}

function BBCcenter() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[align=center]" + theSelection + "[/align]";
        document.post.message.focus();
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
        document.post.center.src = "modules/Forums/bbcode_box/images/center1.gif";
        center = 1;
    } else {
        ToAdd = "[/align]";
        document.post.center.src = "modules/Forums/bbcode_box/images/center.gif";
        center = 0;
    }
    PostWrite(ToAdd);
}

function BBCft() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[font="+document.post.ft.value+"]" + theSelection + "[/font]";
        document.post.message.focus();
        return;
        }
    }
    else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
    {
        mozWrap(txtarea, "[font="+document.post.ft.value+"]", "[/font]");
        return;
    }
    ToAdd = "[font="+document.post.ft.value+"]"+" "+"[/font]";
    PostWrite(ToAdd);
}

function BBCfs() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[size="+document.post.fs.value+"]" + theSelection + "[/size]";
        document.post.message.focus();
        return;
        }
    }
    else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
    {
        mozWrap(txtarea, "[size="+document.post.fs.value+"]", "[/size]");
        return;
    }
    ToAdd = "[size="+document.post.fs.value+"]"+" "+"[/size]";
    PostWrite(ToAdd);
}

function BBCfc() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[color="+document.post.fc.value+"]" + theSelection + "[/color]";
        document.post.message.focus();
        return;
        }
    }
    else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
    {
        mozWrap(txtarea, "[color="+document.post.fc.value+"]", "[/color]");
        return;
    }
    ToAdd = "[color="+document.post.fc.value+"]"+" "+"[/color]";
    PostWrite(ToAdd);
}

function BBCmarqd() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[marq=down]" + theSelection + "[/marq]";
        document.post.message.focus();
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
        document.post.marqd.src = "modules/Forums/bbcode_box/images/marqd1.gif";
        marqd = 1;
    } else {
        ToAdd = "[/marq]";
        document.post.marqd.src = "modules/Forums/bbcode_box/images/marqd.gif";
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

function helpline(help) {
    document.post.helpbox.value = eval(help + "_help");
    document.post.helpbox.readOnly = "true";
}

function checkForm() {
    formErrors = false;    
    if (document.post.message.value.length < 2) {
        formErrors = "{L_EMPTY_MESSAGE}";
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
    var txtarea = document.post.message;
    var baseHeight;
     if (is_ie && typeof(baseHeight) != 'number') baseHeight = document.selection.createRange().duplicate().boundingHeight;
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
    var txtarea = document.post.message;

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
<!-- END switch_advanced_qr -->

function storeCaret(textEl) {
    if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

function PostWrite(text) {
    if (document.post.message.createTextRange && document.post.message.caretPos) {
        var caretPos = document.post.message.caretPos;
        caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?    text + ' ' : text;
    }
    else document.post.message.value += text;
    document.post.message.focus(caretPos)
}

function BBCsup() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[sup]" + theSelection + "[/sup]";
        document.post.message.focus();
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
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[sub]" + theSelection + "[/sub]";
        document.post.message.focus();
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
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[code]" + theSelection + "[/code]";
        document.post.message.focus();
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
        document.post.code.src = "modules/Forums/bbcode_box/images/code1.gif";
        Code = 1;
    } else {
        ToAdd = "[/code]";
        document.post.code.src = "modules/Forums/bbcode_box/images/code.gif";
        Code = 0;
    }
    PostWrite(ToAdd);
}

function BBCphp() {
    var txtarea = document.post.message;
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[php]" + theSelection + "[/php]";
        document.post.message.focus();
        return;
        }
    }
    else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
    {
        mozWrap(txtarea, "[php]", "[/php]");
        return;
    }
    if (PHP == 0) {
        ToAdd = "[php]";
        document.post.php.src = "modules/Forums/bbcode_box/images/php1.gif";
        PHP = 1;
    } else {
        ToAdd = "[/php]";
        document.post.php.src = "modules/Forums/bbcode_box/images/php.gif";
        PHP = 0;
    }
    PostWrite(ToAdd);
}

function BBCquote() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[quote]" + theSelection + "[/quote]";
        document.post.message.focus();
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
        document.post.quote.src = "modules/Forums/bbcode_box/images/quote1.gif";
        Quote = 1;
    } else {
        ToAdd = "[/quote]";
        document.post.quote.src = "modules/Forums/bbcode_box/images/quote.gif";
        Quote = 0;
    }
    PostWrite(ToAdd);
}

function BBClist() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[list]" + theSelection + "[/list]";
        document.post.message.focus();
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
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[b]" + theSelection + "[/b]";
        document.post.message.focus();
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
        document.post.bold.src = "modules/Forums/bbcode_box/images/bold1.gif";
        Bold = 1;
    } else {
        ToAdd = "[/b]";
        document.post.bold.src = "modules/Forums/bbcode_box/images/bold.gif";
        Bold = 0;
    }
    PostWrite(ToAdd);
}

function BBCitalic() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[i]" + theSelection + "[/i]";
        document.post.message.focus();
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
        document.post.italic.src = "modules/Forums/bbcode_box/images/italic1.gif";
        Italic = 1;
    } else {
        ToAdd = "[/i]";
        document.post.italic.src = "modules/Forums/bbcode_box/images/italic.gif";
        Italic = 0;
    }
    PostWrite(ToAdd);
}

function BBCunder() {
    var txtarea = document.post.message;
    
    if ((clientVer >= 4) && is_ie && is_win) {
        theSelection = document.selection.createRange().text;
        if (theSelection != '') {
        document.selection.createRange().text = "[u]" + theSelection + "[/u]";
        document.post.message.focus();
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
        document.post.under.src = "modules/Forums/bbcode_box/images/under1.gif";
        Underline = 1;
    } else {
        ToAdd = "[/u]";
        document.post.under.src = "modules/Forums/bbcode_box/images/under.gif";
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
    document.post.message.value+=ToAdd;
    document.post.message.focus();
}

function storeCaret(textEl) {
    if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

// From http://www.massless.org/mozedit/
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
function sqr_show_hide()
{
    var id = 'sqr';
    var item = null;

    if (document.getElementById)
    {
        item = document.getElementById(id);
    }
    else if (document.all)
    {
        item = document.all[id];
    }
    else if (document.layers)
    {
        item = document.layers[id];
    }

    if (item && item.style)
    {
        if (item.style.display == "none")
        {
            item.style.display = "";
        }
        else
        {
            item.style.display = "none";
        }
    }
    else if (item)
    {
        item.visibility = "show";
    }
}

function sqr_show()
{
    var id = 'sqr';
    var item = null;

    if (document.getElementById)
    {
        item = document.getElementById(id);
    }
    else if (document.all)
    {
        item = document.all[id];
    }
    else if (document.layers)
    {
        item = document.layers[id];
    }

    if (item && item.style)
    {
        if (item.style.display == "none")
        {
            item.style.display = "";
        }
    }
    else if (item)
    {
        item.visibility = "show";
    }
}

//-->
</script>

<!-- BEGIN switch_open_qr_yes -->
<div id="sqr" style="display: show; position: relative; ">
<!-- END switch_open_qr_yes -->
<!-- BEGIN switch_open_qr_no -->
<div id="sqr" style="display: none; position: relative; ">
<!-- END switch_open_qr_no -->
  <form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)">
    <table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
      <tr>
        <th class="thHead" colspan="2" height="25"><strong>{L_QUICK_REPLY}</strong></th>
      </tr>
      <!-- BEGIN switch_username_select -->
      <tr>
        <td class="row1"><span class="gen"><strong>{L_USERNAME}</strong></span></td>
        <td class="row2"><span class="genmed"> <input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" />
          </span></td>
      </tr>
      <!-- END switch_username_select -->
      <tr>
        <td class="row1" width="22%"><span class="gen"><strong>{L_SUBJECT}</strong></span></td>
        <td class="row2" width="78%"> <span class="gen">
        <input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" />
          </span> </td>
      </tr>
      <tr>
        <td class="row1" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="1">
            <tr>
              <td><span class="gen"><strong>{L_MESSAGE_BODY}</strong></span> </td>
            </tr>
            <!-- BEGIN switch_advanced_qr -->
            <tr>
              <td valign="middle" align="center"> <br />
              <table width="100" border="0" cellspacing="0" cellpadding="5">
                  <tr align="center">
                    <td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><strong>{L_EMOTICONS}</strong></td>
                  </tr>
                  <!-- END switch_advanced_qr -->
                  <!-- BEGIN smilies_row -->
                  <tr align="center" valign="middle">
                    <!-- BEGIN smilies_col -->
                    <!-- <td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>-->
                    <td><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" onmouseover="this.style.cursor='pointer';" onclick="emoticon('{smilies_row.smilies_col.SMILEY_CODE}');" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></td>
                    <!-- END smilies_col -->
                  </tr>
                  <!-- END smilies_row -->
                  <!-- BEGIN switch_smilies_extra -->
                  <tr align="center">
                    <td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=500');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
                  </tr>
                  <!-- END switch_smilies_extra -->
                  <!-- BEGIN switch_advanced_qr -->
                </table>
                </td>
            </tr>
            <!-- END switch_advanced_qr -->
          </table>
      </td>
	<td class="row2" valign="top"><span class="gen"><span class="genmed"></span> 
		<table id="posttable" width="100%" border="1" bordercolor="#C0C0C0" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" valign="top">
		<!-- BEGIN switch_advanced_qr -->
		  <tr align="right" valign="middle"> 
			<td valign="center">
				<table width="100%" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
					<tr>
                        <!--<td class="row2" valign="middle"><img src="modules/Forums/bbcode_box/images/dots.gif" style="padding-left: 4px;"></td>-->
                        <td class="row2">
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td align="left" width="70%">
										<select style="height: 20px;" name="ft" onChange="BBCft()" onMouseOver="helpline('ft')">
											<option style="font-weight : bold;" selected="selected">Font type</option>
											<option value="Arial">Default font</option>
											<option style="font-family: Arial;" value="Arial" class="genmed">Arial</option> 
											<option style="font-family: Arial Black;" value="Arial Black" class="genmed">Arial Black</option> 
											<option style="font-family: Century Gothic;" value="Century Gothic" class="genmed">Century Gothic</option>
											<option style="font-family: Comic Sans MS;" value="Comic Sans MS" class="genmed">Comic Sans MS</option> 
											<option style="font-family: Courier New;" value="Courier New" class="genmed">Courier New</option>
											<option style="font-family: Georgia;" value="Georgia" class="genmed">Georgia</option> 
											<option style="font-family: Lucida Console;"value="Lucida Console">Lucida Console</option>
											<option style="font-family: Microsoft Sans Serif;" value="Microsoft Sans Serif" class="genmed">Microsoft Sans Serif</option> 
											<option style="font-family: Symbol;" value="Symbol" class="genmed">Symbol</option> 
											<option style="font-family: Tahoma;" value="Tahoma" class="genmed">Tahoma</option>
											<option style="font-family: Trebuchet;" value="Trebuchet" class="genmed">Trebuchet</option> 
											<option style="font-family: Times New Roman;" value="Times New Roman" class="genmed">Times New Roman</option> 
											<option style="font-family: Verdana;" value="Verdana" class="genmed">Verdana</option> 
										</select>
										<select style="height: 20px;" name="fs" onChange="BBCfs()" onMouseOver="helpline('fs')">
											<option style="font-weight : bold;" selected="selected">Font Size</option>
											<option style="font-size: 8;" value="8" class="genmed">{L_FONT_TINY}</option>
											<option style="font-size: 10;" value="10" class="genmed">{L_FONT_SMALL}</option>
											<option style="font-size: 12;" value="12" class="genmed">{L_FONT_NORMAL}</option>
											<option style="font-size: 18;" value="18" class="genmed">{L_FONT_LARGE}</option>
											<option style="font-size: 24;" value="24" class="genmed">{L_FONT_HUGE}</option>
										</select>
										<select style="height: 20px;" name="fc" onChange="BBCfc()" onMouseOver="helpline('fc')">
											<option style="font-weight : bold;" selected>Font Color</option>
											<option style="color:black; value="{T_FONTCOLOR1}" value="{T_FONTCOLOR1}">{L_COLOR_DEFAULT}</option>
											<option value="darkred">{L_COLOR_DARK_RED}</option>
											<option style="color:red; background-color: {T_TD_COLOR1}" value="red" class="genmed">{L_COLOR_RED}</option>
											<option style="color:orange; background-color: {T_TD_COLOR1}" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
											<option style="color:brown; background-color: {T_TD_COLOR1}" value="brown" class="genmed">{L_COLOR_BROWN}</option>
											<option style="color:yellow; background-color: {T_TD_COLOR1}" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
											<option style="color:green; background-color: {T_TD_COLOR1}" value="green" class="genmed">{L_COLOR_GREEN}</option>
											<option style="color:olive; background-color: {T_TD_COLOR1}" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
											<option style="color:cyan; background-color: {T_TD_COLOR1}" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
											<option style="color:blue; background-color: {T_TD_COLOR1}" value="blue" class="genmed">{L_COLOR_BLUE}</option>
											<option style="color:darkblue; background-color: {T_TD_COLOR1}" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
											<option style="color:indigo; background-color: {T_TD_COLOR1}" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
											<option style="color:violet; background-color: {T_TD_COLOR1}" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
											<option style="color:white; background-color: {T_TD_COLOR1}" value="white" class="genmed">{L_COLOR_WHITE}</option>
											<option style="color:black; background-color: {T_TD_COLOR1}" value="black" class="genmed">{L_COLOR_BLACK}</option>
										</select>
									</td>
									<td align="right" width="30%"><a href="http://hvmdesign.com/" class="gensmall" title="Advanced BBCode Box v5.0.0 MOD - by Disturbed One - www.HVMDesign.com" target="blank">&copy;</a></td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr height="28">
                        <!--<td class="row2" valign="middle"><img src="modules/Forums/bbcode_box/images/dots.gif" style="padding-left: 4px;"></td>-->
                        <td class="row2" valign="middle">
                            <img src="modules/Forums/bbcode_box/images/justify.gif" class="postimage" name="justify" type="image" onClick="BBCjustify()" onMouseOver="helpline('justify')" alt="justify"><img border="0" src="modules/Forums/bbcode_box/images/right.gif" name="right" type="image" onClick="BBCright()" onMouseOver="helpline('right')" class="postimage" alt="right"><img border="0" src="modules/Forums/bbcode_box/images/center.gif" name="center" type="image" onClick="BBCcenter()" onMouseOver="helpline('center')" class="postimage" alt="center"><img border="0" src="modules/Forums/bbcode_box/images/left.gif" name="left" type="image" onClick="BBCleft()" onMouseOver="helpline('left')" class="postimage" alt="left"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/sup.gif" class="postimage" name="supscript" type="image" onClick="BBCsup()" onMouseOver="helpline('sup')" alt="" /><img border="0" src="modules/Forums/bbcode_box/images/sub.gif" name="subs" class="postimage" type="image" onClick="BBCsub()" onMouseOver="helpline('sub')" alt="" /><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/bold.gif" name="bold" type="image" onClick="BBCbold()" onMouseOver="helpline('b')" class="postimage" alt="bold"><img border="0" src="modules/Forums/bbcode_box/images/italic.gif" name="italic" type="image" onClick="BBCitalic()" onMouseOver="helpline('i')" class="postimage" alt="italic"><img border="0" src="modules/Forums/bbcode_box/images/under.gif" name="under" type="image" onClick="BBCunder()" onMouseOver="helpline('u')" class="postimage" alt="under line"><img border="0" src="modules/Forums/bbcode_box/images/strike.gif" class="postimage" name="strik" type="image" onClick="BBCstrike()" onMouseOver="helpline('strike')" alt="" /><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/fade.gif" name="fade" type="image" onClick="BBCfade()" onMouseOver="helpline('fade')" class="postimage" alt="fade"><img border="0" src="modules/Forums/bbcode_box/images/grad.gif" name="grad" type="image" onClick="BBCgrad()" onMouseOver="helpline('grad')" class="postimage" alt="gradient"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/rtl.gif" name="dirrtl" type="image" onClick="BBCdir('rtl')" onMouseOver="helpline('rtl')" class="postimage" alt="Right to Left"><img border="0" src="modules/Forums/bbcode_box/images/ltr.gif" name="dirltr" type="image" onClick="BBCdir('ltr')" onMouseOver="helpline('ltr')" class="postimage" alt="Left to Right"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/marqd.gif" name="marqd" type="image" onClick="BBCmarqd()" onMouseOver="helpline('marqd')" class="postimage" alt="Marque to down"><img border="0" src="modules/Forums/bbcode_box/images/marqu.gif" name="marqu" type="image" onClick="BBCmarqu()" onMouseOver="helpline('marqu')" class="postimage" alt="Marque to up"><img border="0" src="modules/Forums/bbcode_box/images/marql.gif" name="marql" type="image" onClick="BBCmarql()" onMouseOver="helpline('marql')" class="postimage" alt="Marque to left"><img border="0" src="modules/Forums/bbcode_box/images/marqr.gif" name="marqr" type="image" onClick="BBCmarqr()" onMouseOver="helpline('marqr')" class="postimage" alt="Marque to right">
                        </td>
                    </tr>
                    <tr height="28">
                        <!--<td class="row2" valign="middle"><img src="modules/Forums/bbcode_box/images/dots.gif" style="padding-left: 4px;"></td>-->
                        <td class="row2" valign="middle">
                            <img border="0" src="modules/Forums/bbcode_box/images/code.gif" name="code" type="image" onClick="BBCcode()" onMouseOver="helpline('code')" class="postimage" alt="Code"><img border="0" src="modules/Forums/bbcode_box/images/php.gif" name="php" type="image" onClick="BBCphp()" onMouseOver="helpline('php')" class="postimage" alt="Php"><img border="0" src="modules/Forums/bbcode_box/images/quote.gif" name="quote" type="image" onClick="BBCquote()" onMouseOver="helpline('quote')" class="postimage" alt="Quote"><img border="0" src="modules/Forums/bbcode_box/images/spoil.gif" class="postimage" name="spoil" type="image" onClick="BBCspoil()" onMouseOver="helpline('spoil')" alt="" /><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/url.gif" name="url" type="image" onClick="BBCurl()" onMouseOver="helpline('url')" class="postimage" alt="URL"><img border="0" src="modules/Forums/bbcode_box/images/email.gif" name="email" type="image" onClick="BBCmail()" onMouseOver="helpline('mail')" class="postimage" alt="Email"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="20" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/img.gif" name="img" type="image" onClick="BBCimg()" onMouseOver="helpline('img')" class="postimage" alt="Image"><img border="0" src="modules/Forums/bbcode_box/images/flash.gif" name="flash" type="image" onClick="BBCflash()" onMouseOver="helpline('flash')" class="postimage" alt="Flash"><img border="0" src="modules/Forums/bbcode_box/images/video.gif" name="video" type="image" onClick="BBCvideo()" onMouseOver="helpline('video')" class="postimage" alt="Video"><img border="0" src="modules/Forums/bbcode_box/images/sound.gif" name="stream" type="image" onClick="BBCstream()" onMouseOver="helpline('stream')" class="postimage" alt="Stream"><img border="0" src="modules/Forums/bbcode_box/images/ram.gif" name="ram" type="image" onClick="BBCram()" onMouseOver="helpline('ram')" class="postimage" alt="Real Media"><img border="0" src="modules/Forums/bbcode_box/images/googlevid.gif" name="GVideo" type="image" onClick="BBCGVideo()" onMouseOver="helpline('googlevid')" class="postimage" alt="GoogleVid"><img border="0" src="modules/Forums/bbcode_box/images/youtube.gif" name="youtube" type="image" onClick="BBCyoutube()" onMouseOver="helpline('youtube')" class="postimage" alt="Youtube"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/list.gif" name="listdf" type="image" onClick="BBClist()" onMouseOver="helpline('list')" class="postimage" alt="List" /><img border="0" src="modules/Forums/bbcode_box/images/hr.gif" name="hr" type="image" onClick="BBChr()" onMouseOver="helpline('hr')" class="postimage" alt="H-Line"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/plain.gif" name="plain" type="image" onClick="BBCplain()" onMouseOver="helpline('plain')" class="postimage" alt="Remove BBcode">
                        </td> 
                    </tr>
                </table>
			</td>
		  </tr>
		  <tr> 
			<td colspan="9"><span class="gensmall"> 
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:100%; font-size:10px" class="helpline" value="{L_STYLES_TIP}" /></span>
			 </td>
		  </tr>
		  <!-- END switch_advanced_qr -->
		  <tr> 
			<td colspan="9">
				<span class="gen"><textarea name="message" rows="15" cols="35" wrap="virtual" style="width:100%; border: 0px;" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea></span>
			</td>
		  </tr>
			
          </table>
          </span></td>
      </tr>
      <!-- BEGIN switch_advanced_qr -->
      <tr>
        <td class="row1" valign="top"><span class="gen"><strong>{L_OPTIONS}</strong></span><br /><span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
        <td class="row2"><span class="gen"> </span>
        <table cellspacing="0" cellpadding="1" border="0">
          <!-- BEGIN switch_html_checkbox -->
          <tr> 
            <td> 
              <input type="checkbox" name="disable_html" {S_HTML_CHECKED} value="ON" />
            </td>
            <td><span class="gen">{L_DISABLE_HTML}</span></td>
          </tr>
          <!-- END switch_html_checkbox -->
          <!-- BEGIN switch_bbcode_checkbox -->
          <tr> 
            <td> 
              <input type="checkbox" name="disable_bbcode" {S_BBCODE_CHECKED} value="ON" />
            </td>
            <td><span class="gen">{L_DISABLE_BBCODE}</span></td>
          </tr>
          <!-- END switch_bbcode_checkbox -->
          <!-- BEGIN switch_smilies_checkbox -->
          <tr> 
            <td> 
              <input type="checkbox" name="disable_smilies" {S_SMILIES_CHECKED} value="ON" />
            </td>
            <td><span class="gen">{L_DISABLE_SMILIES}</span></td>
          </tr>
          <!-- END switch_smilies_checkbox -->
          <!-- BEGIN switch_signature_checkbox -->
          <tr> 
            <td> 
              <input type="checkbox" name="attach_sig" {S_SIGNATURE_CHECKED} value="ON" />
            </td>
            <td><span class="gen">{L_ATTACH_SIGNATURE}</span></td>
          </tr>
          <!-- END switch_signature_checkbox -->
          <!-- BEGIN switch_notify_checkbox -->
          <tr> 
            <td> 
              <input type="checkbox" name="notify" {S_NOTIFY_CHECKED} value="ON" />
            </td>
            <td><span class="gen">{L_NOTIFY_ON_REPLY}</span></td>
          </tr>
          <!-- END switch_notify_checkbox -->
          <!-- BEGIN switch_lock_topic -->
          <tr> 
            <td> 
              <input type="checkbox" name="lock" {S_LOCK_CHECKED} value="ON" />
            </td>
            <td><span class="gen">{L_LOCK_TOPIC}</span></td>
          </tr>
          <!-- END switch_lock_topic -->
          <!-- BEGIN switch_unlock_topic -->
          <tr> 
            <td> 
              <input type="checkbox" name="unlock" {S_UNLOCK_CHECKED} value="ON" />
            </td>
            <td><span class="gen">{L_UNLOCK_TOPIC}</span></td>
          </tr>        

          <!-- END switch_unlock_topic -->

          </table></td>
      </tr>
      <!-- END switch_advanced_qr -->
    <tr> 
      <td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FORM_FIELDS}<input type="submit" tabindex="5" name="preview" class="mainoption" value="{L_PREVIEW}" />&nbsp;&nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" /></td>
    </tr>
  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
    <tr> 
      <td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
    </tr>
  </table>
</form>
</div>