<?php 
include("header.php");
include("db.php");
?>

<style>
table, th, td {
    text-align: center;
    vertical-align: middle;
}
.img-thumbnail {
    max-width: 80px;
}
</style>

<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>

<div class="container">
  <div class="row">
    <div class="col-md-3"></div>

    <div class="col-md-9">
      <h3>Manage Lucky Draws</h3>
      <hr>

      <table id="myTable" class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
          <tr>
            <th>ID</th>
            <th>Title</th>
      
            <th>Prize</th>
           
            <th>Status</th>
            <th>Image</th>
        
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
        <?php
        $query = mysqli_query($con, "SELECT * FROM events ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
          <tr>
            <td><?= $row['id']; ?></td>

            <td><?= htmlspecialchars($row['title']); ?></td>

          

            <td>
              <strong><?= htmlspecialchars($row['prize_name']); ?></strong><br>
              <small><?= htmlspecialchars($row['prize_value']); ?></small>
            </td>

            

            <td>
              <?php if($row['status'] == 'active'){ ?>
                <span class="label label-success">Active</span>
              <?php } elseif($row['status'] == 'completed'){ ?>
                <span class="label label-primary">Completed</span>
              <?php } else { ?>
                <span class="label label-default">Inactive</span>
              <?php } ?>
            </td>

            <td>
              <?php if (!empty($row['image'])) { ?>
                <img src="uploads/<?= $row['image']; ?>" class="img-thumbnail">
              <?php } else { ?>
                <span class="text-muted">No Image</span>
              <?php } ?>
            </td>

         

   <td>
              <a href="winners.php?id=<?= $row['id']; ?>" 
                 class="btn btn-info btn-xs"
                 >
                 <i class="fa fa-user"></i> Draw Winner
              </a>
            </td>


          </tr>
        <?php } ?>
        </tbody>

      </table>
    </div>
  </div>
</div>
