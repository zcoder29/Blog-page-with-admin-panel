<?php
//
//       if(isset($_POST['check_Box_Array'])){
//        
//       
//        foreach($_POST['check_Box_Array'] as $commentValueId){
//            
//           $options = $_POST['options'];
//            
//           switch($options){
//                   
//               case 'Approved':
//                   
//               $query = "UPDATE comments SET comment_status = '{$options}' WHERE comment_id = '{$commentValueId}' ";
//                       
//               $update_query = mysqli_query($connection, $query);
//               if(!$update_query){
//                   
//                   die('Query failed'. mysqli_error($connection));
//               }
//                 
//                break;
//               
//               case 'Unapproved':
//                   
//               $query = "UPDATE comments SET comment_status = '{$options}' WHERE comment_id = '{$commentValueId}' ";
//                       
//               $update_query = mysqli_query($connection, $query);
//               if(!$update_query){
//                   
//                   die('Query failed'. mysqli_error($connection));
//               }
//
//               break;
//               
//               case 'Delete':
//                   
//               $query = "DELETE FROM comments WHERE comment_id = '{$commentValueId}' ";
//                       
//               $delete_query = mysqli_query($connection, $query);
//               if(!$delete_query){
//                   
//                   die('Query failed'. mysqli_error($connection));
//               }
//
//               break;      
//           }     
//        }           
//    }
//
?>      
 <?php include "includes/header.php"; ?>
   
    <div id="wrapper">   
       
        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>
        
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION['user_name'];  ?></small>
                        </h1>
                    </div>
                </div>       
       <form action="" method="post">
        <!-- All Posts-->
        <table class="table table-responsive table-striped table-bordered">
           
            <div class="col-xs-4" id="bulkOptionContainer">
             <select class="form-control" name="options" id="">
                   <option value="">Select Options</option>
                   <option value="Approved">Approve</option>
                   <option value="Unapproved">Unapprove</option>
                   <option value="Delete">Delete</option>
                </select>
            </div>
            <div class="col-xs-4">
               <input type="submit" class="btn btn-success" name="submit" value="Apply">
            </div>
           
              <thead>
                <tr>
                  <th><input id='selectAllBoxes' type="checkbox"></th>
                  <th>Author</th>
                  <th>Comment</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Approved</th>
                  <th>Unapproved</th>
                  <th>Action</th>
              </tr>
              </thead>
              <tbody>
         <!--Show All Comments-->
         <?php 
         
          if(isset($_GET['id'])){
    
            $the_comment_post_id = $_GET['id'];          
            echo $the_comment_post_id;
              
        $query = "SELECT * FROM comments WHERE comment_post_id = '{$the_comment_post_id}'";
        $select_query =  mysqli_query($connection, $query);
        $num_of_comments = mysqli_num_rows($select_query);
              echo $num_of_comments; 
        
              
        while($num_of_comments !== 0){          
        $query = "SELECT * FROM comments WHERE comment_post_id = '{$the_comment_post_id}' ORDER BY comment_id DESC";
        $select_comments = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_comments)){

            $comment_id = $row['comment_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];
                           
        echo "<tr>";
          ?>
           
            <td><input class='checkBoxes' type='checkbox' name='check_Box_Array[]' value='<?php echo $comment_id; ?>'></td>
          
          <?php 
            
          echo "<td>{$comment_author}</td>  
                <td>{$comment_content}</td>  
                <td>{$comment_email}</td>  
                <td>{$comment_status}</td>
                <td>{$comment_date}</td>  
                <td><a href='./comments.php?approve={$comment_id}'>Approve</a></td>
                <td><a href='./comments.php?unapprove={$comment_id}'>Unapprove</a></td>
                <td><a onClick=\"javascript: return confirm('Are You Sure You Want To Delete'); \" href='./comments.php?delete={$comment_id}'>Delete</a></td>
                  
              </tr>";
            } 
        }
//        }          
          ?>
       
          <?php          
        //Approve Comment Status     
         if(isset($_GET['approve'])){

         $the_comment_id = $_GET['approve']; 

        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = '{$the_comment_id}' ";   
        $update_comment_status_query = mysqli_query($connection, $query);
        confirmQuery($update_comment_status_query);
        header("Location: ./post_comments.php");     
        }
                  
        /*Unapprove Comment Status  */        
        if(isset($_GET['unapprove'])){

         $the_comment_id = $_GET['unapprove']; 

        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = '{$the_comment_id}'  ";   
        $update_comment_status_query = mysqli_query($connection, $query);
        confirmQuery($update_comment_status_query);
        header("Location: ./post_comments.php");     
        }        
                  
          //Delete Post         
         if(isset($_GET['delete'])){ 

            $the_post_id = $_GET['delete'];    

            $query = "DELETE FROM comments WHERE comment_id = '{$comment_id}' ";  
            $delete_comment_query = mysqli_query($connection, $query);  
            confirmQuery($delete_comment_query);     
            header("Location: ./post_comments.php");
        } 
           
       ?>
          
               </tbody>
            </table>
        </form>   
    </div>
        <!-- /.container-fluid -->

</div>
        <!-- /#page-wrapper -->

<?php include "includes/footer.php"; ?>
       