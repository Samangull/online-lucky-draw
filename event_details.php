<?php

include('header.php');
include('sidebar.php');
include('connection.php');

/* ---------------- VALIDATE ID ---------------- */
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo '<div class="container mt-5 alert alert-danger">Invalid Lucky Draw ID</div>';
    include('footer.php');
    exit;
}

/* ---------------- FETCH EVENT ---------------- */
$stmt = mysqli_prepare($con, "
    SELECT title, venu, location, description, image,
           date_and_time, draw_date,
           prize_name, prize_description, prize_value,
           winners_count, eligibility, status
    FROM events
    WHERE id=?
");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($res) == 0) {
    echo '<div class="container mt-5 alert alert-warning">Lucky Draw not found</div>';
    include('footer.php');
    exit;
}
$event = mysqli_fetch_assoc($res);

/* ---------------- PARTICIPANT ENROLMENT ---------------- */
$entry_msg = '';

if (isset($_POST['enter_draw']) && isset($_SESSION['id'])) {

    $user_id = $_SESSION['id'];

    if ($event['status'] != 'active') {

        $entry_msg = "<div class='alert alert-danger'>
                        This lucky draw is closed.
                      </div>";

    } else {

        $chk = mysqli_query($con,
            "SELECT id FROM lucky_draw_entries
             WHERE user_id=$user_id AND event_id=$id"
        );

        if (mysqli_num_rows($chk) > 0) {

            $entry_msg = "<div class='alert alert-warning'>
                            You have already entered this lucky draw.
                          </div>";

        } else {

            mysqli_query($con,
                "INSERT INTO lucky_draw_entries (event_id, user_id)
                 VALUES ($id, $user_id)"
            );

            $entry_msg = "<div class='alert alert-success'>
                            🎉 Successfully entered in lucky draw!
                          </div>";
        }
    }
}
?>

<!-- ===================== DESIGN ===================== -->
<style>
.lucky-img {
    width: 100%;
    height: 350px;
    object-fit: cover;
}
.info-box p { margin-bottom:6px; }
</style>

<div class="container py-5">
  <div class="card shadow-lg">
    <div class="row g-0">

      <!-- IMAGE COLUMN -->
      <div class="col-md-4">
        <?php if($event['image']){ ?>
          <img src="admin/uploads/<?= htmlspecialchars($event['image']) ?>"
               class="lucky-img rounded-start">
        <?php } else { ?>
          <img src="assets/no-image.png" class="lucky-img rounded-start">
        <?php } ?>
      </div>

      <!-- CONTENT COLUMN -->
      <div class="col-md-8">
        <div class="card-body">

          <h2 class="text-primary mb-3">
            <?= htmlspecialchars($event['title']) ?>
          </h2>

          <div class="info-box">
            <p><strong>Venue:</strong> <?= htmlspecialchars($event['venu']) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
            <p><strong>Event Date:</strong>
              <?= date("d M Y h:i A", strtotime($event['date_and_time'])) ?>
            </p>
          </div>

          <hr>

          <h5 class="text-success">🎁 Lucky Draw Info</h5>
          <p><strong>Draw Date:</strong>
            <?= date("d M Y", strtotime($event['draw_date'])) ?>
          </p>
          <p><strong>Prize:</strong>
            <?= htmlspecialchars($event['prize_name']) ?>
            (<?= htmlspecialchars($event['prize_value']) ?>)
          </p>
          <p><strong>No. of Winners:</strong> <?= $event['winners_count'] ?></p>
          <p><strong>Status:</strong>
            <span class="badge bg-info"><?= ucfirst($event['status']) ?></span>
          </p>

          <h6 class="mt-3">Prize Description</h6>
          <p><?= nl2br(htmlspecialchars($event['prize_description'])) ?></p>

          <h6>Eligibility</h6>
          <p><?= nl2br(htmlspecialchars($event['eligibility'])) ?></p>

          <h6>Description</h6>
          <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>

          <!-- PARTICIPANT ENROLMENT -->
          <hr>
          <h5 class="text-primary">🎟 Participant Enrolment</h5>

          <?= $entry_msg ?>

          <?php
          if (isset($_SESSION['id'])) {
              $uid = $_SESSION['id'];
              $chk = mysqli_query($con,
                  "SELECT id FROM lucky_draw_entries
                   WHERE user_id=$uid AND event_id=$id"
              );

              if (mysqli_num_rows($chk) > 0) {
                  echo "<p class='text-success fw-bold'>
                          ✔ You are already entered in this draw
                        </p>";
              } else {
          ?>
                <form method="post">
                  <button type="submit"
                          name="enter_draw"
                          class="btn btn-lg btn-primary mt-2">
                    Enter Lucky Draw
                  </button>
                </form>
          <?php
              }
          } else {
              echo "<p class='text-muted'>
                      Please <a href='login.php'>login</a> to enter lucky draw
                    </p>";
          }
          ?>

          <a href="index.php" class="btn btn-secondary mt-4">
            ← Back
          </a>

        </div>
      </div>

    </div>
  </div>
</div>

<?php include('footer.php'); ?>
