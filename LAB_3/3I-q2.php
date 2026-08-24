/* A simple task management dashboard needs jQuery UI widgets for date-based task scheduling and dialog-based task details. The page must also support adding/removing tasks with visual effects. */

<?php
include 'value.php';

$titleSum1 = $A + $B;
$titleSum2 = $C + $D;
$placeholderHint1 = $A + 1;
$placeholderHint2 = ($B % 9) + 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>3I-Q2 — <?= $titleSum1 ?>_<?= $titleSum2 ?></title>

    <link rel="stylesheet"
          href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">

    <style>
        body {
            font-family: Arial;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        input, button {
            padding: 10px;
            margin: 5px;
        }

        #taskList {
            list-style: none;
            padding: 0;
        }

        #taskList li {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .delete {
            float: right;
            color: red;
            cursor: pointer;
        }

        #taskDialog {
            display: none;
        }
    </style>
</head>

<body>

<h1>Task Manager — Sulav</h1>

<input type="text" id="taskInput" placeholder="Enter task name">

<input type="text" id="dateInput"
       placeholder="DD-MM-YYYY (hint: <?= $placeholderHint1 ?>-0<?= $placeholderHint2 ?>-2026)">

<button id="addTaskBtn">Add Task <?= $D ?></button>
<button id="clearBtn">Clear All Tasks</button>

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
        $('#totalTasks').text(
            'Total tasks: ' + $('#taskList li').length
        );
    }

    $('#addTaskBtn').click(function() {
        const task = $('#taskInput').val().trim();
        const date = $('#dateInput').val().trim();

        if (task === '') {
            $('#dialogContent').text('Task name cannot be empty!');

            $('#taskDialog').dialog({
                title: 'Error',
                modal: true,
                buttons: {
                    OK: function() {
                        $(this).dialog('close');
                    }
                }
            });

            return;
        }

        $('<li>' + task +
          ' (Due: ' + date +
          ') <span class="delete">[x]</span></li>')
            .hide()
            .appendTo('#taskList')
            .fadeIn(500);

        $('#taskInput').val('');
        $('#dateInput').val('');
        updateTotal();
    });

    $('#taskList').on('click', '.delete', function() {
        $(this).parent().fadeOut(300, function() {
            $(this).remove();
            updateTotal();
        });
    });

    $('#clearBtn').click(function() {
        $('#dialogContent').text(
            'Delete all ' + $('#taskList li').length + ' tasks?'
        );

        $('#taskDialog').dialog({
            title: 'Confirm',
            modal: true,
            buttons: {
                OK: function() {
                    $('#taskList').slideUp(400, function() {
                        $(this).empty().show();
                        updateTotal();
                    });
                    $(this).dialog('close');
                },
                Cancel: function() {
                    $(this).dialog('close');
                }
            }
        });
    });

    $('#taskList').on('dblclick', 'li', function() {
        const task = $(this).text().replace('[x]', '').trim();

        $('#dialogContent').text(
            'Task: ' + task +
            ' | Added: ' + new Date().toLocaleDateString() +
            ' | Status: Pending'
        );

        $('#taskDialog').dialog({
            title: 'Task Details',
            modal: true,
            buttons: {
                Close: function() {
                    $(this).dialog('close');
                }
            }
        });
    });

    updateTotal();
});
</script>

</body>
</html>