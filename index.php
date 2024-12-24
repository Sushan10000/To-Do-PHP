<?php
include 'config/db_connection.php';

//Write query for all tasks
$sql = 'SELECT * FROM todo_table ORDER BY created_at DESC';

//Make query and get result
$result = mysqli_query($conn, $sql);

//Fetch the resulting rows as an array
$tasklists = mysqli_fetch_all($result, MYSQLI_ASSOC);

//Free result from memory
mysqli_free_result($result);

//Close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<?php include 'templates/header.php'; ?>
<div class="container mx-auto mt-8 px-4 pb-24">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 p-6 rounded-lg mb-8">
            <h2 class="text-2xl font-bold text-white text-center">Task Overview</h2>
            <div class="text-center mt-4">
                <a href="add.php" class="inline-block bg-white text-gray-800 font-bold py-2 px-6 rounded-full hover:bg-gray-100 transition-colors duration-200">
                    Add New Task
                </a>
            </div>
        </div>
        <?php foreach ($tasklists as $tasklist): ?>
            <div class="bg-white shadow-md rounded-lg mb-4 p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <h2 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($tasklist['task']); ?></h2>
                    <span class="bg-gray-100 text-gray-800 text-sm font-md px-3 py-1 rounded-full">
                        Due: <?php echo htmlspecialchars($tasklist['due_date']); ?>
                    </span>
                </div>
                <div class="mt-4 flex justify-end">
                    <a href="details.php?id=<?php echo $tasklist['id']; ?>"
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                        Details
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'templates/footer.php'; ?>

</html>