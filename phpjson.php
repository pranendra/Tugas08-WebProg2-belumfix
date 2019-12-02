<?php

$konek= mysqli_connect("localhost","root","", "json");

$json = '{"messages": {';
$query = mysqli_query($konek, "select * from message");
$json .= '"pesan": [ ';
while ($x =mysqli_fetch_array($query)){
	$json .= '{';
	$json .= '"id": "' . $x['message_id'] . '",
	"user": "' .htmlspecialchars($x['user_name']) . '",
	"text": "' .htmlspecialchars($x['message']) . '",
	"time": "' .$x['post_time'] . '"
},';
}

//hilangkan koma (,) diakhir
$json = substr($json, 0, strlen($json)-1);

//melengkapi penutup format JSON
$json .= ']';
$json .= '}}';


echo $json;

?>