<?php
include('./INC/DBASE.PHP');
session_start();

if($_REQUEST['id']<1)
{
	echo '<html><script>window.close();</script></html>';
	die;
}
$dom_name = strtolower(a_select('DOMAIN',$_REQUEST['id']));

if(isset($_POST['logout']))
{
	unset($_SESSION['login_mail']);
}

// must be after ALL "adm_login()" occurences
if(isset($_POST['cmdLogin']))
{
	$u = ivo_str($_POST['log_user']);
	$p = ivo_str($_POST['log_pass']);
	$query = 'SELECT ID FROM DOMAIN_USER WHERE USER="'.mysql_real_escape_string(substr($u,0,35)).'" AND PASS="'.mysql_real_escape_string(substr($p,0,30)).'"';
	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
	if(mysql_num_rows($result)) $_SESSION['login_mail'] = mysql_result($result,0,0);
		else $err='Wrong username or password';
}

if($_SESSION['login_mail']!=0)
{
	$query = 'SELECT IS_ADMIN,TITLE,(SELECT ADM_USER FROM DOMAIN WHERE ID='.$_REQUEST['id'].') FROM DOMAIN_USER WHERE ID='.$_SESSION['login_mail'];
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	if(mysql_num_rows($result))
	{
		$is_admin = mysql_result($result,0,0);
		$title = mysql_result($result,0,1);
		$adm_usr = mysql_result($result,0,2);
		$is_owner = ($adm_usr == $_SESSION['login_mail']);
	}
}

function make_copy($part_user,$part_dom,$copy)
{
global $err;
	$kopie = $part_user.'@'.$part_dom;
	$adres = $part_user.'_1@'.$part_dom; 
  if($copy!='')
  {
		$goto = explode(',',$copy);
		if(is_array($goto) AND count($goto)>0)
		{
			foreach($goto as $k=>$v)
			{
				$goto[$k] = trim($v);
				$a = strpos($v,'@');
				if($a===FALSE) $goto[$k] .= '@'.$part_dom;
				if(($err = emailCheck($goto[$k])) != '') break;
				// check for existing user
				$query = 'SELECT 1 FROM users WHERE userid="'.mysql_real_escape_string($goto[$k]).'"';
			 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
			 	if(!mysql_num_rows($result))
			 	{
			 		$err = 'No such e-mail ('.$goto[$k].') - operation aborted';
			 		break;
			 	}
			 	// check for trivial duplicates
			 	if($goto[$k] == $kopie) 
			 	{
			 		$err = 'Sending copies to the same person is a rather illogical and absurd !';
			 		break;
			 	}
			 	// check for loops
				$query = 'SELECT 1 FROM virtual WHERE address IN ("'.mysql_real_escape_string($goto[$k]).'","'.mysql_real_escape_string(str_replace('@','_1@',$goto[$k])).'") 
					AND goto LIKE "%'.mysql_real_escape_string($kopie).'%"';
			 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
			 	if(mysql_num_rows($result))
			 	{
			 		$err = 'Endless cycles between email ('.$goto[$k].') and ('.$kopie.')';
			 		break;
			 	}
			}
			if($err == '')
			{
				$query = 'REPLACE INTO virtual(address,goto) VALUES("'.mysql_real_escape_string($adres).'","'.mysql_real_escape_string(implode(',',$goto)).'")';
			 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
				$query = 'REPLACE INTO sender_bcc(sender,goto) VALUES("'.mysql_real_escape_string($kopie).'","'.mysql_real_escape_string($adres).'")';
			 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
			}
		}
		else $err = 'Please specify BCC destination(s) - comma separated if multiple';
  }
  else remove_copy($part_user,$part_dom);
}

function remove_copy($part_user,$part_dom)
{
  $query = 'DELETE FROM virtual WHERE address="'.mysql_real_escape_string($part_user.'_1@'.$part_dom).'"';
 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
  $query = 'DELETE FROM sender_bcc WHERE sender="'.mysql_real_escape_string($part_user.'@'.$part_dom).'"';
 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
}

if(isset($_POST['cmdMail']) AND ($is_admin OR $is_owner))
{
	$user_name = ivo_str($_POST['new_mail']);
	$user_pass = ivo_str($_POST['new_pass']);
	$user_copy = ivo_str($_POST['new_copy']);
	$a = strpos($user_name,'@');
	if($a!==FALSE) $user_name = substr($user_name,0,$a);
	if($user_name=='') $err='Missing e-mail';
	elseif(strlen($user_name.'@'.$dom_name)>64) $err='E-mail addresses can be no longer than 64 symbols';
	elseif($user_pass=='') $err='Missing password';
	elseif(strlen($user_pass)>64) $err='Password can be no longer than 64 symbols';
	elseif(($err = emailCheck($user_name.'@'.$dom_name)) != '') ;
	else
	{
    $query = 'INSERT IGNORE INTO users(userid,password) VALUES("'.mysql_real_escape_string($user_name.'@'.$dom_name).'","'.mysql_real_escape_string($user_pass).'")';
		$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
    // add copies
    make_copy($user_name,$dom_name,$user_copy);
    if($err=='')
    {
			header('Location:domain.php?id='.$_REQUEST['id']);
			die;
		}
	}
}

if($_REQUEST['del_mail']!='' AND ($is_admin OR $is_owner))
{
	$query = 'DELETE FROM users WHERE userid="'.mysql_real_escape_string($_REQUEST['del_mail'].'@'.$dom_name).'"';
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	remove_copy($_GET['del_mail'],$dom_name);
	header('Location:domain.php?id='.$_REQUEST['id']);
	die;
}

if(is_array($_POST['newMail']) AND ($is_admin OR $is_owner)) foreach($_POST['newMail'] as $k=>$v)
{
	$new_pass = ivo_str($_POST['psw'][$k]);
	$new_copy = ivo_str($_POST['virt'][$k]);
	if($new_pass=='') $err='Missing password';
	elseif(strlen($new_pass)>64) $err='Password can be no longer than 64 symbols';
	else
	{
    $query = 'UPDATE users SET password="'.mysql_real_escape_string($new_pass).'" WHERE userid="'.$k.'@'.$dom_name.'"';	
   	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
   	make_copy($k,$dom_name,$new_copy,true);
	}
	if($err=='')
	{
		header('Location:domain.php?id='.$_REQUEST['id']);
		die;
	}
}

if($_REQUEST['active']!='' AND ($is_admin OR $is_owner))
{
  $query = 'UPDATE users SET active=IF(active="Y","N","Y") WHERE userid="'.mysql_real_escape_string($_REQUEST['active'].'@'.$dom_name).'"';
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	header('Location:domain.php?id='.$_REQUEST['id']);
	die;
}

	if($b = @file_get_contents($tmpdir.'/domain.htm'))
	{
		if($err!='') $z = 'alert("'.mysql_real_escape_string($err).'");';
			else $z = '';
		$b = str_replace('<!--{ERROR}-->',$z,$b);
		$b = str_replace('{PREP}',WEBDIR,$b);
	
		$b = str_replace('{VIS_ADMIN}',($is_admin OR $is_owner) ? '' : 'display:none',$b);
		$b = str_replace('{VIS_LOG}',$_SESSION['login_mail']==0 ? '' : 'display:none',$b);
		$b = str_replace('{VIS_UNLOG}',$_SESSION['login_mail']!=0 ? '' : 'display:none',$b);
		$b = str_replace('{ADMIN}',$title,$b);
		$b = str_replace('{DOMAIN}',strtoupper($dom_name),$b);
		$b = str_replace('{ID}',$_REQUEST['id'],$b);
	
		// show emails for the given domain
		$query = 'SELECT SUBSTRING_INDEX(userid,"@",1),password,goto,active FROM users LEFT JOIN virtual ON address=REPLACE(userid,"@","_1@") WHERE RIGHT(userid,'.strlen($dom_name).')="'.mysql_real_escape_string($dom_name).'" ORDER BY userid';
		$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		$z = '';
		while($row = mysql_fetch_array($result,MYSQL_NUM))
		{
			$z.='<tr><td align="center">';
			if($is_admin OR $is_owner) $z.='<input type="submit" class="button3" name="newMail['.$row[0].']" value="Edit">
				<a href="#" onClick="javascript: if(FinalConfirm(\'Do you really want to delete this item ?\')) with(document.dom_list) { del_mail.value=\''.$row[0].'\'; submit(); }">
				<img src="'.WEBDIR.'/images/stop.gif" alt="DEL" border="0" width="16" height="16" align="absmiddle"></a>';
				else $z.='&nbsp;';
			$z.='</td><td>'.$row[0].'</td><td>';
			if($is_admin OR $is_owner) $z.='<input type="text" class="edit" name="psw['.$row[0].']" value="'.$row[1].'" size="16" maxlength="64">';
			  else $z.= '*****';
			$z.='</td><td align="center">';
			if($is_admin OR $is_owner) $z.='<a href="#" onClick="javascript: with(document.dom_list) { active.value=\''.$row[0].'\'; submit(); }">';
  		$z.='<img src="'.WEBDIR.'/images/'.($row[3]=='Y' ? 'v' : 'x').'_serif.gif" alt="Admin" border="0" width="16" height="16"></a></td>
				<td><input type="text" class="edit" name="virt['.$row[0].']" value="'.$row[2].'" size="120" maxlength="1500"></td></tr>'.chr(13).chr(10);
		}
		$b = str_replace('<tr><td>{MLIST}</td></tr>',$z,$b);
			
		echo $b;
	}
	else die('Could not find template - domain.htm');

?>