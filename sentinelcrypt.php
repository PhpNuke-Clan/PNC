<form method='post'>
Enter password to be encrypted using crypt(): <input name='pw'><br /><br />
Enter the 'salt' value for the encryption (2 long): <input name='salt' maxlength='2'><br /><br />
<input type='submit' name='submit' value='Encrypt'><br /><br />
<?
if (isset($_POST['submit'])&&isset($_POST['pw'])&&!empty($_POST['pw'])) {
   echo "Password <b>".$_POST['pw']."</b> translated is <b>".crypt($_POST['pw'],$_POST['salt'])."</b>";
}
?>