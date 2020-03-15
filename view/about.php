<head>
    <title>UTS Pemweb | About</title>
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
                    <li class="nav-item mr-2">
                        <button class="btn btn-secondary" onclick="window.location.href = '../about' disabled">About</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-danger" onclick="logoutUser()">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4 col-sm-7 col-md-6 col-lg-5 col-xl-4">
        <img src="../assets/img/author.jpg" class="mx-auto d-block" style="border-radius: 50%;">
        <div class="text-center mt-3">
            <h2>Jeremy Yonathan</h2>
            <p>00000027018<br>2018</p>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-primary" onclick="window.location.href = '../main'">Return to main page</button>
        </div>
    </div>
</body>
