<!DOCTYPE html>
<html>

<head>
    <title>Master Page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

</head>

<body style="min-height:100vh" class="bg-bright">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>

    <form id="form1" runat="server">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="image/logo.png" width="250" height="80" />
                </a>
                <div class="navbar-container">
                    <div class="collapse navbar-collapse master" id="navbarNav">

                    </div>
                </div>

            </div>
        </nav>

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
                window.location.href = "Upcoming.php";
            }
        </script>

        <div style="overflow-x: scroll;" class="container row justify-content-md-center mx-auto">
            <table id="StudentGV" class="table w-100 table-striped my-1 table-bordered table-responsive table-hover">
                <?php
                // Include any necessary PHP libraries and configurations here
                // Define the database connection string
                $cs = 'your_database_connection_string';

                // Define the current date
                $currentDate = new DateTime('2023-07-19 15:30:00');

                // Establish a database connection
                $con = new mysqli('hostname', 'username', 'password', 'database_name');

                if ($con->connect_error) {
                    die('Connection failed: ' . $con->connect_error);
                }

                $sql = "SELECT Stud.studID, Stud.studName, Stud.studEmail, Stud.studPhoneNo, Stud.studQualification, Ses.sessionID
                        FROM Student Stud, Internship I, Session Ses
                        WHERE Stud.studID = I.studID
                        AND I.sessionID = Ses.sessionID
                        AND startMonthYear < '" . $currentDate->format('Y-m-d H:i:s') . "'
                        AND endMonthYear > '" . $currentDate->format('Y-m-d H:i:s') . "'";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table class="table w-100 table-striped my-1 table-bordered table-responsive table-hover">';
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Name</th>';
                    echo '<th>Email</th>';
                    echo '<th>Phone No</th>';
                    echo '<th>Qualification</th>';
                    echo '<th>Session</th>';
                    echo '</tr>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr  data-student-id="' . $row['studID'] . '">';
                        echo '<td>' . $row['studID'] . '</td>';
                        echo '<td>' . $row['studName'] . '</td>';
                        echo '<td>' . $row['studEmail'] . '</td>';
                        echo '<td>' . $row['studPhoneNo'] . '</td>';
                        echo '<td>' . $row['studQualification'] . '</td>';
                        echo '<td>' . $row['sessionID'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo 'No records found.';
                }

                $con->close();
                ?>

                <!--If the user click a row, it will be redirect to the student detail page-->
                <script type="text/javascript">
                    function viewStudent(id) {
                        // Perform a client-side redirection to the StudentDetail.aspx page with the extracted ID
                        window.location.href = "StudentDetail.aspx?StudID=" + id;
                    }

                    // Attach a click event listener to each row in the table
                    document.addEventListener("DOMContentLoaded", function () {
                        var rows = document.querySelectorAll("#StudentGV tbody tr");
                        for (var i = 0; i < rows.length; i++) {
                            rows[i].addEventListener("click", function () {
                                // Get the student ID from the data attribute or any other suitable way
                                var id = this.getAttribute("data-student-id");
                                viewStudent(id);
                            });
                        }
                    });
                </script>

            </table>
        </div>

        <footer class="bg-light text-black pt-5 pb-4">
            <div class="container text-center text-md-left">
                <hr class="mb-4">
                <div class="align-items-center">
                    <div class="col-md-12 col-lg-12 text-center">
                        <p>Copyright © 2023 All Rights Reserved by:
                            <strong>2023 - TAR UMT FOCS ITP</strong>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </form>
</body>

</html>