<?php
//Connect Database
require_once(dirname(__FILE__) . "/../../controls/conf/connect_db.inc");

if(isset($_REQUEST["jid"]))
{
//Getting Job Information
$JID = $_REQUEST["jid"];
$JCREATED=getJobCreatedDate($JID);
$JMASTER=getJobMaster($JID);
$JDESCRIPTION=getJobDescription($JID);
$JDESCRIPTION2=getJobDescription2($JID);
$JOVERALLTIME=getJobOverallTime($JID);
$JMONEY=0;

$OUTPUT='<table width=700><tr><td align=center><h1><u>RECHNUNG</u></h1><br></td></tr></table>
	<table>
	<tr>
		<td colspan="2"><h2><u>Auftrag:</u></h2></td>
	</tr>
	<tr>
		<td width=100><u>ID:</u></td>
		<td width=600>'.$JID.'</td>
	</tr>
	<tr>
		<td width=100><u>Angelegt am:</u></td>
		<td width=600>'.$JCREATED.'</td>
	</tr>
	<tr>
		<td width=100><u>Auftraggeber:</u></td>
		<td width=600>'.$JMASTER.'</td>
	</tr>
	<tr>
		<td width=100 valign="top"><u>Beschreibung:</u></td>
		<td width=600>'.$JDESCRIPTION.'</td>
	</tr>
	<tr>
		<td width=100 valign="top"><u>Beschreibung2:</u></td>
		<td width=600>'.$JDESCRIPTION2.'</td>
	</tr>
	<tr>
		<td width=100><u>Gesamtzeit:</u></td>
		<td width=600>'.$JOVERALLTIME.'</td>
	</tr>
</table>

<br>
<br>
<br>
<br>
<br>
<br>


<table border="0">
	<tr>
		<td colspan="5"><h2><u>Aufwände:</u></h2></td>
	</tr>
	<tr>
		<td width=90><u>Datum:</u></td>
		<td width=180><u>Techniker:</u></td>
		<td width=270><u>Aufwand:</u></td>
		<td width=70><u>Zeit:</u></td>
		<td width=90><u>Kosten:</u></td>
	</tr>';

$result=mysql_query("SELECT id FROM task WHERE assignmentref=$JID");
while($line=mysql_fetch_array($result))
{
	$did=$line['id'];
	$OUTPUT.='<tr>
	<td valign="top">'.getDetailDate($did).'</td>
	<td valign="top">'.getDetailTech($did).'</td>
	<td valign="top">'.getDetailDescription($did).'</td>
	<td valign="top">'.getDetailTime($did).' Std.</td>
	<td valign="top">'.getDetailPayPerHour($did)*getDetailTime($did).' &euro;</td>
	</tr>';
	$JMONEY+=getDetailPayPerHour($did)*getDetailTime($did);
}

$OUTPUT.='	
	<tr>
		<td colspan="5"><hr style="width: 700px;text-align: left;" /></td>
	</tr>
	<tr>
		<td>'.getToday().'</td>
		<td>---</td>
		<td>---</td>
		<td>Gesamt:</td>
		<td>'.$JMONEY.' &euro;</td>
	</tr>
</table>

';

//echo $OUTPUT;

$htmldirname  = dirname(__FILE__) . "/rechnung";
$htmlfilename = $htmldirname . "/$JID.html";
@mkdir($texdirname,'0755');

$Hnd=fopen($htmlfilename,"w");
fwrite($Hnd,$OUTPUT);
fclose($Hnd);

$cmd="htmldoc --webpage --left 1cm --top 1cm --right 1cm --bottom 1cm -f \"$htmldirname/$JID.pdf\" \"$htmldirname/$JID.html\"";
exec($cmd);
//echo "<meta http-equiv=\"refresh\" content=\"0; url=rechnung/$JID.pdf\">";
//echo "\"$htmldirname\\$JID.pdf\"";

$pdffilesize = filesize("rechnung/$JID.pdf");

$Hnd=fopen("rechnung/$JID.pdf","r");
$text=fread($Hnd,$pdffilesize);
fclose($Hnd);
	
header('Content-type: application/pdf');
header("Content-Disposition: attachment; filename=\"$filename\"");
	
printf("%s",$text);}

function getJobCreatedDate($id)
{
	$result=mysql_query("SELECT creationdate FROM assignment WHERE id=$id");
	$line=mysql_fetch_array($result);
	$value=$line['creationdate'];
	$value=convertDate($value);
	return $value;
}

function getJobMaster($id)
{
	$result=mysql_query("SELECT employer FROM assignment WHERE id=$id");
	$line=mysql_fetch_array($result);
	$value=$line['employer'];
	return $value;
}

function getJobDescription($id)
{
	$result=mysql_query("SELECT name FROM assignment WHERE id=$id");
	$line=mysql_fetch_array($result);
	$value=$line['name'];
	return $value;
}

function getJobDescription2($id)
{
	$result=mysql_query("SELECT descritption FROM assignment WHERE id=$id");
	$line=mysql_fetch_array($result);
	$value=$line['descritption'];
	return $value;
}

function getJobOverallTime($id)
{
	$alltime="00:00:00";
	$result=mysql_query("SELECT TIMEDIFF(endtime,starttime) FROM task WHERE id=$id");
	while($line=mysql_fetch_array($result))
	{
		$tmp2=$line['TIMEDIFF(endtime,starttime)'];
		$tmp=mysql_fetch_array(mysql_query("SELECT ADDTIME(\"$tmp2\",\"$alltime\")"));
		$alltime=$tmp[0];
	}
	$splits=explode(":",$alltime);
	$seconds=$splits[0]*60*60+$splits[1]*60+$splits[2];
	return round((int)($seconds/3600)+(($seconds%3600)/3600),2);
}

function getDetailDate($did)
{
	$result=mysql_query("SELECT date(starttime) FROM task WHERE id=$did");
	$line=mysql_fetch_array($result);
	$value=$line[0];
	$value=convertDate($value);
	return $value;
}

function getDetailTech($did)
{
	$result=mysql_query("SELECT userref FROM task WHERE id=$did");
	$line=mysql_fetch_array($result);
	$value=$line['userref'];
	$result=mysql_query("SELECT user FROM user WHERE uid=$value");
	$line=mysql_fetch_array($result);
	$value=$line['user'];
	return $value;
}

function getDetailDescription($did)
{
	$result=mysql_query("SELECT name FROM task WHERE id=$did");
	$line=mysql_fetch_array($result);
	$value=$line['name'];
	return $value;
}

function getDetailTime($did)
{
	$result=mysql_query("SELECT TIMEDIFF(endtime,starttime) FROM task WHERE id=$did");
	$line=mysql_fetch_array($result);
	$value=$line[0];
	$splits=explode(":",$value);
	$seconds=$splits[0]*60*60+$splits[1]*60+$splits[2];
	return round((int)($seconds/3600)+(($seconds%3600)/3600),2);
}

function getDetailPayPerHour($did)
{
	return 60;
}

function getToday()
{
	return date("d.m.Y");
}

function convertDate($date)
{
	$date=explode("-",$date);
	return $date[2].".".$date[1].".".$date[0];
}
?>