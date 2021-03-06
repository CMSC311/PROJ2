<?php
include('../CommonMethods.php');
session_start();
$COMMON = new Common(false);
$fileName = "chooseIndividualMeeting.php";

//check if the student has a meeting
$checkForMeeting = "Select * FROM StudentMeeting Where StudentMeeting.StudentID =". $_SESSION['STUDENT_ID'];
$rs = $COMMON->executequery($checkForMeeting,$fileName);
$numRows = mysql_fetch_array($rs);

if($numRows>0){
header('Location:meetingChosen.php');
}
// Searchs for all the meetings that passed 
// 
$search_meeting = "SELECT * FROM Meeting WHERE Meeting.start > NOW() AND Meeting.meetingType = false AND Meeting.numStudents < 1";
$rs = $COMMON->executequery($search_meeting, $fileName);

$allRows = mysql_num_rows($rs);
//adds the selected meeting to studentMeeting
if ($_POST) {
  //adds the selected meeting to studentMeeting
  $theMeetingID = $_POST['meeting'];
 

  //echo "The student ID is ".$_SESSION['STUDENT_ID'];
  //creates a new student meeting
  $create_meeting = "INSERT INTO StudentMeeting(StudentID,MeetingID)
VALUES(" . $_SESSION["STUDENT_ID"] . ",$theMeetingID)";
  $rs=$COMMON->executequery($create_meeting,$fileName);
  
  
  //changes the number of people registered for the meeting
  $changeNumRegistered = "UPDATE Meeting SET numStudents = 1 WHERE meetingID = $theMeetingID";
  $rs=$COMMON->executequery($changeNumRegistered,$fileName);
  
 $_SESSION['MEETING_ID']= $theMeetingID;
  header('Location:homePage.php');
}

?>

<html>
<head></head>
<h1>Choose an Individual Appointment:</h1>
<br>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php
  //makes all the availible meetings into radio buttons
  if (!$allRows){
    echo "<h4>Sorry, there are no appointments available at this time.</h4>";
  }
  else{
    while ($aRow = mysql_fetch_assoc($rs)) {
      echo "<input type = 'radio' name='meeting' value='" . $aRow["meetingID"] . "'>";
        ?>
        <h4>Meeting</h4>

        <ul>
            <li>
	   Start: <?php echo htmlspecialchars($aRow["start"]) ?>
            </li>
            <li>
	   End: <?php echo htmlspecialchars($aRow["end"]) ?>
            </li>
            <li>
	   Building Name: <?php echo htmlspecialchars($aRow["buildingName"]) ?>
            </li>
            <li>
	   Room Number: <?php echo htmlspecialchars($aRow["roomNumber"]) ?>
            </li>
        </ul>
        <?php
	   }
    ?>
      <input type="submit">

</form>
       <?php } ?>
<a href="homePage.php">Return Home</a>
</body>
</html>
