<?php 
include('header.php'); 
include('sidebar.php'); 
include('connection.php');

// Handle search query
$search = isset($_GET['query']) ? mysqli_real_escape_string($con, $_GET['query']) : '';

$query = "SELECT * FROM events";
if (!empty($search)) {
  $query .= " WHERE title LIKE '%$search%' OR location LIKE '%$search%' OR venu LIKE '%$search%'";
}

$sql = mysqli_query($con, $query);
?>


<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
  <h2 class="text-center text-primary" style="margin-bottom: 30px;">All Lucky Draws</h2>



  <div class="row">
    <?php 
    if (mysqli_num_rows($sql) > 0) {
      while ($rows = mysqli_fetch_array($sql)) {
        $id          = $rows['id'];
        $name        = $rows['title'];
        $location    = $rows['location'];
        $vanue       = $rows['venu'];
        $description = $rows['description'];
        $image       = $rows['image'];
    ?>
        <div class="col-sm-6 col-md-4" style="margin-bottom: 20px;">
          <div class="thumbnail" style="height: 100%; border: 1px solid #ddd;">
            <img src="<?= 'admin/uploads/' . $image ?>" alt="Event Image" style="height: 200px; width: 100%; object-fit: cover;">
            <div class="caption">
              <h4 class="text-primary"><?= htmlspecialchars($name) ?></h4>
              <p><strong>Description:</strong> <?= htmlspecialchars($description) ?></p>
              <p><i class="fa fa-map-marker text-danger"></i> <strong>Location:</strong> <?= htmlspecialchars($location) ?></p>
              <p><i class="fa fa-building text-info"></i> <strong>Venue:</strong> <?= htmlspecialchars($vanue) ?></p>
              <p><a href="event_details.php?id=<?= $id ?>" class="btn btn-default btn-sm">View Details</a></p>
            </div>
          </div>
        </div>
    <?php 
      } 
    } else {
      echo '<div class="col-xs-12 text-center text-muted">No events found.</div>';
    }
    ?>
  </div>
</div>

<?php include('footer.php'); ?>

<!-- Custom CSS -->
<style>
  .caption h4 {
    font-weight: 600;
  }
  .caption p {
    font-size: 13px;
  }
  .form-inline .form-group {
    margin-right: 10px;
  }
</style>
