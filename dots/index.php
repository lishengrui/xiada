<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>5DG-dots</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="projects.css" type="text/css" />	
		<script src="../jquery/jquery-1.5.2.js" type="text/javascript"></script>
		<script src="../jquery/char-count.js" type="text/javascript"></script>
	</head>
	<body>
		<!--页头-->	
		<div id="header">	
				<script type="text/javascript">
					function show_all_messages(){
						$("div.message").fadeIn();
					}
				</script>		
				<a href="javascript:;" onclick="show_all_messages();">
					<img src="../../images/dots_big.png" alt="" id="firstimg"/> 	
				</a>	
				<a href="http://www.xiada.org" >
					<img src="../../images/op.jpg" alt="" />		
				</a>
				<div id="profile">
					dots, a robot, Independently thinking and reading. [dots@xiada.org]
				</div>
				<div id="login">
					<!--<a href="" class="lightlink">登录</a>-->
				</div>
		</div>	
		<div id="main">		
			<!--左侧-->
			<div id="leftpage" >
				<?php
				//马甲列表
				$alias_dic = array(
					"fanfeilong"=>array("fanfeilong","ffl","范飞龙","飞龙","肥龙","feilong","fl"),
					"lishengrui"=>array("lishengrui","lsr","李胜睿","胜睿","shengrui","arui","啊睿","李老师"),
					"linsuyang"=>array("linsuyang","lsy","林舒杨","林舒扬"," 舒杨","舒扬","suyang"),
					"zhangxijing"=>array("zhangxijing","zxj","张希婧","张希倩","希倩","希婧"),
					"taolijun"=>array("taolijun","lijun","taotao","taolj","tao_lj","陶丽君","丽君","陶陶"),
					"caijingjing"=>array("caijingjing","jingjing","蔡静静","静静","jing"),
					"zengsai"=>array("zhengsai","曾赛","啊赛","阿賽","啊賽","阿赛"),
					"liuyue"=>array("liuyue","刘悦","刘跃"),
					"wangyuxiang"=>array("wangyuxiang","laowang"),
					"linyanni"=>array("linyanni","yanni","林嫣妮","嫣妮","abu","啊布"),
					"lihong"=>array("lihong","李宏","琪琪","qiqi","啊睿老婆"),
					"zhengle"=>array("zhengle","jennal","郑乐","郑玏","郑王力"),
					"hanbaosheng"=>array("hanbaosheng","韩宝深","tyreal")
				);

				//作者图片
				$author_pic = array(
					"fanfeilong"=>array("feilong.jpg","franky.jpg"),
					"lishengrui"=>array("arui2.jpg","lufei.jpg"),
					"linsuyang"=>array("lsy.jpg","zuoluo.jpg"),
					"zhangxijing"=>array("zhangxijing.jpg","robin.jpg"),
					"taolijun"=>array("taotao.jpg","blueblue.jpg"),
					"caijingjing"=>array("jing.jpg","qiaoba.jpg"),
					"wangyuxiang"=>array("laowang.jpg","shanzi.jpg"),
					"liuyue"=>array("liuyue.png","futurama.jpg"),
					"zengsai"=>array("zengsai.png","doulaimao.png")
					);

				//替换字符列表
				$charater_dic = array(
					"“"=>"「","”"=>"」",
					//"《"=>"&lt;&lt;","》"=>"&gt;&gt;",
					"【"=>"「","】"=>"」",
					"["=>"「","]"=>"」"
				);

				//过滤帖子时间
				$filter_date_dic = array(
					"2011-12-17 13:10:19",
					"2011-12-17 13:08:32",
					"2011-12-17 13:04:52",
					"2011-12-17 13:06:35"
				);

				//排版设置
				$prespace="				";
				$tabspace="    ";
				?>

				<script type="text/javascript">
					var alias_dic = <?php echo json_encode($alias_dic);?>;
					function filter_by_author(author){
						var alias = alias_dic[author];
						$("div.message").fadeOut();
						for(var alia in alias){
							$("div."+alias[alia]).fadeIn();
						}
					}
				</script>

				<?php
				//根据马甲列表生成作者标签列表
				foreach ($alias_dic as $author => $alias) {
					if (array_key_exists($author, $author_pic)) {
						$author_img = $author_pic[$author][1];
						$author_img_hov=$author_pic[$author][0];
					}else{
						$author_img = "unknow.jpg";
						$author_img_hov="majia.jpg";
					}

					echo $prespace.'<div class="button">'."\n";
					echo $prespace.'	<a  href="javascript:;" '."\n";
					echo $prespace.'	    onclick="filter_by_author(\''.$author.'\');"'."\n";
					echo $prespace.'	    class="navilink" '."\n";
					echo $prespace.'	onmouseout="this.style.backgroundImage=\'url(../images/small/'.$author_img.')\'"'."\n";
					echo $prespace.'	    style="background:url(\'../images/small/'.$author_img.'\')no-repeat #fff center center;">'."\n";
					echo $prespace.'	</a> '."\n";
					echo $prespace.'</div>'."\n";
				}

					function get_douban_book_url($book){
						$book_name=$book[1];
						if($book_name=='CLRvaC#第三版'){
							$book_name='C# va CLR';
						}
					
						if($book_name=='Body Part'){
							$link_url='http://www.amazon.com/Body-Parts-Vicki-Stiefel/dp/0843953179';
							$ret = '<a href=\''.$link_url
							       .'\' target=\'_blank\'>'.'&lt;&lt;'
							       .$book_name.'&gt;&gt;'.'</a>';
							return $ret;
						}
					
						$tagheader = 'http://api.douban.com/book/subjects?q=';
						$geturl =$tagheader.urlencode($book_name).'&start-index=1&max-results=1';
						$query = file_get_contents($geturl); 
						$feed = simplexml_load_string($query);
						$children =  $feed->children('http://www.w3.org/2005/Atom');
						$entry =simplexml_load_string($children->entry->asXML());
					
						if($entry==true){
							$links=$entry->xpath('/entry/link[2]');
							$link = $links[0];
							$link_attributes = $link->attributes();
							$link_url=$link_attributes['href'];
							$ret = '<a href=\''.$link_url.'\' target=\'_blank\'>'.'&lt;&lt;'.$book_name.'&gt;&gt;'.'</a>';
							return $ret;
						}else{
							return  '<a href=\'https://www.google.com/search?q='
							        .$book_name.'\' target=\'_blank\'>'.'&lt;&lt;'
							        .$book[1].'&gt;&gt;'.'</a>';
						}
					}
				?>
			</div>

			<!--中间视图--!>
			<div id="centerpage" >
				<!--留言对话框模块-->
				<script type="text/javascript">
					$(document).ready(function(){ 
						//custom usage
						$("#content").charCount({
							allowed: 512, 
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
							if(validate_required(title,"您写的真好，来个漂亮的标题？")==false){
								title.focus();
								return false
							}
							if(validate_required(author,"雁过留声,人过留名。")==false){
								author.focus();
								return false;
							}
							var txtcontent = $('#content').val();
							if(txtcontent.length > 512){
								alert("轻轻的，你留言，不多写一个字。");
								content.focus();
								return false;
							}
						}
					}
				</script>
				<div class="inputDialog">
					<form name="form1" method="post" action="newmessage.php"  onsubmit="return validate_form(this)"> 
						<div class="inputText">
							<textarea name="content" cols="50" rows="2" id="content"></textarea>
						</div>
						<div class="inputHeader">
							<span class="inputSubHeader">标题</span>
							<input name="title" type="text" id="title" size="65">
							<span class="inputSubHeader">作者</span>
							<input name="author" type="text" id="author" size="10">
							<select name="type">
								<option value="1">Target          </option>
								<option value="2">Question        </option>
								<option value="3">Done            </option>
							</select>
							<input id="submit" type="submit" value="↓↓↓发布" >
						</div>
					</form>
				</div>
			    
				

				<!--留言内容-->
				<div class="messageView">
					<?php   
						require_once(dirname(__FILE__).'/../phppackages/PHPLine.php');
						//分类列表数组
						$catagorys = array("→","？","√");
						//打开数据库连接
						$linkID = @mysql_connect("localhost", "xiada", "xiadaorgpass")
							or die("connect db error");
						//mysql_query("SET NAMES 'utf8'");

						@mysql_select_db("xiada_org") or die("select db error");
						$query_select_all_data = "SELECT * FROM dots_topic_table ORDER BY post_time DESC;";
						$result_select_all_data = mysql_query($query_select_all_data);
						$rownum = mysql_numrows($result_select_all_data);
						
						$message_id = 0;
						for($row_counter = 0; $row_counter < mysql_numrows($result_select_all_data); $row_counter++)
						{
							$post_time = mysql_result($result_select_all_data, $row_counter, 'post_time');
							if (in_array($post_time, $filter_date_dic)) {
								continue;
							}
							
							$topic_id = mysql_result($result_select_all_data, $row_counter, 'topic_id');
							$topic_title = mysql_result($result_select_all_data, $row_counter, 'topic_title');
							$topic_content = mysql_result($result_select_all_data, $row_counter, 'topic_content');
							$topic_author = mysql_result($result_select_all_data, $row_counter, 'topic_author');
							$topic_type = mysql_result($result_select_all_data, $row_counter, 'topic_type');
							$topic_content = str_replace("-&gt;","<br/>-&gt;",$topic_content);
							$topic_content = trim($topic_content,"<br/>");

							//替换字符
							foreach($charater_dic as $key=>$value){
								$topic_title = str_replace($key,$value,$topic_title);
								$topic_content = str_replace($key,$value,$topic_content);
							}
							$topic_content = str_replace("“","<br/>-&gt;",$topic_content);
							$topic_content = preg_replace('/"([^"]*)"/', '<q>${1}</q>', $topic_content);

							//自动添加语义链接
							$book_pattern = '/《([^《]*[上]?[一]?[^《]*[局]?)》/';
							$topic_content = autolink($topic_content);
							$topic_content = preg_replace_callback($book_pattern,'get_douban_book_url',$topic_content);
							$topic_title = autolink($topic_title);
							$topic_title = preg_replace_callback($book_pattern,'get_douban_book_url',$topic_title);

							//循环读取XML数据中的每一个thread标签
							$space3="\t\t\t";
							$space4="\t\t\t\t";
							$space5="\t\t\t\t\t";
							$dspace3=$space3;
							if($message_id==0) $dspace3="\t";
							echo $dspace3.'<div class="message catagory'.$topic_type.' '.$topic_author.'" '.'type="'.$topic_type.'">'."\n";
							
							// //帖子顶部
							echo $space4.'<div class="messageHeader catagoryh'.$topic_type.'" '.'>'."\n";
							echo $space5.$catagorys[$topic_type - 1]."\n";
							echo $space5.$topic_title."\n"; 
							echo $space4."</div>\n";
							
							// //帖子内容
							echo $space4.'<p class="messageContent">'."\n".$topic_content."\n".$space4."</p>\n";
							
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

		<!--页脚-->
		<div id="footer">	

		</div>
	</body>
</html>
