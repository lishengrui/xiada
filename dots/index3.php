<html>

<body>

<?php
	echo "==========================\n";
	$str = '³¤¶È';
	// echo strlen($str);
	// echo '<br/>';
	// echo 'mblen: ';
	echo mb_strlen($str, 'UTF8');
	//echo substr($str, 0, 5);
	//ehco 'r = '.$r;
	echo 'test';
	// $linkID = @mysql_connect("localhost", "xiada", "xiadaorgpass")
		// or die("connect db error");
	// @mysql_select_db("xiada_org") or die("select db error");
	// $query_select_all_data = "SELECT topic_title, topic_content, topic_author, topic_type FROM dots_topic_table;";
	// $result_select_all_data = mysql_query($query_select_all_data);
	// $rownum = mysql_numrows($result_select_all_data);
	// echo "row num--$rownum--\n";
	// for($row_counter = 0; $row_counter <= mysql_numrows($result_select_all_data); $row_counter++)
	// {
		// echo mysql_result($result_select_all_data, $row_counter, 'topic_title')."\n";
		// echo mysql_result($result_select_all_data, $row_counter, 'topic_content')."\n";
		// echo mysql_result($result_select_all_data, $row_counter, 'topic_author')."\n";
	// }

?>

</body>

</html>