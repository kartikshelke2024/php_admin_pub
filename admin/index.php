<?php   include('config.php');
        include('includes/header.php');
        include('includes/menu.php') ?>


  
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Sunglide Lubricants  </h2>
                                <!-- <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p> -->
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <!-- <li class="breadcrumb-item active" aria-current="page">E-Commerce Dashboard Template</li> -->
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">

                     
                        <div class="row">
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Recent Products</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                        <table class="table" id="tbl_M_Product_ls"></table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
                    </div>
                </div>
            </div>
      
            <script>

$(document).ready(function () {
       FillSearchDG()
    });

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
            label: "Action", field: "product_id", hidden: "Y",

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
                </script>
            <?php include('includes/footer.php')?>