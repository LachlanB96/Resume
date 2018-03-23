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

if(isset($_POST['cmdVirt']) AND ($is_admin OR $is_owner))
{
	$virt_from = ivo_str($_POST['virt_name']);
	$virt_to = ivo_str($_POST['virt_copy']);
	$a = strpos($virt_from,'@');
	if($a!==FALSE) $virt_from = substr($virt_from,0,$a);
	if($virt_from=='') $err='Missing alias name';
	elseif(strlen($virt_from.'@'.$dom_name)>64) $err='Alias can be no longer than 64 symbols';
	elseif($virt_to=='') $err='Missing destination';
	elseif(($err = emailCheck($virt_from.'@'.$dom_name)) != '') ;
	else
	{
		if($virt_from=='*') $virt_from = '@'.$dom_name;
	  	else $virt_from .= '@'.$dom_name;
		$goto = explode(',',$virt_to);
		if(is_array($goto) AND count($goto)>0)
		{
			foreach($goto as $k=>$v)
			{
				$goto[$k] = trim($v);
				if(($err = emailCheck($v)) != '') break;
				// check for existing user
				$query = 'SELECT 1 FROM users WHERE userid="'.mysql_real_escape_string($goto[$k]).'"';
			 	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
			 	if(!mysql_num_rows($result))
			 	{
			 		$err = 'No such e-mail ('.$goto[$k].') - operation aborted';
			 		break;
			 	}
			 	// check for loops
				$query = 'SELECT 1 FROM virtual WHERE address IN ("'.mysql_real_escape_string($goto[$k]).'","'.mysql_real_escape_string(str_replace('@','_1@',$goto[$k])).'") 
					AND goto LIKE "%'.mysql_real_escape_string($virt_from).'%"';
			 	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
			 	if(mysql_num_rows($result))
			 	{
			 		$err = 'Endless cycle between email ('.$goto[$k].') and ('.$virt_from.')';
			 		break;
			 	}
			}
			if($err == '')
			{
				$query = 'INSERT IGNORE INTO virtual(address,goto) VALUES("'.mysql_real_escape_string($virt_from).'","'.mysql_real_escape_string(implode(',',$goto)).'")';
    		$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
			}
		}
		else $err = 'Please specify destination(s) - comma separated if multiple';
	}
}

if($_REQUEST['del_virt']!='')
{
	$query = 'DELETE FROM virtual WHERE address="'.mysql_real_escape_string($_REQUEST['del_virt'].'@'.$dom_name).'"';
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
}

if(is_array($_POST['newVirt'])) foreach($_POST['newVirt'] as $from=>$virt)
{
  $virt_from = $from.'@'.$dom_name;
	$goto = explode(',',$_POST['virt_to'][$from]);
	if(is_array($goto) AND count($goto)>0)
	{
		foreach($goto as $k=>$v)
		{
			$goto[$k] = trim($v);
			if(strpos($v,'@')===FALSE) $goto[$k] .= '@'.$dom_name; 
			if(($err = emailCheck($goto[$k])) != '') break;
			// check for existing user
			$query = 'SELECT 1 FROM users WHERE userid="'.mysql_real_escape_string($goto[$k]).'"';
		 	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		 	if(!mysql_num_rows($result))
		 	{
		 		$err = 'No such e-mail ('.$goto[$k].') - operation aborted';
		 		break;
		 	}
		 	// check for loops
			$query = 'SELECT 1 FROM virtual WHERE address IN ("'.mysql_real_escape_string($goto[$k]).'","'.mysql_real_escape_string(str_replace('@','_1@',$goto[$k])).'") 
				AND goto LIKE "%'.mysql_real_escape_string($virt_from).'%"';
		 	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		 	if(mysql_num_rows($result))
		 	{
		 		$err = 'Endless cycle between email ('.$goto[$k].') and ('.$virt_from.')';
		 		break;
		 	}
		}
		if($err == '')
		{
			$query = 'UPDATE virtual SET goto="'.mysql_real_escape_string(implode(',',$goto)).'" WHERE address="'.mysql_real_escape_string($virt_from).'"';
		 	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		}
	}
	else $err = 'Please specify destination(s) - comma separated if multiple';
}

	if($b = @file_get_contents($tmpdir.'/alias.htm'))
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
	
		// show aliases for the given domain
		$query = 'SELECT SUBSTRING_INDEX(address,"@",1),goto,address FROM virtual WHERE RIGHT(address,1+'.strlen($dom_name).')="@'.mysql_real_escape_string($dom_name).'" AND LOCATE("_1@",address)=0 ORDER BY address';
		$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		$z = '';
		while($row = mysql_fetch_array($result,MYSQL_NUM))
		{
			$z.='<tr><td align="center">';
			if($is_admin OR $is_owner) $z.='<input type="submit" class="button3" name="newVirt['.$row[0].']" value="Edit">
				<a href="#" onClick="javascript: if(FinalConfirm(\'Do you really want to delete this item ?\')) with(document.alias_list) { del_virt.value=\''.$row[0].'\'; submit(); }"><img src="'.WEBDIR.'/images/stop.gif" alt="DEL" border="0" width="16" height="16" align="absmiddle"></a>';
				else $z.='&nbsp;';
			$z.='</td><td>'.($row[0]!='' ? $row[0] : '*').'</td>
				<td><input type="text" class="edit" name="virt_to['.$row[0].']" value="'.$row[1].'" size="120" maxlength="1500"></td></tr>'.chr(13).chr(10);
		}
		$b = str_replace('<tr><td>{VLIST}</td></tr>',$z,$b);
			
		echo $b;
	}
	else die('Could not find template - alias.htm');

?>