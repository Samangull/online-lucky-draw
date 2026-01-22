<?php
include('header.php');
include('sidebar.php');
include('connection.php');

// Get the event ID from the URL
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch event details
$event_q = mysqli_query($con, "SELECT * FROM events WHERE id = $event_id LIMIT 1");
if (mysqli_num_rows($event_q) == 0) {
    echo "<div class='container py-5'><p class='alert alert-warning'>Event not found.</p></div>";
    include('footer.php');
    exit;
}

$event = mysqli_fetch_assoc($event_q);

// Fetch winners
$winners_q = mysqli_query($con,
    "SELECT u.full_name, u.email
     FROM lucky_draw_winners w
     JOIN users u ON w.user_id = u.id
     WHERE w.event_id = $event_id"
);
$winners = [];
while ($row = mysqli_fetch_assoc($winners_q)) {
    $winners[] = $row;
}
?>

<div class="container py-5">
    <div class="card mb-4 shadow-sm">
        <div class="row g-0">
            <!-- Event Image -->
            <div class="col-md-4">
                <img src="<?= $event['image'] ? 'admin/uploads/' . htmlspecialchars($event['image']) : 'assets/no-image.png' ?>" 
                     class="img-fluid rounded-start h-100 w-100" 
                     style="object-fit: cover; min-height: 250px;">
            </div>

            <!-- Event Details -->
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="text-primary"><?= htmlspecialchars($event['title']); ?></h2>
                    <p><strong>Venue:</strong> <?= htmlspecialchars($event['venu']); ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                    <p><strong>Draw Date:</strong> <?= date("d M Y", strtotime($event['draw_date'])); ?></p>
                    <p><strong>Prize:</strong> <?= htmlspecialchars($event['prize_name']); ?> (<?= htmlspecialchars($event['prize_value']); ?>)</p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge bg-info"><?= ucfirst($event['status']); ?></span>
                    </p>

                    <hr>
                    <h4 class="text-success">🏆 Winners</h4>
                    <?php if (!empty($winners)) { ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($winners as $winner) { ?>
                                <li class="list-group-item">
                                    <strong><?= htmlspecialchars($winner['full_name']); ?></strong>
                                    <span class="text-muted">(<?= htmlspecialchars($winner['email']); ?>)</span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="text-muted">Winners have not been selected yet.</p>
                    <?php } ?>

                    <a href="participate.php?event_id=<?= $event_id ?>" class="btn btn-primary mt-3">Participate</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
