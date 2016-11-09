<?php
session_start();

if($_SESSION["HAS_LOGGED_IN"]){
  include '../CommonMethods.php';

  if($_POST){
    $studentID = $_SESSION["STUDENT_ID"];
    
    //connect to database
    $debug = true;
    $COMMON = new Common($debug);
    $filename = "index.php";
    
    //declaring variable equal to session variable used for query
    $studentID = $_SESSION["STUDENT_ID"];
    
    //search for scheduled appointment
    $scheduledAppt = "SELECT MeetingID FROM StudentMeeting WHERE StudentID = 'studentID'";
    
    $currentAppt = $COMMON->executequery($scheduledAppt, $filename);
     
  }
  
}
?>

<html>
<head>
     <title>Student Homepage</title>
</head>
<body>
      <h1>Student Home</h1>

<?php if ($_SESSION["HAS_LOGGED_IN"]) { ?>

    <h3>
     Welcome <?php echo htmlspecialchars($_SESSION["STUDENT_EMAIL"]); ?>
    </h3>
<?php } ?>

</body>
</html>

<html>

<br>
<a href="viewMeeting.php">View Scheduled Appointment</a>
<br>

<br>
<a href="chooseMeeting.php">Schedule Advising Appointment</a>
<br>

<br>
<a href="cancelMeeting.php">Cancel Advising Appointment</a>
<br>

<br>
<a href="logout.php">Log out</a>
<br>

</html>