<head>
    <title>UTS Pemweb | Edit Student</title>
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
                <p id="loginErr" style="color:#ff0000; display: none;">Wrong email or password.</p>
                <p id="queryErr" style="color:#ff0000; display: none;">Query error. Please ask administrator.</p>
                <p id="phpErr" style="color:#ff0000; display: none;">An error occured. Please try again.</p>
            </div>
            <div class="row justify-content-center">
                <button type="button" id="editBtn" class="btn btn-primary mr-4" onclick="editUser()">Update</button>
                <?php
                    echo "<button type=\"button\" id=\"cancelBtn\" class=\"btn btn-danger\" onclick=\"window.location.href = '../viewuser?id=" . $_GET["id"] . "'\">Cancel</button>"
                ?>
            </div>
        </form>
    </div>
</body>
