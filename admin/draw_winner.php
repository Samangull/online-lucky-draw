<?php
include('db.php');

// Optional: Enable error reporting for debugging
// error_reporting(E_ALL); ini_set('display_errors', 1);

$event_id = intval($_GET['id']);

// Fetch event details
$event = mysqli_fetch_assoc(mysqli_query($con,
    "SELECT title, prize_name, prize_value, winners_count, status FROM events WHERE id='$event_id'"
));

if (!$event) {
    die("Event not found.");
}

// Prevent re-selection if winners already picked
if ($event['status'] == 'completed') {
    echo "<script>alert('Winners have already been selected for this draw.');window.location='manage_events.php';</script>";
    exit;
}

$winners_count = intval($event['winners_count']);

// Fetch eligible users who have NOT won yet for this event
$eligible_q = mysqli_query($con,
    "SELECT u.id AS user_id, u.name, u.email 
     FROM lucky_draw_entries e
     JOIN users u ON e.user_id = u.id
     WHERE e.event_id='$event_id'
       AND e.user_id NOT IN (
           SELECT user_id FROM lucky_draw_winners WHERE event_id='$event_id'
       )
     ORDER BY RAND()
     LIMIT $winners_count"
);

$eligible_rows = mysqli_num_rows($eligible_q);

if ($eligible_rows == 0) {
    echo "<script>alert('No eligible entries found to select winners.');window.location='manage_events.php';</script>";
    exit;
}

// Loop through and insert winners + send email
while ($winner = mysqli_fetch_assoc($eligible_q)) {
    $user_id = intval($winner['user_id']);
    $user_name = $winner['name'];
    $user_email = $winner['email'];

    // Insert winner into table
    mysqli_query($con,
        "INSERT INTO lucky_draw_winners (event_id, user_id) VALUES ('$event_id', '$user_id')"
    );

    // Send email to winner
    $subject = "🎉 Congratulations! You Won the Lucky Draw";
    $message = "
    <html>
    <head>
      <title>Lucky Draw Winner</title>
    </head>
    <body>
      <p>Hi <strong>$user_name</strong>,</p>
      <p>Congratulations! You have won the lucky draw <strong>'".$event['title']."'</strong>.</p>
      <p>Prize: <strong>".$event['prize_name']."</strong> (₹".number_format($event['prize_value'],0).")</p>
      <p>Thank you for participating!</p>
    </body>
    </html>
    ";

    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@yourdomain.com" . "\r\n";

    @mail($user_email, $subject, $message, $headers);
}

// Mark event as completed
mysqli_query($con, "UPDATE events SET status='completed' WHERE id='$event_id'");

echo "<script>alert('Winners Selected and Notified Successfully!');window.location='manage_events.php';</script>";
?>
