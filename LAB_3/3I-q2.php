<?php include 'value.php'; ?>
<?php
  $titleSum1 = $A + $B;
  $titleSum2 = $C + $D;
  $placeholderHint1 = $A + 1;
  $placeholderHint2 = ($B % 9) + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>3I-Q2 — <?= $titleSum1 ?>_<?= $titleSum2 ?></title>
  
  <!-- jQuery UI CSS -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
  
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
    .input-group {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin: 20px 0;
      flex-wrap: wrap;
    }
    #taskInput, #dateInput {
      padding: 10px;
      font-size: 14px;
      border: 2px solid #ddd;
      border-radius: 5px;
    }
    #taskInput {
      width: 250px;
    }
    #dateInput {
      width: 180px;
    }
    button {
      padding: 10px 20px;
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
    #clearBtn {
      background: #f44336;
    }
    #clearBtn:hover {
      background: #da190b;
    }
    #taskList {
      list-style: none;
      padding: 0;
      margin: 20px 0;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    #taskList li {
      padding: 15px 20px;
      border-bottom: 1px solid #eee;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: background 0.2s;
    }
    #taskList li:hover {
      background: #f9f9f9;
    }
    #taskList li:last-child {
      border-bottom: none;
    }
    .delete {
      color: #f44336;
      font-weight: bold;
      cursor: pointer;
      padding: 5px 10px;
      border-radius: 3px;
      transition: background 0.2s;
    }
    .delete:hover {
      background: #ffebee;
    }
    #totalTasks {
      text-align: center;
      font-size: 1.2em;
      font-weight: bold;
      color: #555;
      margin: 20px 0;
    }
    #taskDialog {
      display: none;
    }
    .ui-dialog-titlebar {
      background: #4CAF50;
      border: none;
    }
    .ui-dialog-title {
      color: white;
    }
    .ui-widget-content {
      background: #fff;
    }
  </style>
</head>
<body>

  <h1>Task Manager — YourName</h1>

  <div class="input-group">
    <input type="text" id="taskInput" placeholder="Enter task name">
    <input type="text" id="dateInput" placeholder="DD-MM-YYYY (hint: <?= $placeholderHint1 ?>-0<?= $placeholderHint2 ?>-2026)">
    <button id="addTaskBtn">Add Task <?= $D ?></button>
    <button id="clearBtn">Clear All Tasks</button>
  </div>

  <ul id="taskList">
    <li>Task-<?= $A ?> <span class="delete">[x]</span></li>
    <li>Task-<?= $B ?> <span class="delete">[x]</span></li>
    <li>Task-<?= $C ?> <span class="delete">[x]</span></li>
  </ul>

  <p id="totalTasks">Total tasks: 3</p>

  <div id="taskDialog" title="Task Details">
    <p id="dialogContent"></p>
  </div>


  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#dateInput').datepicker({
        dateFormat: 'dd-mm-yy'
      });

      function updateTotal() {
        const count = $('#taskList li').length;
        $('#totalTasks').text('Total tasks: ' + count);
      }

      $('#addTaskBtn').click(function() {
        const taskName = $('#taskInput').val().trim();
        const dueDate = $('#dateInput').val().trim();

        if (taskName === '') {
          $('#taskDialog').dialog({
            title: 'Error',
            modal: true,
            buttons: {
              OK: function() {
                $(this).dialog('close');
              }
            }
          });
          $('#dialogContent').text('Task name cannot be empty!');
          $('#taskDialog').dialog('open');
          return;
        }

        const taskText = taskName + ' (Due: ' + dueDate + ')';
        $('<li>' + taskText + ' <span class="delete">[x]</span></li>')
          .hide()
          .appendTo('#taskList')
          .fadeIn(500);

        $('#taskInput').val('');
        $('#dateInput').val('');
        updateTotal();
      });

      $('#clearBtn').click(function() {
        const count = $('#taskList li').length;
        
        $('#taskDialog').dialog({
          title: 'Confirm',
          modal: true,
          buttons: {
            OK: function() {
              $(this).dialog('close');
              $('#taskList').slideUp(400, function() {
                $('#taskList').empty();
                $('#taskList').show();
                updateTotal();
              });
            },
            Cancel: function() {
              $(this).dialog('close');
            }
          }
        });
        $('#dialogContent').text('Delete all ' + count + ' tasks?');
        $('#taskDialog').dialog('open');
      });

      $('#taskList').on('dblclick', 'li', function() {
        const taskText = $(this).text().replace('[x]', '').trim();
        const currentDate = new Date().toLocaleDateString();
        
        $('#dialogContent').text('Task: ' + taskText + '\nAdded on: ' + currentDate + '\nStatus: Pending');
        
        $('#taskDialog').dialog({
          title: 'Task: ' + taskText.split(' (')[0],
          modal: true,
          width: 400,
          buttons: {
            Close: function() {
              $(this).dialog('close');
            }
          }
        });
        $('#taskDialog').dialog('open');
      });

      $('#taskList').on('click', '.delete', function(e) {
        e.stopPropagation();
        $(this).parent('li').fadeOut(300, function() {
          $(this).remove();
          updateTotal();
        });
      });

      updateTotal();
    });
  </script>

</body>
</html>