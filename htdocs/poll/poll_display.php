<?Php
//***************************************
// This is downloaded from www.plus2net.com //
/// You can distribute this code with the link to www.plus2net.com ///
//  Please don't  remove the link to www.plus2net.com ///
// This is for your learning only not for commercial use. ///////
//The author is not responsible for any type of loss or problem or damage on using this script.//
/// You can use it at your own risk. /////
//*****************************************

session_start();
$s_id=session_id();
require "config.php";
//////////////////////////////
/* Read the session id to 
display the poll result link 
*/


$count=$dbo->prepare("select s_id from plus_poll_ans where s_id='$s_id'");
$count->execute();
$no=$count->rowCount();
//echo $no;
if($no <=0 ){
echo "<a href=view_poll_result.php>View the poll result</a>";
}


/* You can keep the parts below inside the else area if you don't want to 
show the form for the visitors who have already participated in the poll
*/
$qst_id=1; // Change this ID for a different poll
$count=$dbo->prepare("select * from plus_poll where qst_id=:qst_id");
$count->bindParam(":qst_id",$qst_id,PDO::PARAM_INT,1);
if($count->execute()){
//echo " Success <br>";
$query = $count->fetch(PDO::FETCH_OBJ);
}


//$query=mysql_fetch_object(mysql_query("select * from plus_poll where qst_id=$qst_id"));
echo "
<form method=post action=poll_displayck.php>
<input type=hidden name=qst_id value=$qst_id>
<table border='1' cellspacing='0'  bordercolor='#ffff00' width='320' id='AutoNumber1'>
  <tr>
    <td width='100%' bgcolor='#ffff00'><font face='Verdana' size='2' >$query->qst</font></td>
  </tr>
  <tr>
    <td width='100%' >
    <table border='0' cellspacing='0'  bordercolor='#111111' width='100%'  cellpadding='0'>
      <tr bgcolor='#f1f1f1'>
        <td width='10%'><input type='radio' value='$query->opt1'  name='opt'></td>
        <td width='90%'><font face='Verdana' size='2' >$query->opt1</font></td>
      </tr>
      <tr>
        <td width='10%'><input type='radio' value='$query->opt2'  name='opt'></td>
        <td width='90%'><font face='Verdana' size='2' >$query->opt2</font></td>
      </tr>
      <tr bgcolor='#f1f1f1'>
        <td width='10%'><input type='radio' value='$query->opt3'  name='opt'></td>
        <td width='90%'><font face='Verdana' size='2' >$query->opt3</font></td>
      </tr>
      <tr>
        <td width='10%'><input type='radio' value='$query->opt4'  name='opt'></td>
        <td width='90%'><font face='Verdana' size='2' >$query->opt4</font></td>
      </tr>
    </table>
    </td>
  </tr>
<tr>
    <td width='100%' bgcolor='#ffff00' align=center>
<font face='Verdana' size='2' ><input type=submit value=Submit></form></td>
  </tr>

</table>
";
/* End of the form displaying the poll question and its four options for selection */
?>

<center>
<a href=poll_display.php>Display Poll</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href=view_poll_result.php>View Result</a>
<br><br><a href='http://www.plus2net.com'>PHP SQL HTML free tutorials and scripts</a></center> 


