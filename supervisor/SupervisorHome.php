<!DOCTYPE html>
<html>
<?php
session_start();
$pageTitle = 'Home';
include 'staffHeader.php';

// Check if the session variables are set before accessing them
if (isset($_SESSION['staffID'])) {
    $staffID = $_SESSION['staffID'];
} else {
    // Handle the case where the session data is not set
    $staffID = "empty session";
}
?>

<!DOCTYPE html>
<html>

<div class="container row justify-content-md-center mx-auto">
    <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
        <button id="btnCurrent" class="nav-link active w-50 text-white border-0"
            style="background-color: #dc143c">Current</button>
        <button id="btnUpcoming" class="nav-link w-50 text-black" style="border-color: #FFFBD6"
            onclick="redirectToUpcoming()">Upcoming</button>
    </div>
</div>

<script type="text/javascript">
    function redirectToUpcoming() {
        // Redirect to the "Upcoming.php" page when the button is clicked
        window.location.href = "UpcomingInternship.php";
    }
</script>

<div style="overflow-x: scroll;" class="container row justify-content-md-center mx-auto">
    <div class="container" style="min-height:65vh; max-height:65vh;">
        <table id="StudentGV" class="table w-100 table-striped my-1 table-bordered table-responsive table-hover">
            <table class="table w-100 table-striped my-1 table-bordered table-responsive table-hover">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No</th>
                    <th>Qualification</th>
                    <th>Session</th>
                </tr>

                <?php
                // Define the current date
                $currentDate = date('Y-m-d'); // Format: YYYY-MM-DD
                
                require '../student/connect.php';

                // Check for connection errors
                if ($con->connect_error) {
                    echo '<tr>';
                    echo '<td colspan="6" class="text-center"> No Connection fail.</td>';
                    echo '</tr>';

                    throw new Exception("Connection failed: " . $con->connect_error);
                } else {
                    //generate the record in the table
                    $sql = "SELECT Stud.studID, Stud.studName, Stud.studEmail, Stud.studPhoneNo, Stud.studQualification, Ses.sessionID, Sta.staffID, Sta.staffName
                        FROM Student Stud, Internship I, Session Ses, Supervisor Sup, Staff Sta
                        WHERE Stud.studID = I.studID
                        AND I.sessionID = Ses.sessionID
                        AND Ses.sessionID = Sup.sessionID
                        AND Sup.staffID = Sta.staffID
                        AND (I.internshipStatus = 'In Progress' OR I.internshipStatus = 'Completed')
                        AND startMonthYear < '" . $currentDate . "'
                        AND endMonthYear > '" . $currentDate . "'
                        AND  Sta.staffID = '" . $staffID . "'
                        ORDER BY Ses.sessionID";

                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr style="cursor: pointer;" onclick="viewStudent(' . $row['studID'] . ')" data-href="StudentDetail.php?studID=' . $row['studID'] . '">';
                            echo '<td>' . $row['studID'] . '</td>';
                            echo '<td>' . $row['studName'] . '</td>';
                            echo '<td>' . $row['studEmail'] . '</td>';
                            echo '<td>' . $row['studPhoneNo'] . '</td>';
                            echo '<td>' . $row['studQualification'] . '</td>';
                            echo '<td>' . $row['sessionID'] . '</td>';
                            echo '</tr>';
                        }


                    } else {
                        echo '<tr>';
                        echo '<td colspan="6" class="text-center"> No records found.</td>';
                        echo '</tr>';
                    }

                    $con->close();
                }


                ?>
            </table>
            <!--If the user click a row, it will be redirect to the student detail page-->
            <script type="text/javascript">
                function viewStudent(id) {
                    // Perform a client-side redirection to the StudentDetail.aspx page with the extracted ID
                    window.location.href = "StudentDetail.php?StudID=" + encodeURIComponent(id);
                }
            </script>

        </table>
    </div>
</div>

<?php
include 'staffFooter.php';
?>