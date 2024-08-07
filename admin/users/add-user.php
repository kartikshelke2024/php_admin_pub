<?php
session_start();
include('../config.php');
include('../includes/header.php');
include('../includes/menu.php');

// Sanitize POST data
function sanitizeInput($data, $conn) {
    $result = array();
    foreach ($data as $key => $value) {
        $result[$key] = htmlspecialchars($value);
    }
    return $result;
}



// Fetch User Types
$user_types_data ;
$stmt = $conn->prepare("CALL PL_M_ADD_USER()");
$stmt->execute();
$user_types_data = $stmt->fetch(PDO::FETCH_ASSOC);
//$result = $stmt->get_result();
// while ($row = $result->fetch_row()) { // Fetching data as numeric array
//     $user_types_data[] = $row;
// }
//s$stmt->close();
//$conn->next_result(); // To clear the stored procedure result set




if (isset($_POST['add_user']) || isset($_POST['update_user'])) {
    $errorMSG = false;
    $successMSG = false;
    $message = '';
    $post_result = sanitizeInput($_POST, $conn);
    extract($post_result);

    // Determine the action
    $AEFLAG = isset($_POST['add_user']) ? 'ADD' : 'EDIT';
    $admin_id = isset($_POST['update_admin_id']) ? $_POST['update_admin_id'] : 0;

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

        $message = $AEFLAG == 'ADD' ? 'User Added Successfully.' : 'User Updated Successfully.';
        $successMSG = true;
        $username = $u_name = $password = $email = $role = $status = $phone = '';
    } catch (PDOException $e) {
        $errorMSG = true;
        $error_message = $e->getMessage();
        if (strpos($error_message, "username") !== false) {
            $message = "Username already exists";
        } else if (strpos($error_message, "email") !== false) {
            $message = "Email already exists";
        } else {
            $message = "Error occurred: Something went wrong";
        }
    }

    $showMSG = '<div class="alert alert-' . ($errorMSG ? 'danger' : 'success') . ' alert-dismissible fade show" role="alert">
                    <strong>' . ($errorMSG ? 'Error' : 'Success') . ' </strong> ' . $message . '
                    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>';
} elseif (isset($_GET['edit'])) {
    $edit_id = $_GET['id'];
    $stmt = $conn->prepare("CALL DISP_M_Users(:edit_id)");
    $stmt->bindParam(':edit_id', $edit_id);
    $stmt->execute();
    $user_res = $stmt->fetch(PDO::FETCH_ASSOC);

    $username = $user_res['username'];
    $u_name = $user_res['name'];
    $password = $user_res['password'];
    $email = $user_res['email'];
    $role = $user_res['role'];
    $status = $user_res['status'];
    $phone = $user_res['phone'];
} else {
    $username = $u_name = $password = $email = $role = $status = $phone = '';
}
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <?=isset($_POST['add_user']) ? $showMSG : '';?>
                    <?=isset($_POST['update_user']) ? $showMSG : '';?>
                    <h2 class="pageheader-title"><?=isset($_GET['edit']) ? "Edit" : 'Add';?> User</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?=$base_path?>admin/users/user" class="breadcrumb-link">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?=isset($_GET['edit']) ? "Edit" : 'Add';?> user</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                <div class="tab-regular">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">General</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="post" id="user-form">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="u_name" class="col-form-label">Name</label>
                                                    <input id="u_name" name="u_name" type="text" class="form-control" value="<?=$u_name?>" required>
                                                    <input id="update_admin_id" name="update_admin_id" type="hidden" class="form-control" value="<?=isset($_GET['edit']) ? $_GET['id'] : '';?>" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="username" class="col-form-label">Username</label>
                                                    <input id="username" name="username" type="text" class="form-control" value="<?=$username?>" required>
                                                </div>  
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="phone" class="col-form-label">Phone</label>
                                                    <input id="phone" name="phone" type="number" class="form-control" value="<?=$phone?>" required>
                                                </div>  
                                            </div>
                                            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="email" class="col-form-label">Email</label>
                                                    <input id="email" name="email" type="email" class="form-control" value="<?=$email?>" required>
                                                </div>  
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="password" class="col-form-label">Password</label>
                                                    <input id="password" name="password" type="text" class="form-control" value="<?=$password?>" required>
                                                </div>  
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="cpassword" class="col-form-label">Confirm password</label>
                                                    <input id="cpassword" name="cpassword" type="text" class="form-control" required>
                                                </div>  
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="role">User Role</label>
                                                    <?= populateDropdown('role', $user_types_data, $role); ?>
                                                    <select class="form-control" id="role" name="role">
                                                        <option value="admin">Admin</option>
                                                        <option value="editor">Editor</option>
                                                        <option value="viewer">Viewer</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button type="submit" name="<?=isset($_GET['edit']) ? 'update_user' : 'add_user';?>" class="btn btn-space btn-primary">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include('../includes/footer.php');?>
