<?php

include('../config.php');
include('../includes/header.php');
include('../includes/menu.php');

// Fetch User Types
$user_types_data;
$stmt = $conn->prepare("CALL PL_M_ADD_USER()");
$stmt->execute();

// Fetch the data as numeric arrays
$user_types_data = $stmt->fetchAll(PDO::FETCH_NUM);



// Get AEFLAG from query string and set it in the hidden input
$AEFLAG = isset($_GET['AEFLAG']) ? $_GET['AEFLAG'] : '';

?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
    <div id="msg_Container"></div>
    <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"><?=isset($_GET['AEFLAG']) && ($_GET['AEFLAG'] == "E") ? "Edit" : 'Add';?> User</h2>
                        
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="<?=$base_path?>admin/users/add-user?AEFLAG=E" class="breadcrumb-link">Users</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?=isset($_GET['AEFLAG']) && ($_GET['AEFLAG'] == "E") ? "Edit" : 'Add';?> user</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        <div id="Div_Edit">
            <div class="row">
                <!-- users  -->
                 <!-- ============================================================== -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Admin User List</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table" id="tbl_M_user_ls"></table>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- ============================================================== -->
                    <!-- end recent orders  -->
            </div>
        </div>
        <div id="Div_IU">
           
            
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
                                        <form id="user-form">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="u_name" class="col-form-label">Name</label>
                                                        <input id="u_name" name="u_name" type="text" class="form-control" required>
                                                        <input id="update_admin_id" name="update_admin_id" type="hidden" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="username" class="col-form-label">Username</label>
                                                        <input id="username" name="username" type="text" class="form-control" required>
                                                    </div>  
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="phone" class="col-form-label">Phone</label>
                                                        <input id="phone" name="phone" type="number" class="form-control" required>
                                                    </div>  
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="email" class="col-form-label">Email</label>
                                                        <input id="email" name="email" type="email" class="form-control" required>
                                                    </div>  
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="password" class="col-form-label">Password</label>
                                                        <input id="password" name="password" type="text" class="form-control" required>
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
                                                        <?= populateDropdown('role', $user_types_data); ?>
                                                        <!-- <select class="form-control" id="role" name="role">
                                                            <option value="admin">Admin</option>
                                                            <option value="editor">Editor</option>
                                                            <option value="viewer">Viewer</option>
                                                        </select> -->
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="Y">Active</option>
                                                            <option value="N">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 pl-0">
                                                    <p class="text-right">
                                                        <button type="button" id="submit-btn" class="btn btn-space btn-primary">Submit</button>
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="response-message"></div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="d-none">
        <input type="hidden" name="" id="txtEDITFLAG" Value="Yes">
        <input type="hidden" name="" id="txtADDFLAG" Value="Yes">
        <input type="hidden" name="" id="txtSaveFlag" Value="Yes">
        <input type="hidden" name="" id="txttxtDelFlag" Value="Yes">
        <input type="hidden" name="" id="txtLoadFlag" Value="Yes">
        <input type="hidden" name="" id="txtAEFlag" Value="<?=$AEFLAG?>">
    </div>
<?php include('../includes/footer.php');?>

<script>
      $(document).ready(function() {
                AddFunctionsOnEvents();
                //FillSearchDG()
            });

            //setAddEditFlow();
            function AddFunctionsOnEvents() {
                debugger;
                Set_Add_Edit_Flow()
                $('#cmdGo').click(function() {
                    return ValidateSearchData();
                });
                $('#submit-btn').click(function() {
                    return validateSave();
                });
                
                $('#cmdCancel').click(function() {
                    ClearForm()
                });
            }

            function Set_Add_Edit_Flow() {

                if ($('#txtAEFlag').val() == "A") {
                    cmdAdd_Click()
                } else if ($('#txtAEFlag').val() == "E") {
                    cmdEdit_Click()
                } else {
                    window.location.href = "ErrorPage.aspx?" + "Errorcode=7"
                }
            }
            function cmdAdd_Click() {
                try {
                    if ($('#txtADDFLAG').val() == "No") {
                        window.location.href = "ErrorPage.aspx?" +"Errorcode=3"
                        return
                    }
                    $("#Div_IU").show()
                    $("#Div_Edit").hide()
                    $("#cmddelete").hide()
                    // return
                } catch (e) {
                    console.log(e);
                    $(".loader").fadeOut("slow");
                }
            }
            function cmdEdit_Click() {
                try {

                    if ($('#txtEDITFLAG').val() == "No") {
                        window.location.href = "ErrorPage.aspx?" +"Errorcode=3"
                        return
                    }
                    $("#Div_IU").hide()
                    $("#Div_Edit").show()
                    $("#cmddelete").show()
                    // return

                    FillSearchDG()
                    //Fill_ajax_Progrssive()
                    return
                } catch (e) {
                    $(".loader").fadeOut("slow");
                }
            }


            function validateSave() {
                // Perform validation
                var isValid = true;
                var errorMsg = '';

                // Get form values
                var name = $("#u_name").val().trim();
                var username = $("#username").val().trim();
                var phone = $("#phone").val().trim();
                var password = $("#password").val().trim();
                var cpassword = $("#cpassword").val().trim();

                // Validate required fields
                if (name === '') {
                    errorMsg += 'Name is required.\n';
                    isValid = false;
                }
                if (username === '') {
                    errorMsg += 'Username is required.\n';
                    isValid = false;
                }
                if (phone === '') {
                    errorMsg += 'Mobile number is required.\n';
                    isValid = false;
                }
                if (password === '') {
                    errorMsg += 'Password is required.\n';
                    isValid = false;
                }
                if (cpassword === '') {
                    errorMsg += 'Confirm password is required.\n';
                    isValid = false;
                }
                if (password !== '' && cpassword !== '' && password !== cpassword) {
                    errorMsg += 'Passwords do not match.\n';
                    isValid = false;
                }

                // Show alert if validation fails
                if (!isValid) {
                    alert(errorMsg);
                    return; // Stop form submission
                }
                IU_UserData();
            }
          

            function ClearForm() {
                // Clear text fields


                // Clear grid data
                // Assuming the grid is a table and you want to clear its contents
               

                // Reset dropdowns to their default value
            
            }


            function DispData(userId){
                $(".loader").show();
                clearForm();
                    $.ajax({
                        type: "POST",
                        url: '../ajax/web_services.php',
                        data: { action: 'disp_data', user_id: userId },
                        //dataType: "json",
                        success: function (response) {
                            if (response == "Exception") {
                                alert('Record Not Found !', 'alert');
                                $(".loader").fadeOut("slow");
                                return false;
                            }

                            var user = response;
                
                            // Populate form fields with user data
                            $('#update_admin_id').val(user.admin_id);
                            $('#u_name').val(user.name);
                            $('#username').val(user.username);
                            $('#phone').val(user.phone);
                            $('#email').val(user.email);
                            $('#password').val(user.password);
                            $('#cpassword').val(user.password); // Assuming password should be the same for confirm password
                            $('#role').val(user.role);
                            $('#status').val(user.status);

                            // Show the form
                            $('#Div_IU').show();
                            $('#Div_Edit').hide();
                        },
                        error: function (xhr, status, error) {
                            // Handle errors here
                            $(".loader").hide();
                            alert(xhr.responseText, 'error');
                            ///console.error(xhr.responseText);
                        }
                    });
                }

            function DelRow(userId) {
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        type: 'POST',
                        url: '../ajax/web_service.php',
                        data: { action: 'delete_user', user_id: userId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('User deleted successfully.');
                                // Refresh the user list
                                FillSearchDG();
                            } else {
                                alert('Failed to delete user.');
                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle errors here
                            $(".loader").hide();
                            alert(xhr.responseText, 'error');
                            ///console.error(xhr.responseText);
                        }
                    });
                }
            }
            
            tbl_M_user_ls_headers =  [
                {   label: "id",    field: "admin_id",  hidden: "N" },
                {   label: "Name",    field: "name",  hidden: "N" },
                {   label: "Username",    field: "username",  hidden: "N" },
                {   label: "email",    field: "email",  hidden: "N" },
                {   label: "Phone",    field: "phone",  hidden: "N" },
                {   label: "Password",    field: "password",  hidden: "N" },
                {   label: "Role",    field: "role",  hidden: "N" },
                {   label: "Status",    field: "status",  hidden: "N" },
                {   label: "Action", field: "EditTypeSrNo", hidden: "N",
                    render: function(item) {
                        function GetSetValue(field) {
                            return item[field] !== null && item[field] !== undefined ? item[field] : "";
                        }
                        var rawHtml = ""
                        rawHtml += '<input type="button" onclick="DispData('+GetSetValue("admin_id")+')" class="btn btn-sm btn-outline-light" value="Edit" />'
                        rawHtml += '<button onclick="DelRow(' + GetSetValue("admin_id")+ ') " class="btn btn-sm btn-outline-light" > <i class="text-danger far fa-trash-alt"></i> </button>'
                        return rawHtml
                    }
                }
            ];


            function FillSearchDG() {
                try {
                    $(".loader").show()
                    $.ajax({
                        url: '../ajax/web_services.php',
                        type: 'POST',
                        data: { action: 'fetch_users' },
                        dataType: 'json',
                        success: function(response) {
                            if (response == "Exception") {
                                alert('Record Not Found !', 'alert');
                                $(".loader").fadeOut("slow");
                                return false;
                            }

                            var obj = response;
                            //var obj = jQuery.parseJSON(obj);
                            comm_script.fill_table_data(tbl_M_user_ls_headers, obj, "tbl_M_user_ls", "lbl_tbl_M_user_ls");
                            $(".loader").hide()

                        },
                        error: function(xhr, status, error) {
                            $(".loader").hide()
                            alert('Error fetching users: ' + xhr.responseText);
                        }
                    });
                } catch (err) {
                    $(".loader").hide()
                    alert("Error: " + err.message);
                }
            }

function clearForm(params) {
    $('#update_admin_id').val(0);
    $('#u_name').val("");
    $('#username').val("");
    $('#phone').val("");
    $('#email').val("");
    $('#password').val("");
    $('#cpassword').val(""); // Assuming password should be the same for confirm password
    $('#role').val(0);
    $('#status').val(0);
}

        function IU_UserData(params) {
        
            var action = $("#update_admin_id").val() === '' ? 'A' : 'E';
            var formData = $("#user-form").serialize() + '&AEFLAG=' + action;

            $.ajax({
                url: '../ajax/web_services.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $("#msg_Container").html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<strong>Success!</strong> ' + response +
                        '<a href="#" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></a></div>');
                    //$("#user-form")[0].reset();
                    Set_Add_Edit_Flow();
                    clearForm();
                },
                error: function(xhr, status, error) {
                    $("#msg_Container").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<strong>Error!</strong> ' + xhr.responseText +
                        '<a href="#" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></a></div>');
                }
                
            });

        };

</script>
