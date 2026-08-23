/* A website lets users choose between light and dark themes. The preference is stored in a cookie that expires in 30 minutes. */

<?php
require_once 'value.php';

$durationMinutes = $A + $B;
$themeCookieName = "theme_pref";
$expiryCookieName = "theme_expiry" . $A;

$message = "";
$currentTheme = "light";
$expiryTimestamp = 0;

if (isset($_POST['theme'])) {
  $selectedTheme = trim($_POST['theme']);

  $allowedThemes = ['light', 'dark', 'blue'];

  if (in_array($selectedTheme, $allowedThemes, true)) {
    $expiryTimestamp = time() + (60 * $durationMinutes);

    setcookie($themeCookieName, $selectedTheme, $expiryTimestamp, "/");
    setcookie($expiryCookieName, $expiryTimestamp, $expiryTimestamp, "/");

    $currentTheme = $selectedTheme;
    $message = "Theme set to " . htmlspecialchars($selectedTheme) . " for " . $durationMinutes . " minutes.";
  }
}

if (isset($_COOKIE[$themeCookieName])) {
  $cookieTheme = $_COOKIE[$themeCookieName];

  if (in_array($cookieTheme, ['light', 'dark', 'blue'], true)) {
    $currentTheme = $cookieTheme;
  }
}

if ($expiryTimestamp === 0 && isset($_COOKIE[$expiryCookieName])) {
  $expiryTimestamp = (int)$_COOKIE[$expiryCookieName];
}

$remainingSeconds = max(0, $expiryTimestamp - time());

$backgroundColor = "#fff";
$textColor = "#000";

if ($currentTheme === "dark") {
  $backgroundColor = "#333";
  $textColor = "#fff";
} elseif ($currentTheme === "blue") {
  $backgroundColor = "#e3f2fd";
  $textColor = "#1565c0";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Selector</title>

    <style>
        body {
            background-color: <?= $backgroundColor ?>;
            color: <?= $textColor ?>;
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        select,
        button {
            padding: 8px;
            font-size: 16px;
        }

        pre {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Theme Selector</h1>

    <?php if ($message !== ""): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="theme">Choose a theme:</label>

        <select name="theme" id="theme">
            <option value="light" <?= $currentTheme === "light" ? "selected" : "" ?>>
                light
            </option>
            <option value="dark" <?= $currentTheme === "dark" ? "selected" : "" ?>>
                dark
            </option>
            <option value="blue" <?= $currentTheme === "blue" ? "selected" : "" ?>>
                blue
            </option>
        </select>

        <button type="submit">Set Theme <?= $D ?></button>
    </form>

    <pre>==============================
     Theme: <?= htmlspecialchars($currentTheme) . "\n"?>
==============================
Current time: <?= date("H:i:s") ?>
Cookie expires in: <?= $remainingSeconds ?> seconds
==============================</pre>
</body>
</html>