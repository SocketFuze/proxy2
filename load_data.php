<?php
if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 10;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;
include"db.php";


/* -------------------CUSTOM timeAGO------------------------------*/
function timeAgo($timestamp){
    $datetime1=new DateTime("now");
    $datetime2=date_create($timestamp);
    $diff=date_diff($datetime1, $datetime2);
    $timemsg='';
    if($diff->y > 0){
        $timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');

    }
    else if($diff->m > 0){
     $timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
    }
    else if($diff->d > 0){
     $timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
    }
    else if($diff->h > 0){
     $timemsg = $diff->h .' hour'.($diff->h > 1 ? "'s":'');
    }
    else if($diff->i > 0){
     $timemsg = $diff->i .' minute'. ($diff->i > 1?"'s":'');
    }
    else if($diff->s > 0){
     $timemsg = $diff->s .' second'. ($diff->s > 1?"'s":'');
    }

$timemsg = $timemsg.' ago';
return $timemsg;
}

/* --------------------------------------------- */


$query_pag_data = "SELECT * FROM proxies ORDER BY id ASC LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data);
$msg = "";

	WHILE($rows = mysql_fetch_array($result_pag_data)):
	
		$ip= $rows['ip'];
		$port= $rows['port'];
		$cCode= $rows['country_code'];
		$cName= $rows['country_name'];
		$date = $rows['date'];
		
		$flag = strtolower($cCode);
		
		// <td>" . '<img src="assets/flags/'.$flag.'.png" alt="flag" /> ' . $cName . "</td>
		
    	$msg .= "<tr class=\"\"  rel=\"13351271\">
		    <td>" . $ip . "</td>
		    <td>" . $port . "</td>
		    <td>" . '220 ms' . "</td>
		    <td>" . 'HTTP' . "</td>
		    <td>" . 'Anonymity' . "</td>
		    <td>" . timeAgo($date) . "</td>
		</tr>";
        
    endwhile;


$msg = "<div class='data'>
	<table id=\"listtable\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"75%\" rel=\"50\">
		<thead>
		<tr id=\"theader\">
			<td>IP Address</td>
			<td>Port</td>
			<td>Ping</td>
			<td>Type</td>
			<td>Anonymity</td>
			<td>Last Checked</td>
		</tr>
		</thead>" . $msg . "</table>"; // Content for Data


/* --------------------------------------------- */
$query_pag_num = "SELECT COUNT(*) AS count FROM proxies";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = 20;
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='pagination'><ul id='proxyPage'>";

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#2eafbb;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

$msg = $msg . "</ul></div>";  // Content for pagination
echo $msg;

}

?>
