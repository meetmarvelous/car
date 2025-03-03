<?php
if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = md5($_POST['newpassword']);

    // Check if the email and mobile number match
    $sql = "SELECT EmailId FROM tblusers WHERE EmailId = '$email' AND ContactNo = '$mobile'";
    $query = mysqli_query($con, $sql);

    if (mysqli_num_rows($query) > 0) {
        // Update the password
        $coin = "UPDATE tblusers SET Password = '$newpassword' WHERE EmailId = '$email' AND ContactNo = '$mobile'";
        $chngpwd1 = mysqli_query($con, $coin);

        if ($chngpwd1) {
            echo "<script>alert('Your Password successfully changed');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } else {
        echo "<script>alert('Email id or Mobile no is invalid');</script>";
    }
}
?>

<script type="text/javascript">
function valid() {
    if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password Field do not match !!");
        document.chngpwd.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>

<div class="modal fade" id="forgotpassword">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Password Recovery</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="forgotpassword_wrap">
            <div class="col-md-12">
              <form name="chngpwd" method="post" onSubmit="return valid();">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="Your Email address*" required="">
                </div>
                <div class="form-group">
                  <input type="text" name="mobile" class="form-control" placeholder="Your Reg. Mobile*" required="">
                </div>
                <div class="form-group">
                  <input type="password" name="newpassword" class="form-control" placeholder="New Password*" required="">
                </div>
                <div class="form-group">
                  <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password*" required="">
                </div>
                <div class="form-group">
                  <input type="submit" value="Reset My Password" name="update" class="btn btn-block">
                </div>
              </form>
              <div class="text-center">
                <p class="gray_text">For security reasons we don't store your password. Your password will be reset and a new one will be sent.</p>
                <p><a href="#loginform" data-toggle="modal" data-dismiss="modal"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back to Login</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>