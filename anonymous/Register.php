<!DOCTYPE html>
<html>
<?php
$pageTitle = 'Register';
include 'header.php';
?>

<body style="min-height:100vh" class="bg-bright">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="SupervisorHome.php">
                <img src="https://gohchankeong-bucket.s3.amazonaws.com/logo.png" width="250" height="80" />
            </a>
            <div class="navbar-container">
                <div class="collapse navbar-collapse master" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="../Supervisor/SupervisorHome.php">Home <span
                                    class="sr-only">(current)</span></a> -->
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <div class="justify-content-center">


        <div id="content" class="text-dark d-flex align-items-center justify-content-center loginPage">
            <div class="loginWindow bg-white rounded col-md-5 col-lg-6 col-sm-6">
                <div class="nav-link  rounded-2 active flex-grow-1 loginTab p-3 text-center">
                    <h5>Register</h5>
                </div>
                <form method="POST" action="registerUser.php">
                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-user" style="width: 5%; margin-top: 30px"></i>
                        <div class="form-floating mb-3" style="width: 60%;" id="float">
                            <input type="text" name="txtName" class="form-control userInput" placeholder=" " required/>
                            <label for="name">Name</label>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>


                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-user" style="width: 5%; margin-top: 30px"></i>
                        <div class="form-floating mb-3" style="width: 60%;" id="float">
                            <input type="text" name="txtStudID" class="form-control userInput" placeholder=" " required />
                            <label for="txtName">Student ID</label>
                            <!-- PHP validation code can be added here -->
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>

                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-user" style="width: 5%; margin-top: 30px"></i>
                        <div class="form-floating mb-3" style="width: 60%;" id="float">
                            <input type="text" name="txtIC" class="form-control userInput" placeholder=" " required />
                            <label for="txtName">NRIC</label>
                            <!-- PHP validation code can be added here -->
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>


                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-envelope" style="width: 5%; margin-top: 30px"></i>
                        <div class="form-floating mb-3" style="width: 60%;" id="float1">
                            <input type="email" name="txtEmail" class="form-control userInput" placeholder=" " required />
                            <label for="txtEmail">Email</label>
                            <?php
                            // PHP validation code can be added here
                            ?>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>



                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-lock" style="width: 5%; margin-top: 30px"></i>
                        <div class="form-floating mb-3" style="width: 60%;" id="float2">
                            <input type="password" name="txtPassword" class="form-control userInput" placeholder=" "
                                required onInput="updateStrength()" />
                            <label for="txtPassword">Password</label>
                            <?php
                            // PHP validation code can be added here
                            ?>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>

                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-lock" style="width: 5%; margin-top: 30px"></i>
                        <div class="form-floating mb-3" style="width: 60%;" id="float3">
                            <input type="password" name="txtCfmPassword" class="form-control userInput" placeholder=" "
                                required />
                            <label for="txtCfmPassword">Confirm Password</label>
                            <?php
                            // PHP validation code can be added here
                            ?>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>


                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-phone" style="width: 5%; margin-top: 30px"></i>
                        <div class="form-floating mb-3" style="width: 60%;" id="float4">
                            <input type="tel" name="txtPhone" class="form-control userInput" placeholder=" " required />
                            <label for="txtPhone">Phone No</label>
                            <?php
                            // PHP validation code for phone number can be added here
                            ?>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <i class="fa-solid fa-venus-mars" style="width: 5%;"></i>
                        <div class="row" style="width: 60%; margin-right: 15px;">
                            <div class="w-25">
                                <label for="rblGender">Gender:</label>
                            </div>
                            <div class="w-75">
                                <input type="radio" id="rblGenderMale" name="gender" value="Male" required>
                                <label for="rblGenderMale">Male</label>
                                <input type="radio" id="rblGenderFemale" name="gender" value="Female" required>
                                <label for="rblGenderFemale">Female</label>
                            </div>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <i class="fa-solid fa-user-graduate" style="width: 5%;"></i>
                        <div class="row" style="width: 60%; margin-right: 15px;">
                            <div class="w-25">
                                <label for="rblQualification">Qualification:</label>
                            </div>
                            <div class="w-75">
                                <input type="radio" id="rblQualification1" name="qualification" value="Diploma"
                                    required>
                                <label for="rblQualification1">Diploma</label>
                                <input type="radio" id="rblQualification2" name="qualification" value="Degree" required>
                                <label for="rblQualification2">Degree</label>
                            </div>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <i class="fa-solid fa-user-graduate" style="width: 5%;"></i>
                        <div class="row" style="width: 60%; margin-right: 15px;">
                            <div class="w-25">
                                <label for="ddlInternshipSession">Internship Session:</label>
                            </div>
                            <div class="w-75">
                                <select id="ddlInternshipSession" name="internship_session" class="form-select"
                                    required>
                                    <option value="">Please select a session.</option>

                                    <?php
                                    require '../student/connect.php';

                                    // Check for connection errors
                                    if ($con->connect_error) {
                                        throw new Exception("Connection failed: " . $con->connect_error);
                                    } else {
                                        // Generate the record in the table
                                        $sql = "SELECT * FROM Session";
                                        $result = $con->query($sql);

                                        if ($result->num_rows > 0) {
                                            // Loop through the query results and generate <option> elements
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['sessionID'] . '">' . $row['sessionID'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No sessions found</option>';
                                        }
                                        $con->close();
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <i style="width: 5%; margin-top: 30px"></i>
                    </div>


                    <div class="text-center">
                        <button type="submit" class="btn-default w-75 my-5" id="btnRegister"
                            name="btnRegister">Register</button>

                    </div>


                </form>

            </div>
        </div>

    </div>
</body>

</html>