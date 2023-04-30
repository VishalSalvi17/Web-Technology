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

if ((!$_GET[all]) AND (!eregi("^[a-z0-9]{5,15}$",$_GET[ID]))) exit;
dq("update $s[tblname] set i_m = i_m + 1, i_earned = (i_m*$s[ratio]), i_nu = (i_nu+$s[ratio]) where username = '$_GET[ID]'",1);
$q = dq("select max(number) from $s[tblname]"); $data = mysql_fetch_row($q);
list($usec,$sec) = explode(' ',microtime()); srand((float) ($sec+($usec * 100000))); $i=rand(0,$data[0]);

if ($_GET[all])
{ echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n<HTML><HEAD>
  <META http-equiv=Content-Type content=\"text/html;\"><title>ALL BANNERS</title></HEAD>
  <BODY><center><table border=0 cellpadding=0 cellspacing=0 width=$s[width]>";
  $q = dq("select $s[tblname].*,MD5(RAND()) AS m from $s[tblname] where approved = 1 ORDER BY m",1);
  while ($data = mysql_fetch_assoc($q))
  { echo "<tr>
    <td width=$s[width] valign=\"top\" align=\"left\"><a target=\"_top\" href=\"$data[siteurl]\"><img border=0 src=\"$data[urlbanner]\" width=$s[width] height=$s[height]></a>
    </td></tr>";
  }
  echo '</table></BODY>';
  exit;
}

$q = dq("select $s[tblname].*,MD5(RAND()) AS m from $s[tblname] where approved = 1 AND i_nu >= 1 AND NOT(username = '$_GET[ID]') ORDER BY m LIMIT 1",1);
$data = mysql_fetch_assoc($q); 

if ($data[username])
{ echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n<HTML><HEAD>
  <META http-equiv=Content-Type content=\"text/html;\"></HEAD>
  <BODY><table border=0 cellpadding=0 cellspacing=0 width=$s[width]><tr>
  <td width=$s[width] valign=\"top\" align=\"left\"><a target=\"_top\" href=\"$data[siteurl]\"><img border=0 src=\"$data[urlbanner]\" width=$s[width] height=$s[height]></a>
  </td></tr></table></BODY>";
  dq("update $s[tblname] set i_nu = i_nu-1, i_w = i_w + 1 where username = '$data[username]'",1);
}
else
{ echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n<HTML><HEAD>
  <META http-equiv=Content-Type content=\"text/html;\"></HEAD>
  <BODY><table border=0 cellpadding=0 cellspacing=0 width=$s[width]><tr>
  <td width=$s[width] valign=\"top\" align=\"left\"><a target=\"_top\" href=\"$s[defaulturl]\"><img border=0 src=\"$s[defaultbanner]\" width=$s[width] height=$s[height]></a>
  </td></tr></table></BODY>";
}

#########################################################################

?>