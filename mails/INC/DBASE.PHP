<?php
include("conf.php");

define('DELIM','-');

define('COL_NEW','A5E5BA'); //new event background
define('COL_OLD','F7BEAD'); //inactive request background
define('COL_REQ','E8E8E8'); //show_req header background
define('COL_DEL','FFD1E5'); //rejected request background
define('COL_EDIT','FFFFFF'); //currently edited item in Admin pages

$conn = mysqli_connect("localhost","root","mysql", "resume");


function myErrorHandler ($errno, $errstr, $errfile, $errline, $vars)
{
  // Only handle the errors specified by the error_reporting directive or function
  // Ensure that we should be displaying and/or logging errors
  //if ( ! ($errno & error_reporting ()) || ! (ini_get ('display_errors') || ini_get ('log_errors'))) return;
  if($errno & (E_NOTICE | E_STRICT)) return;

  // define an assoc array of error string
  // in reality the only entries we should
  // consider are 2,8,256,512 and 1024
  $errortype = array (
    1   =>  'Error',
    2   =>  'Warning',
    4   =>  'Parsing Error',
    8   =>  'Notice',
    16  =>  'Core Error',
    32  =>  'Core Warning',
    64  =>  'Compile Error',
    128 =>  'Compile Warning',
    256 =>  'User Error',
    512 =>  'User Warning',
    1024=>  'User Notice',
    2048=>  'Strict Mode',
    4096=>  'Recoverable Error'
    );
  echo "</table></table></table><br>\n<b>".$errortype[$errno]."</b><br>\n$errstr<br>\n# $errline, $errfile<br>\n";
	$MAXSTRLEN = 64;
	$s = '<pre align=left>';
	$a = debug_backtrace();
	array_shift($a);
	$traceArr = array_reverse($a);
	$tabs = 0;
	foreach($traceArr as $arr)
	{
		for ($i=0; $i < $tabs; $i++) $s .= '  ';
		$Line = (isset($arr['line'])? $arr['line'] : "unknown");
		$File = (isset($arr['file'])? $arr['file'] : "unknown");
		$s .= sprintf("<font color=blue># line <b>%d</b>, file: <a href=\"file:/%s\">%s</a></font>", $Line, $File, $File);
		$s .= "\n";
		for ($i=0; $i < $tabs; $i++) $s .= '  ';
		$s .= '<font face="Courier New,Courier">';
		if (isset($arr['class'])) $s .= $arr['class'].'.';
		$args = array();
		if(!empty($arr['args'])) foreach($arr['args'] as $v)
		{
			if (is_null($v)) $args[] = 'NULL';
			elseif (is_array($v)) $args[] = 'Array['.sizeof($v).']'.(sizeof($v)<=5 ? serialize($v) : ''); 
			elseif (is_object($v)) $args[] = 'Object:'.get_class($v);
			elseif (is_bool($v)) $args[] = $v ? 'true' : 'false';
			else
			{ 
				$v = (string) @$v;
				$str = htmlspecialchars(substr($v,0,$MAXSTRLEN));
				if (strlen($v) > $MAXSTRLEN) $str .= '...';
				$args[] = "\"".$str."\"";
			}
		}
		if(isset($arr['function'])) $s .= $arr['function'].'('.implode(', ',$args).')</font>';
		else $s .= '[PHP Kernel] ('.implode(', ',$args).')</font>';
		$s .= "\n";
		$tabs ++;
	}    
	echo $s;
  die;
}

// set to the user defined error handler
$old_error_handler = set_error_handler('myErrorHandler');


function loger($x)
{
global $tmpdir;

	error_log(date('[d-m-Y] (H:i:s) {'.$_SERVER['REMOTE_ADDR'].($_SERVER["HTTP_X_FORWARDED_FOR"]!='' ? ','.$_SERVER["HTTP_X_FORWARDED_FOR"] : '').'} -> ').$x.chr(13).chr(10),3,$tmpdir.PLOG);
}

function loger2($x)
{
global $tmpdir;

	error_log(date('[d-m-Y] (H:i:s) -> ').$x.chr(13).chr(10),3,$tmpdir.'/ivo.log');
}

function ivo_str($z)
{
	return preg_replace('/[ \t]+/',' ',trim(strtr(str_replace('<','&lt;',str_replace('>','&gt;',$z)),chr(160).chr(92).chr(39),chr(32).chr(32).chr(96)))); 
}

function ivo_str2($z)
{
	return preg_replace('/[ \t]+/',' ',trim(strtr(strip_tags($z,'<b><p><i><font><table><tr><td><th><ul><ol><li><a><hr><h1><h2><h3><h4><h5><h6><pre><small><strike><strong><u><caption><br><center><span>'),chr(160).chr(92).chr(10).chr(13),'    ')));
} 

function fnum($n)
{
	return (float)str_replace(',','.',$n);
}

function dom_check($d)
{
	$d = trim($d);
	if($d=='') return false;
	$knownDomsPat= '/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/';
	$emailPat= '/^(.+)@(.+)$/';
	$specialChars= '\\(\\)><@,;\/:\\\\\\\"\\.\\[\\]';
	$validChars= '[^\\s' . $specialChars . ']';
	$atom= $validChars . '+';
	$domainPat= '/^' . $atom . '(\\.' . $atom . ')*$/';
	if(!preg_match($domainPat,$d)) return false;
	for ($i=0; $i<strlen($d); $i++) 
		if (ord(substr($d,$i,1))>127) return false; //'This domain name contains invalid characters ('.substr($domain,$i,1).')';
	$atomPat= '/^' . $atom . '$/';
	$domArr=preg_split('/\./',$d);
	$len=count($domArr);
	for ($i=0;$i<$len;$i++) 
		if (!preg_match($atomPat,$domArr[$i])) return false; //'The domain name does not seem to be valid ('.$domArr[$i].').';
	if (strlen($domArr[count($domArr)-1])!=2 && !preg_match($knownDomsPat,$domArr[count($domArr)-1]))
		return false; //'The email address ('.$domArr[count($domArr)-1].') must end in a well-known domain or two letter country, or IP closed in [].';
	if ($len<2) return false; //'This email address ('.$emailStr.') is missing a hostname!';
	return true;
}

// check E-mail validity
function emailCheck($emailStr)
{

	if($emailStr=='') return '';
		else $emailStr = trim($emailStr);

  // The following is the list of known TLDs that an e-mail address must end with.
	$knownDomsPat= '/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/';

  /* The following pattern is used to check if the entered e-mail address
  fits the user@domain format.  It also is used to separate the username
  from the domain. */

	$emailPat= '/^(.+)@(.+)$/';

  /* The following string represents the pattern for matching all special
  characters.  We don't want to allow special characters in the address.
  These characters include ( ) < > @ , ; : \ " . [ ] */

	$specialChars= '\\(\\)><@,;\/:\\\\\\\"\\.\\[\\]';

  /* The following string represents the range of characters allowed in a
  username or domainname.  It really states which chars aren't allowed.*/

	$validChars= '[^\\s' . $specialChars . ']';

  /* The following pattern applies if the "user" is a quoted string (in
  which case, there are no rules about which characters are allowed
  and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
  is a legal e-mail address. */

	$quotedUser= '(\"[^\"]*\")';

  /* The following pattern applies for domains that are IP addresses,
  rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
  e-mail address. NOTE: The square brackets are required. */

	$ipDomainPat= '/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/';

  // The following string represents an atom (basically a series of non-special characters.)

	$atom= $validChars . '+';

  /* The following string represents one word in the typical username.
  For example, in john.doe@somewhere.com, john and doe are words.
  Basically, a word is either an atom or quoted string. */

	$word= '(' . $atom . '|' . $quotedUser . ')';

  // The following pattern describes the structure of the user

	$userPat= '/^' . $word . '(\\.' . $word . ')*$/';

  /* The following pattern describes the structure of a normal symbolic
  domain, as opposed to ipDomainPat, shown above. */

	$domainPat= '/^' . $atom . '(\\.' . $atom . ')*$/';

  // Finally, let's start trying to figure out if the supplied address is valid.

  /* Begin with the coarse pattern to simply break up user@domain into
  different pieces that are easy to analyze. */

	if (!preg_match($emailPat,$emailStr,$matchArray))
	{

    /* Too many/few @'s or something; basically, this address doesn't
    even fit the general mould of a valid e-mail address. */
		return 'Email address "'.$emailStr.'" seems incorrect (check @ and .)';
	}
	$user=$matchArray[1];
	$domain=$matchArray[2];

  // Start by checking that only basic ASCII characters are in the strings (0-127).

	for ($i=0; $i<strlen($user); $i++) 
		if (ord(substr($user,$i,1))>127) return 'The username in email contains invalid character ('.substr($user,$i,1).')';
	for ($i=0; $i<strlen($domain); $i++) 
		if (ord(substr($domain,$i,1))>127) return 'This domain name contains invalid characters ('.substr($domain,$i,1).')';

  // user is not valid
	if (!preg_match($userPat,$user)) return 'The username in email does not seem to be valid ('.$user.').';

  // if the e-mail address is at an IP address (closed in [] ) make sure the IP address is valid.
	if (preg_match($ipDomainPat,$domain,$IPArray))
	{
		for ($i=1;$i<=4;$i++) 
			if ($IPArray[$i]>255 OR $IPArray[$i]=='') return 'Destination IP address ('.$domain.') is invalid!';
		return '';
	}

  // Domain is symbolic name.  Check if it's valid.

	$atomPat= '/^' . $atom . '$/';
	$domArr=preg_split('/\./',$domain);
	$len=count($domArr);
	for ($i=0;$i<$len;$i++) 
		if (!preg_match($atomPat,$domArr[$i])) return 'The domain name does not seem to be valid ('.$domArr[$i].').';

  /* domain name seems valid, but now make sure that it ends in a
  known top-level domain (like com, edu, gov) or a two-letter word,
  representing country (uk, nl), and that there's a hostname preceding
  the domain or country. */

	if (strlen($domArr[count($domArr)-1])!=2 && !preg_match($knownDomsPat,$domArr[count($domArr)-1]))
		return 'The email address ('.$domArr[count($domArr)-1].') must end in a well-known domain or two letter country, or IP closed in [].';

  // Make sure there's a host name preceding the domain.

	if ($len<2) return 'This email address ('.$emailStr.') is missing a hostname!';
/*
// Check DNS records for A and PTR existense and equality
		getmxrr($domain, $dns_mx);
		if(count($dns_mx)==0) $dns_mx[] = $domain;
		$no_dns = true;
		foreach($dns_mx as $www)
		{
			$dns_a = dns_get_record($www,DNS_A);
			if(count($dns_a)>0) 
				foreach($dns_a as $mx)
				{
					$ip = explode('.',$mx['ip']);
					$arpa = $ip[3].'.'.$ip[2].'.'.$ip[1].'.'.$ip[0].'.in-addr.arpa';
					$dns_ptr = dns_get_record($arpa,DNS_PTR);
					if(count($dns_ptr)>0) $no_dns = false;
					// unfortunately, most PRT records do not correspond to A records
					//	foreach($dns_ptr as $ptr)
					//		if($ptr['target']==$www) $no_dns = false;
				}
		}
		if($no_dns) return 'This domain does not have proper DNS information';
*/	
  // If we've gotten this far, everything's valid!
	return '';
} 

// returns a cell from table by its column and row
function a_select($tbl,$clause,$field='',$where='')
{
	if ($clause==0) return '&nbsp;';
	if($field=='') $field=$tbl;
	$query = "SELECT $field FROM $tbl WHERE ";
	if($where=='') $query.='ID='.$clause;
		else $query.=$where;
	$res = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
	if(mysql_num_rows($res)>0) $x = mysql_result($res,0,0);
		else $x = '&nbsp;';
	mysql_free_result($res);
	return $x;
} 

// returns list of records from table $TABLE, sorted by column $SORT in ascending/descending $ORDER,
// using $END as optional WHERE clause
// $TABLE can be comma separated list - the first element is used as primary key
// $FIELD can be comma separated list, too
function loadItems($table,$field,$current,$empty="",$end="",$sort="",$order="ASC")
{
	$a = substr($table,0,strpos($table,','));
	if($a != '') $a .= '.';
	$query = 'SELECT '.$a."ID ID0,$field FROM $table $end";
 	if($sort!='') $query.= " ORDER BY $sort $order";
	$result = mysql_unbuffered_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
	if ($empty!='') $z = '<option value="0">'.$empty.'</option>';
  while ($row = mysql_fetch_array($result,MYSQL_NUM))
	{	
  	if(is_array($current))
  	{
  		if (in_array($row[0],$current)) $a = 'selected'; else $a = '';
  	}
  	else
  	{
  		if ($row[0] != $current) $a=''; else $a='selected';
  	}
 		$z .= '<option '.$a.' value="'.$row[0].'">'.$row[1].'</option>';
 	}
 	mysql_free_result($result);
 	return $z;
} 

?>