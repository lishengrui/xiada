<?php
//header
ini_set('display_errors', 'On');
require_once (dirname(__FILE__) . '/../../phppackages/PHPLinq.php');
require_once (dirname(__FILE__) . '/../../phppackages/PHPQuery.php');
require_once (dirname(__FILE__) . '/../../phppackages/PHPLine.php');

//variables
$schoolsFile = "schools.xml";
$schools = phpQuery::newDocumentFileXML($schoolsFile, $charset = 'utf-8') -> find('schools');
$space = '			';
$state_colors = array("#D198C3", "#C9E5AD", "#B6ADE5", "#E5D9AD");
$school_name = $_POST['school_name'];
$school_id = $_POST['school_id'];
$school = pq('school[id="' . $school_id . '"]', $schools);
$group_types = array("url","todo","done","empty","item");

//calculate dates
date_default_timezone_set('PRC');
$apply_dead_line = pq("[key='网申截至']",$school);
$profile_dead_line = pq("[key='Portfolia截止日期']",$school);
$startdate=strtotime("now");  

$apply_enddate_str=pq($apply_dead_line)->text();
$apply_enddate=strtotime($apply_enddate_str);
$apply_item_value='未知';
if($apply_enddate!=false){
		$apply_item_value=round(($apply_enddate-$startdate)/3600/24);
}

$profile_enddate_str=pq($profile_dead_line)->text();
$profile_enddate=strtotime($profile_enddate_str);
$profile_item_value='未知';
$status_tag = 'school-prority-low';
if($profile_enddate!=false){
		$profile_item_value=round(($profile_enddate-$startdate)/3600/24);
		$status_tag = 'school-prority-normal';
		if($profile_item_value >= 0 && $profile_item_value <= 10){
				$status_tag = 'school-prority-high';
		}
		if($profile_item_value < 0){
				$status_tag = 'school-prority-partial-done';
		}
}

//panel header
pbegin("pline", "+网申学校+ 内容-项目 ");
pline("<div id='school-tables'>", 3, 1);

$shool_tool_bar = 
		  "<div class='table-title ".$status_tag."'>"
		 ."编号:" . $school_id . " 学校:" . $school_name 
		 ."</div>"
pline($school_tool_bar, 3, 2);

//tables
foreach ($group_types as $group_type) {
	pline("<table class='hor-minimalist-b' id='".$group_type."'>", 3, 2);
	pline("<tbody>", 3, 3);
	foreach (pq($group_type,$school) as $item) {
			$item_key = trim(pq($item)->attr("key"));
		  $item_value=pq($item)->text();
			if($item_key=="网申剩余天数"){
					$item_value=$apply_item_value;
			}
			if($item_key=="作品集剩余天数"){
					$item_value=$profile_item_value;
			}
			$item_value=autolink($item_value);
			pline("<tr class='".$group_type."'>", 3, 4);
			pline("<td class='key'>" . $item_key . "</td>", 3, 5);
			pline("<td class='value'>".$item_value . "</td>", 3, 5);
			pline("</tr>", 3, 4);
	}
	pline("</tbody>", 3, 3);
	pline("</table>", 3, 2);
}

//panel end
pline("</div>", 3, 1);
pend("pline");
?>
