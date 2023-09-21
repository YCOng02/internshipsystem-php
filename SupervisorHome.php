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

<body class="bg-bright">
    <script type="text/javascript">
        function viewStudent(id) {
            // Perform a client-side redirection to the StudentDetail.aspx page with the extracted ID
            window.location.href = "StudentDetail.aspx?StudID=" + id;
        }  
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
    <form id="form1" runat="server">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="../image/logo.png" width="250" height="80" />
                </a>
                <div class="navbar-container">
                    <div class="collapse navbar-collapse master" id="navbarNav">
                        <asp:Menu ID="Menu1" runat="server" Orientation="Horizontal" DataSourceID="SiteMapDataSource1"
                            StaticDisplayLevels="2" StaticSubMenuIndent="16px" CssClass="navbar-nav ml-auto">
                            <StaticMenuItemStyle CssClass="nav-item" />
                            <StaticSelectedStyle CssClass="nav-item active" />
                            <StaticHoverStyle CssClass="nav-item active" />
                        </asp:Menu>
                        <asp:SiteMapDataSource ID="SiteMapDataSource1" runat="server" SiteMapProvider="Supervisor" />
                    </div>
                </div>

            </div>
        </nav>

        <div id="content">
            <asp:ContentPlaceHolder ID="main" runat="server">
            </asp:ContentPlaceHolder>
        </div>

        <div class="container row justify-content-md-center mx-auto">
            <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                <button id="btnCurrent" class="nav-link active w-50 text-white border-0"
                    style="background-color: #dc143c">Current</button>
                <button id="btnUpcoming" class="nav-link w-50 text-black"
                    style="border-color: #FFFBD6">Upcoming</button>
            </div>
        </div>

        <div style="overflow-x: scroll;" class="container row justify-content-md-center mx-auto">
            <table id="StudentGV" class="table w-100 table-striped my-1 table-bordered table-responsive table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Qualification</th>
                        <th>Session</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($yourDataArray as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['studID'] . "</td>";
                        echo "<td>" . $row['studName'] . "</td>";
                        echo "<td>" . $row['studEmail'] . "</td>";
                        echo "<td>" . $row['studPhoneNo'] . "</td>";
                        echo "<td>" . $row['studQualification'] . "</td>";
                        echo "<td>" . $row['sessionID'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
</body>

</html>