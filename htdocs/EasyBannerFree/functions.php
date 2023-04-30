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

error_reporting  (E_ERROR | E_PARSE); include('./data/data.php'); if (ini_get("magic_quotes_sybase")) ini_set("magic_quotes_sybase",0); ini_set("magic_quotes_gpc",0); ini_set("magic_quotes_runtime",1); if ($s[kun]='UG93ZXJlZCBieSBFYXN5IEJhbm5lcg==') $x = 1; else $x = 0; if (ini_get("register_globals")) ini_set("register_globals","Off"); $r = $s[phprath].$s[phpruth].$s[kun]; if (strlen($r)!=92) exit; $linkid = db_connect();
include('./data/messages.php'); $m = strip_replace_array($m); $linkid = db_connect(); $s[header] = implode("\n",file("$s[phppath]/data/templates/_header.txt")); $s[footer] = implode("\n",file("$s[phppath]/data/templates/_footer.txt")); // public only
//session_start(); if ($_GET[action] == 'admin_log_off') admin_log_off(); if ($_POST[action]=='admin_logged_in') admin_logged_in($_POST); if (!$_SESSION['admin_username']) admin_login_form(); admin_check_session($_SESSION); // admin only

#########################################################################

function check_email($email) {if (eregi("^[a-z0-9_.-]+@[a-z0-9_-]+\.[a-z0-9.]+$",$email)) return 1;return 0; }
function db_connect() { global $s; unset($s[db_error],$s[dben]); if ($s[nodbpass]) $link_id = mysql_connect($s[dbhost], $s[dbusername]); else $link_id = mysql_connect($s[dbhost],$s[dbusername],$s[dbpassword]); if(!$link_id) { $s[db_error] = "Unable to connect to the host $s[dbhost]. Check database host, username, password."; $s[dben] = mysql_errno(); return 0; } if ( (!$s[dbname]) && (!mysql_select_db($s[dbname])) ) { $s[db_error] = mysql_errno().' '.mysql_error(); $s[dben] = mysql_errno(); return 0; } if ( ($s[dbname]) && (!mysql_select_db($s[dbname])) ) { $s[db_error] = mysql_errno().' '.mysql_error(); $s[dben] = mysql_errno(); return 0; } return $link_id; }
function strip_replace_array ($a) { if (!$a) return $a; reset ($a); while (list ($k, $v) = each ($a)) { if (is_array($v)) continue;$a[$k] = ereg_replace("''","'",strip_tags($v));$a[$k] = htmlspecialchars(str_replace(chr(92),'',$a[$k]));$a[$k] = eregi_replace('&amp;','&',$a[$k]); } return $a; }
function strip_replace_once ($x) { if (!$x) return $x; $x = ereg_replace("''","'",$x);$x = stripslashes($x);$x = eregi_replace('&amp;','&',$x);return $x; }
function add_slashes_array ($a) { if (!$a) return $a; reset ($a); while (list ($k, $v) = each ($a)) { if (is_array($v)) continue; $a[$k] = addslashes(ereg_replace("''","'",$v)); } return $a; }
function page_from_template($template,$value) { global $s; $template = "$s[phppath]/data/templates/$template"; if (!is_array($value)) $value = array(); $value[mail] = $s[email]; $f = fopen($template,'r') or public_problem("Unable to read template $template"); while (!feof($f)) $line .= fgets($f,4096); fclose ($f); $line1 = base64_decode($s[phprath]).base64_decode($s[phpruth]).base64_decode($s[kun]).base64_decode('PC9hPjxicj4='); while (list($k,$v) = each($value)) $line = str_replace("#%$k%#",$v,$line); reset($value); $line = eregi_replace("#%[a-z0-9_]*%#",'',strip_replace_once($line)); include ("$s[phppath]/data/templates/_header.txt"); echo $line; include("$s[phppath]/data/templates/_footer.txt"); echo $line1; exit; }
function mail_from_template($template,$value) { global $s; $template = "$s[phppath]/data/templates/$template"; $fd = fopen($template,'r') or public_problem("Unable to read template $template"); while ($line = fgets($fd,4096)) $emailtext .= $line; fclose($fd); eregi("Subject: +([^\n\r]+)", $emailtext, $regs); $sub = $regs[1]; $emailtext = eregi_replace("Subject: +([^\n\r]+)[\r\n]+",'', $emailtext); reset ($value); while (list($key, $val) = each ($value)) $emailtext = str_replace("#%$key%#",$val,$emailtext); $emailtext = eregi_replace("#%[a-z0-9_]*%#",'',$emailtext); $emailtext = strip_replace_once($emailtext);
//echo "To: $value[to]<br>From: $s[email]<br>Sub: $sub<br>$emailtext<br><br><br>"; $ok = 1; 
$ok = mail($value[to],$sub,$emailtext,"From: $s[email]"); return $ok; }
function parse_part($template,$value) { global $s; $template = "$s[phppath]/data/templates/$template"; if (!is_array($value)) $value = array(); $value[mail] = $s[email]; $fh = fopen($template,'r') or public_problem("Unable to read template $template"); while (!feof($fh)) $line .= fgets ($fh,4096); fclose ($fh); foreach ($value as $k=>$v) $line = str_replace("#%$k%#",$v,$line); $line = eregi_replace("#%[a-z0-9]*%#",'',strip_replace_once($line)); return $line; }
function dq($query,$check) { global $s; $q = mysql_query($query); if (($check) AND (!$q)) public_problem(mysql_error()); return $q; }
function datum ($cas) { return date ("m-d-Y",$cas); }
function iot($info) { return '<span class="text13b_bold"><b>'.$info.'</b></span><br><br>'; }
function eot($info,$errors) { return '<span class="text13b_bold"><b>'.$info.'</b></span><br><span class="text13">'.$errors.'</span><br><br>'; }
function public_problem ($error) { global $s; $s[info] = $error; page_from_template('error.html',$s); }
function admin_right_frame_home() { admin_ih(); echo '<br><br><br><br><br><span class="text13b_bold">Welcome to the Admin Area</span><br><br><span class="text13">Please select a function from the menu on the left</span>'; admin_ift(); }
function admin_log_off() { global $s; session_destroy(); $s[info] = iot('You have been logged off'); admin_login_form(0); }
function admin_problem ($error) { admin_ih(); echo '<br><br><span class="text13b_bold">ERROR<br><br>'.$error.'</span><br><br>'; admin_ift(); }
function admin_ift() { include('./footer.txt'); exit; }
function admin_ih() { include('./head.txt'); }
function admin_check_session($data) { global $s; $a = file("$s[phppath]/data/.htpasswd"); $b = split (':',trim($a[0])); if ($data[admin_username]!=$b[0]) { session_destroy(); $in[info] = iot('An error has occurred. Please login again.'); admin_login_form($in); } }
function admin_login_data_edit($a) { global $s; admin_ih(); echo $s[info].iot('Modify Admin\'s Username/Password').'<table border="0" width="200" cellspacing="0" cellpadding="5" class="table1"><form action="index.php" method="post"><input type="hidden" name="action" value="admin_login_data_edited"><tr><td align="center"><tr><td align="right" nowrap><span class="text13">New username </span></td><td align="left"><input class="field11" size="15" name="new_username" value='.$a[new_username].'></td></tr> <tr><td align="right" nowrap><span class="text13">New password </span></td><td align="left"><input class="field11" size="15" name="new_password" value='.$a[new_password].'></td></tr> <tr><td align="center" colspan=2><input type="submit" name="A1" value="Submit" class="button10"></td></tr></form></table>'; admin_ift(); }
function admin_login_data_edited($a) { global $s; if (($a[new_username]) AND ($a[new_password])) { $sb = fopen("$s[phppath]/data/.htpasswd",'w'); $zapis = fwrite ($sb, "$a[new_username]:" . MD5($a[new_password])); fclose($sb); chmod("$s[phppath]/data/.htpasswd",0666); if (!$zapis) $s[info] = iot('Unable to write to your "data/.htpasswd" file. Make sure that the data directory has 777 permission and the .htaccess file has 666 permission.'); $s[info] = iot('Admin username and password have been updated.<br>If you have modified your username, you now have to log in again.'); } elseif (($a[new_username]) OR ($a[new_password])) $s[info] = iot('Both fields are required'); admin_login_data_edit($a); }
function admin_login_form($in) {
global $s;echo '<script>
<!--
if (window!= top)
top.location.href=location.href
// -->
</script>';admin_ih();echo $s[info];echo '<table border="0" width="200" cellspacing="2" cellpadding="4" class="table1"><form method="POST" action="index.php"><input type="hidden" name="action" value="admin_logged_in"><tr><td align="left"><span class="text13">Username</span></td><td align="left"><input class="field11" name="username" size=15 maxlength=15 value="'.$in[username].'"></td></tr><tr><td align="left"><span class="text13">Password</span></td><td align="left"><input class="field11" type="password" name="password" size=15 maxlength=15 value="'.$in[password].'"></td></tr><tr><td colspan=2 align="center"><input type="submit" value="Submit" name="B1" class="button10"></td></tr> </form></table>'; admin_ift(); }
function admin_logged_in($in) {global $s;if ((!$in[username]) OR (!$in[password])) admin_login_form($in);$password = md5($in[password]); $a = file('../data/.htpasswd'); $b = split (':',trim($a[0]));if (($in[username]!=$b[0]) OR ($password!=$b[1])) { $s[info] = iot('Wrong username or password. Please try again.'); admin_login_form($in); }$s[admin_username] = $_SESSION[admin_username] = $in['username'];unset($_POST);home_page();}

##################################################################################

?>