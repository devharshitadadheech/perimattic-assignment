<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name')); ?>::Login</title>
</head>

<body>
    <main class="app">
        <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h4>Login</h4>
                        <?php echo $__env->make('layout.notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('verify')); ?>" id="loginForm" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12 col-xs-12 col-md-12">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control w-100" placeholder="Email">
                                </div>
                                <div class="col-12 col-xs-12 col-md-12 mt-2">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control w-100"
                                        placeholder="Password">
                                </div>
                                <div class="col-12 col-xs-12 col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            Not a user? <a href="">Register here</a>
                                        </div>
                                        <div class="col-6 text-end">
                                            <a href="#">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button class="btn btn-success">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\code\assignment\resources\views/login.blade.php ENDPATH**/ ?>