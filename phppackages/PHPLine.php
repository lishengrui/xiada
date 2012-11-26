<?php
function pbegin($environment,$comment){
	if($environment=="pline"){
		echo "<!--".$comment."-->\n";
		return;
	}
}
function pend($environment){
	if($environment=="pline"){
		echo "\n";
		return;
	}
}
function pline($out_text,$init_indent_level,$indent_level){
	$out_pre_space = str_repeat("\t",$init_indent_level).str_repeat("  ",$indent_level);
	echo $out_pre_space.$out_text."\n";
}
function ppre($info,$init_indent_level,$indent_level){
	$out_pre_space = str_repeat("\t",$init_indent_level).str_repeat("  ",$indent_level);
	echo $out_pre_space."<pre>".$info."</pre>"."\n";
}
function autolink($text){
	$ret = ' ' . $text;
	
	//TODO
	$ret = str_replace("http"," http", $ret);
	$ret = str_replace("ftp"," ftp", $ret);
	$ret = str_replace("html,","html ,", $ret);
	$ret = str_replace("html，","html ,", $ret);
	$ret = str_replace("htm,","htm ,", $ret);
	$ret = str_replace("php,","php ,", $ret);
	$ret = str_replace("/,","/ ", $ret);
	$ret = str_replace(".tv,",".tv ", $ret);
	$ret = str_replace("/ ftp","/ftp", $ret);
	
    $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", 
    					"'\\1<a style=\"color:blue;\" target=\"_blank\" href=\"\\2\" >\\2</a>'", 
    					$ret);
    $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", 
    					"'\\1<a style=\"color:blue;\" target=\"_blank\" href=\"http://\\2\" >\\2</a>'", 
    					$ret);
    $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", 
    					"\\1<a style=\"color:blue;\" href=\"mailto:\\2@\\3\">\\2@\\3</a>", 
    					$ret);
	$ret = substr($ret, 1);

    return($ret);
}
function get_service_time(){
	date_default_timezone_set('Asia/Shanghai');
	return date('Y-m-d H:i:s',time());
}

?>
