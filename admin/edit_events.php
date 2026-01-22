<?php
include("header.php");
include("db.php");
?>

<style>
table, th, td {
  text-align: center;
}
input, textarea, select {
  width: 100%;
}
</style>

<div class="container">
  <div class="row">
    <div class="col-md-3"></div>

    <div class="col-md-9">

<?php
if (isset($_GET['edit'])) {

    $edit_id = intval($_GET['edit']);

    $qry = mysqli_query($con, "SELECT * FROM events WHERE id='$edit_id'");
    $row = mysqli_fetch_assoc($qry);

    if (!$row) {
        echo "<div class='alert alert-danger'>Record not found</div>";
        exit;
    }
}
?>

<h3>Edit Lucky Draw</h3>
<hr>

<form method="post" enctype="multipart/form-data">

<table class="table table-bordered">

<tr>
  <th>Title</th>
  <td><input type="text" name="title" value="<?= htmlspecialchars($row['title']); ?>" required></td>
</tr>

<tr>
  <th>Venue</th>
  <td><input type="text" name="venu" value="<?= htmlspecialchars($row['venu']); ?>"></td>
</tr>

<tr>
  <th>Location</th>
  <td><input type="text" name="location" value="<?= htmlspecialchars($row['location']); ?>"></td>
</tr>

<tr>
  <th>Event Date & Time</th>
  <td><input type="datetime-local" name="date_and_time"
      value="<?= date('Y-m-d\TH:i', strtotime($row['date_and_time'])); ?>" required></td>
</tr>

<tr>
  <th>Draw Date</th>
  <td><input type="date" name="draw_date"
      value="<?= $row['draw_date']; ?>" required></td>
</tr>

<tr>
  <th>Prize Name</th>
  <td><input type="text" name="prize_name"
      value="<?= htmlspecialchars($row['prize_name']); ?>" required></td>
</tr>

<tr>
  <th>Prize Value</th>
  <td><input type="text" name="prize_value"
      value="<?= htmlspecialchars($row['prize_value']); ?>"></td>
</tr>

<tr>
  <th>Prize Description</th>
  <td><textarea name="prize_description"><?= htmlspecialchars($row['prize_description']); ?></textarea></td>
</tr>

<tr>
  <th>Winners Count</th>
  <td><input type="number" name="winners_count"
      value="<?= $row['winners_count']; ?>" required></td>
</tr>

<tr>
  <th>Eligibility</th>
  <td><textarea name="eligibility"><?= htmlspecialchars($row['eligibility']); ?></textarea></td>
</tr>

<tr>
  <th>Description</th>
  <td><textarea name="description"><?= htmlspecialchars($row['description']); ?></textarea></td>
</tr>

<tr>
  <th>Status</th>
  <td>
    <select name="status">
      <option value="active" <?= ($row['status']=='active')?'selected':''; ?>>Active</option>
      <option value="inactive" <?= ($row['status']=='inactive')?'selected':''; ?>>Inactive</option>
      <option value="completed" <?= ($row['status']=='completed')?'selected':''; ?>>Completed</option>
    </select>
  </td>
</tr>

<tr>
  <th>Image</th>
  <td>
    <?php if($row['image']){ ?>
      <img src="uploads/<?= $row['image']; ?>" width="80"><br><br>
    <?php } ?>
    <input type="file" name="image">
  </td>
</tr>

<tr>
  <td colspan="2" align="right">
    <button type="submit" name="update" class="btn btn-success">
      Update Lucky Draw
    </button>
  </td>
</tr>

</table>
</form>

<?php
if (isset($_POST['update'])) {

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $venu = mysqli_real_escape_string($con, $_POST['venu']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $date_and_time = $_POST['date_and_time'];
    $draw_date = $_POST['draw_date'];
    $prize_name = mysqli_real_escape_string($con, $_POST['prize_name']);
    $prize_value = mysqli_real_escape_string($con, $_POST['prize_value']);
    $prize_description = mysqli_real_escape_string($con, $_POST['prize_description']);
    $winners_count = $_POST['winners_count'];
    $eligibility = mysqli_real_escape_string($con, $_POST['eligibility']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $status = $_POST['status'];

    // Image upload (optional)
    $image = $row['image'];
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
    }

    $update = mysqli_query($con, "
        UPDATE events SET
        title='$title',
        venu='$venu',
        location='$location',
        date_and_time='$date_and_time',
        draw_date='$draw_date',
        prize_name='$prize_name',
        prize_value='$prize_value',
        prize_description='$prize_description',
        winners_count='$winners_count',
        eligibility='$eligibility',
        description='$description',
        image='$image',
        status='$status'
        WHERE id='$edit_id'
    ");

    if ($update) {
        echo "<script>alert('Lucky Draw updated successfully');</script>";
        echo "<script>window.location='manage_events.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Update failed</div>";
    }
}
?>

    </div>
  </div>
</div>
