<?php
include('init.php');
session_start();
if(isset($_SESSION['dashboard_login'])){
$page = "All";

if (isset($_GET['page'])) {

  $page = $_GET['page'];
}

if ($page == "All") {

  $statment = $connect->prepare("SELECT * FROM customers");
  $statment->execute();
  $userCount = $statment->rowCount();
  $result = $statment->fetchAll();

?>

  <div class="container mt-5 pt-5">

    <div class="row">

      <div class="col-md-10 m-auto">
        <?php
        if (isset($_SESSION['messege_user'])) {
          echo "<h4 class='alert alert-success text-center'>" . $_SESSION['messege_user'] . "</h4>";
          header("Refresh:3;url=customer.php");
          unset($_SESSION['messege_user']);
        }
        ?>
        <h4 class="text-center">Users Table <span class="badge badge-primary"> <?php echo $userCount ?></span>
          <a href="customer.php?page=create" class="btn btn-success">Crate new user</a>
        </h4>

        <table class="table table-dark">

          <thead>

          </thead>

          <tbody>
            <?php

            foreach ($result as $item) {

            ?>

              <tr>

                <td><?php echo $item['customer_id'] ?></td>
                <td><?php echo $item['customername'] ?></td>
                <td><?php echo $item['email'] ?></td>
                <td>
                  <a href="customer.php?page=show&customer_id=<?php echo $item['customer_id'] ?>" class="btn btn-success">
                    <i class="fa-solid fa-eye"></i>
                  </a>


                  <a href="customer.php?page=edit&customer_id=<?php echo $item['customer_id'] ?>" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>

                  <a href="customer.php?page=delete&customer_id=<?php echo $item['customer_id'] ?>" class="btn btn-danger">
                    <i class="fa-solid fa-trash"></i>
                  </a>


                </td>
              </tr>
            <?php
            }
            ?>

          </tbody>

        </table>

      </div>
    </div>
  </div>
<?php
} elseif ($page == "show") {

  if (isset($_GET['customer_id'])) {

    $customer_id = $_GET['customer_id'];
  }

  $statment = $connect->prepare("SELECT * FROM customers WHERE customer_id=?");

  $statment->execute(array($customer_id));

  $result = $statment->fetch();

?>

  <div class="container mt-3 pt-3">

    <div class="row">
      <div class="col-md-10 m-auto">

        <h4 class="text-center">Details of User <span class="badge badge-primary">1</span></h4>
        <table class="table table-dark text-center">

          <thead>
            <tr>
              <td>ID</td>
              <td>Name</td>
              <td>Email</td>
              <td>Password</td>
              <td>Status</td>
              <td>Role</td>
              <td>Created_at</td>
              <td>Opration</td>

            </tr>
          </thead>

          <tbody>

            <tr>
          <tbody>



            <td>

              <?php
              echo $result['customer_id'] ?></td>
            <td><?php
                echo $result['customername'] ?></td>
            <td><?php
                echo $result['email'] ?></td>
            <td><?php
                echo $result['password'] ?></td>
            <td><?php
                echo $result['status'] ?></td>
            <td><?php
                echo $result['role'] ?></td>
            <td><?php
                echo $result['created_at'] ?>
            </td>
            <td>
              <a href="customer.php" class="btn btn-success"><i class="fa-solid fa-house"></i></a>
            </td>
            </tr>

        </table>

      </div>

    </div>

  </div>


<?php
} else if ($page == "delete") {

  if (isset($_GET['customer_id'])) {
  }
  $user_id = $_GET['customer_id'];
  $statment = $connect->prepare("DELETE FROM customers WHERE customer_id=?");
  $statment->execute(array($user_id));
  $_SESSION['messege_user'] = "Deleted Successfully";
  header("Location:customer.php");
} elseif ($page == "create") {
  $id = $user = $email = $pass = "";
  $idErr = $userErr = $emailErr = $passErr = "";
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $user = $_POST['user'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $status = $_POST['status'];
    $role = $_POST['role'];
    if (empty($id)) {
      $idErr = "Enter ID";
    } elseif (empty($user)) {
      $userErr = "Enter your name";
    } elseif (empty($email)) {
      $emailErr = "Enter your email";
    } elseif (empty($pass)) {
      $passErr = "Enter your password";
    } else {
      $_SESSION['id'] = $id;
      $_SESSION['user'] = $user;
      $_SESSION['email'] = $email;
      $_SESSION['pass'] = $pass;
      $_SESSION['status'] = $status;
      $_SESSION['role'] = $role;
      header("Location:customer.php?page=savenew");
    }
  }

?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-10 m-auto">

        <?php

        if (isset($_SESSION['error'])) {
          echo "<h4 class='alert alert-danger text-center'>" . $_SESSION['error'] . "</h4>";
          unset($_SESSION['error']);
        }

        ?>
        <form action="customer.php?page=create" method="post">
          <label>ID</label>
          <input type="text" name="id" class="form-control mb-4" value=<?php echo $id ?>>
          <h4 class="text-center"><?php echo $idErr ?></h4>
          <label>Name</label>
          <input type="text" value="<?php echo $user ?>" name="user" class="form-control mb-4">
          <h4 class="text-center"><?php echo $userErr ?></h4>
          <label>Email</label>
          <input type="email" value="<?php echo $email ?>" name="email" class="form-control mb-4">
          <h4 class="text-center"><?php echo $emailErr ?></h4>
          <label>password</label>
          <input type="password" name="pass" class="form-control mb-4">
          <h4 class="text-center"><?php echo $passErr ?></h4>
          <label>Status</label>
          <select name="status" class="form-control mb-4">
            <option value="0">Block</option>
            <option value="1">Active</option>
          </select>
          <label>Role</label>
          <select name="role" class="form-control mb-4">
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
          <input type="submit" value="create" class=" w-100 btn btn-primary">

        </form>
      </div>
    </div>
  </div>
<?php
} elseif ($page == "savenew") {
  $id = $_SESSION['id'];
  $user = $_SESSION['user'];
  $email = $_SESSION['email'];
  $pass = $_SESSION['pass'];
  $status = $_SESSION['status'];
  $role = $_SESSION['role'];
  try {
    $statment = $connect->prepare("INSERT INTO customers (customer_id,customername,email, `password`, `status`, `role`,created_at) VALUES (?,?,?,?,?,?,now())");
    $statment->execute(array($id, $user, $email, $pass, $status, $role));
    $_SESSION['messege_user'] = "Created successfully";
    header("Location:customer.php");
  } catch (PDOException $e) {
    $_SESSION['error'] = "Duplicate ID";
    header("Location:customer.php?page=create");
  }
} elseif ($page == "edit") {
  if (isset($_GET['customer_id'])) {
    $user_id = $_GET['customer_id'];
  }
  $statment = $connect->prepare("SELECT * FROM customers WHERE customer_id=?");
  $statment->execute(array($user_id));
  $result = $statment->fetch();
  ?>
 
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-10 m-auto">
      <?php
        if (isset($_SESSION['error'])) {
          echo "<h4 class='alert alert-danger text-center'>".$_SESSION['error'] ."</h4>";
          unset($_SESSION['error']);
        }

       ?> 
        <form method="post" action="customer.php?page=saveupdate">
          <input type="hidden" name="old_id" value="<?php echo $result['customer_id']; ?>">
          <label>ID</label>
          <input type="text" name="id" class="form-control mb-4" value="<?php echo $result['customer_id']; ?>">
          <label>Name</label>
          <input type="text" name="user" class="form-control mb-4" value="<?php echo $result['customername']; ?>">
          <label>Email</label>
          <input type="text" name="email" class="form-control mb-4" value="<?php echo $result['email']; ?>">
          <label>Password</label>
          <input type="text" name="pass" class="form-control mb-4" value="<?php echo $result['password']; ?>">
          <label>Status</label>
          <select name="status" class="form-control">
            <?php
            if ($result['status'] == 0) {
              echo '<option value="0" selected>block</option>';
              echo '<option value="1">Active</option>';
            } else {

              echo '<option value="0" >block</option>';
              echo '<option value="1" selected>Active</option>';
            }
            ?>

          </select>
          <label>Role</label>
          <select name="Role" class="form-control">

            <?php

            if ($result['Role'] == 'user') {

              echo '<option value="user" selected>User</option>';

              echo '<option value="admin">Admin</option>';
            } else {

              echo '<option value="user" >User</option>';

              echo '<option value="admin" selected>Admin</option>';
            }
            ?>

          </select>
          <input type="submit" value="update" class=" btn btn-success btn-block mt-3 md-4">
        </form>
      </div>
    </div>
  <?php
} elseif ($page == "saveupdate") {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $oldid = $_POST['old_id'];
    $newid = $_POST['id'];
    $user = $_POST['user'];
    $email = $_POST['email'];

    $pass = $_POST['pass'];

    $status = $_POST['status'];

    $role = $_POST['role'];
    try {
      $statment = $connect->prepare("UPDATE customers
      SET customer_id=?,
      customername=?,
      email=?,
     `password`=?,
      `status`=?,
      `role`=?,
      updated_at=now()
      WHERE customer_id=?
     ");
      $statment->execute(array($newid, $user, $email, $pass, $status, $role, $oldid));
      $_SESSION['messege_user'] = "Updated  successfully";
      header("Location:customer.php");
    } catch (PDOException $e) {
      $_SESSION['error'] = "Duplicate ID";
      header("Location:customer.php?page=edit&user_id=$oldid ");
    }
  }
}

  ?>
  <?php
  include('includes/temp/footer.php');
}else{
  $_SESSION['login_error']="Login First";
  header("location:../login.php");
}
  ?>