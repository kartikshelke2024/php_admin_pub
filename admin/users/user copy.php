<?php   include('../config.php');
        include('../includes/header.php');
        include('../includes/menu.php') ?>

        <?php
        if (isset($_GET['delete'])) {
            $del_id = $_GET['id'];
            $del_sql = "DELETE  FROM admin_user where admin_id='$del_id'";
            if (mysqli_query($pdo,$del_sql)) {
                $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success </strong> User Deleted Successfully.
                <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
                </div>';
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error </strong>Something Went Wrong.
                <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
                </div>';
                
            }
            
        }
        ?>

  
          <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
        <?=isset($_GET['delete']) ? $msg : '' ;?>
                    <div class="row">
                        
                        <!-- users  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Admin User List</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">id</th>
                                                        <th>Name</th>
                                                        <th>Username</th>
                                                        <th>email</th>
                                                        <th>Phone</th>
                                                        <th>Password</th>
                                                        <th>Role</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                            $user_sql = "SELECT * FROM `admin_user`";
                                                            $user_data = mysqli_query($pdo,$user_sql);
                                                            for ($i=1; $i <= mysqli_num_rows($user_data) ; $i++) { 
                                                                extract(mysqli_fetch_assoc($user_data));?>
                                                                <tr>
                                                                    <td><?=$admin_id?></td>
                                                                    <td><?=$name?></td>
                                                                    <td><?=$username?></td>
                                                                    <td><?=$email?></td>
                                                                    <td><?=$phone?></td>
                                                                    <td><?=$password?></td>
                                                                    <td><?=$role?></td>
                                                                    <td><?=$status == 1 ? "Enabled" : "Disabled" ;?></td>
                                                                    <td>
                                                                        <a href="<?=$base_path?>admin/users/add-user?edit&id=<?=$admin_id?>" class="btn btn-sm btn-outline-light">Edit</a>
                                                                        <a href="<?=$base_path?>admin/users/user?delete&id=<?=$admin_id?>" class="btn btn-sm btn-outline-light">
                                                                            <i class="text-danger far fa-trash-alt"></i>
                                                                        </a>
                                                                    </td>
                                                                   
                                                                </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                </tbody>
                                                <tfoot>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Username</th>
                                                            <th>email</th>
                                                            <th>Phone</th>
                                                            <th>Password</th>
                                                            <th>Role</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                            </table>
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
      
            <?php include('../includes/footer.php')?>