<?php $show_title="高考志愿 - ".htmlentities($special);
	$OJ_BG="";
?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<?php

function printTable($first_table){
	echo "<table class='table striped'  style='overflow:auto' >";
	echo "<tr><th>序号<th>学校代码<th>学校名称<th>专业代码<th>专业名称<th>23计划数<th>24计划数<th>23分数线<th>24分数线<th>23位次<th>24位次(0表示未招满)<th>必应搜索";
	$c=0;
	foreach( $first_table as $row){
		echo "<tr>";
		$c++;
		$i=0;
		foreach($row as $col){
			$i++;
			echo "<td>";
			$span='';
			if($i==1) $col=$c;
			if($i==9){
				if($last>0){
					if($last>$col){
						echo "<span class='green'>";
						$span='⬇️</span>';
					}else if($last<$col){
						echo "<span class='red'>";
						$span='⬆️</span>';
					}
				}
			}else if($i==7||$i==11){
				if($last>0&&$col>0){
					if($last>$col){
						echo "<span class='red'>";
						$span='⬆️</span>';
					}else if($last<$col){
						echo "<span class='green'>";
						$span='⬇️</span>';
					}
				}
				if($last>0&&$col==0){
						echo "<span class='green'>";
						$span='⬇️</span>';
				
				}
			}
			if($i==3) echo "<a href='zjgk.php?school=".htmlentities($col)."'>";
			if($i==5) echo "<a href='zjgk.php?special=".htmlentities($col)."'>";
			echo htmlentities($col);
			if($i==3||$i==5) echo "</a>";
			if(!empty($span)&&$i==11&&$col>0){
				echo "&nbsp;[".(intval(($last-$col)/$last*10000)/100)."%]";
				
			}
			echo "$span";
			echo "</td>";
			$last=$col;
		}
		echo "<td><a class='ui green button' href='https://cn.bing.com/search?q=".htmlentities( $row['school_name']." ".$row["special_name"].'专业介绍' )."' target='_blank'>介绍</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>
<div class="padding">
    <h1 class='padding'>2024年浙江高考普通类分数线与位次速查  ……  本页数据来自互联网，仅供参考
	
  	<form id=simform class="ui form" action="zjgk.php" method="get"  style="float:left">
	学校<input class="ui input" name="school" style='width:250px;' value='<?php echo htmlentities($school)?>'  placeholder='学校关键词或全称'>
<br>
		专业<input class="ui input" name="special" style='width:450px;' value='<?php echo htmlentities($special)?>'  placeholder='专业关键词或全称,可空格分隔多个'> 
<br>
		分数
		<input class="ui input" name="min_mark" style='width:250px;' value='<?php echo intval($min_mark)>0? intval($min_mark):"" ?>'  placeholder='最低分数'>
		~
		<input class="ui input" name="max_mark" style='width:250px;'  value='<?php echo intval($max_mark)>0? intval($max_mark):""  ?>'  placeholder='最高分数'>
<br>
	        位次	
		<input class="ui input" name="min_rank" style='width:250px;'  value='<?php echo intval($min_rank)>0?intval($min_rank):"" ?>'  placeholder='最前位次'>
		~
		<input class="ui input" name="max_rank" style='width:250px;'  value='<?php echo intval($max_rank)>0?intval($max_rank):"" ?>'  placeholder='最后位次'>
		<input class="ui primary button" onclick="$('form').submit()" type="submit" value='提交查询' >
		
	</form>
	<img width="300" style="float:right" src=http://zjicm.hustoj.com/upload/zjicm.hustoj.com/image/20250306/20250306095438_40564.jpg >
	<h3 style="float:right"> 如果你觉得这个页面有用，请微信扫一扫关注！<br> 本页地址 zj.hustoj.com</h3><h4 class='blue' style='float:right' > [<?php echo $count ?> visited ]</h4>
</h1>
    <div class="ui existing segment" style="width:95%;overflow:auto;">
	<div id="content" class="font-content">
	第一段:
	<?php
		printTable($first_table);
	?>
	第二段:
	<?php
		printTable($second_table);
	?>
	</div>
    </div>
</div>

<?php include("template/$OJ_TEMPLATE/footer.php");?>
