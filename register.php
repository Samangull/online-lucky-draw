<?php include('connection.php');
include('header.php');
include('sidebar.php');

if (isset($_POST['submit'])) {

  $name = $_POST['name'];

  $email = $_POST['email'];
  $password = $_POST['password'];
  $mobile = $_POST['mobile'];
  $city = $_POST['city'];
  $type = $_POST['type'];



  $xyz = "insert into users (name, email, password, mobile, city, type) values ('$name', '$email', '$password', '$mobile', '$city', '$type')";



  $sql = mysqli_query($con, $xyz);


  if ($sql) {

    echo "<script> alert (' Your data has been submitted', '" . $name . "')</script>";
  } else {

    echo "not";
  }
}




?>




<div class="container">
  <div class="row">
    <div class="col-lg-12">




      <form class="form-horizontal" method="post" enctype="multipart/form-data">

        <fieldset style="margin:50px">

          <!-- Form Name -->
          <legend>Create an Account</legend>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput"> Name</label>
            <div class="col-md-4">
              <input name="name" type="text" placeholder="Enter your Name" class="form-control input-md" required="">

            </div>
          </div>


          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Email</label>
            <div class="col-md-4">
              <input name="email" type="email" placeholder="Enter Email" class="form-control input-md" required="">

            </div>
          </div>


          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Password</label>
            <div class="col-md-4">
              <input name="password" type="password" placeholder="Enter Password" class="form-control input-md" required>

            </div>
          </div>


          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Mobile Number</label>
            <div class="col-md-4">
              <input name="mobile" type="number" placeholder="Enter Mobile Number" class="form-control input-md">

            </div>
          </div>


          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">City</label>
            <div class="col-md-4">
              <input name="city" type="text" placeholder="Enter City Name" class="form-control input-md">

            </div>
          </div>


          <!-- Text input-->
          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">User Type</label>
            <div class="col-md-4">
              <select class="form-control input-md" name="type" required>

                <option value="">
                  Select User Type
                <option value="User">User</option>




              </select>

            </div>
          </div>




          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput"></label>
            <div class="col-md-4">
              <center>
                <a href="index.php" class="btn btn-info">Home</a>

                <input name="submit" type="submit" placeholder="Submit" class="btn btn-success">

                <a href="index.php" class="btn btn-danger">Cancel</a>
              </center>
            </div>
          </div>




        </fieldset>
      </form>

    </div>
  </div>
</div>

<?php include('footer.php'); ?>