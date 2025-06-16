<?php
////////////////////////////Common head
$cache_time = 30;
$OJ_CACHE_SHARE = false;
require_once( './include/db_info.inc.php' );
require_once( './include/bbcode.php' );
require_once( './include/memcache.php' );
require_once( './include/setlang.php' );
$view_title = "浙江高考-校答喵AI";
///////////////////////////MAIN	

	$school=$_GET['school'];
	$special=$_GET['special'];
	$min_mark=$_GET['min_mark'];
	$max_mark=$_GET['max_mark'];
	$min_rank=$_GET['min_rank'];
	$max_rank=$_GET['max_rank'];
	$where="";
	$args=array();
	if(!empty($school)){
		if(!empty($where)) $where.=" and ";
		$where.=" school_name like ? ";
		array_push($args,"%$school%");	
	}
	if(!empty($special)){
		if(!empty($where)) $where.=" and ";
		$sps=explode(" ",$special);
		$spwhere="";
		foreach($sps as $sp){
			if(empty($sp)) continue;
			if(!empty($spwhere)) $spwhere.=" or ";
			else $spwhere="(";
			$spwhere.=" special_name like ? ";
			array_push($args,"%$sp%");	
		}
		if(!empty($spwhere)) $where.="$spwhere ) ";
	}
	if(!empty($min_mark)){
		if(!empty($where)) $where.=" and ";
		$where.=" baseline >= ? ";
		array_push($args,intval($min_mark));	
	}

	if(!empty($max_mark)){
		if(!empty($where)) $where.=" and ";
		$where.=" baseline <= ? ";
		array_push($args,intval($max_mark));	
	}

	if(!empty($min_rank)){
		if(!empty($where)) $where.=" and ";
		$where.=" `rank` >= ? ";
		array_push($args,intval($min_rank));	
	}

	if(!empty($max_rank)){
		if(!empty($where)) $where.=" and ";
		$where.=" `rank` <= ? and `rank` >=1 ";
		array_push($args,intval($max_rank));	
	}


	if(!empty($where)){
		$where="where ".$where;
	}
	$sql1=" SELECT * from zj2024pt1 $where order by baseline desc,plan desc limit 50";
	$first_table=pdo_query($sql1,$args);
	$sql2=" SELECT * from zj2024pt2 $where order by baseline desc,plan desc limit 50";
	$second_table=pdo_query($sql2,$args);

	pdo_query("update counter set count=count+1 where id=1");
	$count=pdo_query("select count from counter where id=1")[0][0];
//	echo $sql2;
//	var_dump($args);

/////////////////////////Template
require( "template/" . $OJ_TEMPLATE . "/".basename(__FILE__) );
