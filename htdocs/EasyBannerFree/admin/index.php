<?PHP

#####################################################################
##                                                                 ##
##                       Easy Banner Free                          ##
##                 http://www.phpwebscripts.com/                   ##
##                 e-mail: info@phpwebscripts.com                  ##
##                                                                 ##
##                       copyright (c) 2005                        ##
##                                                                 ##
##                    This script is freeware                      ##
##                                                                 ##
##                You may distribute it by any way                 ##
##                   BUT! You may not modify it!                   ##
## Removing the link to PHPWebScripts.com is a copyright violation.##
##   Altering or removing any of the code that is responsible, in  ##
##   any way, for generating that link is strictly forbidden.      ##
##   Anyone violating the above policy will have their license     ##
##   terminated on the spot.  Do not remove that link - ever.      ##
##                                                                 ##
#####################################################################

include('./functions.php');
switch ($_GET[action]) {
case 'left_frame'				: left_frame();
case 'admin_right_frame_home'	: admin_right_frame_home(); 
case 'show_users'				: show_users($_GET[what]);
case 'user_details'				: user_details($_GET[user]);
case 'statistic_reset'			: statistic_reset();
case 'admin_login_data_edit'	: admin_login_data_edit(''); 
case 'configuration_edit'		: configuration_edit(); 
}
switch ($_POST[action]) {
case 'user_edited'				: user_edited($_POST);
case 'user_approved'			: user_approved($_POST[user]);
case 'user_deleted'				: user_deleted($_POST[user]);
case 'statistic_reseted'		: statistic_reseted();
case 'admin_login_data_edited'	: admin_login_data_edited($_POST); 
case 'configuration_edited'		: configuration_edited($_POST); 
}

#########################################################################

function home_page() { 
global $s;
echo '<html>
<head>
<title>Easy Banner - Administration</title>
<base target="_self"></head>
<frameset rows="1*" cols="140, 1*" border="0">
<frame name="left" scrolling="auto" marginwidth="0" marginheight="0" src="index.php?action=left_frame" frameBorder=no Resize>
<frame name="right" scrolling="auto" src="index.php?action=admin_right_frame_home" Resize frameBorder=NO>
</frameset>
</html>';
}

#########################################################################

function left_frame() { global $s; admin_ih(); ?><table border=0 cellpadding=0 cellspacing=0 width="100%"><tr><td align="center" valign="top"><br><table border=0 width=95% cellspacing=2 cellpadding=0>
<TR><TD align="left" nowrap><span class="text13"><b>Menu</b><br>
<a target="right" href="index.php?action=show_users&what=all">All users</a><br>
<a target="right" href="index.php?action=show_users&what=approved">Approved users</a><br>
<a target="right" href="index.php?action=show_users&what=noapr">Unapproved users</a><br>
<a target="right" href="index.php?action=statistic_reset">Reset stats</a><br>
<a target="right" href="index.php?action=configuration_edit">Configuration</a><br>
<a target="right" href="index.php?action=admin_login_data_edit">Username/pass</a><br><br>
<a target="_top" href="index.php?action=admin_log_off">Log off</a><br>
</td></tr></table></center><?PHP admin_ift(); }

#########################################################################

function show_users($what) {
global $s; if ($what == 'all') { $q = dq("select * from $s[tblname] order by number",1); $info = 'All'; }
elseif ($what == 'approved') { $q = dq("select * from $s[tblname] where approved = 1 order by number",1); $info = 'Approved'; }
elseif ($what == 'noapr') { $q = dq("select * from $s[tblname] where approved = 0 order by number",1); $info = 'Unapproved'; }
admin_ih();
echo eot($info.' Users','Sorted by join date');
echo '<table border="0" width="650" cellspacing="0" cellpadding="2" class="table1">
<tr>
<TD align="left" valign="top"><span class="text10"><b>Username</b></span></TD>
<TD align="center" valign="top" nowrap><span class="text10">URL</span></TD>
<TD align="center" valign="top" nowrap><span class="text10">Impressions sent<br>by this user</span></TD>
<TD align="center" valign="top" nowrap><span class="text10">Impressions received<br>by this user</span></TD>
<TD align="center" valign="top" nowrap><span class="text10">Impressions<br>unused</span></TD>
<TD align="center" valign="top" nowrap><span class="text10">Joined</span></TD>
</TR>';
while ($data = mysql_fetch_assoc($q))
{ echo '<TR>
  <TD align="left"><a title="Click to view/edit details" href="index.php?action=user_details&user='.$data[username].'" class="link10"><b>'.$data[username].'</b></a></TD>
  <TD align="center"><a title="Click to go to users site ('.$data[siteurl].')" target="_blank" href="'.$data[siteurl].'" class="link10">URL</a></TD>
  <TD align="center"><span class="text10">'.$data[i_m].'</span></TD><TD align="center"><span class="text10">'.$data[i_w].'</span></TD>
  <TD align="center"><span class="text10">'.$data[i_nu].'</span></TD>
  <TD align="center" nowrap><span class="text10">'.$data[date].'</span></TD>
  </TR>';
  $xzobr = $xzobr + $data[i_m]; $xmy = $xmy + $data[i_w]; $xnep = $xnep + $data[i_nu];
}
echo '<tr>
<TD colspan=2 align="left"><span class="text10"><b>TOTAL</b></span></TD>
<TD align="center"><span class="text10"><b>'.$xzobr.'</b></span></TD>
<TD align="center"><span class="text10"><b>'.$xmy.'</b></span></TD>
<TD align="center"><span class="text10"><b>'.$xnep.'</b></span></TD>
<TD>&nbsp;</TD></TR></table>';
admin_ift();
}

#########################################################################

function user_approved($user) { global $s; dq("update $s[tblname] set approved = 1 where username = '$user'",0); $s[info] = iot('Selected user has been approved'); user_details($user); }
function user_edited($data) { global $s; $q = dq("update $s[tblname] set siteurl = '$data[siteurl]',urlbanner = '$data[urlbanner]',email = '$data[email]',password = '$data[password]' where username = '$data[user]'",0); $s[info] = iot('Selected user has been edited'); user_details($data[user]); }
function user_deleted($user) { global $s; dq("delete from $s[tblname] where username = '$user'",0); admin_ih(); echo iot('Selected user has been deleted'); admin_ift(); }

#########################################################################

function user_details($user) { global $s; $q = dq("select * from $s[tblname] where username = '$user'",1); $data = mysql_fetch_assoc($q); if ($data[approved] == 1) $jeschvaleny = 'approved';
else { $jeschvaleny = 'not approved'; $schvalbutton = '<form METHOD="post" action="index.php"><input type="hidden" name="action" value="user_approved"><input type="hidden" name="user" value="'.$user.'"><input type="submit" name="co" value="Approve this user" class="button10" style="width=120"></form>';	}
if (!$data[username]) admin_problem('Selected user does not exist');
$cas = date ("Y-m-j, H:i:s"); admin_ih(); echo $s[info].'<span class="text13b_bold"><b>User '.$data[username].'</span></b><br><span class="text13">This user is '.$jeschvaleny.'</span><br>'.
$schvalbutton.'<form method="POST" action="index.php"><input type="hidden" name="action" value="user_deleted"><input type="hidden" name="user" value="'.$user.'"><INPUT type=submit value="Delete this user" name="co" class="button10" style="width=120"></form>';
?><table border="0" width="500" cellspacing="2" cellpadding="4" class="table1"><tr><td colspan=2 align="center"><span class="text13b_bold"><b>User Details</b></span></td></tr>
<tr><td align="left" nowrap><span class="text13">URL</span></td><td align="left" nowrap><span class="text13"><a target="_blank" href="<?PHP echo "$data[siteurl]\">$data[siteurl]"; ?></a></span></td></tr>
<tr><td align="left" nowrap><span class="text13">Email</span></td><td align="left" nowrap><span class="text13"><a href="mailto:<?PHP echo "$data[email]\">$data[email]"; ?></a></span></td></tr>
<tr><td align="left" nowrap><span class="text13">Password</span></td><td align="left" nowrap><span class="text13"><?PHP echo $data[password]; ?></span></td></tr>
<tr><td align="left" nowrap><span class="text13">Date joined</span></td><td align="left" nowrap><span class="text13"><?PHP echo $data[date]; ?></span></td></tr>
<tr><td colspan="2" nowrap align="center"><span class="text13">Banner</span><br><?PHP echo "<img width=\"$s[width]\" height=\"$s[height]\" src=\"$data[urlbanner]\">"; ?></td></tr></table>
<br><table border="0" width="500" cellspacing="2" cellpadding="4" class="table1"><tr><td colspan=2 align="center"><span class="text13b_bold"><b>Statistic</b></span></td></tr>
<tr><td align="left" nowrap><span class="text13">Banners displayed by this user </span></td><td align="left" nowrap><span class="text13"><?PHP echo $data[i_m]; ?></span></td></tr>
<tr><td align="left" nowrap><span class="text13">Credits earned </span></td><td align="left" nowrap><span class="text13"><?PHP echo $data[i_earned]; ?></span></td></tr>
<tr><td align="left" nowrap><span class="text13">Banners displayed for this user </span></td><td align="left" nowrap><span class="text13"><?PHP echo $data[i_w]; ?></span></td></tr>
<tr><td align="left" nowrap><span class="text13">Unused credits </span></td><td align="left" nowrap><span class="text13"><?PHP echo $data[i_nu]; ?></span></td></tr></table><br>
<form method="POST" action="index.php"><input type="hidden" name="action" value="user_edited"><input type="hidden" name="user" value="<?PHP echo $data[username]; ?>">
<table border="0" width="500" cellspacing="2" cellpadding="4" class="table1"><tr><td nowrap colspan=2 align="center"><span class="text13b_bold">Edit user details</b></span></td></tr>
<tr><td align="left" nowrap><span class="text13">URL</span></td><td align="left" nowrap><INPUT maxLength=255 size=60 name="siteurl" value="<?PHP echo $data[siteurl]; ?>" class="field11"></td></tr>
<tr><td align="left" nowrap><span class="text13">Banner URL</span></td><td align="left" nowrap><INPUT maxLength=255 size=60 name="urlbanner" value="<?PHP echo $data[urlbanner]; ?>" class="field11"></td></tr>
<tr><td align="left" nowrap><span class="text13">Email</span></td><td align="left" nowrap><INPUT maxLength=255 size=60 name="email" value="<?PHP echo $data[email]; ?>" class="field11"></td></tr>
<tr><td align="left" nowrap><span class="text13">Password</span></td><td align="left" nowrap><INPUT maxLength=15 size=15 name="password" value="<?PHP echo $data[password]; ?>" class="field11"></td></tr><tr>
<td align="middle" width="100%" colSpan=2><INPUT type="submit" value="Save" class="button10"></span></TD></TR></TBODY></TABLE></FORM><?PHP admin_ift(); }

#########################################################################

function configuration_edit() {
global $info; include("../data/data.php"); admin_ih();
reset ($s); while (list ($key, $val) = each ($s)) { $s[$key] = str_replace(chr(92),'',$val); $s[$key] = htmlspecialchars($s[$key]); if (!$s[$key]) $s[$key] = ''; } 
$ratio = $s[ratio]*100; echo $info;
echo '<span class="text13b_bold"><b>Configuration</b></span><br><span class="text10">Do not use these characters: <b> \ $</b> in any of your values</span><br><br>
<form method="POST" action="index.php"><input type="hidden" name="action" value="configuration_edited">
<table border="0" width="620" cellspacing="0" cellpadding="5" class="table1"><tr><td align="center">
<table border="0" width="600" cellspacing="0" cellpadding="2">
<form method="POST" action="index.php"><input type="hidden" name="action" value="configuration_edited">
<tr><td align="left"><span class="text13">Mysql database host</span></td><td align="left"><INPUT size=30 name="dbhost" value="'.$s[dbhost].'" class="field11"></td></tr>
<tr><td align="left"><span class="text13">Mysql database username</span></td><td align="left"><INPUT size=30 name="dbusername" value="'.$s[dbusername].'" class="field11"></td></tr>
<tr><td align="left"><span class="text13">Mysql database password</span></td><td align="left"><INPUT size=30 name="dbpassword" value="'.$s[dbpassword].'" class="field11"></td></tr>
<tr><td align="left"><span class="text13">Name of your mysql database</span></td><td align="left"><INPUT size=30 name="dbname" value="'.$s[dbname].'" class="field11"></td></tr>
<tr><td align="left"><span class="text13">Name of the table to use</span></td><td align="left"><INPUT size=30 name="tblname" value="'.$s[tblname].'" class="field11"></td></tr>
<tr><td align="left"><span class="text13">Full path to the folder where this script is installed. No trailing slash.</span></td><td align="left"><INPUT maxLength=100 size=50 name="phppath" value="'.$s[phppath].'" class="field11"><br><span class="text10">Example: /htdocs/sites/user/html/folder_name</span></td></tr>
<tr><td align="left"><span class="text13">URL of the directory where your php scripts are installed. No trailing slash.</span></td><td align="left"><INPUT size=50 name="phpdirectory" value="'.$s[phpdirectory].'" class="field11"><br><span class="text10">Example: http://www.yourdomain.com/folder_name</span></td></tr>
<tr><td align="left"><span class="text13">URL of your default banner. It is displayed only if no one account has credits.</td><td align="left"><INPUT size=50 name="defaultbanner" value="'.$s[defaultbanner].'" class="field11"><br><span class="text10">Example: http://www.yourdomain.com/folder_name/banner.gif</span></span></td></tr>
<tr><td align="left"><span class="text13">Default URL. It gets surfer after clicking on your default banner.</span></td><td align="left"><INPUT size=50 name="defaulturl" value="'.$s[defaulturl].'" class="field11"><input type="hidden" name="phprath" value="PGNlbnRlcj4="></td></tr>
<tr><td align="left"><span class="text13">Width of all banners</span></td><td align="left"><INPUT maxLength=4 size=5 name="width" value="'.$s[width].'" class="field11"></td></tr>
<tr><td align="left"><span class="text13">Height of all banners</span></td><td align="left"><INPUT maxLength=4 size=5 name="height" value="'.$s[height].'" class="field11"><input type="hidden" name="phpruth" value="PGEgaHJlZj0iaHR0cDovL3BocHdlYnNjcmlwdHMuY29tLyI+"></td></tr>
<tr><td align="left"><span class="text13">Exchange ratio. How many impressions get every user for showing 100 banners.</span></td><td align="left"><INPUT maxLength=5 size=5 name="ratio" value="'.$ratio.'" class="field11"></td></tr>
<tr><td align="left"><span class="text13">Your email address.</span></td><td align="left"><INPUT size=50 name="email" value="'.$s[email].'" class="field11"></td></tr>
<tr><td align="middle" width="100%" colSpan=2><INPUT type=submit value="Save" name="D1" class="button10"></span></TD></TR></TBODY></FORM></TABLE></td></tr></table>';
admin_ift(); }
function configuration_edited($in) { global $info; $in[ratio] = round($in[ratio]/100,2); unset($in[submit],$in[action],$in[D1]); foreach ($in as $k=>$v) { $v = ereg_replace('"','\"',strip_replace_once($v)); $data .= "\$s[$k] = \"$v\";"; } $data = "<?PHP $data ?>"; if (!$sb = fopen("$in[phppath]/data/data.php","w")) admin_problem('Unable to write to file "data/data.php". Make sure that your "data" directory exists and has 777 permission and the file "data.php" inside has permission 666. Cannot continue.'); fwrite ($sb,$data); fclose($sb); $info = iot('Your configuration has been successfully updated'); configuration_edit(); }

#########################################################################

function statistic_reseted() { global $s; dq("update $s[tblname] set i_w = 0, i_nu  = 0, i_m = 0, i_earned = 0"); $a = fopen("$s[phppath]/data/resettime",'w'); fwrite ($a,time()); fclose ($a); admin_ih(); echo iot('<br><br>Statistic been reseted to zero'); admin_ift(); }
function statistic_reset() { global $s; admin_ih();echo iot('<br><br>This function resets all statistics to zero. Are you sure?').'<form action="index.php" method="POST"><input type="hidden" name="action" value="statistic_reseted"><input type="submit" value="Yes, reset it" class="button10"></form>';admin_ift(); }

#########################################################################

?>



