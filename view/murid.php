<head>
    <title>UTS Pemweb | Main</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/jquery-3.4.1.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
        }

        table td {
            padding: 0;
            margin: 0;
        }
    </style>
    <script>
        function deleteUser() {
            var userid = $('#deleteBtn').val();

            $.ajax({
                url: "../controller/deleteuser.php",
                method: "POST",
                data: {
                    userid: userid
                },
                success: function(data) {
                    var result = JSON.parse(data);

                    if(result.message == "success") {
                        window.location.href = ".";
                    }
                    else if(result.message == "error") {
                        $('#deleteModal').modal("hide");
                        $('#delErrModal').modal("show");
                    }
                },
                error: function() {
                    $('#deleteModal').modal("hide");
                    $('#delErrModal').modal("show");
                }
            });
        }
    </script>
</head>
<body style="background-color: #fffcec;">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffe4b3;">
        <div class="container">
            <a class="navbar-brand" href="#">USchool</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar-collapse" class="navbar-collapse collapse">
                <ul class="nav navbar-nav ml-auto">
                    <span class="navbar-text mr-2">
                        <?php
                            echo "Welcome, " . $currUser->getFName();
                        ?>
                    </span>
                    <li class="nav-item">
                        <button class="btn btn-danger">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td width="150">Name:</td>
                    <?php
                        echo "<td>" . $currUser->getFName() . " " . $currUser->getLName() . "</td>";
                    ?>
                </tr>
                <tr>
                    <td>ID:</td>
                    <?php
                        echo "<td>" . $_SESSION["uschool-id"] . "</td>";
                    ?>
                </tr>
            </tbody>
        </table>
        <p>Ringkasan nilai:</p>
        <table class="table table-bordered" style:"margin-left:0px;">
            <thead>
                <tr>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                        $grade;
                        $i = 0;
                        while($i < count($grades)) {
                            if($grades[$i]->getId() == $_SESSION["uschool-id"]) {
                                echo "<td>" . $grades[$i]->getTugas() . "</td>";
                                echo "<td>" . $grades[$i]->getUTS() . "</td>";
                                echo "<td>" . $grades[$i]->getUAS() . "</td>";

                                $grade = ($grades[$i]->getTugas() + $grades[$i]->getUTS() + $grades[$i]->getUAS()) / 3;
                                break;
                            }
                        }
                    ?>
                </tr>
            </tbody>
        </table>
        <?php
            if($grade >= 80) echo "<p>Grade: A</p>";
            else if($grade >= 65) echo "<p>Grade: B</p>";
            else if($grade >= 45) echo "<p>Grade: C</p>";
            else echo "<p>Grade: D</p>";

            if($grade >= 45) echo "<p>Dinyatakan: <b>LULUS</b></p>";
            else echo "<p>Dinyatakan: <b>TIDAK LULUS</b></p>";
        ?>
    </div>
</body>
