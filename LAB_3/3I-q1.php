<?php

  require_once 'value.php';

  $studentId = $A . $B . $C;
  $captionText = "Student" . $D . "'s Gallery";
  $placeholderMin = $D + 2;
  $altText = "Photo-" . $A . "-" . $B;
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>3I-Q1 — Student<?= $studentId ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background: #f5f5f5;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    .gallery-container {
      text-align: center;
      margin: 30px 0;
    }
    #galleryImg {
      border: 3px solid #333;
      border-radius: 8px;
      max-width: 100%;
    }
    #caption {
      font-size: 1.2em;
      font-weight: bold;
      color: #555;
      margin: 15px 0;
    }
    .button-group {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
      margin: 20px 0;
    }
    button {
      padding: 10px 16px;
      font-size: 14px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      background: #4CAF50;
      color: white;
      transition: background 0.3s;
    }
    button:hover {
      background: #45a049;
    }
    #captionInput {
      padding: 10px;
      font-size: 14px;
      border: 2px solid #ddd;
      border-radius: 5px;
      width: 250px;
    }
    #captionList {
      list-style: none;
      padding: 0;
      margin: 20px 0;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    #captionList li {
      padding: 12px 16px;
      border-bottom: 1px solid #eee;
    }
    #captionList li:last-child {
      border-bottom: none;
    }
    .caption-controls {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
      margin: 20px 0;
    }
  </style>
</head>
<body>

  <h1>3I-Q1 Gallery — Sulav</h1>

  <div class="gallery-container">
    <img id="galleryImg" src="https://picsum.photos/300/200?random=1" alt="Photo-8-5">
    <p id="caption"><?= $captionText ?></p>
  </div>

  <div class="button-group">
    <button id="hideBtn">Hide Image</button>
    <button id="showBtn">Show Image</button>
    <button id="toggleBtn">Toggle Image</button>
    <button id="fadeBtn">Fade Toggle</button>
    <button id="slideBtn">Slide Toggle</button>
    <button id="changeImg">Change Image</button>
  </div>

  <div class="caption-controls">
    <input type="text" id="captionInput" placeholder="Caption (min <?= $placeholderMin ?> chars)">
    <button id="addCaptionBtn">Add Caption</button>
    <button id="removeCaptionBtn">Remove Last Caption</button>
    <button id="highlightBtn">Highlight Captions</button>
    <button id="resetBtn">Reset Captions</button>
  </div>

  <ul id="captionList">
    <li>Image 1</li>
    <li>Image 2</li>
    <li>Image 3</li>
  </ul>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#hideBtn').click(function() {
        $('#galleryImg').hide(600);
      });

      $('#showBtn').click(function() {
        $('#galleryImg').show(600);
      });

      $('#toggleBtn').click(function() {
        $('#galleryImg').toggle(400);
      });

      $('#fadeBtn').click(function() {
        $('#galleryImg').fadeToggle(800);
      });

      $('#slideBtn').click(function() {
        $('#galleryImg').slideToggle(500);
      });

      $('#changeImg').click(function() {
        const newSrc = 'https://picsum.photos/300/200?random=2';
        const currentTime = new Date().toLocaleTimeString();
        $('#galleryImg').attr('src', newSrc);
        $('#caption').text('Image changed at: ' + currentTime);
      });

      $('#addCaptionBtn').click(function() {
        const captionText = $('#captionInput').val().trim();
        if (captionText) {
          $('#captionList').append('<li>' + captionText + '</li>');
          $('#captionInput').val('');
        }
      });

      $('#removeCaptionBtn').click(function() {
        $('#captionList li:last').remove();
      });

      $('#highlightBtn').click(function() {
        $('#captionList li').css({
          'background': 'lightblue',
          'padding': '8px'
        });
      });

      $('#resetBtn').click(function() {
        $('#captionList').html('<li>Image 1</li><li>Image 2</li><li>Image 3</li>');
      });
    });
  </script>

</body>
</html>