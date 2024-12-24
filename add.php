<?php
include 'config/db_connection.php';

if (isset($_POST["submit"])) {
    $errors = []; // Collect errors to display them later

    // Task validation
    if (empty($_POST["task"])) {
        $errors[] = 'A task is required.';
    } else {
        $task = $_POST['task'];
        if (!is_string($task) || trim($task) === '') {
            $errors[] = 'Task must be a valid non-empty string.';
        }
    }

    // Task description validation
    $task_description = '';
    if (!empty($_POST["task_description"])) {
        $task_description = $_POST['task_description'];
        if (!is_string($task_description)) {
            $errors[] = 'Task description must be a string.';
        }
    }

    // Due date validation
    if (empty($_POST["due_date"])) {
        $errors[] = 'A due date is required.';
    } else {
        $due_date = $_POST['due_date'];
        $date = DateTime::createFromFormat('Y-m-d', $due_date);
        if (!$date || $date->format('Y-m-d') !== $due_date) {
            $errors[] = 'Due date must be a valid date in YYYY-MM-DD format.';
        }
    }

    // Display errors or proceed
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . '<br/>';
        }
    } else {
        // Sanitize inputs
        $task = mysqli_real_escape_string($conn, $_POST['task']);
        $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
        $task_description = mysqli_real_escape_string($conn, $task_description);

        // Create SQL query
        $sql = "INSERT INTO todo_table(task, task_description, due_date) VALUES('$task', '$task_description', '$due_date')";

        // Save to database and check
        if(mysqli_query($conn, $sql)){
            header('Location: index.php');
        } else {
            echo 'Query error: ' . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<?php include 'templates/header.php'; ?>

<div class="container mx-auto mt-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 p-6 rounded-lg mb-8">
            <h2 class="text-2xl font-bold text-white text-center">Add New Task</h2>
        </div>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="add.php" method="POST">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="task">
                        Task
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="task" 
                           name="task" 
                           type="text" 
                           placeholder="Enter your task">
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="task_description">
                        Task Description
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="task_description" 
                           name="task_description" 
                           rows="4"
                           placeholder="Enter task details"></textarea>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="due_date">
                        Due Date
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           id="due_date"
                           name="due_date"
                           type="date">
                </div>
                
                <div class="flex justify-end">
                    <button class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded transition-colors duration-200" 
                            type="submit"
                            name="submit">
                        Add Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
</html>
