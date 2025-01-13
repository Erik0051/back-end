<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (title) VALUES (?)");
        $stmt->bind_param('s', $title);
        $stmt->execute();
    }
    header('Location: index.php');
    exit();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: index.php');
    exit();
}


$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Task Manager</h1>

 
    <form action="index.php" method="POST">
        <input type="text" name="title" placeholder="Enter task title" required>
        <button type="submit">Add Task</button>
    </form>

    <h2>Tasks</h2>
    <ul>
        <?php while ($task = $result->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($task['title']) ?> 
                <a href="?delete=<?= $task['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
