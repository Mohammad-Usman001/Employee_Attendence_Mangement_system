<?php
session_start();
include("functions.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use boolean check to handle success or failure
    if (!empty($username) && !empty($password)) { 
        $user=authenticate_user($conn, $username, $password);

        if($user){
            $_SESSION['user_id']= $user['admin_id'];
            $_SESSION['username']=$user['username'];
            $_SESSION["admin_logged_in"] = true;
            header('Location: index.php');
            exit();
        }
        
    } else {
        echo "Error: Please fill all details:";
    }
}

include("header.php");
?>

<body>
    <!-- <form method="POST" action="" class="w-50 mx-auto mt-5 p-4 border rounded">
        <h2 class="text-center mb-4">Login</h2>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
            <a href="admin_registration.php">Not have an account?</a>
        </div>
    </form> -->
    <section class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="card mb-0">
                            <div class="row g-0 align-items-center">
                                <div class="col-xxl-5">
                                    <div class="card auth-card bg-secondary h-100 border-0 shadow-none d-none d-sm-block mb-0">
                                        <div class="card-body py-5 d-flex justify-content-between flex-column">
                                            <div class="text-center">
                                                <h3 class="text-white">Start your journey with us.</h3>
                                                <p class="text-white opacity-75 fs-base">It brings together your tasks, projects, timelines, files and more</p>
                                            </div>
                            
                                            <div class="auth-effect-main my-5 position-relative rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                                <div class="effect-circle-1 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="effect-circle-2 position-relative mx-auto rounded-circle d-flex align-items-center justify-content-center">
                                                        <div class="effect-circle-3 mx-auto rounded-circle position-relative text-white fs-4xl d-flex align-items-center justify-content-center">
                                                            Welcome to <span class="text-primary ms-1">Admin Panel</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="auth-user-list list-unstyled">
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="assets/images/users/avatar-1.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="assets/images/users/avatar-2.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="assets/images/users/avatar-3.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="assets/images/users/avatar-4.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="avatar-sm d-inline-block">
                                                            <div class="avatar-title bg-white shadow-lg overflow-hidden rounded-circle">
                                                                <img src="assets/images/users/avatar-5.jpg" alt="" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                    
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-6 mx-auto">
                                    <div class="card mb-0 border-0 shadow-none mb-0">
                                        <div class="card-body p-sm-5 m-lg-4">
                                            <div class="text-center mt-5">
                                                <h5 class="fs-3xl">Welcome Back</h5>
                                                <p class="text-muted">Sign in to continue to Admin Panel.</p>
                                            </div>
                                            <div class="p-2 mt-5">
                                                <form action=""  method="POST">
                            
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                                        <div class="position-relative ">
                                                            <input type="text" class="form-control  password-input" id="username" placeholder="Enter username" name="username" required>
                                                        </div>
                                                    </div>
                            
                                                    <div class="mb-3">
                                                        <div class="float-end">
                                                            <a href="auth-pass-reset.html" class="text-muted">Forgot password?</a>
                                                        </div>
                                                        <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                                            <input type="password" class="form-control pe-5 password-input " placeholder="Enter password" id="password-input" name="password" required>
                                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        </div>
                                                    </div>
                            
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                    </div>
                            
                                                    <div class="mt-4">
                                                        <button class="btn btn-primary w-100" name="submit" type="submit">Sign In</button>
                                                    </div>
                            
                                                    <div class="mt-4 pt-2 text-center">
                                                        <div class="signin-other-title position-relative">
                                                            <h5 class="fs-sm mb-4 title">Sign In with</h5>
                                                        </div>
                                                        <div class="pt-2 hstack gap-2 justify-content-center">
                                                            
                                                            <button type="button" class="btn btn-subtle-danger btn-icon"><i class="ri-google-fill fs-lg"></i></button>
                                                            
                                                        </div>
                                                    </div>
                                                </form>
                            
                                                <div class="text-center mt-5">
                                                    <p class="mb-0">Don't have an account ? <a href="admin_registration.php" class="fw-semibold text-secondary text-decoration-underline"> SignUp</a> </p>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

    <!-- Bootstrap JS and Popper.js (optional for some features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
