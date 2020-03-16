<head>
    <title>UTS Pemweb | Edit Grades</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/jquery-3.4.1.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function editGrade() {
            $('#editBtn').attr("disabled", true);

            var updated = 0;
            $('#useridMsg').hide();
            $('#fnameMsg').hide();
            $('#worksMsg').hide();
            $('#midtermMsg').hide();
            $('#finaltermMsg').hide();
            $('#unchangeErr').hide();
            $('#queryErr').hide();
            $('#phpErr').hide();

            var userid = $('#userid').val();
            var fname = $('#fname').val();
            var works = $('#works').val();
            var midterm = $('#midterm').val();
            var finalterm = $('#finalterm').val();

            if(userid == '') $('#useridMsg').show();
            if(fname == '') $('#fnameMsg').show();
            if(works == '') $('#worksMsg').show();
            if(midterm == '') $('#midtermMsg').show();
            if(finalterm == '') $('#finaltermMsg').show();

            if(userid != '' && fname != '' && works != '' && midterm != '' && finalterm != '') {
                $.ajax({
                    url: "../controller/update_grade.php",
                    method: "POST",
                    data: {
                        userid: userid,
                        works: works,
                        mid: midterm,
                        final: finalterm
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

            if(updated == 0) $('#editBtn').attr("disabled", false);
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
                <label for="fname">Nama</label>
                <?php
                    echo "<input type=\"text\" value=\"" . $user->getFName() . " " . $user->getLName() . "\" class=\"form-control\" id=\"fname\" disabled>";
                ?>
                <small id="fnameMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="form-group">
                <label for="userid">User ID</label>
                <?php
                    echo "<input type=\"text\" value=\"" . filter_input(INPUT_POST, 'id', FILTER_SANITIZE_ENCODED); . "\" class=\"form-control\" id=\"userid\" disabled>";
                ?>
                <small id="useridMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="form-group">
                <label for="works">Nilai Tugas</label>
                <?php
                    if($grade->getTugas() != -1) echo "<input type=\"text\" value=\"" . $grade->getTugas() . "\" class=\"form-control\" id=\"works\">";
                    else echo "<input type=\"text\" class=\"form-control\" id=\"works\">";
                ?>
                <small id="worksMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="form-group">
                <label for="midterm">Nilai UTS</label>
                <?php
                    if($grade->getUTS() != -1) echo "<input type=\"text\" value=\"" . $grade->getUTS() . "\" class=\"form-control\" id=\"midterm\">";
                    else echo "<input type=\"text\" class=\"form-control\" id=\"midterm\">";
                ?>
                <small id="midtermMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="form-group">
                <label for="finalterm">Nilai UAS</label>
                <?php
                    if($grade->getUAS() != -1) echo "<input type=\"text\" value=\"" . $grade->getUAS() . "\" class=\"form-control\" id=\"finalterm\">";
                    else echo "<input type=\"text\" class=\"form-control\" id=\"finalterm\">";
                ?>
                <small id="finaltermMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
            </div>
            <div class="text-center">
                <p id="updated" style="color:#ff0000; display: none;">Grade updated. Redirecting to main page.</p>
                <p id="unchangeErr" style="color: #ff0000; display: none;">Nothing changed.</p>
                <p id="queryErr" style="color:#ff0000; display: none;">Query error or no permission. Please try again.</p>
                <p id="phpErr" style="color:#ff0000; display: none;">An error occured. Please try again.</p>
            </div>
            <div class="row justify-content-center mb-4">
                <button type="button" id="editBtn" class="btn btn-primary mr-4" onclick="editGrade()">Update</button>
                <?php
                    echo "<button type=\"button\" id=\"cancelBtn\" class=\"btn btn-danger\" onclick=\"window.location.href = '..'\">Cancel</button>"
                ?>
            </div>
        </form>
    </div>
</body>
