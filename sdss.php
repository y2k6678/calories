<?php
$access_token = '2SXOQ6j8Ipjcbg+PIgV8TexlTkhjodAiLYqXfdZ4Rvmv6y8gaLW9PDrVDP5SNvA+VbROj9BAJZIE5PSP5meBL9GDYemfcdw6B5cpwu8hPtEGCL15MFX8bilDpdvyVe8iI8p1Q3PFpIdn9047ldBvpAdB04t89/1O/w1cDnyilFU=';
$host = "ec2-54-225-97-112.compute-1.amazonaws.com";
$user = "qrnbebahudbqmp";
$pass = "a43af8db99a527ec88af37c48030569674700a18b57304f05e4348f81e81b94f";
$db = "d4d2gobi48opm9";
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
// function showtime($time)
// {
// 	$date = date("Y-m-d");
// 	$h = split(":", $time);
// 	if ($h[1] < 15)
// 	{
// 		$h[1] = "00";
// 		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:0:00' and '$date $h[0]:15:00' order by \"DATETIME\" desc limit 1";
// 	}
// 	else
// 	if ($h[1] >= 15 && $h[1] < 30)
// 	{
// 		$h[1] = "15";
// 		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:15:01' and '$date $h[0]:30:00' order by \"DATETIME\" desc limit 1";
// 	}
// 	else
// 	if ($h[1] >= 30 && $h[1] < 45)
// 	{
// 		$h[1] = "30";
// 		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:30:01' and '$date $h[0]:45:00' order by \"DATETIME\" desc limit 1";
// 	}
// 	else
// 	if ($h[1] >= 45)
// 	{
// 		$h[1] = "45";
// 		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:45:01' and '$date $h[0]:59:59' order by \"DATETIME\" desc limit 1";
// 	}
	
// 	return array(
// 		$h[0] . ":" . $h[1],
// 		$selectbydate
// 	);
// }
// database
$dbconn = pg_connect("host=" . $GLOBALS['host'] . " port=5432 dbname=" . $GLOBALS['db'] . " user=" . $GLOBALS['user'] . " password=" . $GLOBALS['pass']) or die('Could not connect: ' . pg_last_error());
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
$Light = file_get_contents('https://api.thingspeak.com/channels/331361/fields/3/last.txt');
$water = file_get_contents('https://api.thingspeak.com/channels/331361/fields/4/last.txt');
$HUM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/2/last.txt');
$TEM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/1/last.txt');
$aba = ('https://i.imgur.com//yuRTcoH.jpg');
// convert
// $sqlgetlastrecord = "select * from weatherstation order by \"DATETIME\" desc limit 1";
try
{
	if (!is_null($events['events']))
	{
		echo "1";
		// Loop through each event
		foreach($events['events'] as $event)
		{
			echo "2";
			// Reply only when message sent is in 'text' format
			if ($event['type'] == 'message' && $event['message']['type'] == 'text')
			{
				echo "3";
				// Get text sent
				$text = $event['message']['text'];
				// Get replyToken
				$replyToken = $event['replyToken'];
				//select * from calorie where "MENU" = 'กล้วยฉาบ' limit 1
				$selectfoodmenu = "select * from calorie where \"MENU\" = '$text' limit 1";
				$messages = ['type' => 'text',  'text' =>"รายการ : $selectfoodmenu"];


				// $messages = ['type' => 'text',  'text' =>"รายการ : $selectfoodmenu ไม่มีในระบบ $dbconn ===== host=" . $GLOBALS['host'] . " port=5432 dbname=" . $GLOBALS['db'] . " user=" . $GLOBALS['user'] . " password=" . $GLOBALS['pass'] ];
				$rs = pg_query($dbconn, $selectfoodmenu) or die("Cannot execute query: $selectfoodmenu");
				// $messages = ['type' => 'text',  'text' =>"รายการ : $rs"];
				 $qcount=0;
				 $foodname = $text;
				 $unit = "";
				 $cal = "";
				 while ($row = pg_fetch_row($rs))
				 {
				 	$foodname = $row[1];
				 	$unit = $row[2];
				 	$cal = $row[3];
				 	$qcount++;
				 }
				// $messages = ['type' => 'text',  'text' =>"รายการ : $qcount"];
				 if($qcount==0)
				 	$messages = ['type' => 'text',  'text' =>"รายการ : $foodname ไม่มีในระบบ"];
				 else
				 	$messages = ['type' => 'text',  'text' =>"รายการ : $foodname ปริมาณ : $unit แคล : $cal"];

				// Make a POST Request to Messaging API to reply to sender
				$url = 'https://api.line.me/v2/bot/message/reply';
				$data = ['replyToken' => $replyToken, 'messages' => [$messages], ];
				$post = json_encode($data);
				$headers = array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $access_token
				);
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				$result = curl_exec($ch);
				curl_close($ch);
				echo $result . "\r\n";
			}
		}
	}
}
catch(Exception  $ex)
{
	
	echo $ex;
	$messages = ['type' => 'text',  'text' =>"รายการ : $ex"];
	$url = 'https://api.line.me/v2/bot/message/reply';
				$data = ['replyToken' => $replyToken, 'messages' => [$messages], ];
				$post = json_encode($data);
				$headers = array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $access_token
				);
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				$result = curl_exec($ch);
				curl_close($ch);
}
echo "OK";
echo "ssssss";
echo $date;
echo "select * from calorie where \"MENU\" = 'กล้วยฉาบ' limit 1";
