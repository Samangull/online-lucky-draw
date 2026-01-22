<?php 
include("header.php");
include("sidebar.php");
?>


<style>
    .form-container {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        margin-top: 50px;
    }
    .form-heading {
        font-family: 'Segoe UI', sans-serif;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <?php
            if (isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];   
                $qry = "SELECT * FROM users WHERE id='$edit_id'";
                $run = mysqli_query($con, $qry);

                if ($run && mysqli_num_rows($run) > 0) {
                    $row = mysqli_fetch_assoc($run);
                    extract($row);
                }
            }
            ?>

            <form method="post" class="form-container">
                <h3 class="form-heading">Edit Profile</h3>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" name="password" class="form-control" value="<?php echo $password; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile" class="form-control" value="<?php echo $mobile; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $city; ?>" required>
                </div>

                <hr>

                


                <br>
                <div class="d-grid">
                    <button type="submit" name="register" class="btn btn-primary">Update Profile</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php 
if (isset($_POST['register'])) {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $city   = $_POST['city'];
    
    

    $qry = "UPDATE users SET 
        name = '$name',
        email = '$email',
        password = '$password',
        mobile = '$mobile',
        city = '$city'
       
       
        WHERE id = '$edit_id'";

    $run = mysqli_query($con, $qry);

    if ($run) {
        echo "<script>alert('Record updated successfully')</script>";
        echo "<script>window.open('profile.php', '_self')</script>";
    } else {
        echo "<script>alert('Something went wrong, please try again')</script>";
    }
}
?>
    </div>
    </div>
</div>

<?php 
include("footer.php");
?>
