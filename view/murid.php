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
        function logoutUser() {
            $.ajax({
                url: "../controller/logout.php",
                method: "POST",
                data: {},
                success: function(data) {
                    var result = JSON.parse(data);

                    if(result.message == "success") {
                        window.location.href = "..";
                    }
                    else {
                        alert("Failed to logout. Please clear your browsing data immediately.");
                    }
                },
                error: function() {
                    alert("Failed to logout. Please clear your browsing data immediately.");
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
                    <li class="nav-item mr-2">
                        <button class="btn btn-secondary" onclick="window.location.href = '../about'">About</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-danger" onclick="logoutUser()">Logout</button>
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
                        foreach($grades as $userGrade) {
                            if($userGrade->getId() == $_SESSION["uschool-id"]) {
                                if($userGrade->getTugas() != -1) echo "<td>" . $userGrade->getTugas() . "</td>";
                                else echo "<td>Ungraded</td>";
                                if($userGrade->getUTS() != -1) echo "<td>" . $userGrade->getUTS() . "</td>";
                                else echo "<td>Ungraded</td>";
                                if($userGrade->getUAS() != -1) echo "<td>" . $userGrade->getUAS() . "</td>";
                                else echo "<td>Ungraded</td>";

                                if($userGrade->getTugas() != -1 && $userGrade->getUTS() != -1 && $userGrade->getUAS() != -1) $grade = ($userGrade->getTugas() + $userGrade->getUTS() + $userGrade->getUAS()) / 3;
                                else $grade = -1;
                                break;
                            }
                        }
                    ?>
                </tr>
            </tbody>
        </table>
        <?php
            if($grade == -1) echo "<p>Belum dinilai. Harap cek jika nilai anda telah dinilai dan tersubmit ke sistem.</p>";
            if($grade >= 80) echo "<p>Grade: A</p>";
            else if($grade >= 65) echo "<p>Grade: B</p>";
            else if($grade >= 45) echo "<p>Grade: C</p>";
            else if ($grade != -1) echo "<p>Grade: D</p>";

            if($grade >= 45) echo "<p>Dinyatakan: <b>LULUS</b></p>";
            else if($grade != -1) echo "<p>Dinyatakan: <b>TIDAK LULUS</b></p>";
        ?>
    </div>
</body>
