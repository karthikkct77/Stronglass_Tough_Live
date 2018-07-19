
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Change Password</h1>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Change Password</h3>
                <div class="tile-body">
                    <form method="post" role="form" action="<?php echo site_url('User_Controller/save_password'); ?>" onSubmit="return validatePassword()" name="data_register">


                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" required >

                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required>

                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="New Password" required>

                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function  validatePassword() {
        var new_pwd = document.getElementById('newPassword').value;
        var cnfrm_pwd = document.getElementById('confirmPassword').value;

        if(new_pwd ==  cnfrm_pwd)
        {
            return true;
        }
        else
        {
            alert("Confirm Password is Error...");
            return false;
        }
    }
</script>
