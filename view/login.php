<head>
    <title>UTS Pemweb | Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/jquery-3.4.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        
    </script>
</head>
<body style="background-color: #fff7e8;">
    <div class="container justify-content-center">
        <div class="row">
            <div id="cardContainer" class="card h-100 mx-auto mt-5 col-md-6 col-lg-5 col-xl-4 shadow" style="height: 30rem;">
                <div class="card-body ml-4 mr-4">
                    <div class="row justify-content-center mt-5">
                        <h2>Login</h2>
                    </div>
                    <div class="row mt-4 justify-content-center">
                        <form id="loginForm">
                            <div class="form-group">
                                <label for="userid">User ID</label>
                                <input type="text" class="form-control" id="userid">
                                <small id="useridMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password">
                                <small id="pwMsg" style="color:#ff0000; display: none;">Please enter this field.</small>
                            </div>
                            <div class="text-center">
                                <p id="loginErr" style="color:#ff0000; display: none;">Wrong email or password.</p>
                                <p id="queryErr" style="color:#ff0000; display: none;">Query error. Please ask administrator.</p>
                                <p id="phpErr" style="color:#ff0000; display: none;">An error occured. Please try again.</p>
                            </div>
                            <div class="row justify-content-center">
                                <button type="button" class="btn btn-primary" onclick="loginUser()">Login</button>
                            </div>
                        </form>
                    </div>
                    <footer class="mt-5 text-center mb-5">&copy; 2020 Jerjer. All rights reserved.</footer>
                </div>
            </div>
        </div>
    </div>
</body>
