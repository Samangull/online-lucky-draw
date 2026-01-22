<?php
session_start();
include('header.php');
include('sidebar.php');
include('connection.php');

/* ---------------- GET EVENT ID ---------------- */
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($event_id <= 0) {
    echo "<div class='container mt-5 alert alert-danger'>Invalid Event ID.</div>";
    include('footer.php');
    exit;
}

/* ---------------- FETCH EVENT ---------------- */
$event_q = mysqli_query($con, "SELECT * FROM events WHERE id=$event_id");
if (mysqli_num_rows($event_q) == 0) {
    echo "<div class='container mt-5 alert alert-warning'>Event not found.</div>";
    include('footer.php');
    exit;
}

$event = mysqli_fetch_assoc($event_q);
$winners_count = intval($event['winners_count']);

/* ---------------- FETCH PARTICIPANTS ---------------- */
$participants_q = mysqli_query($con, 
    "SELECT user_id FROM lucky_draw_entries WHERE event_id=$event_id"
);
$participants = [];
while ($row = mysqli_fetch_assoc($participants_q)) {
    $participants[] = $row['user_id'];
}

/* ---------------- CHECK PARTICIPANTS ---------------- */
if (count($participants) == 0) {
    echo "<div class='container mt-5 alert alert-warning'>No participants in this lucky draw yet.</div>";
    include('footer.php');
    exit;
}

/* ---------------- RANDOM WINNER SELECTION ---------------- */
$winners_count = min($winners_count, count($participants)); // prevent exceeding participants
$selected_winners = [];

if ($winners_count > 0) {
    $selected_winners = (array)array_rand(array_flip($participants), $winners_count);
}

/* ---------------- SAVE WINNERS IN DATABASE ---------------- */
foreach ($selected_winners as $uid) {
    // Check if already saved
    $chk = mysqli_query($con, "SELECT id FROM lucky_draw_winners WHERE event_id=$event_id AND user_id=$uid");
    if (mysqli_num_rows($chk) == 0) {
        mysqli_query($con,
            "INSERT INTO lucky_draw_winners (event_id, user_id) VALUES ($event_id, $uid)"
        );
    }
}
?>

<div class="container py-5">
    <h3 class="text-primary mb-4">🎯 Random Winner Selection</h3>

    <p><strong>Event:</strong> <?= htmlspecialchars($event['title']); ?></p>
    <p><strong>Draw Date:</strong> <?= date("d M Y", strtotime($event['draw_date'])); ?></p>

    <hr>

    <h4 class="text-success mb-3">🏆 Winners</h4>

    <?php if (!empty($selected_winners)) { ?>
        <ul class="list-group">
        <?php
        foreach ($selected_winners as $uid) {
            // Fetch user info
            $user_q = mysqli_query($con, "SELECT full_name, email FROM users WHERE id=$uid");
            $user = mysqli_fetch_assoc($user_q);
            echo "<li class='list-group-item'>
                    <strong>" . htmlspecialchars($user['full_name']) . "</strong>
                    (" . htmlspecialchars($user['email']) . ")
                  </li>";
        }
        ?>
        </ul>
    <?php } else { ?>
        <p class="alert alert-warning">No winners selected.</p>
    <?php } ?>

    <a href="events.php" class="btn btn-secondary mt-4">← Back to Events</a>
</div>

<?php include('footer.php'); ?>
