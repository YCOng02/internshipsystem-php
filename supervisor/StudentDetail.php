<!DOCTYPE html>
<html>

<head>
    <title>Student Details</title>
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
    <script type="text/javascript">
        function confirmMessage() {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = "SupervisorHome.aspx";
                return true;
            } else {
                return false;
            }
        }


    </script>

    <form id="form1" runat="server">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="../image/logo.png" width="250" height="80" />
                </a>
                <div class="navbar-container">
                    <div class="collapse navbar-collapse master" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="supervisor">Home <span class="sr-only">(current)</span></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>

        <input type="hidden" id="HFindemnity" />
        <input type="hidden" id="HFparentAcknowledgement" />
        <input type="hidden" id="HFcompanyAcceptance" />
        <input type="hidden" id="HFFirstReport" />
        <input type="hidden" id="HFSecondReport" />
        <input type="hidden" id="HFThirdReport" />
        <input type="hidden" id="HFEvalReport" />

        <?php
        // Define the database connection string
        $cs = 'your_database_connection_string';

        // Define the current date
        $currentDate = new DateTime('2023-07-19 15:30:00');


        // Create a connection
        $con = new mysqli('localhost', 'root', '', 'internship');

        // Check for connection errors
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        } else {
            //generate the record in the table
            $sql = "SELECT * FROM Student Stud, Internship I, Session Ses 
                WHERE Stud.studID = I.studID
                AND I.sessionID = Ses.sessionID
                AND @studID = Stud.studID";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    echo '<tr  data-student-id="' . $row['studID'] . '">';
                    $ID = $row['studID'] . '</td>';
                    $Name = $row['studName'] . '</td>';
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


        <div class="container">
            <div class="row my-2 mx-auto">
                <div style="width:600px;" class="border border-dark my-1 mx-auto col-md-4 col-lg-12">
                    <div class="justify-content-md-center">
                        <hr style="color:black;" />
                        <h2 class="text-black text-center">Student Details</h2>
                        <hr style="color:black;" />

                        <div class="m-2 row">
                            <div class="col-2">
                                <label>Name</label>
                            </div>
                            <div class="col">
                                <?php
                                echo '<span class="m-2">' . $Name . '</span>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="width:600px;"
                    class="justify-content-md-center border border-dark my-1 mx-auto col-md-4 col-lg-12">
                    <hr style="color:black;" />
                    <h2 class="text-black text-center">Pre-Internship Submission</h2>
                    <hr style="color:black;" />

                    <!-- HTML content for pre-internship submission here -->

                </div>

                <!-- Empty div for layout purposes -->
                <div style="width:600px;" class="col-md-8"></div>
            </div>

            <div class="row my-2 mx-auto">
                <div style="width:750px;"
                    class="justify-content-md-center border border-dark my-1 mx-auto col-md-4 col-lg-12">
                    <hr style="color:black;" />
                    <h2 class="text-black text-center">Internship Report Submission</h2>
                    <hr style="color:black;" />

                    <!-- HTML content for internship report submission here -->

                </div>

                <!-- Empty div for layout purposes -->
                <div style="width:600px;" class="mx-auto col-md-4 col-lg-12"></div>
            </div>
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