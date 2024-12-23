
<?php
include('init_user.php');
session_start();
$page ="All";
if(isset($_GET['page'])){
    $page=$_GET['page'];
}
if($page =="All"){
?>
<div class="container mt-4 pt-4">
    <div class="row">
        <div class="col-md-10 m-auto">
        <?php 
        if(isset($_SESSION['login_error'])){
           echo "<h4 class='alert alert-danger text-center'> ". $_SESSION['login_error']."</h4>";
     unset( $_SESSION['login_error']);
    }
     ?> 
            <h4 class="text-center mb-2">Welcome To Login Bage</h4>
        <form method="post" action="login.php?page=check">
            <label>Email:</label>
            <input type="email" placeholder="Enter your Email" name="email" class="form-control mb-4">
            <label>Password:</label>
            <input type="password" placeholder="Enter your Password" name="pass" class="form-control mb-4">
            <input type="submit"  value="Login" class="btn btn-block btn-success">
        </form>
        </div>
    </div>
</div>

<?php 
}else if ($page=="check"){
 if($_SERVER['REQUEST_METHOD']=="POST"){
    
      $email = $_POST['email'];
    
     $pass = $_POST['pass'];
    
     $statment = $connect->prepare("SELECT * FROM users WHERE email=? and `password`=?");
    
     $statment->execute(array($email, $pass));
    
     $usercount = $statment->rowCount();
    
     if($usercount>0){
        $result =  $statment->fetch();
        if( $result['status']==1){
            if( $result['role']=="admin"){
                $_SESSION['dashboard_login']=$email;
                header("location:admin/dashboard.php");
            }else{
                header("location:admin/index.php");
            }

        }else{
            $_SESSION['login_error'] = "Account Not Active";
            header("Location:login.php");

        }
    
  }elseif($_SERVER['REQUEST_METHOD']=="POST"){
    
    $email = $_POST['email'];
  
   $pass = $_POST['pass'];
  
   $statment = $connect->prepare("SELECT * FROM customers WHERE email=? and `password`=?");
  
   $statment->execute(array($email, $pass));
  
   $usercount = $statment->rowCount();
  
   if($usercount>0){
      $result =  $statment->fetch();
      if( $result['status']==1){
          if( $result['role']=="admin"){
              $_SESSION['dashboard_login']=$email;
              header("location:Map-layers-master/index.html");
          }else{
            $_SESSION['login_error'] = "Account is blocked";
            header("Location:login.php");
          }

      }else{
          $_SESSION['login_error'] = "Account Not Active";
          header("Location:login.php");

      }
  }else{
    $_SESSION['login_error'] = "Account Not Found";
    header("Location:login.php");
   }
 
  }

}
}
?>


<?php
include('includes/temp/footer.php');
?>

