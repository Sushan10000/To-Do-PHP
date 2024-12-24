<?php
include('config/db_connection.php');

// check GET request id params
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //make sql 
    $sql = "SELECT * FROM todo_table WHERE id = $id";

    //get query result
    $result = mysqli_query($conn, $sql);

    //fetch result in array format
    $tasklists = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    mysqli_close($conn);
}

if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id_to_update']);

    $task_description = mysqli_real_escape_string($conn, $_POST['task_description']);

    $sql = "UPDATE todo_table SET task_description = '$task_description' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo 'Query error: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
}

if (isset($_POST['delete'])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM todo_table WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sql)) {
        //success   
        header('Location: index.php');
    } else {
        //failure
        echo 'Query error: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<?php include 'templates/header.php'; ?>

<div class="container mx-auto mt-8 px-4">
    <?php if ($tasklists): ?>
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 text-white p-6 mb-0 rounded-t-lg">
                <h2 class="text-2xl font-bold text-center"><?php echo htmlspecialchars($tasklists['task']); ?></h2>
            </div>

            <div class="bg-white shadow-md rounded-b-lg p-6">
                <div class="mb-4">
                    <span class="text-gray-600">Created:</span>
                    <span class="ml-2 text-gray-800"><?php echo htmlspecialchars($tasklists['created_at']); ?></span>
                </div>

                <form action="details.php" method="POST" class="mb-4">
                    <textarea name="task_description" class="w-full p-2 border rounded mb-2" rows="4"><?php echo htmlspecialchars($tasklists['task_description']); ?></textarea>
                    <input type="hidden" name="id_to_update" value="<?php echo $tasklists['id']; ?>">
                    <button type="submit" name="update" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                        Update Description
                    </button>
                </form>

                <div class="mb-6">
                    <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">
                        Due: <?php echo htmlspecialchars($tasklists['due_date']); ?>
                    </span>
                </div>

                <div class="flex justify-end">
                    <form action="details.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                        <input type="hidden" name="id_to_delete" value="<?php echo $tasklists['id']; ?>">
                        <button type="submit" name="delete" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded transition-colors duration-200">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center">
            <p class="text-red-600 font-md">Task not found</p>
            <a href="index.php" class="inline-block mt-4 text-gray-800 hover:text-gray-600">Return to Tasks</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>

</html>