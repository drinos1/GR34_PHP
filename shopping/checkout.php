<?php
  require 'config.php';

  // Initialize the session
  session_start();

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }

  $grand_total = 0;
  $allItems = '';
  $items = array();

  $sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt -> get_result();
  while($row = $result -> fetch_assoc()){
    $grand_total += (int)$row['total_price'];
    $items[] = $row['ItemQty'];

  }
  $allItems = implode(", ", $items);

 ?>

 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/55fb307a8a.js" crossorigin="anonymous"></script>


  </head>
  <body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="../homepage1/index.php"><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;App Team</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Produktet</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="servisimi.php">Servisimi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="checkout.php">Blej</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger"></span></a>
      </li>
    </ul>
  </div>
</nav>

<div class="container" style="margin-top:3.5em;">
  <div class="row justify-content-center">
    <div class="col-lg-6 px-4 pb-4" id="order">
      <h4 class="text-center text-info p-2">Kompletoni porosine tuaj!</h4>
      <div class="jumbotron p-3 mb-2 text-center">
        <h6 class="lead"><b>Produkti : </b><?= $allItems; ?></h6>
        <h6 class="lead"><b>Delivery charge: </b> Free</h6>
        <h5><b>Shuma per te paguar: </b><i class="fas fa-euro-sign"></i>&nbsp;<?= number_format($grand_total,2)?> </h5>
      </div>
      <form id="placeOrder" action="" method="post">
        <input type="hidden" name="products" value="<?= $allItems; ?>">
        <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">

        <div class="form-group">
          <input type="text" name="name" class="form-control" placeholder="Shkruaj emrin" required>
        </div>

        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Shkruaj email-in" required>
        </div>

        <div class="form-group">
          <input type="tel" name="phone" class="form-control" placeholder="Shkruaj numrin e telefonit" required>
        </div>

        <div class="form-group">
          <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Shkruaj adresen e dorezimit ketu... "></textarea>
        </div>
        <h6 class="text-center lead">Zgjedh llojin e pageses</h6>
        <div class="form-group">
          <select class="form-control" name="pmode">
              <option value="" selected disabled>Zgjedh llojin e pageses</option>
              <option value="Pagesa pas dorezimit">Pagesa pas dorezimit</option>
              <option value="Net Banking">Net Banking</option>
              <option value="Debit/Credit Card">Debit/Credit Card</option>
          </select>
        </div>
        <div class="form-group">
          <input type="submit" name="submit" value="Porosit" class="btn btn-danger btn-block">
        </div>
      </form>
    </div>

  </div>

</div>
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

    $("#placeOrder").submit(function(e){
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize()+"&action=order",
        success: function(response){
          $("#order").html(response);
        }
      });

    });
    load_cart_item_number();

    function load_cart_item_number(){
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {cartItem: "cart_item"},
        success: function(response){
          $("#cart-item").html(response);
        }
      });
    }
  });

</script>
  </body>
</html>
