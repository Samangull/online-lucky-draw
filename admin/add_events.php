<?php 
include("header.php");
include("db.php");
?>

<style>
table, th, td {
    text-align: center;
}
</style>

<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-9">

      <div class="panel panel-primary" style="margin-top:30px;">
        <div class="panel-heading">
          <h4 class="panel-title">Create Lucky Draw</h4>
        </div>

        <div class="panel-body">
          <form method="post" enctype="multipart/form-data">
            <div class="row">

              <!-- Lucky Draw Title -->
              <div class="form-group col-md-6">
                <label>Lucky Draw Title</label>
                <input type="text" class="form-control" name="title" required>
              </div>

              <!-- Venue -->
              <div class="form-group col-md-6">
                <label>Venue</label>
                <input type="text" class="form-control" name="venue">
              </div>

              <!-- Location -->
              <div class="form-group col-md-6">
                <label>Location</label>
                <input type="text" class="form-control" name="location">
              </div>

              <!-- Event Date -->
              <div class="form-group col-md-6">
                <label>Event Date & Time</label>
                <input type="datetime-local" class="form-control" name="date_time" required>
              </div>

              <!-- Draw Date -->
              <div class="form-group col-md-6">
                <label>Draw Date</label>
                <input type="date" class="form-control" name="draw_date" required>
              </div>

              <!-- Winners Count -->
              <div class="form-group col-md-6">
                <label>Number of Winners</label>
                <input type="number" class="form-control" name="winners_count" required>
              </div>

              <!-- Prize Name -->
              <div class="form-group col-md-6">
                <label>Prize Name</label>
                <input type="text" class="form-control" name="prize_name" required>
              </div>

              <!-- Prize Value -->
              <div class="form-group col-md-6">
                <label>Prize Value</label>
                <input type="text" class="form-control" name="prize_value">
              </div>

              <!-- Prize Description -->
              <div class="form-group col-md-12">
                <label>Prize Description</label>
                <textarea class="form-control" name="prize_description" rows="3"></textarea>
              </div>

              <!-- Eligibility -->
              <div class="form-group col-md-12">
                <label>Eligibility Criteria</label>
                <textarea class="form-control" name="eligibility" rows="3" required></textarea>
              </div>

              <!-- Description -->
              <div class="form-group col-md-12">
                <label>Lucky Draw Description</label>
                <textarea class="form-control" name="description" rows="4"></textarea>
              </div>

              <!-- Image -->
              <div class="form-group col-md-6">
                <label>Lucky Draw Image</label>
                <input type="file" class="form-control" name="image">
              </div>

              <div class="form-group col-md-12 text-right">
                <button type="submit" name="btn" class="btn btn-success">
                  Create Lucky Draw
                </button>
              </div>

            </div>
          </form>

          <?php
          if (isset($_POST['btn'])) {

              $title = mysqli_real_escape_string($con, $_POST['title']);
              $venue = mysqli_real_escape_string($con, $_POST['venue']);
              $location = mysqli_real_escape_string($con, $_POST['location']);
              $date_time = $_POST['date_time'];
              $draw_date = $_POST['draw_date'];
              $winners_count = $_POST['winners_count'];

              $prize_name = mysqli_real_escape_string($con, $_POST['prize_name']);
              $prize_description = mysqli_real_escape_string($con, $_POST['prize_description']);
              $prize_value = mysqli_real_escape_string($con, $_POST['prize_value']);
              $eligibility = mysqli_real_escape_string($con, $_POST['eligibility']);
              $description = mysqli_real_escape_string($con, $_POST['description']);

              $status = 'active';

              // Image Upload
              $image = $_FILES['image']['name'];
              $tmp = $_FILES['image']['tmp_name'];
              if ($image != '') {
                  move_uploaded_file($tmp, "uploads/".$image);
              }

              $query = "INSERT INTO events 
              (title, venu, date_and_time, location, description, image,
               draw_date, prize_name, prize_description, prize_value,
               winners_count, eligibility, status)

              VALUES
              ('$title','$venue','$date_time','$location','$description','$image',
               '$draw_date','$prize_name','$prize_description','$prize_value',
               '$winners_count','$eligibility','$status')";

              if (mysqli_query($con, $query)) {
                  echo "<div class='alert alert-success'>🎉 Lucky Draw Created Successfully!</div>";
              } else {
                  echo "<div class='alert alert-danger'>Error: ".mysqli_error($con)."</div>";
              }
          }
          ?>

        </div>
      </div>

    </div>
  </div>
</div>
