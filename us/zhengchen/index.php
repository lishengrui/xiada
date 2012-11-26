<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>5dg-zhengchen</title>
		<link rel="stylesheet" href="monkeyface.css" type="text/css" />	
		<link rel="icon" href="../../images/hat.ico" />
		<script src="../../jquery/jquery-1.5.2.js" type="text/javascript"></script>
		<script type="text/javascript">
				//-----------------------------------------------//
				//ajax动态解析学校内容并返回添加到
				//conterpage 
				//-----------------------------------------------//

				$(document).ready( function () {
				//show the first school information by ajax
				var firstschool = $('.school-button:first');
				var jqxhr = $.post("school.php",
						{school_id:firstschool.attr("id"), school_name:firstschool.text()}, 
						function(data) {
							$('#centerpage').html(data);
					});
				//add ajax to school-button
				$('.school-button').click ( function () {
					 $(".school-button").each(function(){
    					$(this).removeClass("hilight-button");
  					 });
					 $(this).addClass("hilight-button");
					 var jqxhr = $.post(
						"school.php",
						{school_id:this.id, school_name:$(this).text()}, 
						function(data) {
							$('#centerpage').html(data);
						});
				});
			});
		</script>	
	</head>

	<body >	
		<!--
		//---------------------------------//
		//全局代码区
		//在此写业务逻辑
		//---------------------------------//
		-->
		<?php
				//初始化
				ini_set('display_errors', 'On');
				date_default_timezone_set('PRC');
				
				//加载库文件
				require_once(dirname(__FILE__).'/../../phppackages/PHPLinq.php');
				require_once(dirname(__FILE__).'/../../phppackages/PHPQuery.php');
				require_once(dirname(__FILE__).'/../../phppackages/PHPLine.php');

				//读取schools.xml
			  $schoolsFile = "schools.xml";
				$doc = phpQuery::newDocumentFileXML($schoolsFile,$charset = 'utf-8')->find('schools');
				$today=strtotime("now");  
				//遍历、排序、转换
				$school_button_array=array();
				foreach(pq('school') as $school) {
						//计算作品截止日期
						$profile_dead_line = pq("[key='Portfolia截止日期']",$school);
						$profile_end_day=strtotime(pq($profile_dead_line)->text());
						$is_end_day_valid=$profile_end_day!=false;

						//拼接school_button
						$school_id = pq($school)->attr('id');
						$school_name = pq($school)->attr('name');

						//添加到school_button_array
						if($is_end_day_valid){
								$profie_rest_day = round(($profile_end_day-$today)/3600/24);

								$status_tag = 'school-prority-normal';
								if($profie_rest_day >= 0 && $profie_rest_day <= 10){
										$status_tag = 'school-prority-high';
								}
								if($profie_rest_day < 0){
										$status_tag = 'school-prority-partial-done';
								}

								$school_button=
										 "<a class='school-button ".$status_tag."' id='".$school_id."' href=\"javascript:void(0)\">"
										//."<span class='profile_rest_day'>".$profile_rest_day."</span>"
										.$school_name
										."</a>";

								$school_button_array[$profie_rest_day][]=$school_button;
						}else{
								$status_tag = 'school-prority-low';
								$school_button=
										"<a class='school-button ".$status_tag."' id='".$school_id."' href=\"javascript:void(0)\">"
										.$school_name
										."</a>";
								$school_button_array[365][]=$school_button;
						}
						
				}	
				
				//根据作品截止日期排序	
				function datesort($a,$b) {
						if($a<0 && $b>0){
								return true;
						}

						if($a<0 && $b<0){
								return $a<$b;
						}

						if($b<0 && $a>0){
								return false;
						}

						return $a>$b;
				}
				uksort($school_button_array,'datesort');
				
				//其他全局变量
				$space='			';
				$state_colors=array("#D198C3","#C9E5AD","#B6ADE5","#E5D9AD");
		?>

		<!--
		//---------------------------------//
		//div:main, 关注布局和内容，
		//样式和动画尽量交给外部css/js处理
		//---------------------------------//
		-->
		<div class="main">
		<!--页头-->	
		<div id="header">			
				<img src="../../images/unknow.jpg" alt="" id="firstimg"/> 		
				<img src="../../images/op.jpg" alt=""/>		
				<div id="title">
					郑晨 (+86) 158–59609689  [gracezhengchen@gmail.com]
				</div>
				<div id="login">
					<a href="" class="lightlink">登录</a>
				</div>
		</div>	
		<div id="content">	
			<!--左侧-->
			<div id="leftpage" class="navigator" >
				<?php
				pbegin("pline","网申学校列表");
				pline("<div id='school-navigator'>",3,1);
				foreach($school_button_array as $rest_date=>$buttons){
						foreach($buttons as $button){
								pline($button,3,2);
						}
				}
				pline("</div>",3,1);
				pend("pline");
				?>
			</div>

			<!--中间视图--!>
			<div id="centerpage" >
			
			</div>
		</div>	

		<!--页脚-->
		<div id="footer">	

		</div>
	</div>
	</body>
</html>
