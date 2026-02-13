<?php
$oldPasswd = $newPasswd = $confirmNewPasswd = '';
$oldPasswdErr = $newPasswdErr = '';

$user = loggedInUser();
if (!$user) {
    header("Location: ./?page=login");
    exit;
}

// Get current photo path (uses your function)
$currentPhoto = getUserPhoto();

$uploadMessage = '';

// ─── HANDLE UPLOAD ────────────────────────────────────────────────
if (isset($_POST['uploadPhoto']) && !empty($_FILES['photo']['name'])) {

    $result = uploadUserPhoto($_FILES['photo']);

    if ($result['success']) {
        $uploadMessage = '<div class="alert alert-success">' . htmlspecialchars($result['message']) . '</div>';
        // After successful upload → refresh the photo path
        $currentPhoto = getUserPhoto();  // now returns the new one
    } else {
        $uploadMessage = '<div class="alert alert-danger">' . htmlspecialchars($result['message']) . '</div>';
    }
}

// ─── HANDLE DELETE ────────────────────────────────────────────────
if (isset($_POST['deletePhoto'])) {

    $result = deleteUserPhoto();

    if ($result['success']) {
        $uploadMessage = '<div class="alert alert-info">' . htmlspecialchars($result['message']) . '</div>';
        $currentPhoto = getUserPhoto();  // should return emptyuser.png
    } else {
        $uploadMessage = '<div class="alert alert-warning">' . htmlspecialchars($result['message']) . '</div>';
    }
}


if (isset($_POST['changePasswd'], $_POST['oldPasswd'], $_POST['newPasswd'], $_POST['confirmNewPasswd'])) {
    $oldPasswd = trim($_POST['oldPasswd']);
    $newPasswd = trim($_POST['newPasswd']);
    $confirmNewPasswd = trim($_POST['confirmNewPasswd']);
    if (empty($oldPasswd)) {
        $oldPasswdErr = 'please input your old password';
    }
    if (empty($newPasswd)) {
        $newPasswdErr = 'please input your new password';
    }
    if ($newPasswd !== $confirmNewPasswd) {
        $newPasswdErr = 'password does not match';
    } else {
        if (!isUserHasPassword($oldPasswd)) {
            $oldPasswdErr = 'password is incorrect';
        }
    }
    if (empty($oldPasswdErr) && empty($newPasswdErr)) {
        if (setUserNewPassowrd($newPasswd)) {
            unset($_SESSION['user_id']);
            echo '<div class="alert alert-success" role="alert">
                password changed successfully. <a href="./?page=login">click here</a> to login again.
                </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                try aggain.
                </div>';
        }
    }
}

?>
<div class="row justify-content-center mb-5">
    <div class="col-12 col-md-6 col-lg-5 text-center">

        <?php if ($uploadMessage): ?>
            <?= $uploadMessage ?>
        <?php endif; ?>

        <form method="post" action="./?page=profile" enctype="multipart/form-data" id="photoForm">
            <!-- Hidden file input -->
            <input type="file" name="photo" id="profileUpload" accept="image/jpeg,image/jpg,image/png" hidden>

            <!-- Clickable image area -->
            <label for="profileUpload" style="cursor: pointer; display: inline-block;">
                <img id="profilePreview"
                     src="<?= htmlspecialchars($currentPhoto) ?>"
                     class="rounded-circle shadow"
                     style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #dee2e6; background: #f8f9fa;">
            </label>

            <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
                <button type="submit" name="uploadPhoto" class="btn btn-success px-4" id="btnUpload" disabled>
                    Upload
                </button>
                <button type="submit" name="deletePhoto" class="btn btn-danger px-4"
                        onclick="return confirm('Are you sure you want to remove your profile picture?');">
                    Delete
                </button>
            </div>
        </form>

    </div>
</div>

<!-- JavaScript: Live Preview + Enable Upload Button -->
<script>
document.getElementById('profileUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    // Show instant preview
    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('profilePreview').src = ev.target.result;
    };
    reader.readAsDataURL(file);

    // Enable upload button
    document.getElementById('btnUpload').disabled = false;
});
</script>


    <div class="col-6">
        <form method="post" action="./?page=profile" class="col-md-8 col-lg-6 mx-auto">
            <h3>Change Password</h3>
            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input value="<?php echo $oldPasswd ?>" name="oldPasswd" type="password" class="form-control 
                <?php echo empty($oldPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $oldPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input name="newPasswd" type="password" class="form-control 
                <?php echo empty($newPasswdErr) ? '' : 'is-invalid' ?>">
                <div class="invalid-feedback">
                    <?php echo $newPasswdErr ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input name="confirmNewPasswd" type="password" class="form-control">
            </div>
            <button type="submit" name="changePasswd" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>