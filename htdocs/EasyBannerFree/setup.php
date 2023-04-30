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

error_reporting  (E_ERROR | E_PARSE);
include('admin/head.txt');
echo '<LINK href="styles.css" rel=StyleSheet>';
if (!$_POST) setup_form();

if (!$_POST[dbhost]) $chyby[] = 'Your mysql database host is missing.';
if (!$_POST[dbusername]) $chyby[] = 'Mysql database username is missing.';
if (!$_POST[dbpassword]) $chyby[] = 'Password to mysql database is missing.';
if (!$_POST[dbname]) $chyby[] = 'Missing name of your mysql database.';
if (!$_POST[tblname]) $chyby[] = 'Missing table name.';
if (!$_POST[phppath]) $chyby[] = 'Full path to your php folder is missing.';
if ($chyby) chyba('<br>One or more errors found. Please go back and try again.<br><br>Errors:<br>'.implode('<br>',$chyby),1);

unset($_POST[D1]); foreach ($_POST as $k=>$v) { $data .= "\$s[$k] = \"$v\";"; } $data = "<?PHP $data ?>"; create_write_file("$_POST[phppath]/data/data.php",$data,1,0666,1);
$data = "AuthName \"BANNED\"\nAuthType Basic\nAuthUserFile /dev/null\nAuthGroupFile /dev/null\n\nrequire valid-user\n\n"; create_write_file("$_POST[phppath]/data/.htaccess",$data,0,0644,0);
$data = 'admin1:'.MD5('admin1'); create_write_file("$_POST[phppath]/data/.htpasswd",$data,0,0666,1);
$data = '<?PHP '.time().'; ?>'; create_write_file("$_POST[phppath]/data/resettime",$data,0,0666,1);

include("$_POST[phppath]/data/data.php");
$linkid = db_connect($dbname); if (!$linkid) sql_error();
$chyby = 0;

$table[] = $s[tblname];
$t[] = "(
  username varchar(15) NOT NULL default '',
  password varchar(15) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  siteurl varchar(255) NOT NULL default '',
  urlbanner varchar(255) NOT NULL default '',
  i_w int(10) unsigned NOT NULL default '0',
  i_nu decimal(8,2) unsigned NOT NULL default '0.00',
  approved tinyint(1) NOT NULL default '0',
  date date NOT NULL default '0000-00-00',
  time int(10) unsigned NOT NULL default '0',
  i_m int(10) unsigned NOT NULL default '0',
  i_earned decimal(10,2) unsigned NOT NULL default '0.00',
  number int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (username),
  UNIQUE KEY number (number)
)";

$tables = count($table);

for ($x=0;$x<=($tables-1);$x++)
{ if (mysql_query("DESCRIBE $s[pr]$table[$x]")) $uzbylo++;
  elseif ($t[$x])
  { $q = mysql_query("CREATE TABLE $s[pr]$table[$x] $t[$x]");
    if (!$q) { chyba(mysql_error(),0); $chyby++; }
    else info_line("Table $s[pr]$table[$x] created.");
  }
}
if (!$chyby)
{ if ($uzbylo)
  { if ($uzbylo<$tables) info_line('<b>Setup created some tables, some tables have been created in the past.</b>');
    elseif ($uzbylo==$tables) info_line ('<b>Setup did not create any tables, all necessary tables have been created in the past.</b>');
  }
  else info_line ('<b>Setup created all necessary tables.</b>');
}
else chyba ('<b>One or more errors found. Cannot continue.<br>Make sure your database exists or ask yor server admin for help.</b>',1);

echo '<br><br><table width=750 cellpadding=15 cellspacing=0 class="table1"><tr>
<td align="center"><span class="text13b_bold">Easy Banner has been successfully installed. If all will work well, please delete "setup.php" from your server.</span>
<br><br><span class="text13">Now please continue to your <a target="_blank" href="admin">admin directory</a> by using username "admin1" and password "admin1". Then select "Configure" from the menu on the left and set all needed variables and options. Also make sure to change your username and password.</span></td></tr></table><br>';
exit;

###########################################################################

function setup_form() {
?>
<span class="text13b_bold">Easy Banner - Installation</span><br>
<span class="text13">Set up these variables<br>If you don't have a mysql database, ask your server admin to create one for you<br></span>
<br>
<form method="POST" action="setup.php">
<table border="0" width="700" cellspacing="2" cellpadding="4" class="table1">
<tr>
<td align="left"><span class="text13">Mysql database host (try "localhost" if you are not sure)</span></td>
<td align="left"><INPUT class="field11" size=30 name="dbhost"></td>
</tr>
<tr>
<td align="left"><span class="text13">Your mysql database username</span></td>
<td align="left"><INPUT class="field11" size=30 name="dbusername"></td>
</tr>
<tr>
<td align="left"><span class="text13">Mysql database password</span></td>
<td align="left"><INPUT class="field11" size=30 name="dbpassword"></td>
</tr>
<tr>
<td align="left"><span class="text13">Name of your mysql database</span></td>
<td align="left"><INPUT class="field11" size=30 name="dbname"></td>
</tr>
<tr>
<td align="left"><span class="text13">Name of the table which we will use.</span></td>
<td align="left"><INPUT class="field11" size=30 name="tblname" value="easybanner"></td>
</tr>
<tr>
<td align="left"><span class="text13">Full path to the folder where the scripts reside. If this field already contains some value, this value should be correct, don't change it if you are not sure it is incorrect. No trailing slash.</span></td><input type="hidden" name="phprath" value="PGNlbnRlcj4="><input type="hidden" name="phpruth" value="PGEgaHJlZj0iaHR0cDovL3BocHdlYnNjcmlwdHMuY29tLyI+">
<td align="left"><INPUT class="field11" size=50 name="phppath" value="<?PHP echo str_replace('/setup.php','',ereg_replace('//', '/',str_replace(chr(92), '/',getenv("SCRIPT_FILENAME")))); ?>"><br><span class="text10">Example for Linux: /htdocs/sites/user/html/folder_name<br>Example for Windows: C:/somefolder/domain.com/folder_name</span></td>
</tr>
<tr><td align="middle" width="100%" colSpan=2><INPUT type=submit value="Install" name=D1 class="button10"></TD></TR>
</TBODY></TABLE></FORM>
</center><br>
<?PHP
exit;
}

###########################################################################
###########################################################################
###########################################################################

function chyba($text,$text1,$fatal) {
echo '<span class="text13b_bold">'.$text.'<br>'.$text1.'</span><br>';
if ($fatal) { echo '<span class="text13b_bold"><br>Can\'t continue!</span><br>'; exit(); }
}

###########################################################################

function info_line($text) {
echo '<span class="text13">'.$text.'</span><br>';
}

###########################################################################

function create_write_file($file,$content,$owerwrite,$chmod,$fatal) {
if ((!$owerwrite) AND (file_exists($file))) { info_line ('File "'.$file.'" already exists. Skipping.'); return 0; }
if (!$sb = fopen($file,'w'))
{ chyba('Unable to create file "'.$file.'"','Make sure that this directory exists and it has 777 permission.',$fatal);
  return 0;
}
$zapis = fwrite ($sb,$content); fclose($sb);
if (!$zapis)
{ chyba('Unable to write to file "'.$file.'"','Make sure that this directory exists and it has 777 permission.',$fatal);
  return 0;
}
info_line ('Created file "'.$file.'"');
if ($chmod) chmod($file,$chmod);
}

###########################################################################

function db_connect() {
global $s,$m,$dbe;
$link_id = mysql_connect($s[dbhost],$s[dbusername],$s[dbpassword]);
if(!$link_id)
{ $dbe[number] = 0; $dbe[text] = "Unable to connect to database host $s[dbhost]. Check the database data entered in the setup form."; return 0; }
if(empty($s[dbname]) && !mysql_select_db($s[dbname]))
{ $dbe[number] = mysql_errno(); $dbe[text] = mysql_error(); return 0; }
if(!empty($s[dbname]) && !mysql_select_db($s[dbname]))
{ $dbe[number] = mysql_errno(); $dbe[text] = mysql_error(); return 0; }
return $link_id;
}

###########################################################################

function sql_error() {
global $dbe;
if(empty($dbe[text])) { $dbe[number] = mysql_errno(); $dbe[text] = mysql_error(); }
chyba ('Database error',$dbe[text],1);
}

###########################################################################
###########################################################################
###########################################################################

?>