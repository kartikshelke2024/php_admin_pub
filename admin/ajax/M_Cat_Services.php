<?php
include('../config.php');
session_start();

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    // Handle category add/update
    if (isset($_POST['AEFLAG'])) {
        handleCategoryAddUpdate($conn);
    }
    
    // Handle other actions
    if (isset($_POST['action'])) {
        handleOtherActions($conn);
    }
}

function handleCategoryAddUpdate($conn) {
    $response = [];
    $AEFLAG = $_POST['AEFLAG'];

    if ($AEFLAG == 'A' || $AEFLAG == 'E') {



        $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;
        $cat_name = $_POST['category_name'];
        $cat_desc = $_POST['category_desc'];
        $parent_id = $_POST['parent_id'];
        $status = $_POST['status'];
        $created_by =  $_SESSION['admin_id']; // Example value
        $modified_by = $created_by; // Example value
        $delflag = 'N'; // Example value
        $cat_img = '';

        // Handle file upload
        if (isset($_FILES['category_img']) && $_FILES['category_img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/';
            
            // Check if directory exists, if not, create it
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    $response['message'] = 'Failed to create upload directory.';
                    http_response_code(500);
                    echo json_encode($response);
                    return;
                }
            }

            $uploadFile = $uploadDir . basename($_FILES['category_img']['name']);

            if (move_uploaded_file($_FILES['category_img']['tmp_name'], $uploadFile)) {
                $cat_img = $_FILES['category_img']['name'];
            } else {
                $response['message'] = 'File upload failed.';
                http_response_code(500);
                echo json_encode($response);
                return;
            }
        }

        try {
            $stmt = $conn->prepare("CALL IU_M_Cat(:AEFLAG, :cat_id, :cat_name, :cat_desc, :parent_id, :cat_img, :created_by, :modified_by, :delflag, :status)");
            $stmt->bindParam(':AEFLAG', $AEFLAG);
            $stmt->bindParam(':cat_id', $cat_id);
            $stmt->bindParam(':cat_name', $cat_name);
            $stmt->bindParam(':cat_desc', $cat_desc);
            $stmt->bindParam(':parent_id', $parent_id);
            $stmt->bindParam(':cat_img', $cat_img);
            $stmt->bindParam(':created_by', $created_by);
            $stmt->bindParam(':modified_by', $modified_by);
            $stmt->bindParam(':delflag', $delflag);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            $response['message'] = $AEFLAG == 'A' ? 'Category Added Successfully.' : 'Category Updated Successfully.';
            http_response_code(200);
        } catch (PDOException $e) {
            $response['message'] = 'Error occurred: ' . $e->getMessage();
            http_response_code(500);
        }

        echo json_encode($response);
    } else {
        $response['message'] = 'Invalid action.';
        http_response_code(400);
    }
}

function handleOtherActions($conn) {
    $action = $_POST['action'];

    switch ($action) {
        case 'fetchCategories':
            fetchCategories($conn);
            break;
        case 'disp_data':
            dispCategory($conn);
            break;
        case 'delete_category':
            deleteCategory($conn);
            break;
    }
}

function fetchCategories($conn) {
    try {
        $sql = "CALL LS_M_Cat()";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($categories);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
}

function dispCategory($conn) {
    try {
        $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;

        $stmt = $conn->prepare("CALL DISP_M_Cat(:cat_id)");
        $stmt->bindParam(':cat_id', $cat_id);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($category);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
}

function deleteCategory($conn) {
    try {
        $cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : 0;

        $stmt = $conn->prepare("CALL DEL_M_Cat(:cat_id)");
        $stmt->bindParam(':cat_id', $cat_id);
        $stmt->execute();

        echo json_encode(['message' => 'Category Deleted Successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Error : Database query failed: ' . $e->getMessage()]);
    }
}
?>
