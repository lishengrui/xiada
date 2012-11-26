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
		
		<?php   
			function autolink($text)    
			{   
				$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\1" target=_blank rel=nofollow>\1</a>', $text);   
				if(strpos($text, "http") === FALSE ){   
					$text = eregi_replace('(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="http://\1" target=_blank rel=nofollow >\1</a>', $text);   
				}
				else{
					$text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '\1<a href="http://\2" target=_blank rel=nofollow>\2</a>', $text);   
				}
				return $text;    
			}
			
			function format_analyse($text)
			{
				$begIndex = 0;
				$endIndex = 0;
				$retString = '';
				$brHtml = '<br />';
				$brLen = strlen($brHtml);
				$breakFlag = false;
				while(true)
				{
					if(strlen($text) == 0)
					{
						break;
					}
					$endIndex = stripos($text, $brHtml);
					if($endIndex == false)
					{
						$breakFlag = true;
						$endIndex = strlen($text);
					}
					
					
					//$endIndex += $brLen;
					//$leftString = substr($text, 0, $begIndex);
					$midString = '';
					$rightString = '';
					$midString = substr($text, 0, $endIndex);
					$rightString = substr($text, $endIndex + $brLen);
					$midString = format_line($midString);
					$retString = $retString.$midString.$brHtml;
					$text = $rightString;
					if($breakFlag == true)
					{
						break;
					}
					$endIndex++;
				}
				return $retString;
			}
			
			function format_line($line)
			{
				//isSurround为true代表前后都必须有该符号
				//三级标题
				$symbol[0] = '====';
				$isSurround[0] = true;
				$surroundHtmlBeg[0] = '<font style="font-size:100%">';
				$surroundHtmlEnd[0] = '</font>';
				//二级标题
				$symbol[1] = '===';
				$isSurround[1] = true;
				$surroundHtmlBeg[1] = '<font style="font-size:110%">';
				$surroundHtmlEnd[1] = '</font>';
				//一级标题
				$symbol[2] = '==';
				$isSurround[2] = true;
				$surroundHtmlBeg[2] = '<font style="font-size:150%">';
				$surroundHtmlEnd[2] = '</font>';
				//加点，缩进
				$symbol[3] = '***';
				$isSurround[3] = false;	
				$surroundHtmlBeg[3] = '<ul><ul><ul><li>';
				$surroundHtmlEnd[3] = '</li></ul></ul></ul>';
				$symbol[4] = '**';
				$isSurround[4] = false;	
				$surroundHtmlBeg[4] = '<ul><ul><li>';
				$surroundHtmlEnd[4] = '</li></ul></ul>';
				$symbol[5] = '*';
				$isSurround[5] = false;	
				$surroundHtmlBeg[5] = '<ul><li>';
				$surroundHtmlEnd[5] = '</li></ul>';
				
				$begHtml = '';
				$endHtml = '';
				$symbolNum = count($symbol);
				for($i = 0; $i < $symbolNum; $i++)
				{
					$line = eregi_replace("\r\n", "", $line);
					$line = eregi_replace("\r", "", $line);
					$line = eregi_replace("\n", "", $line);
					
					$index = stripos($line, $symbol[$i]);
					if($index === 0)
					{
						//去掉原有格式符号
						$symbolLen = strlen($symbol[$i]);
						echo 'i1 = '.$i.'<br/>';
						echo $symbolLen.'<br/>';
						$line = substr($line, $symbolLen);
						echo $line.'<br/>';
						// echo $line.'<br/>';
						if($isSurround[$i] == true)
						{
							$len = strlen($line) - $symbolLen;
							echo 'substr len: '.$len.'<br/>';
							$line = substr($line, 0, strlen($line) - $symbolLen);
						}
						// //前后增加的HTML标记
						// $begHtml = $begHtml.$surroundHtmlBeg[$i];
						// $endHtml = $surroundHtmlEnd[$i].$endHtml;
						break;
					}
				}
				//$symbol[] = '';	$isSurround[] = ;	
				//$symbol[] = '';	$isSurround[] = ;	
				//$line = $begHtml.$line.$endHtml;
				return $line;
			}
			
			function text_process($text)
			{
				$text = format_analyse($text);
				$text = autolink($text);
				return $text;
			}
			
			function get_service_time()
			{
				date_default_timezone_set('Asia/Shanghai');
				return date('Y-m-d H:i:s',time());
			}
		?>
		
		
		
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
			//$guestbook = simplexml_load_file('messages.xml');
			//打开数据库连接
			$linkID = @mysql_connect("localhost", "xiada", "xiadaorgpass")
				or die("connect db error");
			@mysql_select_db("xiada_org") or die("select db error");
			$query_select_all_data = "SELECT * FROM dots_topic_table ORDER BY topic_id DESC;";
			$result_select_all_data = mysql_query($query_select_all_data);
			$rownum = mysql_numrows($result_select_all_data);
			

			$message_id = 0;
			//foreach($guestbook->thread as $th) {
			for($row_counter = 0; $row_counter < mysql_numrows($result_select_all_data); $row_counter++)
			{
				$topic_id = mysql_result($result_select_all_data, $row_counter, 'topic_id');
				$topic_title = mysql_result($result_select_all_data, $row_counter, 'topic_title');
				$topic_content = mysql_result($result_select_all_data, $row_counter, 'topic_content');
				$topic_author = mysql_result($result_select_all_data, $row_counter, 'topic_author');
				$topic_type = mysql_result($result_select_all_data, $row_counter, 'topic_type');
				$post_time = mysql_result($result_select_all_data, $row_counter, 'post_time');
		
				//循环读取XML数据中的每一个thread标签
				$space3="\t\t\t";
				$space4="\t\t\t\t";
				$space5="\t\t\t\t\t";
				$dspace3=$space3;
				if($message_id==0) $dspace3="\t";
				echo $dspace3.'<div class="message catagory'.$topic_type.'" '.'type="'.$topic_type.'">'."\n";
				
				// //帖子顶部
				echo $space4.'<div class="messageHeader catagoryh'.$topic_type.'" '.'>'."\n";
				echo $space5.$catagorys[$topic_type - 1]."\n";
				echo $space5.text_process($topic_title)."\n"; 
				echo $space4."</div>";
				
				// //帖子内容
				echo $space4.'<p class="messageContent">'.text_process(nl2br($topic_content)).$space4."</p>\n";
				
				// //帖子脚部
				echo $space4.'<a href="guestBookPost.php?reply='.$topic_id.'">＠回复</a>'."\n";
				echo $space5.$post_time."\n";
				echo $space5.$topic_author."<br/>\n";
				
				echo $space3."</div>"."\n"."\n";
				$message_id += 1;
			} 
			mysql_close();
		?> 
		</div>
	</div>
	</body>
</html>
