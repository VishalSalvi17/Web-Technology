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

include('./functions.php'); if (!$_POST) page_from_template('join.html',$s);
$in = $_POST;
if ((!$in[urlbanner]) OR (!$in[username]) OR (!$in[password]) OR (!$in[email]) OR (!$in[siteurl])) public_problem('All fields are required. Please try again.');
if (!eregi("^[a-z0-9]{5,15}$",$in[username])) public_problem('Incorrect username. It should contain only letters and numbers and have 5-15 characters.'); 
if (!eregi("^[a-z0-9]{5,15}$",$in[password])) public_problem('Incorrect password. It should contain only letters and numbers and have 5-15 characters.'); 
if (strlen($in[email]) > 255) public_problem('Email address is too long. Maximum is 255 characters.');
if (strlen($in[siteurl]) > 255) public_problem ('URL is too long. Maximum is 255 characters.');
if (strlen($in[urlbanner]) > 255) public_problem ('Banner URL is too long. Maximum is 255 characters.');
if (!check_email($in[email])) public_problem ('Wrong email address. Please try again.');
if (!eregi("http://*",$in[siteurl])) public_problem ('Wrong URL. Please try again.');
$q = dq("select count(*) from $s[tblname] where username = '$in[username]'",0); $data = mysql_fetch_row($q); if ($data[0]) public_problem('Entered username is already in use. Please use another.');
eregi(".*gif$",$in[urlbanner],$hh); eregi(".*jpg$",$in[urlbanner],$hh); eregi(".*png$",$in[urlbanner],$hh); if (!$hh[0]) public_problem ('Incorrect banner image format. Please try again.');
$cas = time(); $datum = Date('Y-m-d'); 
dq("insert into $s[tblname] values('$in[username]','$in[password]','$in[email]','$in[siteurl]','$in[urlbanner]','0','0','0','$datum','$cas','0','0',NULL)",1);
$in[number] = mysql_insert_id();
$in[memberfile] = "$s[phpdirectory]/member.php"; $in[to] = $in[email]; mail_from_template('email_join.txt',$in); 
$in[adminfile] = "$s[phpdirectory]/admin/"; $in[memberemail] = $in[email]; $in[to] = $s[email]; mail_from_template('email_admin.txt',$in);
$s[workfile]="$s[phpdirectory]/work.php?ID=$in[username]"; $in[html] = parse_part('html.txt',$s);
$a[memberfile]="$s[phpdirectory]/member.php"; $in[banner] = '<img border=0 width="'.$s[width].'" height="'.$s[height].'" src="'.$in[urlbanner].'">'; page_from_template('join_success.html',$in);

#########################################################################

?>