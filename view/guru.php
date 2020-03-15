<head>
    <title>UTS Pemweb | Main</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/jquery-3.4.1.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
        <table class="table mt-2">
            <thead>
                <tr>
                    <th scope="col" width="80">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tugas</th>
                    <th scope="col">UTS</th>
                    <th scope="col">UAS</th>
                    <th scope="col" width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $db->query("SELECT * FROM user");
                    $users = array();
                    while($row = $result->fetch_assoc()) {
                        array_push($users, new User($row["user_id"], $row["first_name"], $row["last_name"], $row["role_id"], $row["address"]) );
                    }

                    foreach($grades as $row) {
                        echo "<tr>";

                        $i = 0;
                        while($i < count($users)) {
                            if($row->getId() == $users[$i]->getId()) {
                                echo "<td>" . $row->getId() . "</td>";
                                echo "<td>" .  $users[$i]->getFName() . " " .  $users[$i]->getLName() . "</td>";
                                break;
                            }
                            $i++;
                        }
                        echo "<td>" . $row->getTugas() . "</td>";
                        echo "<td>" . $row->getUTS() . "</td>";
                        echo "<td>" . $row->getUAS() . "</td>";
                        echo "<td><a href=\"../editgrade?id=" . $row->getId() . "\"><button class=\"btn mr-2 text-white\" style=\"background-color: #009900;\">Edit</button></a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
