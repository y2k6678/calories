<?php
$access_token = '2SXOQ6j8Ipjcbg+PIgV8TexlTkhjodAiLYqXfdZ4Rvmv6y8gaLW9PDrVDP5SNvA+VbROj9BAJZIE5PSP5meBL9GDYemfcdw6B5cpwu8hPtEGCL15MFX8bilDpdvyVe8iI8p1Q3PFpIdn9047ldBvpAdB04t89/1O/w1cDnyilFU=';
$host = "ec2-54-225-97-112.compute-1.amazonaws.com";
$user = "qrnbebahudbqmp";
$pass = "a43af8db99a527ec88af37c48030569674700a18b57304f05e4348f81e81b94f";
$db = "d4d2gobi48opm9";
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");

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
$sqlgetlastrecord = "select MENU,CAL from calorie where MENU = ";
if (!is_null($events['events']))
{
	// Loop through each event
	foreach($events['events'] as $event)
	{
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text')
		{
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = ['type' => 'text', 'text' => "ไม่มีเมนูอาหารที่คุณป้อน" . "\n" . "หรือกรุณาป้อนข้อความให้ถูกต้อง"];
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "HELP")
			{
				$messages = ['type' => 'text', 'text' => "ป้อนชื่ออาหารได้เลยครับ"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "อากาศ"){
				
				$messages = ['type' => 'text', 'text' => "สถานที่ : " . "มหาวิทยาลัยวลัยลักษณ์" .  "\n" . "อุณหภูมิ C :" . $TEM . "\n" . "ความชื้น :" . $HUM . " %" . "\n" . "[help] เพื่อดูเมนู"];
			}
			
			
			
			
			
			
			
			
			
			//EndCase
			if (trim(strtoupper($text)) == "HI")
			{
				$messages = ['type' => 'text', 'text' => "hello"];
			}
			if ($text == "รูป")
			{
				$messages = ['type' => 'image', 'originalContentUrl' => "https://sv6.postjung.com/picpost/data/184/184340-1-2995.jpg", 'previewImageUrl' => "https://sv6.postjung.com/picpost/data/184/184340-1-2995.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "INFO")
			{
				$messages = ['type' => 'text', 'text' => "มหาวิทยาลัยวลัยลักษณ์เป็นมหาวิทยาลัยของรัฐ และอยู่ในกำกับของรัฐบาลที่ได้รับพระมหากรุณาธิคุณจากพระบาทสมเด็จพระเจ้าอยู่หัว พระราชทานชื่ออันเป็นสร้อยพระนามในสมเด็จพระเจ้าลูกเธอ เจ้าฟ้าจุฬาภรณวลัยลักษณ์อัครราชกุมารี" ."\n"."อ่านเพิ่มเติม: https://www.wu.ac.th"];
            }

            if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กระเพาะปลา")
			{
				$messages = ['type' => 'text', 'text' => "1 ชาม	150 กิโลแคลอรี่"];
            }
            if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กล้วยไข่")
			{
				$messages = ['type' => 'text', 'text' => "1 ชาม	40 กิโลแคลอรี่"];
            }
            if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กล้วยคลุกมะพร้าว")
			{
				$messages = ['type' => 'text', 'text' => "1 ถ้วย	100 กิโลแคลอรี่"];
            }
            if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กล้วยฉาบ")
			{
				$messages = ['type' => 'text', 'text' => "1 ชิ้น	29 กิโลแคลอรี่"];
            }
            if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "กล้วยตาก")
			{
				$messages = ['type' => 'text', 'text' => "1 ผล	30 กิโลแคลอรี่"];
            }
           




			if ( ereg_replace('[[:space:]]+', '', trim($textSplited[0])) == "")
			{
				$dataFromshowtime = showtime($textSplited[1]);
				$rs = pg_query($dbconn, $dataFromshowtime[1]) or die("Cannot execute query: $query\n");
				$templink = ""; 
				$qcount=0;
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
					$qcount++;
				}
				//$messages = ['type' => 'text', 'text' => "HI $dataFromshowtime[0] \n$dataFromshowtime[1] \n$templink"
				if ($qcount > 0){
				$messages = [
				'type' => 'text',
				'text' => $templink,
					
				];}
		
			}






				
			if ( ereg_replace('[[:space:]]+', '', trim($text)) == "ภาพ")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			$textSplited = split(" ", $text);
			if ( ereg_replace('[[:space:]]+', '', trim($textSplited[0])) == "ภาพ")
			{
				$dataFromshowtime = showtime($textSplited[1]);
				$rs = pg_query($dbconn, $dataFromshowtime[1]) or die("Cannot execute query: $query\n");
				$templink = ""; 
				$qcount=0;
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
					$qcount++;
				}
				//$messages = ['type' => 'text', 'text' => "HI $dataFromshowtime[0] \n$dataFromshowtime[1] \n$templink"
				if ($qcount > 0){
				$messages = [
				'type' => 'image',
				'originalContentUrl' => $templink,
					'previewImageUrl' => $templink
				];}
				else {
					$messages = [
						'type' => 'image',
						'originalContentUrl' => "https://imgur.com/aOWIijh.jpg",
							'previewImageUrl' => "https://imgur.com/aOWIijh.jpg" 
		
						];
				}
			}
			if ($text == "ภาพ")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			if ($text == "map")
			{
				$messages = ['type' => 'location','title'=> 'my location','address'=> 'เคลิ้ม',
				'latitude'=> 8.652311,'longitude'=> 99.918031];
			}
			/*if($text == "image"){
			$messages = [
			$img_url = "http://sand.96.lt/images/q.jpg";
			$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
			$response = $bot->replyMessage($event->getReplyToken(), $outputText);
			];
			}*/
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
echo "OK";
echo $date;
