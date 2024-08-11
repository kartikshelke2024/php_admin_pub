<?php
include('../config.php');
include('../includes/header.php');
include('../includes/menu.php');

// Fetch Parent Categories

$parent_categories_data;
$stmt = $conn->prepare("CALL LS_M_CAT()");
$stmt->execute();
$parent_categories_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get AEFLAG from query string and set it in the hidden input
$AEFLAG = isset($_GET['AEFLAG']) ? $_GET['AEFLAG'] : '';

?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div id="msg_Container"></div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><?= isset($_GET['AEFLAG']) && ($_GET['AEFLAG'] == "E") ? "Edit" : 'Add'; ?> Category</h2>
                    
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?=$base_path?>admin/category/add-category?AEFLAG=E" class="breadcrumb-link">Categories</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= isset($_GET['AEFLAG']) && ($_GET['AEFLAG'] == "E") ? "Edit" : 'Add'; ?> Category</li>
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
                        <h5 class="card-header">Master Category List</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table" id="tbl_M_category_ls"></table>
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
                                        <form id="category-form" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="category_name" class="col-form-label">Category Name</label>
                                                        <input id="category_name" name="category_name" type="text" class="form-control" required>
                                                        <input id="update_category_id" name="update_category_id" type="hidden" class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 d-none">
                                                    <div class="form-group">
                                                        <label for="category_img" class="col-form-label">Category Image</label>
                                                        <input id="category_img" name="category_img" type="file" class="form-control">
                                                    </div>  
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="parent_id" class="col-form-label">Parent Category</label>
                                                        <select id="parent_id" name="parent_id" class="form-control">
                                                            <option value="0" selected>Select Category</option>
                                                            <?php foreach ($parent_categories_data as $category): ?>
                                                                <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="status" class="col-form-label">Status</label>
                                                        <select id="status" name="status" class="form-control">
                                                            <option value="Y">Active</option>
                                                            <option value="N">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="category_desc" class="col-form-label">Category Description</label>
                                                        <textarea id="category_desc" name="category_desc" class="form-control" rows="4"></textarea>
                                                    </div>  
                                                </div>
                                                <div class="col-sm-12 pl-0">
                                                    <p class="text-right">
                                                        <button type="button" id="submit-btn" class="btn btn-space btn-primary">Submit</button>
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
    </div>
    
    <div class="d-none">
        <input type="hidden" name="" id="txtEDITFLAG" Value="Yes">
        <input type="hidden" name="" id="txtADDFLAG" Value="Yes">
        <input type="hidden" name="" id="txtSaveFlag" Value="Yes">
        <input type="hidden" name="" id="txtDelFlag" Value="Yes">
        <input type="hidden" name="" id="txtLoadFlag" Value="Yes">
        <input type="hidden" name="" id="txtAEFlag" Value="<?=$AEFLAG?>">
    </div>
<?php include('../includes/footer.php');?>

<script>
    $(document).ready(function() {
        AddFunctionsOnEvents();
    });

    function AddFunctionsOnEvents() {
        Set_Add_Edit_Flow();
        $('#submit-btn').click(function() {
            return validateSave();
        });
    }

    function Set_Add_Edit_Flow() {
        if ($('#txtAEFlag').val() == "A") {
            cmdAdd_Click();
        } else if ($('#txtAEFlag').val() == "E") {
            cmdEdit_Click();
        } else {
            window.location.href = "ErrorPage.aspx?" + "Errorcode=7";
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
                   // FillCategoryData()
                   // Fill_ajax_Progrssive()
                    return
                } catch (e) {
                    $(".loader").fadeOut("slow");
                }
            }

    function validateSave() {
        var isValid = true;
        var errorMsg = '';

        var categoryName = $("#category_name").val().trim();
        var categoryDesc = $("#category_desc").val().trim();

        if (categoryName === '') {
            errorMsg += 'Category Name is required.\n';
            isValid = false;
        }
        if (categoryDesc === '') {
            errorMsg += 'Category Description is required.\n';
            isValid = false;
        }

        if (!isValid) {
            alert(errorMsg);
            return; // Stop form submission
        }

        IU_CategoryData();
    }


    tbl_M_category_ls_headers =  [
                {   label: "id",    field: "category_id",  hidden: "N" },
                {   label: "Name",    field: "category_name",  hidden: "N" },
                {   label: "Descriprtion",    field: "category_desc",  hidden: "N" },
                {   label: "Image",    field: "category_img",  hidden: "Y" },
                {   label: "Parent",    field: "parent_name",  hidden: "N" },
                {   label: "Level",    field: "level",  hidden: "N" },
                {   label: "Created By",    field: "created_by_name",  hidden: "N" },
                {   label: "Status",    field: "status",  hidden: "N" },
                {   label: "Modified By", field: "modified_by_name", hidden: "Y" },
                {   label: "Action",    field: "category_id",  hidden: "N",

                    render: function(item) {
                        function GetSetValue(field) {
                            return item[field] !== null && item[field] !== undefined ? item[field] : "";
                        }
                        var rawHtml = ""
                        rawHtml += '<input type="button" onclick="DispData('+GetSetValue("category_id")+')" class="btn btn-sm btn-outline-light" value="Edit" />'
                        rawHtml += '<button onclick="DelRow(' + GetSetValue("category_id")+ ') " class="btn btn-sm btn-outline-light" > <i class="text-danger far fa-trash-alt"></i> </button>'
                        return rawHtml
                    }
                }
            ];
    function FillSearchDG() {
                try {
                    $(".loader").show()
                    $.ajax({
                        url: '../ajax/M_Cat_Services.php',
                        type: 'POST',
                        data: { action: 'fetchCategories' },
                        dataType: 'json',
                        success: function(response) {
                            if (response == "Exception") {
                                alert('Record Not Found !', 'alert');
                                $(".loader").fadeOut("slow");
                                return false;
                            }

                            var obj = response;
                            //var obj = jQuery.parseJSON(obj);
                            comm_script.fill_table_data(tbl_M_category_ls_headers, obj, "tbl_M_category_ls", "lbl_tbl_M_category_ls");
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


            function DispData(cat_id){
                $(".loader").show();
                clearForm();
                    $.ajax({
                        type: "POST",
                        url: '../ajax/M_Cat_Services.php',
                        data: { action: 'disp_data', cat_id: cat_id },
                        //dataType: "json",
                        success: function (response) {
                            if (response == "Exception") {
                                alert('Record Not Found !', 'alert');
                                $(".loader").fadeOut("slow");
                                return false;
                            }

                           
                
                            // Populate form fields with user data
                            var category = response;
                            $('#update_category_id').val(category.category_id);
                            $('#category_name').val(category.category_name);
                            $('#category_desc').val(category.category_desc);
                            $('#parent_id').val(category.parent_id);
                            $('#status').val(category.status);

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

                function DelRow(cat_id) {
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        type: 'POST',
                        url: '../ajax/M_Cat_Services.php',
                        data: { action: 'delete_category', cat_id: cat_id },
                        dataType: 'json',
                        success: function(response) {
                            if (response.message.includes("error")) {
                                alert(response.message);
                                // Refresh the user list
                                
                            } else {
                                alert(response.message);
                                FillSearchDG();
                                
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
            
            function clearForm() {
                $('#update_category_id').val(0);
                $('#category_name').val("");
                $('#category_desc').val("");
                $('#parent_id').val(0);
                $('#status').val(0);
            }
    
    function IU_CategoryData() {
        var action = $("#update_category_id").val() === '' ? 'A' : 'E';
        var formData = new FormData($("#category-form")[0]);
        formData.append('AEFLAG', action);

        $.ajax({
            url: '../ajax/M_Cat_Services.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#msg_Container").html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<strong>Success!</strong> ' + response +
                        '<a href="#" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span></a></div>');
                    $("#category-form")[0].reset();
                    Set_Add_Edit_Flow();
                    //clearForm()
            },
            error: function(xhr, status, error) {
                $("#msg_Container").html('Error: ' + xhr.responseText);
            }
        });
    }
</script>

