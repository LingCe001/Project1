<?php
include '../includes/header.inc.php';
include '../includes/navbar.inc.php';
$nameErr = $usernameErr = $passwordErr = $confirmErr = $successMsg = $errorMsg = "";
$name = $username = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name          = trim($_POST['name'] ?? '');
    $username      = trim($_POST['username'] ?? '');
    $password      = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    if (empty($name)) {
        $nameErr = 'please input name!';
    }

    if (empty($username)) {
        $usernameErr = 'please input username!';
    }

    if (empty($password)) {
        $passwordErr = 'please input password';
    }
    if (!empty($password) && $password !== $confirmPassword) {
        $confirmErr   = 'Password does not match!';
        $passwordErr .= ' ';
    }
    if (empty($nameErr) && empty($usernameErr) && empty($passwordErr) && empty($confirmErr)) {
        if (usernameExists($username)) {
            $usernameErr = 'Pls choose another username !';
        } else {
            if (registerUser($name, $username, $password)) {
                $successMsg = 'Registration successful! You can now <a href="./?page=login" class="alert-link">log in</a>.';
            } else {
                $errorMsg = 'Registration failed! Please try again.';
            }
        }
    }
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6">

            <h3 class="text-center mb-4">Register Page</h3>

            <?php if ($successMsg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $successMsg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if ($errorMsg): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $errorMsg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <form method="post" action="" class="p-4 border rounded bg-light">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" value="<?= htmlspecialchars($name) ?>" type="text"
                           class="form-control <?= $nameErr ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $nameErr ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="username" value="<?= htmlspecialchars($username) ?>" type="text"
                           class="form-control <?= $usernameErr ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $usernameErr ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input name="password" type="password"
                           class="form-control <?= $passwordErr ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $passwordErr ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input name="confirmPassword" type="password"
                           class="form-control <?= $confirmErr ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $confirmErr ?></div>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100">
                    Submit
                </button>

            </form>

        </div>
    </div>
</div>

<?php
include '../includes/footer.icn.php';
?>