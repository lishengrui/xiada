<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>5DG海贼团-dots</title>
		<link rel="stylesheet" href="projects.css" type="text/css" />	
		<script src="../jquery/jquery-1.5.2.js" type="text/javascript"></script>
		<script src="../jquery/char-count.js" type="text/javascript"></script>
	</head>
	<body class="body">
	<div class="headspace"></div>
	<div class="head">
		<!--导航条-->
		<script type="text/javascript">		
			function showHome(){
				$("div.message").fadeIn();
			}
			function showMessages(id){
				$("div.message").fadeOut();
				$("div.message[type="+id+"]").fadeIn();
			}
		</script>
		<div class="navigator">
			<ul>
				<li style="background-color:#FF8400"><a href="javascript:;" onclick="showHome();" >↑&nbsp;首页</a></li>
				<li style="background-color:#E42B2B"><a href="javascript:;" onclick="showMessages(1);">→&nbsp;任务列表</a></li>
				<li style="background-color:#A800FF"><a href="javascript:;" onclick="showMessages(2);">？&nbsp;问题列表</a></li>
				<li style="background-color:#49A7F3"><a href="javascript:;" onclick="showMessages(3);">√&nbsp;已完成列表</a></li>
			</ul>
		</div>
	</div>
	<div class="mainView">
		
		<!--留言对话框模块-->
		<script type="text/javascript">
			$(document).ready(function(){ 
				//custom usage
				$("#content").charCount({
					allowed: 140, 
					warning: 10,
					counterText: '剩下字数:'
				});
			});

			function validate_required(field,alerttxt){
				with (field){
					if (value==null||value==""){
						alert(alerttxt);
						return false;
					}else {
						return true;
					}
				}
			}

			function validate_form(thisform){
				with(thisform){
					if(validate_required(title,"您写的真好，来个漂亮的标题？                                                                ")==false){
						title.focus();
						return false
					}
					if(validate_required(author,"雁过留声,人过留名.                                                                          ")==false){
						author.focus();
						return false;
					}
					var txtcontent = $('#content').val();
					if(txtcontent.length > 140){
						alert("轻轻的，你留言，不多写一个字。                                                              ");
						content.focus();
						return false;
					}
				}
			}
			
		</script>
		
		<div class="inputDialog">
		    <form name="form1" method="post" action="newmessage.php"  onsubmit="return validate_form(this)"> 
			<div class="inputText">
				<textarea name="content" cols="71" rows="2" id="content"></textarea>
			</div>
			<div class="inputHeader">
				<span class="inputSubHeader">标题</span>
				<input name="title" type="text" id="title" size="35">
				<span class="inputSubHeader">作者</span>
				<input name="author" type="text" id="author" size="11">
				<select name="type">
  					<option value="1">任务列表              </option>
  					<option value="2">问题列表              </option>
  					<option value="3">已完成列表            </option>
				</select>
				<input id="submit" type="submit" value="○↓发布" >
			</div>
		    </form>
		</div>
		

		<!--留言内容-->
		<div class="messageView">
		<?php   //分类列表数组
			$catagorys = array("→","？","√");

			//打开用于存储留言的XML文件
			$guestbook = simplexml_load_file('messages.xml');

			$message_id = 0;
			foreach($guestbook->thread as $th) {
				//循环读取XML数据中的每一个thread标签
				$space3="\t\t\t";
				$space4="\t\t\t\t";
				$space5="\t\t\t\t\t";
				$dspace3=$space3;
				if($message_id==0) $dspace3="\t";
				echo $dspace3.'<div class="message catagory'.$th->type.'" '.'type="'.$th->type.'">'."\n";
				
				//帖子顶部
				echo $space4.'<div class="messageHeader catagoryh'.$th->type.'" '.'>'."\n";
				echo $space5.$catagorys[$th->type-1]."\n";
				echo $space5.$th->title."\n"; 
				echo $space4."</div>\n";
				
				//帖子内容
				echo $space4.'<p class="messageContent">'."\n".$th->content."\n".$space4."</p>\n";
				
				//帖子脚部
				echo $space4.'<a href="guestBookPost.php?reply='.$message_id.'">＠回复</a>'."\n";
				echo $space5.$th->time."\n";
				echo $space5.$th->author."<br/>\n";
				
				echo $space3."</div>"."\n"."\n";
				$message_id += 1;
			} 
		?> 
		</div>
	</div>
	</body>
</html>
