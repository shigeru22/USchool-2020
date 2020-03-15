<head>
    <title>UTS Pemweb | Main</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/jquery-3.4.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div class="container">
        <h2 class="text-center mt-5">User Details</h2>
        <table class="table mt-5">
            <tbody>
                <?php
                    $targetId = $_GET["id"];
                    $result = $db->query("SELECT * FROM user WHERE user_id='$targetId'");

                    $row = $result->fetch_assoc();
                    echo "<tr><td width=\"120\">Nama</td><td>" . $row["first_name"] . " " . $row["last_name"] . "</td></tr>";
                    echo "<tr><td>ID</td><td>" . $row["user_id"] . "</td></tr>";
                    echo "<tr><td>Role</td><td>" . $roles[$row["role_id"] - 1]->getName() . "</td></tr>";
                    echo "<tr><td>Address</td><td>" . $row["address"] . "</td></tr>";
                ?>
            </tbody>
        </table>
        <?php
            echo "<button class=\"btn btn-primary\" onclick=\"window.location.href = '../edituser?id=" . $targetId . "'\">Update</button>";
        ?>
        <button class="btn btn-secondary" onclick="window.location.href='..'">Return</button>
    </div>
</body>
