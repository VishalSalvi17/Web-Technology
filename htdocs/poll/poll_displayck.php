<?php

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
$opt=$_POST['opt'];
$qst_id=$_POST['qst_id'];
if(!isset($opt)){echo "<font face='Verdana' size='2' color=red>Please select one option and then submit</font>";}
else{

$sql=$dbo->prepare("insert into plus_poll_ans(s_id,qst_id,opt)  values(:s_id,:qst_id,:opt)");
$sql->bindParam(':s_id',$s_id,PDO::PARAM_STR, 100);
$sql->bindParam(':qst_id',$qst_id,PDO::PARAM_INT, 1);
$sql->bindParam(':opt',$opt,PDO::PARAM_STR,2);
if($sql->execute()){
//$mem_id=$dbo->lastInsertId(); 
echo "Thanks for your views, Please <a href=view_poll_result.php>click here to view the poll result</a> or click here to visit the <a href=poll_display.php>php poll script tutorial</a>";
}
else{
echo " Not able to add data please contact Admin ";
}

//$qt=mysql_query("insert into plus_poll_ans(s_id,qst_id,opt) values('$s_id',$qst_id,'$opt')");
//echo mysql_error();
}

?>



<center>
<a href=poll_display.php>Display Poll</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href=view_poll_result.php>View Result</a>
<br><br><a href='http://www.plus2net.com'>PHP SQL HTML free tutorials and scripts</a></center> 
