<?php
include('./INC/DBASE.PHP');
session_start();

if(isset($_POST['logout']))
{
	unset($_SESSION['login_mail']);
}

if(isset($_POST['cmdLogin']))
{
	$u = ivo_str($_POST['log_user']);
	$p = ivo_str($_POST['log_pass']);
	$query = 'SELECT ID FROM DOMAIN_USER WHERE USER="'.mysql_real_escape_string(substr($u,0,35)).'" AND PASS="'.mysql_real_escape_string(substr($p,0,30)).'"';
	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
	if(mysql_num_rows($result)) $_SESSION['login_mail'] = mysql_result($result,0,0);
		else $err='Wrong username or password';
}

if($_GET['admin']!=0)
{
	$query = 'UPDATE DOMAIN_USER SET IS_ADMIN = NOT IS_ADMIN WHERE ID='.$_GET['admin'];
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	header('Location:index.php');
	die;
}

// must be after login and after Admin ON/OFF
if($_SESSION['login_mail']!=0)
{
	$query = 'SELECT IS_ADMIN,TITLE FROM DOMAIN_USER WHERE ID='.$_SESSION['login_mail'];
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	if(mysql_num_rows($result))
	{
		$is_admin = mysql_result($result,0,0);
		$title = mysql_result($result,0,1);
	}
}

if(isset($_POST['cmdDomain']) AND $is_admin)
{
	$dom = ivo_str($_POST['new_dom']);
	$adm = (int)$_POST['adm_owner'];
	if($dom=='') $err='Missing domain name';
	elseif(strlen($dom)>64) $err='Domain names can be no longer than 64 symbols';
	elseif(!dom_check($dom)) $err='Invalid format for domain name';
	else
	{
		if($_SESSION['login_mail']==0) adm_login();
		$query = 'INSERT IGNORE INTO DOMAIN(DOMAIN,ADM_USER) VALUES("'.mysql_real_escape_string($dom).'",'.$adm.')';
		$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		header('Location:index.php');
		die;
	}
}

if(isset($_POST['cmdAdmin']) AND $is_admin)
{
	$adm_title = ivo_str($_POST['new_title']);
	$adm_user = ivo_str($_POST['new_user']);
	$adm_pass = ivo_str($_POST['new_pass']);
	if($adm_title=='') $err='Missing supervisor friendly name';
	elseif($adm_user=='') $err='Missing supervisor username';
	elseif($adm_pass=='') $err='Missing supervisor password';
	else
	{
		$query = 'INSERT IGNORE INTO DOMAIN_USER(TITLE,USER,PASS) VALUES("'.mysql_real_escape_string($adm_title).'","'.mysql_real_escape_string($adm_user).'","'.mysql_real_escape_string($adm_pass).'")';
		$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	}
}

if($_GET['del_dom']!=0 AND $is_admin)
{
	$query = 'DELETE FROM DOMAIN WHERE ID='.$_GET['del_dom'];
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
}

if($_GET['del_adm']!=0 AND $is_admin)
{
	$query = 'DELETE FROM DOMAIN_USER WHERE ID='.$_GET['del_adm'];
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	$query = 'UPDATE DOMAIN SET ADM_USER=NULL WHERE ADM_USER='.$_GET['del_adm'];
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
}

if(is_array($_POST['newDom']) AND $is_admin) foreach($_POST['adm_dom'] as $k=>$v)
{
	$query = 'UPDATE DOMAIN SET ADM_USER='.(int)$v.' WHERE ID='.$k;
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
}

if(is_array($_POST['newAdm']) AND $is_admin) foreach($_POST['newAdm'] as $k=>$v)
{
	$query = 'UPDATE DOMAIN_USER SET TITLE="'.mysql_real_escape_string($_POST['adm_title'][$k]).'",USER="'.mysql_real_escape_string($_POST['adm_user'][$k]).'",PASS="'.mysql_real_escape_string($_POST['adm_pass'][$k]).'" WHERE ID='.$k;
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
}

if($b = @file_get_contents($tmpdir.'/index.htm'))
{
	if($err!='') $z = 'alert("'.$err.'");';
		else $z = '';
	$b = str_replace('<!--{ERROR}-->',$z,$b);
	$b = str_replace('{PREP}',WEBDIR,$b);

	$b = str_replace('{VIS_ADMIN}',$is_admin ? '' : 'display:none',$b);
	$b = str_replace('{VIS_LOG}',$_SESSION['login_mail']==0 ? '' : 'display:none',$b);
	$b = str_replace('{VIS_UNLOG}',$_SESSION['login_mail']!=0 ? '' : 'display:none',$b);
	$b = str_replace('{ADMIN}',$title,$b);

	// show domain list
	$query = 'SELECT DOMAIN.ID,DOMAIN,TITLE,ADM_USER FROM DOMAIN LEFT JOIN DOMAIN_USER U ON ADM_USER=U.ID ORDER BY DOMAIN';
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	$z = '';
	while($row = mysql_fetch_array($result,MYSQL_NUM))
	{
		$z.='<tr><td><a href="'.WEBDIR.'/domain.php?id='.$row[0].'" class="cl_tit" target="_blank">'.$row[1].'</a></td><td>'.($is_admin ? '<select name="adm_dom['.$row[0].']" class="combo">'.loadItems('DOMAIN_USER','TITLE',$row[3],' ','','TITLE') : ($row[2]!='' ? $row[2] : '&nbsp;')).'</td><td align="center">';
		$query = 'SELECT COUNT(*) FROM users WHERE RIGHT(userid,'.(1+strlen($row[1])).')="@'.mysql_real_escape_string($row[1]).'"';
		$res = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		$num_user = mysql_result($res,0,0); 
		$z.= ($num_user!=0 ? $num_user : '&nbsp;').'</td><td align="center">';
		$query = 'SELECT COUNT(*) FROM virtual WHERE RIGHT(address,'.(1+strlen($row[1])).')="@'.mysql_real_escape_string($row[1]).'" AND LOCATE("_1@",address)=0';
		$res = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		$num_virt = mysql_result($res,0,0); 
		$z.= ($num_virt!=0 ? $num_virt : '&nbsp;').'</td><td align="center">';
		if($is_admin) $z.='<input type="submit" class="button3" name="newDom['.$row[0].']" value="Edit">
			<a href="?del_dom='.$row[0].'"><img src="'.WEBDIR.'/images/stop.gif" alt="DEL" border="0" width="16" height="16" align="absmiddle"></a>';
			else $z.='&nbsp;';
		$z.='</td></tr>'.chr(13).chr(10);
	}
	$b = str_replace('<tr><td>{DLIST}</td></tr>',$z,$b);
	$b = str_replace('<option value="0">{ADM_USER}</option>',loadItems('DOMAIN_USER','TITLE',0,' ','','TITLE'),$b);

	// show domain owners
	$query = 'SELECT * FROM DOMAIN_USER ORDER BY TITLE';
	$result = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
	$z = '';
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$z.='<tr><td><input type="text" class="edit" name="adm_title['.$row['ID'].']" size="35" maxlength="50" value="'.$row['TITLE'].'"></td>
			<td>'.($is_admin ? '<input type="text" class="edit" name="adm_user['.$row['ID'].']" size="22" maxlength="35" value="'.$row['USER'].'">' : '*****').'</td>
			<td>'.($is_admin ? '<input type="text" class="edit" name="adm_pass['.$row['ID'].']" size="22" maxlength="30" value="'.$row['PASS'].'">' : '*****').'</td>
			<td align="center">';
		if($is_admin) $z.='<a href="?admin='.$row['ID'].'">';
		$z.='<img src="'.WEBDIR.'/images/'.($row['IS_ADMIN'] ? 'v' : 'x').'_serif.gif" alt="Admin" border="0" width="16" height="16"></a></td><td>';
		// get list of owned domains
		$query = 'SELECT DOMAIN FROM DOMAIN WHERE ADM_USER='.$row['ID'].' ORDER BY DOMAIN';
		$res = mysql_query($query,$conn) or trigger_error($query.'<br>'.mysql_error($conn),E_USER_ERROR);
		if(mysql_num_rows($res)) while($red = mysql_fetch_array($res,MYSQL_NUM)) $z.= $red[0].'<br>';
			else $z.='&nbsp;';
		$z.='</td><td align="center">';
		if($is_admin) $z.='<input type="submit" class="button3" name="newAdm['.$row['ID'].']" value="Edit">
			<a href="?del_adm='.$row['ID'].'"><img src="'.WEBDIR.'/images/stop.gif" alt="DEL" border="0" width="16" height="16" align="absmiddle"></a>';
			else $z.='&nbsp;';
		$z.='</td></tr>'.chr(13).chr(10);
	}
	$b = str_replace('<tr><td>{ALIST}</td></tr>',$z,$b);
		
	echo $b;
}
else die('Could not find template - index.htm');

?>