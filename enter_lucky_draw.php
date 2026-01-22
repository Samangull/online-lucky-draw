<?php
include('header.php');
include('sidebar.php');
include('connection.php');


$user_id = $_SESSION['id'];
$event_id = intval($_GET['id']);

/* -------- Fetch Lucky Draw -------- */
$q = mysqli_query($con, "SELECT * FROM events WHERE id='$event_id' AND status='active'");
$event = mysqli_fetch_assoc($q);

if (!$event) {
    echo "<div class='container py-5 alert alert-danger'>
            Lucky Draw not available.
          </div>";
    exit;
}

/* -------- Eligibility Check -------- */
/*
 Example eligibility rules:
 - Logged in users
 - Event eligibility text based
*/
$eligible = true;
$eligibility_reason = '';

if (strpos(strtolower($event['eligibility']), 'registered') !== false && !isset($_SESSION['id'])) {
    $eligible = false;
    $eligibility_reason = 'Only registered users allowed';
}

/* -------- Already Entered Check -------- */
$check = mysqli_query($con,
    "SELECT id FROM lucky_draw_entries
     WHERE user_id='$user_id' AND event_id='$event_id'"
);

if (mysqli_num_rows($check) > 0) {
    $eligible = false;
    $eligibility_reason = 'You have already entered this lucky draw';
}

/* -------- Handle Entry -------- */
if (isset($_POST['enter']) && $eligible) {

    $insert = mysqli_query($con,
        "INSERT INTO lucky_draw_entries (user_id, event_id)
         VALUES ('$user_id', '$event_id')"
    );

    if ($insert) {
        echo "<div class='container alert alert-success mt-4'>
                🎉 You have successfully entered the Lucky Draw!
              </div>";
        $eligible = false;
    } else {
        echo "<div class='container alert alert-danger'>
                Entry failed. Try again.
              </div>";
    }
}
?>

<div class="container py-5">
  <div class="card shadow">
    <div class="card-body">

      <h3><?= htmlspecialchars($event['title']); ?></h3>

      <p><strong>Prize:</strong>
        <?= $event['prize_name']; ?> (<?= $event['prize_value']; ?>)
      </p>

      <p><strong>Draw Date:</strong>
        <?= date('d M Y', strtotime($event['draw_date'])); ?>
      </p>

      <p><strong>Eligibility:</strong>
        <?= htmlspecialchars($event['eligibility']); ?>
      </p>

      <?php if ($eligible) { ?>
        <form method="post">
          <button name="enter" class="btn btn-success">
            🎯 Enter Lucky Draw
          </button>
        </form>
      <?php } else { ?>
        <div class="alert alert-info mt-3">
          <?= $eligibility_reason; ?>
        </div>
      <?php } ?>

      <a href="index.php" class="btn btn-secondary mt-3">← Back</a>

    </div>
  </div>
</div>

<?php include('footer.php'); ?>
