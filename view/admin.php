<head>
    <title>UTS Pemweb | Main</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/jquery-3.4.1.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function deleteUser() {
            var userid = $('#deleteBtn').val();

            $.ajax({
                url: "../controller/delete.php",
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
                    <li class="nav-item">
                        <button class="btn btn-danger" onclick="logoutUser()">Logout</button>
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
                        echo "<td><a href=\"../viewuser?id=" . $row["user_id"] . "\"><button class=\"btn mr-2 text-white\" style=\"background-color: #009900;\">View</button></a><button class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteModal\" data-selectedbtn=\"". $row["user_id"] . "\">Delete</button></td>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- user error modal -->
    <div class="modal fade" id="delErrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <i class="material-icons" style="font-size: 96px;">error</i>
                    <h3 class="mt-2">This user can't be deleted.</h3>
                    <small>Possible causes: Logged in user, no permission, or query error</small>
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete user confimation modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <i class="material-icons" style="font-size: 96px; color: #ff0000;">delete</i>
                    <h3 class="mt-2">Are you sure to delete this user?</h3>
                    <div class="mt-4">
                        <button id="deleteBtn" type="button" class="btn btn-danger mr-2" onclick="deleteUser()">Delete</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- script to change target userid value -->
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var recipient = button.data('selectedbtn');
            $(this).find('#deleteBtn').val(recipient);
        });
    </script>
</body>
