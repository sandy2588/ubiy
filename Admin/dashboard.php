<?php
session_start();
if(isset($_SESSION['dashboard_login'])){
 include('init.php');
 $q1= $connect->prepare("SELECT * FROM users");
$q1->execute();
$userCount=$q1->rowCount();
$q2 =$connect->prepare("SELECT * FROM customers");
$q2->execute();
$cateCount= $q2->rowCount();
?>
<div class="container mt-5 pt-5 con">
<div class="row">
<div class="col-md-4 text-center">
<div class="box">
<i class="fa-regular fa-user fa-2xl"></i>
<h3 class="my-3">Users</h3>

<h5><?php echo $userCount?></h5>


<a href="user.php" class="btn btn-success">show</a>

</div>

</div>

<div class="col-md-4 text-center">

<div class="box">

<i class="fa-solid fa-user-tie fa-2xl"></i>

<h3 class="my-3">Customers</h3>
<h5><?php echo $cateCount?></h5>


<a href="customer.php" class="btn btn-primary">more...</a>

</div>

</div>
<div class="col-md-4 text-center prog">

<div class="box">

<i class="fa-solid fa-cloud-bolt fa-2xl"></i>
<h3 class="my-3">Propagation</h3>
<a href="users.php" class="btn btn-dark">show</a>

</div>

</div>




</div>

</div>
<?php
 include('includes/temp/footer.php');
}else{
    $_SESSION['login_error']="Login First";
    header("location:../login.php");
}
 ?>  