<?php
include('header.php');
include('sidebar.php');
include('connection.php');
?>

<div class="container py-5">
    <h2 class="text-primary mb-4">🎯 Lucky Draw Results</h2>
    <hr>

    <?php
    $events_q = mysqli_query($con, "SELECT * FROM events ORDER BY draw_date DESC");
    if (mysqli_num_rows($events_q) == 0) {
        echo '<div class="text-center py-5">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    No Lucky Draws available at the moment.
                </div>
              </div>';
    } else {
    ?>
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Event Title</th>
                    <th>Draw Date</th>
                    <th>Venue</th>
                    <th>Prize Name</th>
                    <th>Prize Value</th>
                    <th>Winner Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>City</th>
                    <th>Win Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                while ($event = mysqli_fetch_assoc($events_q)) {
                    $winners_q = mysqli_query(
                        $con,
                        "SELECT u.name, u.email, u.mobile, u.city, w.win_date
                         FROM lucky_draw_winners w
                         JOIN users u ON w.user_id = u.id
                         WHERE w.event_id = {$event['id']}
                         ORDER BY w.win_date ASC"
                    );

                    if (mysqli_num_rows($winners_q) > 0) {
                        while ($winner = mysqli_fetch_assoc($winners_q)) {
                            echo '<tr class="text-center">';
                            echo '<td>' . $counter++ . '</td>';
                            echo '<td>' . htmlspecialchars($event['title']) . '</td>';
                            echo '<td>' . date("d M Y", strtotime($event['draw_date'])) . '</td>';
                            echo '<td>' . htmlspecialchars($event['venu']) . '</td>';
                            echo '<td>' . htmlspecialchars($event['prize_name']) . '</td>';
                            echo '<td>₹' . number_format($event['prize_value'], 0) . '</td>';
                            echo '<td>' . htmlspecialchars($winner['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($winner['email']) . '</td>';
                            echo '<td>' . htmlspecialchars($winner['mobile']) . '</td>';
                            echo '<td>' . htmlspecialchars($winner['city']) . '</td>';
                            echo '<td>' . date("d M Y H:i", strtotime($winner['win_date'])) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        // No winners for this event
                        echo '<tr class="text-center">';
                        echo '<td>' . $counter++ . '</td>';
                        echo '<td>' . htmlspecialchars($event['title']) . '</td>';
                        echo '<td>' . date("d M Y", strtotime($event['draw_date'])) . '</td>';
                        echo '<td>' . htmlspecialchars($event['venu']) . '</td>';
                        echo '<td>' . htmlspecialchars($event['prize_name']) . '</td>';
                        echo '<td>₹' . number_format($event['prize_value'], 0) . '</td>';
                        echo '<td colspan="5" class="text-muted">No winners yet</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<!-- Optional Bootstrap styling -->
<style>
    .table th,
    .table td {
        vertical-align: middle;
    }
</style>

<?php include('footer.php'); ?>