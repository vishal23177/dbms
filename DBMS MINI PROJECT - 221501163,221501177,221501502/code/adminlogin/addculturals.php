<?php
 
$eventid = $_POST['eventid'];
$eventName = $_POST['eventName'];
$eventDateTime = $_POST['eventDateTime'];
$eventVenue= $_POST['eventVenue'];
$eventDescription = $_POST['eventDescription'];
$eventParticipants = $_POST['eventParticipants'];

$conn = new mysqli('localhost','root','','test');
if($conn->connect_error){
    echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);}
else{
    $stmt=$conn->prepare("insert into culturals(eventid, eventName, eventDateTime, eventVenue, eventDescription, eventParticipants)
    values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss",$eventid, $eventName, $eventDateTime, $eventVenue, $eventDescription, $eventParticipants);
    $execval = $stmt->execute();
	
    echo '<script>alert("added succeessfully");</script>';
    $Stmt->close();
    $conn->close();
}


?>