<?php
include('config.php');
include('includes/header.php');
include('includes/menu.php');

// Fetch Categories
$categories_data;
$stmt = $conn->prepare("CALL LS_M_CAT()");
$stmt->execute();
$categories_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get AEFLAG from query string and set it in the hidden input
$AEFLAG = isset($_GET['AEFLAG']) ? $_GET['AEFLAG'] : '';

?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div id="msg_Container"></div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"><?= isset($_GET['AEFLAG']) && ($_GET['AEFLAG'] == "E") ? "Edit" : 'Add'; ?> Product</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?=$base_path?>admin/add-product?AEFLAG=E" class="breadcrumb-link">Products</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= isset($_GET['AEFLAG']) && ($_GET['AEFLAG'] == "E") ? "Edit" : 'Add'; ?> Product</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div id="Div_Edit">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Product List</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table" id="tbl_M_Product_ls"></table>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <form id="product-form" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="product_name" class="col-form-label">Product Name</label>
                                                        <input id="product_name" name="product_name" type="text" class="form-control" required>
                                                        <input id="update_product_id" name="update_product_id" type="hidden" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="category_id" class="col-form-label">Category</label>
                                                        <select id="category_id" name="category_id" class="form-control">
                                                        <option value="0">Select Category</option>
                                                            <?php foreach ($categories_data as $category): ?>
                                                                <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="sub_category_id" class="col-form-label">Sub-Category</label>
                                                        <select id="sub_category_id" name="sub_category_id" class="form-control" placeholder="Select Sub Category ">
                                                            <option value="0">Select Sub Category</option>
                                                            <!-- Populate sub-categories dynamically based on selected category -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="product_image" class="col-form-label">Product Image</label>
                                                        <input id="product_image" name="product_image" type="file" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="product_desc" class="col-form-label">Product Description</label>
                                                        <textarea id="product_desc" name="product_desc" class="form-control" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="key_dtl" class="col-form-label">Key Details</label>
                                                        <input id="key_dtl" name="key_dtl" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="sku" class="col-form-label">SKU</label>
                                                        <input id="sku" name="sku" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="price" class="col-form-label">Price</label>
                                                        <input id="price" name="price" type="number" step="0.01" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="quantity" class="col-form-label">Quantity</label>
                                                        <input id="quantity" name="quantity" type="number" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="unit_of_measure" class="col-form-label">Unit of Measure</label>
                                                        <input id="unit_of_measure" name="unit_of_measure" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="viscosity" class="col-form-label">Viscosity</label>
                                                        <input id="viscosity" name="viscosity" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="packaging_type" class="col-form-label">Packaging Type</label>
                                                        <input id="packaging_type" name="packaging_type" type="text" class="form-control">
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
                                                        <label for="meta_title" class="col-form-label">Meta Title</label>
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="meta_desc" class="col-form-label">Meta Description</label>
                                                        <textarea id="meta_desc" name="meta_desc" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="keywords" class="col-form-label">Keywords</label>
                                                        <input id="keywords" name="keywords" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                                                    <button type="button" id="btn_cancel" class="btn btn-secondary">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Additional tabs can be added here if needed -->
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
        <input type="hidden" name="" id="txt_sub_cat_val" Value="0">
        <input type="hidden" name="" id="txtAEFlag" Value="<?=$AEFLAG?>">
    </div>

<script>
    $(document).ready(function () {
        AddFunctionsOnEvents();
    });

    function AddFunctionsOnEvents() {
        Set_Add_Edit_Flow();
        $('#btn_save').click(function (e) {
            e.preventDefault(); // Prevent the default action of the button click

            // Call the validation function
            return validateSave();
        });

        $('#category_id').change(function () {
            
            return cboChange_category_ID();
        });

         $('#btn_cancel').click(function () {
            $("#product-form")[0].reset();
            Set_Add_Edit_Flow()
            //window.location.href = "add-product.php?AEFLAG=" + (AEFLAG == "E" ? "E" : "A");
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
                window.location.href = "ErrorPage.aspx?" + "Errorcode=3"
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
                window.location.href = "ErrorPage.aspx?" + "Errorcode=3"
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

        var product_name = $("#product_name").val().trim();
        var category_id = $("#category_id").val().trim();
        var product_desc = $("#product_desc").val().trim();
        var meta_title = $("#meta_title").val().trim();
        var meta_desc = $("#meta_desc").val().trim();
        var keywords = $("#keywords").val().trim();




        if (product_name === '') {
            errorMsg += errorMsg == "" ? 'Product Name' : ", Product Name";
            isValid = false;
        }
        if (category_id === '' || category_id ==0 ) {
            errorMsg += errorMsg == "" ? 'Category Name' : ", Category Name";
            isValid = false;
        }
        if (product_desc === '') {
            errorMsg += errorMsg == "" ? 'Product Description' : ", Product Description";
            isValid = false;
        }
        if (meta_title === '') {
            errorMsg += errorMsg == "" ? 'Meta Title' : ", Meta Title";
            isValid = false;
        }
        if (meta_desc === '') {
            errorMsg += errorMsg == "" ? 'Meta Descrption' : ", Meta Descrption";
            isValid = false;
        }


        if (!isValid) {
            alert(errorMsg);
            return false // Stop form submission
        }

        IU_ProductData();
    }


    function cboChange_category_ID() {
        var category_id = $("#category_id").val();
        // Fetch sub-categories based on selected category
        $.ajax({
            url: 'ajax/M_Prod_Service.php',
            type: 'POST',
            data: { action: 'fetch_sub_categories', category_id: category_id },
            success: function (response) {
                var arrayData = response.map(function(item) {
                return [item.value, item.text]; // Adjust if necessary
            });

                comm_script.populateDropdown("sub_category_id",arrayData,$("#txt_sub_cat_val").val())
                //$('#sub_category_id').html(response);
            },
            error: function (xhr, status, error) {
                    $(".loader").hide()
                    alert('Error fetching Products: ' + xhr.responseText);
                }
        });
    }



    tbl_M_Product_ls_headers = [
        { label: "id", field: "product_id", hidden: "N" },
        { label: "Name", field: "product_name", hidden: "N" },
        // { label: "Descriprtion", field: "product_desc", hidden: "N" },
        // { label: "Key Details", field: "product_key_details", hidden: "Y" },
        { label: "Category", field: "category_id", hidden: "N" },
        { label: "Status", field: "status", hidden: "N" },
        { label: "Created By", field: "created_by_name", hidden: "N" },
        { label: "Modified By", field: "modified_by_name", hidden: "Y" },
        {
            label: "Action", field: "product_id", hidden: "N",

            render: function (item) {
                function GetSetValue(field) {
                    return item[field] !== null && item[field] !== undefined ? item[field] : "";
                }
                var rawHtml = ""
                rawHtml += '<input type="button" onclick="DispData(' + GetSetValue("product_id") + ')" class="btn btn-sm btn-outline-light" value="Edit" />'
                rawHtml += '<button onclick="DelRow(' + GetSetValue("category_id") + ') " class="btn btn-sm btn-outline-light" > <i class="text-danger far fa-trash-alt"></i> </button>'
                return rawHtml
            }
        }
    ];
    function FillSearchDG() {
        try {
            $(".loader").show()
            $.ajax({
                url: 'ajax/M_Prod_Service.php',
                type: 'POST',
                data: { action: 'fetchProduct' },
                dataType: 'json',
                success: function (response) {
                    if (response == "Exception") {
                        alert('Record Not Found !', 'alert');
                        $(".loader").fadeOut("slow");
                        return false;
                    }

                    var obj = response;
                    //var obj = jQuery.parseJSON(obj);
                    comm_script.fill_table_data(tbl_M_Product_ls_headers, obj, "tbl_M_Product_ls", "lbl_M_Product_ls");
                    $(".loader").hide()

                },
                error: function (xhr, status, error) {
                    $(".loader").hide()
                    alert('Error fetching Products: ' + xhr.responseText);
                }
            });
        } catch (err) {
            $(".loader").hide()
            alert("Error: " + err.message);
        }
    }


    function DispData(pr_id) {
        $(".loader").show();
       // clearForm();
        $.ajax({
            type: "POST",
            url: 'ajax/M_Prod_Service.php',
            data: { action: 'disp_data', update_product_id: pr_id },
            //dataType: "json",
            success: function (response) {
                if (response == "Exception") {
                    alert('Record Not Found !', 'alert');
                    $(".loader").fadeOut("slow");
                    return false;
                }

                var product = response;

                // Populate form fields with user data
                var category = response;
                $('#update_product_id').val(category.product_id);
                $('#product_name').val(category.product_name);
                $('#category_id').val(category.category_id).change();
                $('#txt_sub_cat_val').val(category.sub_category_id);
                $('#product_image').val(category.product_img);
                $('#product_desc').val(category.product_desc);
                $('#key_dtl').val(category.product_key_details);
                $('#sku').val(category.sku);
                $('#price').val(category.price);
                $('#quantity').val(category.quantity);
                $('#unit_of_measure').val(category.unit_of_measure);
                $('#viscosity').val(category.viscosity);
                $('#packaging_type').val(category.packaging_type);
                $('#status').val(category.status);
                $('#meta_title').val(category.meta_title);
                $('#meta_desc').val(category.meta_description);
                $('#keywords').val(category.keywords);

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

    function DelRow(update_product_id) {
        if (confirm('Are you sure you want to delete this Product?')) {
            $.ajax({
                type: 'POST',
                url: 'ajax/M_Prod_Service.php',
                data: { action: 'delete_product', update_product_id: update_product_id },
                dataType: 'json',
                success: function (response) {
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

    // function clearForm() {
    //     $('#update_product_id').val(0);
    //     $('#category_name').val("");
    //     $('#category_desc').val("");
    //     $('#parent_id').val(0);
    //     $('#status').val(0);
    // }





    function IU_ProductData() {
        
        var action = $("#update_product_id").val() === '' ? 'A' : 'E';
        var formData = new FormData($("#product-form")[0]);
        formData.append('AEFLAG', action);

      //  var formData = new FormData(this);
        formData.append('action', 'save_product');
        $.ajax({
            url: 'ajax/M_Prod_Service.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#msg_Container").html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    '<strong>Success!</strong> ' + response +
                    '<a href="#" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></a></div>');
                $("#product-form")[0].reset();
                Set_Add_Edit_Flow();
                //clearForm()
            },
            error: function (xhr, status, error) {
                $("#msg_Container").html('Error: ' + xhr.responseText);
            }
        });
    };

   

</script>

<?php include('includes/footer.php'); ?>
