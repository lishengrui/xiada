<?php
		header( "Content-type:   text/html;charset=UTF-8");
		$linkID = @mysql_connect("localhost", "xiada", "xiadaorgpass")
			or die("connect db error");
		@mysql_select_db("xiada_org") or die("select db error");
		echo '<p>beg</p>';
		//标题
		$topic_title = trim($_POST['title']);
		$topic_title = htmlspecialchars($topic_title);
		//内容
		$topic_content = trim($_POST['content']);
		//var_dump($topic_content);
		//echo $topic_content;
		$topic_content = htmlspecialchars($topic_content);
		var_dump($topic_content);

		//作者
		$topic_author = trim($_POST['author']);
		$topic_author = htmlspecialchars($topic_author);
		//类型
		$topic_type = $_POST['type'];
		date_default_timezone_set('Asia/Shanghai');
		$post_time = date('Y-m-d H:i:s',time());
		$query_insert_data = "INSERT INTO dots_topic_table (topic_title, topic_content, topic_author, topic_type, post_time)";
		$query_insert_data = $query_insert_data." values ('$topic_title', '$topic_content', '$topic_author', '$topic_type', '$post_time');";
		echo $query_insert_data;
		mysql_query($query_insert_data);
		mysql_close();
		header('Location:/dots/index.php');
		
	//include "index2.php";
	// $messagefile = new DomDocument(); 
	// //load messagefile
	// $messagefile->load('messages.xml'); 
	
	// //read xml data
	// $threads = $messagefile->documentElement; 
	
	// //get the root xml node
	// //create a new thread node and insert before first node
	// $thread = $messagefile->createElement('thread');
	// $threads->insertBefore($thread,$threads->firstChild); 
	
	// //create title node and append to the new thread 
	// $title = $messagefile->createElement('title'); 
	// $title_str = trim($_POST['title']);
	// $title_str = htmlspecialchars($title_str);
	// if(empty($title_str)) exit('text');
	// $title->appendChild($messagefile->createTextNode($title_str)); 
	// $thread->appendChild($title); 
	
	// //create time node and append to the new thread 
	// $time = $messagefile->createElement('time'); 
	// $time->appendChild($messagefile->createTextNode(date("Y-m-d")));
	// $thread->appendChild($time);

	// //create type node and append to the new thread 
	// $type = $messagefile->createElement('type');
	// $type_str = trim($_POST['type']);
	// if(empty($type_str)) exit('type');
	// $type->appendChild($messagefile->createTextNode($type_str));
	// $thread->appendChild($type);

	// //create author node and append to the new thread
	// $author = $messagefile->createElement('author');
	// $author_str = trim($_POST['author']);
	// $author_str = htmlspecialchars($author_str);
	// if(empty($author_str)) exit('author');
	// $author->appendChild($messagefile->createTextNode($author_str));
	// $thread->appendChild($author); 

	// //create content node and append to the new thread  
	// $content = $messagefile->createElement('content'); 
	// $content_str = trim($_POST['content']);
	// $content_str = htmlspecialchars($content_str);
	// if(empty($content_str)) exit('content');
	// $content->appendChild($messagefile->createTextNode($content_str)); 
	// $thread->appendChild($content); 

	// //save the xml file
	// $fp = fopen("messages.xml", "w"); 
	// $success = fwrite($fp, $messagefile->saveXML());
	// fclose($fp);
	// if($success){
		// header('Location:/dots/');
	// }else{
		// echo 'Fuck,Fail to save,-__-|||';
	// }
?> 
