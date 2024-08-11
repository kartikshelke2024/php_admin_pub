<?php
include('../config.php');
session_start();
// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    // Handle product add/update
    if (isset($_POST['AEFLAG'])) {
        handleProductAddUpdate($conn);
    }

    // Handle other actions
    if (isset($_POST['action'])) {
        handleOtherActions($conn);
    }
}

function handleProductAddUpdate($conn) {
    $response = [];
    $AEFLAG = $_POST['AEFLAG'];

    if ($AEFLAG == 'A' || $AEFLAG == 'E') {
        $update_product_id = isset($_POST['update_product_id']) ? $_POST['update_product_id'] : 0;
        $prod_name = $_POST['product_name'];
        $prod_desc = $_POST['product_desc'];
        $prod_key_details = $_POST['key_dtl'];
        $prod_img = '';
        $category_id = $_POST['category_id'];
        $sub_category_id = $_POST['sub_category_id'];
        $sub_category_id =  $sub_category_id > 0 ? $sub_category_id : null;

        $sku = $_POST['sku'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $unit_of_measure = $_POST['unit_of_measure'];
        $viscosity = $_POST['viscosity'];
        $packaging_type = $_POST['packaging_type'];
        $meta_title = $_POST['meta_title'];
        $meta_desc = $_POST['meta_desc'];
        $keywords = $_POST['keywords'];
        $status = $_POST['status'];
        $created_by =  $_SESSION['admin_id']; // Example value
        $modified_by = $created_by; // Example value
        $delflag = 'N'; // Example value

        // Handle file upload
        if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
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

            $uploadFile = $uploadDir . basename($_FILES['product_img']['name']);

            if (move_uploaded_file($_FILES['product_img']['tmp_name'], $uploadFile)) {
                $prod_img = $_FILES['product_img']['name'];
            } else {
                $response['message'] = 'File upload failed.';
                http_response_code(500);
                echo json_encode($response);
                return;
            }
        }

        try {
            $stmt = $conn->prepare("CALL IU_M_Product(:AEFLAG, :update_product_id, :prod_name, :prod_desc, :prod_key_details, :prod_img, :category_id, :sub_category_id, :sku, :price, :quantity, :unit_of_measure, :viscosity, :packaging_type, :status, :created_by, :modified_by, :delflag, :meta_title, :meta_desc, :keywords)");
            $stmt->bindParam(':AEFLAG', $AEFLAG);
            $stmt->bindParam(':update_product_id', $update_product_id);
            $stmt->bindParam(':prod_name', $prod_name);
            $stmt->bindParam(':prod_desc', $prod_desc);
            $stmt->bindParam(':prod_key_details', $prod_key_details);
            $stmt->bindParam(':prod_img', $prod_img);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':sub_category_id', $sub_category_id);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unit_of_measure', $unit_of_measure);
            $stmt->bindParam(':viscosity', $viscosity);
            $stmt->bindParam(':packaging_type', $packaging_type);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':created_by', $created_by);
            $stmt->bindParam(':modified_by', $modified_by);
            $stmt->bindParam(':delflag', $delflag);
            $stmt->bindParam(':meta_title', $meta_title);
            $stmt->bindParam(':meta_desc', $meta_desc);
            $stmt->bindParam(':keywords', $keywords);
            $stmt->execute();

            $response['message'] = $AEFLAG == 'A' ? 'Product Added Successfully.' : 'Product Updated Successfully.';
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
        case 'fetchProduct':
            fetchProduct($conn);
            break;
        case 'fetch_sub_categories':
            fetchSubCategories($conn);
            break;
        case 'disp_data':
            dispProduct($conn);
            break;
        case 'delete_product':
            deleteProduct($conn);
            break;
    }
}

function fetchProduct($conn) {
    try {
        $sql = "CALL LS_M_Prod()";
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

function fetchSubCategories($conn) {
    try {
        $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;

        $stmt = $conn->prepare("CALL LS_M_SubCat(:category_id)");
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        $subCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($subCategories);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
}

function dispProduct($conn) {
    try {
        $update_product_id = isset($_POST['update_product_id']) ? $_POST['update_product_id'] : 0;

        $stmt = $conn->prepare("CALL DISP_M_Product(:update_product_id)");
        $stmt->bindParam(':update_product_id', $update_product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($product);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
    }
}

function deleteProduct($conn) {
    try {
        $update_product_id = isset($_POST['update_product_id']) ? $_POST['update_product_id'] : 0;

        $stmt = $conn->prepare("CALL DEL_M_Product(:update_product_id)");
        $stmt->bindParam(':update_product_id', $update_product_id);
        $stmt->execute();

        echo json_encode(['message' => 'Product Deleted Successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Error: Database query failed: ' . $e->getMessage()]);
    }
}
?>
