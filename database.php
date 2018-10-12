<?php 
echo $_GET['getID'];
echo $_GET['getMENU'];
echo $_GET['getUNIT'];
echo $_GET['getCAL'];
$host = "ec2-107-22-211-182.compute-1.amazonaws.com";
$user = "mmdkvvqziulstc";
$pass = "e10240d71df70c411f5201bc37491e9091491ff276b8d8b66f8e507ea5b7dc22";
$db   = "dcv361109jo6fh";
$dbconn = pg_connect("host=".$GLOBALS['host']." port=5432 dbname=".$GLOBALS['db']." user=".$GLOBALS['user']." password=".$GLOBALS['pass'])
    or die('Could not connect: ' . pg_last_error());
    $sql = "INSERT INTO weatherstation (\"ID\", \"LINK\", \"DATETIME\")
   VALUES ('".$_GET['getid']."', '".$_GET['getLINK']."', '".$_GET['getDATETIME']."')";
 
 $query = pg_query($sql);
 if($query)
   echo "inserted successfully!";
 else{
   echo "There was an error! ".pg_last_error();
 }
 
 // Closing connection
 pg_close($dbconn);
?>
