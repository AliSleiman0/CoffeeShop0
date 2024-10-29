<?php
            require('db.php');
            session_start();
           
            // When form submitted, check and create user session.
            if (isset($_POST['submit'])) {
                $email = stripslashes($_REQUEST['email']);// removes backslashes
                $email = mysqli_real_escape_string($con, $email);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con, $password);
                // Check user is exist in the database
                $query    = "SELECT * FROM `logins` WHERE email='$email' AND password= '$password'";
               
              
                $result = mysqli_query($con, $query);
                $row = $result->fetch_assoc();
                $rows = mysqli_num_rows($result);
            
                if($email == 'admin' && $password == 'admin'){
                    
                    echo '<script type="text/javascript">';
                    echo 'alert("Welcome Admin!");';
                    echo 'window.location.href = "../adminPanel/admin.php";';
                    echo '</script>';

                }
                else if ($rows == 1) {
                    $_SESSION['email'] = $email;
                  
                    $_SESSION['user_id'] =  $row['id'];
                  
                    $_SESSION['name'] =  $row['name'];
                  
                
                    $_SESSION['number'] =  $row['number'];
                  
                    // Redirect to user dashboard page
                  
                    echo '<script type="text/javascript">';
                    echo 'alert("Welcome '. $row['name'] .'!");';
                    echo 'window.location.href = "../index.php";';
                    echo '</script>';                  
                                       
                    
                } else {
                    echo '<script type="text/javascript">';
                    echo 'alert("Incorrect Email OR Password");';
                    echo 'window.location.href = "login.php";';
                    echo '</script>'; 
                
               ; }
            } 

               
        ?>
            
       

        <!-- <script src="js/script.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

       