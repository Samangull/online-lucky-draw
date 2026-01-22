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

// Fetch past draws
$query = "SELECT * FROM events WHERE draw_date <= NOW() ORDER BY draw_date DESC";
$result = mysqli_query($con, $query);

$draws = [];
$totalWinners = 0;
$totalPrizeValue = 0;

while($row = mysqli_fetch_assoc($result)){
    $draws[] = $row;
    $totalWinners += (int)$row['winners_count'];
    $totalPrizeValue += (float)$row['prize_value'];
}

$totalDraws = count($draws);

?>

<style>
.container-report {
    margin-top: 50px;
}
.overview-cards {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}
.card {
    background-color: #f8f9fa;
    padding: 20px;
    width: 23%;
    border-radius: 8px;
    box-shadow: 0px 0px 5px #ccc;
    text-align: center;
}
.card h3 {
    margin: 10px 0;
}
table.report-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
table.report-table th, table.report-table td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}
table.report-table th {
    background-color: #4CAF50;
    color: white;
}
table.report-table tr:nth-child(even) {
    background-color: #f2f2f2;
}
h2 {
    text-align: center;
}
</style>

<div class="container-report">
    <h2>Past Draws Report</h2>

    <!-- Overview Cards -->
    <div class="overview-cards">
        <div class="card">
            <h4>Total Draws</h4>
            <h3><?php echo $totalDraws; ?></h3>
        </div>
        <div class="card">
            <h4>Total Winners</h4>
            <h3><?php echo $totalWinners; ?></h3>
        </div>
        <div class="card">
            <h4>Total Prize Value</h4>
            <h3><?php echo number_format($totalPrizeValue, 2); ?></h3>
        </div>
        <div class="card">
            <h4>Average Winners per Draw</h4>
            <h3><?php echo $totalDraws > 0 ? round($totalWinners/$totalDraws, 2) : 0; ?></h3>
        </div>
    </div>



    <!-- Detailed Table -->
    <table class="report-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Venue</th>
                <th>Date & Time</th>
                <th>Location</th>
                <th>Draw Date</th>
                <th>Prize Name</th>
                <th>Prize Value</th>
                <th>Winners Count</th>
                <th>Eligibility</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($draws) > 0): ?>
                <?php foreach($draws as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['venu']; ?></td>
                    <td><?php echo $row['date_and_time']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['draw_date']; ?></td>
                    <td><?php echo $row['prize_name']; ?></td>
                    <td><?php echo $row['prize_value']; ?></td>
                    <td><?php echo $row['winners_count']; ?></td>
                    <td><?php echo $row['eligibility']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="11">No past draws found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



</div>


