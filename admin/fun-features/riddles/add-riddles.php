<?php   include('../../config.php');
        include('../../includes/header.php');
        include('../../includes/menu.php') ?>

<?php
// Handle Request
if (isset($_POST['add_riddle'])) {
    $errorMSG = false;
    $successMSG = false;
    $messege='';
    $post_result = mysqli_escape_array($db,$_POST);
    extract($post_result);

    $add_usr_sql = "INSERT INTO `riddle`(`question`, `answer`, `difficulty_level`, `category`, `language`) VALUES ('$question','$answer','$difficulty_level','$category','$language')";
    try {
        mysqli_query($pdo,$add_usr_sql);
        $messege='User Added Successfully.';
        $successMSG = true;
        $answer=$question=$password=$email=$category=$status=$phone= '';   
    } catch (\Throwable $th) {
        // Error occurred
        $errorMSG = true;
        $messege =  "Error occurred: Something went wrong";
      
       

    }
    if ($errorMSG) {
        $showMSG ='<div class="alert alert-danger alert-dismissible fade show" category="alert">
                    <strong>Error </strong> '.$messege.'
                    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    </div>';
    }elseif ($successMSG) {
        $showMSG ='<div class="alert alert-success alert-dismissible fade show" category="alert">
                    <strong>Success </strong> '.$messege.'
                    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    </div>';
    }
  
}elseif (isset($_POST['update_riddle'])) {
    $errorMSG = false;
    $successMSG = false;
    $messege='';
    $post_result = mysqli_escape_array($db,$_POST);
    extract($post_result);

    $update_usr_sql = "UPDATE `admin_user` SET `answer`='$answer',`name`='$question',`password`='$password',`email`='$email',`category`='$category',`status`='$status',`phone`='$phone' WHERE admin_id='$update_riddle_id'";
    
    try {
        mysqli_query($pdo,$update_usr_sql);
        $messege='User Updated Successfully.';
        $successMSG = true;
        $answer=$question=$password=$email=$category=$status=$phone= '';   
    } catch (\Throwable $th) {
        $errorMSG = true;
         // Error occurred
        if (mysqli_errno($db) == 1062) {
            // Duplicate entry error occurred
            $error_message = mysqli_error($db);
            if (strpos($error_message, "answer") !== false) {
                // Duplicate entry error occurred for unique key 1
                $messege= "answer already exists";
            } else if (strpos($error_message, "email") !== false) {
                // Duplicate entry error occurred for unique key 2
                $messege =  "Email already exists";
            } else {
                // Other type of duplicate entry error occurred
                $messege =  "Duplicate entry error occurred";
            }
        } else {
            // Other type of error occurred
            $messege =  "Error occurred: Something went wrong";
        }
       

    }
    if ($errorMSG) {
        $showMSG ='<div class="alert alert-danger alert-dismissible fade show" category="alert">
                    <strong>Error </strong> '.$messege.'
                    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    </div>';
    }elseif ($successMSG) {
        $showMSG ='<div class="alert alert-success alert-dismissible fade show" category="alert">
                    <strong>Success </strong> '.$messege.'
                    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    </div>';
    }

    
}elseif (isset($_GET['edit'])) {
    $edit_id = $_GET['id'];
    $user_sql = "SELECT * FROM `admin_user` where admin_id = '$edit_id'";
    $user_data = mysqli_query($pdo,$user_sql);
    $user_res = mysqli_fetch_assoc($user_data);

    $answer= $user_res['answer'];
    $question= $user_res['name'];
    $password= $user_res['password'];
    $email= $user_res['email'];
    $category= $user_res['category'];
    $status= $user_res['status'];
    $phone= $user_res['phone'];

}else{
    $answer=$question=$password=$email=$category=$status=$phone= ''; 
}

?>



  
          <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                       <?=isset($_POST['add_riddle'])? $showMSG : '' ;?>
                       <?=isset($_POST['update_riddle'])? $showMSG : '' ;?>
                            <h2 class="pageheader-title"> <?=isset($_GET['edit'])? "Edit" : 'Add' ;?> Riddle</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?=$base_path?>admin/users/user" class="breadcrumb-link">Fun Features</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?=isset($_GET['edit'])? "Edit" : 'Add' ;?> Riddles</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
             
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- basic tabs  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                            <!-- <div class="section-block">
                                <h5 class="section-title">English</h5>
                                <p>Takes the basic nav from above and adds the .nav-tabs class to generate a tabbed interface..</p>
                            </div> -->
                            <div class="tab-regular">
                                <ul class="nav nav-tabs " id="myTab" category="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" category="tab" aria-controls="home" aria-selected="true">General</a>
                                    </li>
                                  
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" category="tabpanel" aria-labelledby="home-tab">
                                        <div class="card">
                                        <div class="card-body">
                                            <form  action="" method="post" id="user-form">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                        <div class="form-group">
                                                            <label for="question" class="col-form-label">Quesition</label>
                                                            <textarea id="question" name="question" type="text" class="form-control" value="<?=$question?>" required> </textarea>
                                                            <input id="update_riddle_id" name="update_riddle_id" type="hidden" class="form-control" value="<?=isset($_GET['edit'])? $_GET['id'] : '' ;?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                        <div class="form-group">
                                                            <label for="answer" class="col-form-label">Answer</label>
                                                            <input id="answer" name="answer" type="text" class="form-control" value="<?=$answer?>" required>
                                                        </div>  
                                                    </div>
                                                   
                                                    
                                                   
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                                                        <div class="form-group">
                                                            <label for="category">Category</label>
                                                            <select class="form-control" id="category" name="category">
                                                                <?php
                                                                    $riddle_category_sql = "SELECT * FROM riddle_category";
                                                                    $riddle_category_data = mysqli_query($pdo,$riddle_category_sql);
                                                                    for ($i=0; $i < mysqli_num_rows($riddle_category_data); $i++) { 
                                                                        extract(mysqli_fetch_assoc($riddle_category_data));?>
                                                                        <option value="<?=$category_id?>" ><?=$category_name?></option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                                                        <div class="form-group">
                                                            <label for="difficulty_level">Difficulty</label>
                                                            <select class="form-control" id="difficulty_level" name="difficulty_level">
                                                                <option value="Difficult" >Hard</option>
                                                                <option value="Medium"  >Medium</option>
                                                                <option value="Easy" >Easy</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                                                        <div class="form-group">
                                                            <label for="language">Language</label>
                                                            <select class="form-control" id="language" name="language">
                                                                <?php
                                                                    $language_sql = "SELECT * FROM language";
                                                                    $language_data = mysqli_query($pdo,$language_sql);
                                                                    for ($i=0; $i < mysqli_num_rows($language_data); $i++) { 
                                                                        extract(mysqli_fetch_assoc($language_data));?>
                                                                        <option value="<?=$language_id?>" ><?=$language_name?></option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                   
                                                    <div class="col-sm-12 pl-0">
                                                        <p class="text-right">
                                                        <?=isset($_GET['edit'])? '<button name="update_riddle" type="submit" class="btn btn-space btn-primary" onclick="return validate_form(`user-form`)">Update</button>' : ' <button name="add_riddle" type="submit" class="btn btn-space btn-primary" onclick="return validate_form(`user-form`)">Submit</button>' ;?>
                                                            
                                                            <button type="reset"  class="btn btn-space btn-secondary">Cancel</button>
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
                        <!-- ============================================================== -->
                        <!-- end basic tabs  -->
                        <!-- ============================================================== -->
                      
                    </div>
              
            </div>

            <script>
                function validate_form(formID) {
                let form = document.getElementById(formID);
                if (!(form.password.value==form.cpassword.value)) {
                    alert("password and Confirm password Should be same");
                    return false;
                }else{
                    return true;
                }
                    
                }
            </script>

      
            <?php include('../../includes/footer.php')?>