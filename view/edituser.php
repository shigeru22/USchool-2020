<head>
    <title>UTS Pemweb | Edit Student</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/jquery-3.4.1.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function editUser() {
            $('#editBtn').attr("disabled", true);

            var updated = 0;
            $('#useridMsg').hide();
            $('#fnameMsg').hide();
            $('#lnameMsg').hide();
            $('#roleMsg').hide();
            $('#addrMsg').hide();
            $('#unchangeErr').hide();
            $('#queryErr').hide();
            $('#phpErr').hide();

            var userid = $('#userid').val();
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var role = $('#role').val();
            var address = $('#address').val();

            if(userid == '') $('#useridMsg').show();
            if(fname == '') $('#fnameMsg').show();
            if(lname == '') $('#lnameMsg').show();
            if(role == '') $('#roleMsg').show();
            if(address == '') $('#addrMsg').show();

            if(userid != '' && fname != '' && lname != '' && role != '' && address != '') {
                $.ajax({
                    url: "../controller/update_user.php",
                    method: "POST",
                    data: {
                        userid: userid,
                        fname: fname,
                        lname: lname,
                        role: role,
                        address: address
                    },
                    success: function(data) {
                        var result = JSON.parse(data);
                        if(result.message == "success") {
                            updated = 1;
                            $('#updated').show();
                            setTimeout(function(){
                                window.location.href = "..";
                            }, 3000);
                        }
                        else if(result.message == "unchanged") {
                            $('#unchangeErr').show();
                        }
                        else if(result.message == "error") {
                            $('#queryErr').show();
                        }
                    },
                    error: function() {
                        $('#phpErr').show();
                    }
                });
            }

            if(updated == 0) $('#addBtn').attr("disabled", false);
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
    <div class="container mt-4 col-sm-7 col-md-6 col-lg-5 col-xl-4">
        <form id="addForm">
            <div class="form-group">
                <label for="userid">User ID</label>
                <?php
                    echo "<input type=\"text\" value=\"" . $_GET["id"] . "\" class=\"form-control\" id=\"userid\" disabled>";
                ?>
                <small id="useridMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="fname">Nama depan</label>
                    <?php
                        echo "<input type=\"text\" value=\"" . $currUser->getFName() . "\" class=\"form-control\" id=\"fname\">";
                    ?>
                    <small id="fnameMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
                </div>
                <div class="col form-group">
                    <label for="lname">Nama belakang</label>
                    <?php
                        echo "<input type=\"text\" value=\"" . $currUser->getLName() . "\" class=\"form-control\" id=\"lname\">";
                    ?>
                    <small id="lnameMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
                </div>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role">
                    <option value="">Please select...</option>
                    <?php
                        foreach($roles as $row) {
                            if($row->getId() == $currUser->getRoleId()) echo "<option value=\"" . $row->getId() . "\" selected>" . $row->getName() . "</option>";
                            else echo "<option value=\"" . $row->getId() . "\">" . $row->getName() . "</option>";
                        }
                    ?>
                </select>
                <small id="roleMsg" style="color:#ff0000; display: none;">Please select an option form this field.</small>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <?php
                    echo "<input type=\"text\" value=\"" . $currUser->getAddress() . "\" class=\"form-control\" id=\"address\">";
                ?>
                <small id="addrMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" value="(Same password)" class="form-control" id="password" disabled>
                <small id="pwMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="text-center">
                <p id="updated" style="color:#ff0000; display: none;">User updated. Redirecting to main page.</p>
                <p id="unchangeErr" style="color: #ff0000; display: none;">Nothing changed.</p>
                <p id="queryErr" style="color:#ff0000; display: none;">Query error or no permission. Please try again.</p>
                <p id="phpErr" style="color:#ff0000; display: none;">An error occured. Please try again.</p>
            </div>
            <div class="row justify-content-center mb-4">
                <button type="button" id="editBtn" class="btn btn-primary mr-4" onclick="editUser()">Update</button>
                <?php
                    echo "<button type=\"button\" id=\"cancelBtn\" class=\"btn btn-danger\" onclick=\"window.location.href = '../viewuser?id=" . $_GET["id"] . "'\">Cancel</button>"
                ?>
            </div>
        </form>
    </div>
</body>
