<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="./favicon.svg" sizes="any" type="image/svg+xml">
    <!-- Link to Bootstrap 5 -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <style>
        body {
            background: #fff;
        }

        div#content {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 350px;
            height: auto;
            padding: 20px;
            background: #fff;
            text-align: center;
            border-radius: 15px;
        }

        a { }
    </style>

    <div id="content">

            <div class="col-12">
                <div class="text-center my-5">
                    <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
                </div>
                <div class="card shadow-lg">
                    <div class="card-body px-3">
                        <h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
                        <form id="myForm" class="needs-validation" novalidate="" autocomplete="off">
                            <div class="mb-3">
                                <label class="mb-2 text-muted float-start" for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="" required="" autofocus="">
                                <div class="invalid-feedback">
                                    Email is invalid
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="mb-2 w-100">
                                    <label class="text-muted float-start" for="password">Password</label>
                                    <a href="forgot.html" class="float-end link-primary">
                                        Forgot Password?
                                    </a>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" required="">
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                    <label for="remember" class="form-check-label">Remember Me</label>
                                </div>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Don't have an account? <a href="register.html" class="text-dark">Create One</a>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5 text-muted">
                    Copyright © 2017-2021 — Your Company
                </div>
                <div id="result" class="mt-3"></div> <!-- แสดงผลลัพธ์ -->
            </div>
        </div>

    <!-- Bootstrap 5 Script -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/login.js"></script> <!-- แยก JavaScript ออก -->
</body>
</html>