<?php   include('../config.php');
        include('../includes/header.php');
        include('../includes/menu.php') ?>

        
  
          <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
            <div id="msg_Container"></div>
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

    
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->


                      
                      
                      
                    </div>
              
            </div>




<!--  -->
<script type="text/javascript">
            $(document).ready(function() {
                AddFunctionsOnEvents();
                FillSearchDG()
            });

            //setAddEditFlow();
            function AddFunctionsOnEvents() {
                $('#cmdGo').click(function() {
                    return ValidateSearchData();
                    FillSearchDG()
                });
                $('#cmdCancel').click(function() {
                    ClearForm()
                });
            }
            function Set_Add_Edit_Flow() {

                if ($('#ctl00_ContentPlaceHolder1_txtAEFlag').val() == "A") {
                    cmdAdd_Click()
                } else if ($('#ctl00_ContentPlaceHolder1_txtAEFlag').val() == "E") {
                    cmdEdit_Click()
                } else {
                    window.location.href = 'ErrorPage.aspx';
                }
            }
            function cmdAdd_Click() {
                try {
                    var fid = $('#ctl00_ContentPlaceHolder1_txtFid').val()
                    if ($('#ctl00_ContentPlaceHolder1_txtADDFLAG').val() == "No") {
                        window.location.href = "ErrorPage.aspx?fid=" + fid + "&Errorcode=3"
                        return
                    }
                    $("#Div_Edit").show()
                    $("#ctl00_ContentPlaceHolder1_FrEdit").hide()
                    $("#cmddelete").hide()
                    $("#ctl00_ContentPlaceHolder1_txtIsEdit").val("False")
                    // return
                } catch (e) {
                    $(".loader").fadeOut("slow");
                }
            }
            function cmdEdit_Click() {
                try {
                    var fid = $('#ctl00_ContentPlaceHolder1_txtFid').val()

                    if ($('#ctl00_ContentPlaceHolder1_txtEDITFLAG').val() == "No") {
                        window.location.href = "ErrorPage.aspx?fid=" + fid + "&Errorcode=3"
                        return
                    }
                    $("#ctl00_ContentPlaceHolder1_FrMain").hide()
                    $("#ctl00_ContentPlaceHolder1_FrEdit").show()
                    $("#ctl00_ContentPlaceHolder1_txtIsEdit").val("True")

                    FillDG('P')
                    //Fill_ajax_Progrssive()
                    return
                } catch (e) {
                    $(".loader").fadeOut("slow");
                }
            }

            function ValidateSearchData() {
                var txtPatientName = document.getElementById('ctl00_ContentPlaceHolder1_txtPatientName');
                var dtpFDate = document.getElementById('ctl00_ContentPlaceHolder1_dtpFDate');
                var dtpToDate = document.getElementById('ctl00_ContentPlaceHolder1_dtpToDate');
                var txtPatientID = document.getElementById('ctl00_ContentPlaceHolder1_txtPatientID');
                var txtAdmissionNo = document.getElementById('ctl00_ContentPlaceHolder1_txtAdmissionNo');
                var txtOrderNo = document.getElementById('ctl00_ContentPlaceHolder1_txtOrderNo');
                var cboComponent = document.getElementById('ctl00_ContentPlaceHolder1_cboComponent');
                var cboReqType = document.getElementById('ctl00_ContentPlaceHolder1_cboReqType');

                if (txtPatientID.value == "" && txtOrderNo.value == "" && (dtpFDate.value == "" || dtpToDate.value == "")) {
                    if (dtpFDate.value != "" && dtpToDate.value == "") {
                        msgbox_C2("Enter To Date !", 'alert', "ctl00_ContentPlaceHolder1_dtpToDate");
                        return false;
                    }
                    if (dtpFDate.value == "" && dtpToDate.value != "") {
                        msgbox_C2("Enter From Date !", 'alert', "ctl00_ContentPlaceHolder1_dtpFDate");
                        return false;
                    }
                    msgbox_C2("Enter One Of These (Patient ID / Order No /Order From Date & To Date) !", 'alert', "ctl00_ContentPlaceHolder1_txtPatientID");
                    return false;
                }
                if (dtpFDate.value != "" && dtpToDate.value != "") {
                    if ((new Date(dtpFDate.value).getTime()) > (new Date(dtpToDate.value).getTime())) {
                        msgbox_C2("Order From Date Should Be Less Than To Date !", 'alert', "ctl00_ContentPlaceHolder1_dtpFDate");
                        return false;
                    }

                }
            }

            function ClearForm() {
                // Clear text fields
                $('#ctl00_ContentPlaceHolder1_txtPatientID').val('');
                $('#ctl00_ContentPlaceHolder1_txtAdmissionNo').val('');
                $('#ctl00_ContentPlaceHolder1_txtOrderNo').val('');
                $('#ctl00_ContentPlaceHolder1_txtPatientName').val('');
                $('#ctl00_ContentPlaceHolder1_dtpFDate').val('');
                $('#ctl00_ContentPlaceHolder1_dtpToDate').val('');

                $("#lbl_DgIssDetails").text("");

                // Clear grid data
                // Assuming the grid is a table and you want to clear its contents
                $('#tbl_DgIssDetails ').empty();

                // Reset dropdowns to their default value
                $('#ctl00_ContentPlaceHolder1_cboComponent').val(0);
                $('#ctl00_ContentPlaceHolder1_cboReqType').val(0);
                $('#ctl00_ContentPlaceHolder1_cboSyncStatus').val(0);
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

                    var param = {

                        cboEditTypeSrNo: $('#ctl00_ContentPlaceHolder1_cboEditTypeSrNo').val(),
                        txtSampleID: $('#ctl00_ContentPlaceHolder1_txtSampleID').val(),
                        txtDrBrName: $('#ctl00_ContentPlaceHolder1_txtDrBrName').val(),
                        txtBrID: $('#ctl00_ContentPlaceHolder1_txtBrID').val(),
                        txtadmisionNo: $('#ctl00_ContentPlaceHolder1_txtadmisionNo').val(),
                        txtOrderNo: $('#ctl00_ContentPlaceHolder1_txtOrderNo').val(),
                        dtpFDate: $('#ctl00_ContentPlaceHolder1_dtpFLogDate').val() || null,
                        dtpToDate: $('#ctl00_ContentPlaceHolder1_dtpToLogDate').val() || null,
                        opt_Master: $('#ctl00_ContentPlaceHolder1_opt_Master').prop("checked") ? "M" : "T",
                        fid: $('#ctl00_ContentPlaceHolder1_txtFid').val()
                    }

                    $.ajax({
                        url: '../ajax/web_services.php',
                        type: 'POST',
                        data: { action: 'fetch_users' },
                        dataType: 'json',
                        success: function(response) {
                            if (response == "Exception") {
                                msgbox_C2('Record Not Found !', 'alert');
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
        </script>
            <!--  -->





      
            <?php include('../includes/footer.php')?>