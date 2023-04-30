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

include('./functions.php'); if (!$_POST) page_from_template('member_login.html',$s);
foreach ($_POST as $k=>$v) $_POST[$k] = htmlspecialchars(str_replace('"','',str_replace("'",'',str_replace('"','',str_replace(chr(92),'',$v)))));
$q = dq("select password from $s[tblname] where username = '$_POST[username]' AND password = '$_POST[password]'",1); $data = mysql_fetch_row($q); if (!$data[0]) public_problem ('Wrong username or password. Please try again.');
if (!$_POST[action]) page_from_template('member_action.html',$_POST);
switch ($_POST[action]) {
	case 'edit'			: edit($_POST);
	case 'edited'		: edited($_POST);
	case 'stats'		: stats($_POST);
	case 'html'			: html($_POST);
}

function edit($in) {
global $s; $q = dq("select * from $s[tblname] where username = '$in[username]'",1); $data = mysql_fetch_assoc($q);
$data[width] = $s[width]; $data[height] = $s[height]; $data[info] = $s[info]; $data[banner] = '<img border=0 width="'.$s[width].'" height="'.$s[height].'" src="'.$data[urlbanner].'">'; page_from_template('member_edit.html',$data);
}

function edited($in) { global $s;
if (!eregi("^[a-z0-9]{5,15}$",$in[newpass])) public_problem('Incorrect password. It should contain only letters and numbers and have 5-15 characters.');
if (strlen($in[email]) > 255) public_problem('Email address is too long. Maximum is 255 characters.');
if (strlen($in[siteurl]) > 255) public_problem ('URL is too long. Maximum is 255 characters.');
if (strlen($in[urlbanner]) > 255) public_problem ('Banner URL is too long. Maximum is 255 characters.');
if (!check_email($in[email])) public_problem ('Wrong email address. Please try again.');
if (!eregi("http://*",$in[siteurl])) public_problem ('Wrong URL. Please try again.');
eregi(".*gif$",$in[urlbanner],$hh); eregi(".*jpg$",$in[urlbanner],$hh); eregi(".*png$",$in[urlbanner],$hh); if (!$hh[0]) public_problem ('Incorrect banner image format. Please try again.');
$q = dq("update $s[tblname] set password='$in[newpass]',email='$in[email]',siteurl='$in[siteurl]',urlbanner='$in[urlbanner]' where username = '$in[username]'",1);
$in[memberemail] = $in[email]; $in[to] = $s[email]; $in[password] = $in[newpass]; mail_from_template('email_admin_edit.txt',$in);
$s[info] = iot('Data has been saved'); edit($in); }

function stats($in) { global $s; $q = dq("select * from $s[tblname] where username = '$in[username]'",1); $data = mysql_fetch_assoc($q); page_from_template('member_stats.html',$data); }
function html($in) { global $s; $in[workfile] = "$s[phpdirectory]/work.php?ID=$in[username]"; $in[width] = $s[width]; $in[height] = $s[height]; $in[html] = parse_part('html.txt',$in); page_from_template('member_html.html',$in); }

#########################################################################

?>