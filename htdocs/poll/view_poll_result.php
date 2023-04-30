<?Php
//***************************************
// This is downloaded from www.plus2net.com //
/// You can distribute this code with the link to www.plus2net.com ///
//  Please don't  remove the link to www.plus2net.com ///
// This is for your learning only not for commercial use. ///////
//The author is not responsible for any type of loss or problem or damage on using this script.//
/// You can use it at your own risk. /////
//*****************************************

require "config.php";
//////////////////////////////
echo "<font size='2' face='Verdana' color='#000000'> The  Poll from plus2net.com ( Poll ID = 1)</font>";

$qst_id=1; // change this to change the poll 

/* Find out the question first */

$count=$dbo->prepare("select qst from plus_poll where qst_id=:qst_id");
$count->bindParam(":qst_id",$qst_id,PDO::PARAM_INT,3);

if($count->execute()){
//echo " Success <br>";
$row = $count->fetch(PDO::FETCH_OBJ);
}else{
echo "Database Problem";
}
echo "<br><b><br>$row->qst</b><br>"; // display the question
/* for percentage calculation we will find out the total number
 of answers ( options submitted ) given by the visitors */

$count=$dbo->prepare("select ans_id from plus_poll_ans where qst_id=:qst_id");
$count->bindParam(":qst_id",$qst_id,PDO::PARAM_INT,3);
$count->execute();
$rt=$count->rowCount();
echo " No of records = ".$rt; 

/* Find out the answers and display the graph */
$sql="select count(*) as no,qst,plus_poll_ans.opt from plus_poll,plus_poll_ans where plus_poll.qst_id=plus_poll_ans.qst_id and plus_poll.qst_id='$qst_id' group by opt";

echo "<table cellpadding='0' cellspacing='0' border='0' >";
 
foreach ($dbo->query($sql) as $noticia) {
 echo "<tr>
    <td width='40%' bgcolor='#F1F1F1'>&nbsp;<font size='1' face='Verdana' color='#000000'>$noticia[opt]</font></td>";
$width2=$noticia['no'] *10 ; /// change here the multiplicaiton factor //////////
$ct=($noticia[no]/$rt)*100;
$ct=sprintf ("%01.2f", $ct); // number formating 

echo "    <td width='10%' bgcolor='#F1F1F1'>&nbsp;<font size='1' face='Verdana' color='#000000'>($ct %)</font></td><td width='50%' bgcolor='#F1F1F1'>&nbsp;<img src='graph.jpg' height=10 width=$width2></td>
  </tr>";
 echo "<tr>
    <td  bgcolor='#ffffff' colspan=2></td></tr>";
//echo $noticia['sel'],$noticia[no]."<br>";
}
echo "</table>";
echo "</font>";


?>
<center>
<a href=poll_display.php>Display Poll</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href=view_poll_result.php>View Result</a>
<br><br><a href='http://www.plus2net.com' rel='nofollow'>Poll script from plus2net.com- free tutorials and scripts</a></center> 
