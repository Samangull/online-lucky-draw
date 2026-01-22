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
<?php

$event_id=intval($_GET['id']);

$q=mysqli_query($con,"
SELECT u.name,u.email,w.win_date
FROM lucky_draw_winners w
JOIN users u ON u.id=w.user_id
WHERE w.event_id='$event_id'
");
?>

<h3>Winners</h3>
<table class="table table-bordered">
<tr><th>#</th><th>Name</th><th>Email</th><th>Date</th></tr>
<?php $i=1; while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?= $i++; ?></td>
<td><?= $r['name']; ?></td>
<td><?= $r['email']; ?></td>
<td><?= $r['win_date']; ?></td>
</tr>
<?php } ?>
</table>


</div>
</div>
</div>
