/* A website wants to log every visitor's name and timestamp to a text file, then display all past visitors. */

<?php
require_once 'value.php';

$guestbookFile = "guestbook-" . $A . ".txt";
$messageStatus = "";

if (isset($_POST['action']) && $_POST['action'] === "sign") {
  $rawName = trim($_POST['name']) ?? '';
  $rawMessage = trim($_POST['message']) ?? '';

  if ($rawMessage === '') {
    $messageStatus = "Error: Name is required.";
  } else {
    $name = htmlspecialchars($rawName, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($rawMessage, ENT_QUOTES, 'UTF-8');
    
    $timestamp = (date("Y") + $B) . date("-m-d H:i:s");

    $entry = "[" . $timestamp . "] " . $name . " wrote: " . $message . PHP_EOL;

    file_put_contents($guestbookFile, $entry, FILE_APPEND | LOCK_EX);

    $messageStatus = "Thank you. " . $name . "! Your message has been recorded.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visitor Guestbook</title>
</head>
<body>
<h1>Visitor Guestbook</h1>

<?php if ($messageStatus !== ""): ?>
  <p><?php echo $messageStatus; ?></p>
<?php endif; ?>

<form method="post" action="">
  <label for="name">Name: </label>
  <input type="text" id="name" name="name">
  
  <br><br>

  <label for="message">Message: </label>
  <textarea id="message" name="message" rows="5" cols="30"></textarea><br><br>

  <input type="hidden" name="action" value="sign">
  <button type="submit">Sign Guestbook <?php echo $A; ?></button>

</form>
<hr>

<h2>Guestbook Entries</h2>

<?php
if (file_exists($guestbookFile)) {
    $contents = file_get_contents($guestbookFile);
  $entries = trim($contents) === ''
    ? []
    : preg_split('/\r\n|\r|\n/', trim($contents));
    echo '<pre>';
    echo htmlspecialchars($contents, ENT_QUOTES, 'UTF-8');
    echo '</pre>';

    echo "<p>Total entries: " . count($entries) . "</p>";
} else {
  echo "<p>No entries yet. Be the first to sign the guestbook!</p>";
  echo "<p>Total entries: 0</p>";
}
?>
</body>
</html>