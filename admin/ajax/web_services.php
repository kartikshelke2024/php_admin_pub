<?php
include('../config.php');

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'fetch_users':
            fetchUsers($conn);
            break;
        case 'delete_user':
            deleteUser();
            break;
        // Add more cases for other operations like 'update_user', 'add_user', etc.
    }
}

function fetchUsers($conn) {
    try {
        $sql = "CALL LS_M_USER()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($users);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
}

function deleteUser() {
    global $pdo;
    if (isset($_POST['id'])) {
        $del_id = $_POST['id'];

        // Prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("DELETE FROM admin_user WHERE admin_id = ?");
        $stmt->bind_param("i", $del_id);

        if ($stmt->execute()) {
            echo 'User Deleted Successfully.';
        } else {
            echo 'Error: Something went wrong.';
        }
        $stmt->close();
    }
}
?>
