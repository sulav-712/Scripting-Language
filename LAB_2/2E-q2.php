/* An admin tool allows uploading text files and viewing their contents. The system also maintains a log of all uploads. */

<?php
require_once 'value.php';
$uploadDir = 'uploads/';
$logFile = 'upload-log-' . $A . '.txt';

if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$message = $uploadedFileName = $uploadedFileContent = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['text_file'])) {
    $file = $_FILES['text_file'];
    $name = $file['name'];
    $tmpName = $file['tmp_name'];
    $error = $file['error'];
    $size = $file['size'];

    if ($error !== UPLOAD_ERR_OK)
        $message = 'Error uploading file: ' . $error;
    elseif (strtolower(pathinfo($name, PATHINFO_EXTENSION)) !== 'txt')
        $message = 'Only .txt files are allowed.';
    elseif (move_uploaded_file($tmpName, $uploadDir . $name)) {
        $uploadedFileName = $name;
        $timestamp = date('Y-m-d H:i:s', strtotime("+$B years"));
        $logEntry = "[$timestamp] - Uploaded file: $name ($size bytes)\n";

        file_put_contents($logFile, $logEntry, FILE_APPEND);
        $uploadedFileContent = file_get_contents($uploadDir . $name);
        $message = 'File uploaded successfully.';
    } else
        $message = 'Failed to move uploaded file.';
}

$files = [];

if (is_dir($uploadDir)) {
    foreach (scandir($uploadDir) as $item) {
        if ($item === '.' || $item === '..') continue;

        $filepath = $uploadDir . $item;
        if (is_file($filepath))
            $files[] = ['name' => $item, 'size' => filesize($filepath)];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload Dashboard</title>
    <style>
        body { font-family: Arial,sans-serif; margin:20px; }
        pre { background:#f5f5f5; padding:10px; overflow:auto; }
        .error { color:#b00020; }
        .success { color:#006400; }
    </style>
</head>
<body>
    <h1>File Upload Dashboard</h1>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="102400">
        <label for="text_file">Select a .txt file:</label>
        <input type="file" name="text_file" id="text_file" accept=".txt">
        <button type="submit">Upload File <?php echo $D; ?></button>
    </form>

    <?php if ($message): ?>
        <p class="<?php echo strpos($message, 'failed') !== false || strpos($message, 'Only') !== false ? 'error' : 'success'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <?php if ($uploadedFileName && $uploadedFileContent): ?>
        <h2>Contents of: <?php echo htmlspecialchars($uploadedFileName); ?></h2>
        <pre><?php echo htmlspecialchars($uploadedFileContent); ?></pre>
    <?php endif; ?>

    <h2>Uploaded Files</h2>
    <?php if (!$files): ?>
        <p>No files uploaded yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($files as $f): ?>
                <li>
                    📄 <?php echo htmlspecialchars($f['name']); ?>
                    (<?php echo $f['size']; ?> bytes)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>