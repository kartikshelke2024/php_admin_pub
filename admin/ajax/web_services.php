<?php
include('../config.php');

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    // Handle user add/update
    if (isset($_POST['AEFLAG'])) {
        handleUserAddUpdate($conn);
    }
    
    // Handle other actions
    if (isset($_POST['action'])) {
        handleOtherActions($conn);
    }
}

function handleUserAddUpdate($conn) {
    $response = [];
    $AEFLAG = $_POST['AEFLAG'];
    
    if ($AEFLAG == 'A' || $AEFLAG == 'E') {
        $admin_id = isset($_POST['update_admin_id']) ? $_POST['update_admin_id'] : 0;
        $username = $_POST['username'];
        $u_name = $_POST['u_name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        $phone = $_POST['phone'];

        try {
            $stmt = $conn->prepare("CALL IU_AddOrUpdateUser(:AEFLAG, :admin_id, :username, :u_name, :password, :email, :role, :status, :phone)");
            $stmt->bindParam(':AEFLAG', $AEFLAG);
            $stmt->bindParam(':admin_id', $admin_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':u_name', $u_name);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();

            $response['message'] = $AEFLAG == 'A' ? 'User Added Successfully.' : 'User Updated Successfully.';
            http_response_code(200);
        } catch (PDOException $e) {
            $response['message'] = 'Error occurred: ' . $e->getMessage();
            http_response_code(500);
        }
    } else {
        $response['message'] = 'Invalid action.';
        http_response_code(400);
    }

    echo json_encode($response);
}

function handleOtherActions($conn) {
    $action = $_POST['action'];

    switch ($action) {
        case 'fetch_users':
            fetchUsers($conn);
            break;
        case 'disp_data':
            disp_data($conn);
            break;
        case 'delete_user':
            deleteUser($conn);
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

function disp_data($conn) {
    try {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

        $stmt = $conn->prepare("CALL DISP_M_users(:user_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($user);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
}

function deleteUser($conn) {

    try {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

        $stmt = $conn->prepare("CALL DEL_M_User_Maseter(:user_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        echo json_encode(['message' => 'User Deleted Successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Error: Database query failed: ' . $e->getMessage()]);
    }
}
?>
