<?php
session_start();
//***************************************************************************
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                           */
//***************************************************************************
$step = $_GET['step'];
if($step == "") {
$step = "";
}
$pncv = "4.5.0";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php
echo"<title>PNC 2.1.1/3.0.x and PHPNUKE 7.6 to PNC $pncv UPDATE FILE</title>
<META NAME=\"RATING\" CONTENT=\"GENERAL\">";

echo"<META NAME=\"GENERATOR\" CONTENT=\"PNC $pncv http://phpnuke-clan.net\">";
?>
<style type="text/css">
/*<![CDATA[*/
 body.c1 {background-color:#E2E2E2}
 div.c1 {text-align: center}
 input.c1 {width:300px;}
 p.c1 {font-weight: bold}
 span.c1 {font-size:small;}
 span.c2 {color:red;font-weight:bold;}
 span.c3 {color:blue;font-weight:bold;}
/*]]>*/
</style>
</head>
  <body class="c1">
  <img src="PNC_logo.png" border="0" alt="" />
    <h2>
    <?php
      echo"PNC&trade; &copy; 2006, 2007 - PNC $pncv";
      ?>
    </h2>
    <span class="c2">Welcome to the PNC update/installer</u> </span>

<?php
ini_set('display_errors','on');
ini_set('mysql.connect_timeout',120);

?>
<hr />
        <p>Make sure you have read the Guide <?php echo $pncv; ?> which came with this package. <font color=red>Especailly make sure you chmod all the files properly per the Guide.</font></p>
    <p>What would you like to do, please select to update or install, To update to PNC<?php echo "$pncv"; ?> you need to update from the version you are using now. </p>
    <p><font color=red>If you are Upgrading it is recommended that you install and run the FixGroups script (found in Extras Folder) prior to ugrading the site. However, you may also run it after upgrading. Lastly if Upgrading you must add the following line to your config.php file: $vwarmodname ="vwar";</font></p>
    <hr />
    <table>
      <tr>
        <td>

          <form method="post" action="installSQL.php">
            <b>Option 1 -</b> <input class="c1" type="submit" value="Clean PNC <?php echo $pncv; ?> installation" />
            &nbsp;&nbsp;<span class="c3"></span>
          </form>        </td>
      </tr>
      <tr>
        <td>

          <form method="post" action="UPDATE/index.php">
            <b>Option 2  -</b>
            <input class="c1" type="submit"  value="Update PNC 4.x to PNC <?php echo $pncv; ?> Core Tables" />
            &nbsp;&nbsp;<span class="c3"></span>
          </form>        </td>
      </tr>
      <tr>
        <td>

          <form method="post" action="302-400.php">
            <b>Option 3  -</b>
            <input class="c1" type="submit"  value="Update PNC 3.0.2 to PNC <?php echo $pncv; ?> Core Tables" />
            &nbsp;&nbsp;<span class="c3"></span>
          </form>        </td>
      </tr>
                <tr>
        <td>

          <form method="post" action="301to302.php">
            <b>Option 4  -</b>
            <input class="c1" type="submit" value="Update PNC 3.0.1 to PNC 3.0.2 Core Tables" />
            &nbsp;&nbsp;<span class="c3"></span>
          </form>        </td>
      </tr>
                <tr>
        <td>

          <form method="post" action="300bto301.php">
            <b>Option 5  -</b>
            <input class="c1" type="submit" value="Update PNC 3.0.0b to PNC 3.0.1 Core Tables" />
            &nbsp;&nbsp;<span class="c3"></span>
          </form>        </td>
      </tr>
                        <tr>
        <td>

          <form method="post" action="211to301.php">
            <b>Option 6  -</b>
            <input class="c1" type="submit" value="Update PNC 2.1.1 to PNC 3.0.1 Core Tables" />
            &nbsp;&nbsp;<span class="c3"></span>
          </form>        </td>
      </tr>
      <tr>
        <td>

          <form method="post" action="n76topnc4.php">
            <b>Option 7  -</b>
            <input class="c1" type="submit"  value="Update PHPNUKE 7.6 to PNC<?php echo $pncv; ?> Core Tables" />
            &nbsp;&nbsp;<span class="c3"></span>
          </form>        </td>
      </tr>
    </table>
<?php
?>
