<?php

$oldPasswd = $newPasswd = $confirmNewPasswd = '';
$oldPasswdErr = $newPasswdErr = '';

if (isset($_POST['changePasswd'])) {
    $oldPasswd = trim($_POST['oldPasswd']);
    $newPasswd = trim($_POST['newPasswd']);
    $confirmNewPasswd = trim($_POST['confirmNewPasswd']);

    if (empty($oldPasswd)) {
        $oldPasswdErr = 'please input your old password';
    }

    if (empty($newPasswd)) {
        $newPasswdErr = 'please input your new password';
    }

    if ($newPasswd != $confirmNewPasswd) {
        $newPasswdErr = 'password does not match';
    }

    if (empty($oldPasswdErr) && empty($newPasswdErr)) {
        if (!isUserHasPassword($oldPasswd)) {
            $oldPasswdErr = 'password is incorrect';
        }
    }

    if (empty($oldPasswdErr) && empty($newPasswdErr)) {
        if (setUserNewPassowrd($newPasswd)) {
            header('Location: ?page=logout');
        } else {
            echo '<div class="alert alert-danger" role="alert">
                Something went wrong, please try again.
            </div>';
        }
    }
}
?>
<div class="row">
    <div class="col-6">
        <form method="post" action="?page=profile" enctype="multipart/form-data">
            <div class="d-flex justify-content-center">
                <div>
                    <input 
                        type="file" 
                        name="photo" 
                        id="photo" 
                        class="d-none" 
                    >
                    <label for="photo" role="button">
                        <img 
                            src="assets/images/emptyuser.png" 
                            class="rounded"
                        >
                    </label>
                </div>
            </div>

            <div class="justify-content-center d-flex">
                <button 
                    type="submit" 
                    name="deletePhoto" 
                    class="btn btn-danger"
                >Delete</button>

                <button 
                    type="submit" 
                    name="uploadPhoto" 
                    class="btn btn-success"
                >Upload</button>
            </div>
        </form>
    </div>
</div>
<div class="col-6" action="?page=profile" class="col-md-8 col-lg-6 mx-auto">
    <form method="post">
        <div>
            <h3>Change Password</h3>
            
            <div class="mb-3 php echo value">
                <label class="form-label">Old Password</label>
                <input label class="form echo $oldPasswd ?>" name="oldPasswd" type="password" class="form-control
                    <?php echo $oldPasswdErr ? 'is-invalid' : '' ?>">
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
        </div>
    </form>
    <?php if (!empty($success)) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
</div>