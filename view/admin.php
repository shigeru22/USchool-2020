<head>
    <title>UTS Pemweb | Main</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/jquery-3.4.1.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
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
        <div class="text-right mt-2">
            <a href="../add"><button class="btn btn-primary">Add Student</button></a>
        </div>
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col" width="80">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Role</th>
                    <th scope="col" width="250">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $db->query("SELECT * FROM user");

                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row["user_id"] . "</td>";
                        echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                        echo "<td>" . $roles[$row["role_id"] - 1]->getName() . "</td>";
                        echo "<td><a href=\"../viewuser?id=" . $row["user_id"] . "\"><button class=\"btn mr-2 text-white\" style=\"background-color: #009900;\">View</button></a><a href=\"../delete?id=" . $row["user_id"] . "\"><button class=\"btn btn-danger\">Delete</button></a></td>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
