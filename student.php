<?php 
    ob_start();
    session_start();
    if(isset($_SESSION['username'])){
        include "init.php";
            
        $do = $_GET['do'] ?? "Manage";
        
        // Start Manage Student
        if($do == "Manage") {
            echo "<div class='container Manage-Student'>";
                echo "<h1 class='text-center'>Manage Student</h1>";
        ?>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Add New Student
        </button>


    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Add New Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <?php 
                        $obj = new Student();
                        $regNo = "ss-101";
                        if(empty( $obj->getLastRegNo()) ){
                             $regNo = "ss-100";
                        }else {
                            $regNo = $obj->getLastRegNo()[0];
                            $regNo = substr($regNo,3);
                            $regNo++;
                            $regNo = "ss-" . $regNo;
                        }
                    ?>
                    <label for="regNo">RegNo</label>
                    <input type="text" readonly name="regNo" class="form-control" value="<?= $regNo; ?>">
                </div>            
                <div class="form-group">
                    <label for="fname">FullName</label>
                    <input type="text" name="fname" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Cellphone</label>
                    <input type="text" name="phone" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <label for="addr">Address</label>
                    <input type="text" name="addr" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addBtn" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>

    
    <!-- Start Insert Information  -->
    <?php
        if( isset($_POST['addBtn']) ) {
            $regNo = filter_var($_POST['regNo'],FILTER_SANITIZE_STRING);
            $fname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
            $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
            $addr  = filter_var($_POST['addr'],FILTER_SANITIZE_STRING);
            
            $imgName = $_FILES['image']['name'];
            $imgTmp  = $_FILES['image']['tmp_name'];
            $imgType = $_FILES['image']['type'];
            $imgSize = $_FILES['image']['size'];

            // validateImage() function created inside functions file

            $imageErrors = array();

            if( !empty(validateImage($imgName,$imgType,$imgSize)) ){
                $imageErrors[] = validateImage($imgName,$imgType,$imgSize);
            }

            $formErrors = array();
            
            foreach($imageErrors as $errImg){
                foreach($errImg as $err){
                    echo "<div class='alert alert-danger msg'>" . $err . "</div>";
                }
            }
            
            if(empty($fname)):
                $formErrors[] = "FullName <strong>can't be empty</strong>";
            endif;

            if(!is_numeric($phone)):
                $formErrors[] = "Cellphone <strong>Must be Numeric </strong>";
            endif;

            if(empty($addr)):
                $formErrors[] = "Address <strong>can't be empty</strong>";
            endif;


            foreach($formErrors as $error):
                echo "<div class='alert alert-danger msg'>" . $error . "</div>";
            endforeach;

            if( empty($formErrors) && empty($imageErrors) ){
                $image = date("U") . "-" . $imgName;
                // var $img recover the path of folder will save images inside it
                move_uploaded_file($imgTmp,$img . $image);
                $objInsert = new Student();
                $insert = $objInsert->insertStudent($regNo,$fname,$phone,$addr,$image);
                if($insert == 1):
                    echo "<div class='alert alert-success msg'>Student Added</div>";
                    header("refresh: 3; url=?do=Manage");
                else:
                    echo "<div class='alert alert-danger msg'>Duplicate</div>";
                    header("refresh: 3; url=?do=Manage");
                endif;
            }

        }
    ?>
    
    <!-- End Insert Information  -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group" id="img">
                        <img src="" class="img-thumbnail"  alt="pic">
                    </div>
                    <div class="form-group">
                        <label for="regNo">RegNo</label>
                        <input type="text" readonly name="regNo" id="regNo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fname">FullName</label>
                        <input type="text" name="fname" id="fname" class="form-control">
                    </div>                    
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="addr">Address</label>
                        <input type="text" name="addr" id="addr" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btnEdit" class="btn btn-success">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Start Update Information -->
    <?php
        if(isset($_POST['btnEdit'])){
            $regNo = filter_var($_POST['regNo'],FILTER_SANITIZE_STRING);
            $fname = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
            $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
            $addr  = filter_var($_POST['addr'],FILTER_SANITIZE_STRING);
            
            $imgName = $_FILES['image']['name'];
            $imgTmp  = $_FILES['image']['tmp_name'];
            $imgType = $_FILES['image']['type'];
            $imgSize = $_FILES['image']['size'];

            $imageErrors = array();
            $formErrors = [];
            

            $student = new Student();
            $std = $student->getStudent($regNo);
            
            if(empty($std)){
                $std = ['','','','','',''];
            }
            
            if(empty($fname)):
                $fname = $std[2];
            endif;

            if(empty($phone)):
                $phone = $std[3];
            endif;

            if(empty($addr)):
                $addr = $std[4];
            endif;

            $qlf = true;
            if(empty($imgName)):
                $imgName = $std[5];
                $qlf = false;
            else:
                if( !empty(validateImage($imgName,$imgType,$imgSize)) ){
                    $imageErrors[] = validateImage($imgName,$imgType,$imgSize);
                }    
            endif;
 
            // Handle The Form Errors 
            
            
            foreach($imageErrors as $errImg){
                foreach($errImg as $err){
                    echo "<div class='alert alert-danger msg'>" . $err . "</div>";
                }
            }

            if(!is_numeric($phone)):
                $formErrors[] = "Cellphone <strong>Must Be Numeric</strong>";
            endif;

            foreach ($formErrors as $error) {
                echo "<div class='alert alert-danger msg'>" . $error . "</div>";
            }
            
            if( empty($formErrors) && empty($imageErrors) ){
                if($qlf){
                    $image = date("U") . "-" . $imgName;
                    // var $img recover the path of folder will save images inside it
                    move_uploaded_file($imgTmp,$img . $image);
                }else {
                    $image = $imgName;
                }
                $objUpdate = new Student();
                $update = $objUpdate->updateStudent($fname,$phone,$addr,$image,$regNo);
                if($update > 0):
                    echo "<div class='alert alert-success msg'>Student Infomation Updated</div>";
                    header("refresh: 3; url=?do=Manage");
                endif;
            }



        }
    
    ?>
    
    <!-- End Update Information -->

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" hidden id="regNb" name="regNb" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btnDelete" class="btn btn-danger">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Start Delete Student  -->
    <?php
        if(isset($_POST['btnDelete'])){
         
            $regNo = $_POST['regNb'];
            $delete = new Student();
            if($delete->deleteStudent($regNo) > 0){
                echo "<div class='alert alert-danger msg'>Student <strong>Deleted</strong></div>";
            }
        }
    
    ?>

    <!-- End Delete Student  -->


    <!-- Start Table -->

    <table class="table table-student">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Register No</th>
                <th scope="col">FullName</th>
                <th scope="col">Cellphone</th>
                <th scope="col">Address</th>
                <th scope="col">Control</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $students = new Student();
                foreach($students->getAllStudents() as $student):
            ?>
            <tr>
                <td scope="row"><?= $student['idS'];?></td>
                <td><?= $student['RegNo'];?></td>
                <td><?= $student['Fullname'];?></td>
                <td><?= $student['Cellphone'];?></td>
                <td><?= $student['Addr'];?></td>
                <td hidden><?= $student['Image'];?></td>
                <td class="control">
                    <button type="button" class="btn btn-success btnEdit" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fas fa-edit"></i> Edit
                    </button>     
                    <button type="button" class="btn btn-danger btnDelete" data-delete="<?= $student['RegNo'];?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-user-times"></i> Delete
                    </button>                             
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

        <!-- End Table -->
        
        <?php    
            echo "</div>";
        }  // End Manage Student 
        
        // Start Update Student
        elseif($do == "Update") {
            echo "<div class='container'>";
                echo "<h1 class='text-center'>Update Student</h1>";
            echo "</div>";
        } // End Update Student
        
        // Start Delete Student
        elseif($do == "Delete") {
            echo "<h1>Manage Student</h1>";
            
        }
        // End Delete Student
        else {
            echo "You are not available to access";
        }

    ?>


    <?php
        include $tpl . "footer.php";
    }else {
        header("Location: index.php");
    }

?>