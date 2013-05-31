


<script language="JavaScript">
<!-- Hide the script from old browsers --
  function MakeArray(n){
    this.length=n;
    for(var i=1; i<=n; i++) this[i]=i-1;
    return this
  }

  hex=new MakeArray(16);
  hex[11]="A"; hex[12]="B"; hex[13]="C"; hex[14]="D";
  hex[15]="E"; hex[16]="F";

  function ToHex(x){  // Changes a int to hex (in the range 0 to 255)
    var high=x/16;
    var s=high+"";        //1
    s=s.substring(0,2);   //2 the combination of these = trunc funct.
    high=parseInt(s,10);  //3
    var left=hex[high+1]; // left part of the hex-value
    var low=x-high*16;    // calculate the rest of the values
    s=low+"";             //1
    s=s.substring(0,2);   //2 the combination of these = trunc funct.
    low=parseInt(s,10);   //3
    var right=hex[low+1]; // right part of the hex-value
    var string=left+""+right; // add the high and low together
    return string;
  }

  function fadein(text){
    text=text.substring(3,text.length-4); 
                          // gets rid of the HTML-comment-tags
    color_d1=255;         // any value in 'begin' 0 to 255
    mul=color_d1/text.length;
    for(i=0;i<text.length;i++){
      color_d1=mul*i;
      // some other things you can try>>
      // "=255-mul*i" to fade out, "=mul*i" to fade in, 
      // or try "255*Math.sin(i/(text.length/3))"
      color_h1=ToHex(color_d1);
      color_d2=mul*i;
      color_h2=ToHex(color_d2);
      document.write("<FONT COLOR='#FF"+color_h1+color_h2+"'>"
        +text.substring(i,i+1)+'</FONT>');
    }
  }
  // --End Hiding Here -->
</script>
<br>


  <script language="JavaScript">
  <!--
    {fadein("-->THIS IS WHERE YOUR TEXT GOES<!__");} 
  //-->
  </script>










<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>&copy; PNC 4.0.</title>
<style type="text/css">
<!--
.style2 {font-family: Geneva, Arial, Helvetica, sans-serif}
-->
</style>
</head>

<body>
<div align="center">
  <p><img src="pict/PNC.jpg" width="159" height="115"><br>
  </p>
  <p>Features, modules list:<br>
  </p>
  <table width="496" border="1">
  <tr>
    <td width="146"><div align="left">4nLAN</div></td>
    <td width="334">Module to display next LANS</td>
  </tr>
  <tr>
    <td><div align="left">Content</div></td>
    <td>Display home made text </td>
  </tr>
  <tr>
    <td><div align="left">Docs</div></td>
    <td>Add docs / TOs etc to your site </td>
  </tr>
  <tr>
    <td><div align="left">Donations</div></td>
    <td>Gain donations by users, on Paypal Account </td>
  </tr>
  <tr>
    <td><div align="left"> Downloads</div></td>
    <td>NSN GR Downloads</td>
  </tr>
  <tr>
    <td><div align="left">FAQ</div></td>
    <td>Add FAQ and answers </td>
  </tr>
  <tr>
    <td><div align="left">Groups</div></td>
    <td>NSN Groups</td>
  </tr>
  <tr>
    <td><div align="left">Maps</div></td>
    <td>Map Manager 2.0 </td>
  </tr>
  <tr>
    <td><div align="left">Members List</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">News</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">NukeSentinel</div></td>
    <td>Nuke Security module v2.5.03 </td>
  </tr>
  <tr>
    <td><div align="left">private messages </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">Recommend Us </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">Search</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">ShoutBox</div></td>
    <td>Shout Box 5.8 bu ourscripts.net </td>
  </tr>
    <tr>
    <td><div align="left">SQuery</div></td>
    <td>Disply your server info on ur website (new fully intergrated into phpnuke) </td>
  </tr>
    <tr>
    <td><div align="left">Statistics</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">Stories Archive</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">Submit Downloads </div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">Submit News </div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">Supporters</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left"> Surveys</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">Teamspeak</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">Ventrilo</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">vWar</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">vWar Account</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">vWar Sig Web Links </div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">Who is Where </div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><div align="left">XFire </div></td>
    <td>&nbsp;</td>
  </tr>
      <tr>
    <td><div align="left">Your Account </div></td>
    <td>&nbsp;</td>
  </tr>

</table>

</div>
</body>
</html>
