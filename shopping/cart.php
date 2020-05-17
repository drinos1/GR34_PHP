

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Shporta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/55fb307a8a.js" crossorigin="anonymous"></script>


  </head>
  <body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark" style="margin-bottom:15px;">
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
        <a class="nav-link" href="checkout.php">Blej</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger"></span></a>
      </li>
    </ul>
  </div>
</nav>
<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
<a href="logout.php" class="btn btn-outline-danger" style="float:right;margin-left:5px;margin-right:5px;">Shkyqu <i class="fas fa-sign-out-alt"></i></a>
<?php } ?>

<?php

  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    ?>
<span><a href="#" class="btn btn-info" style="float:right;" >I kyqur&nbsp;&nbsp;<i class="fas fa-user-circle"></i></a>
</span>
    <?php } ?>


<div class="container" style="margin-top:7em;">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div style="display:<?php if(isset($_SESSION['showAlert'])){echo $_SESSION['showAlert'];} else{ echo 'none'; } unset($_SESSION['showAlert']); ?>; "
        class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>
          <?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} unset($_SESSION['showAlert']); ?>
        </strong>
      </div>
      <div class="table-responsive mt-2">
        <table class="table table-bordered table-striped text-center">
          <thead>
            <tr>
              <td colspan="7">
                <h4 class="text-center text-info m-0">Produktet ne shporten tuaj!</h4>
              </td>
            </tr>
            <tr>
              <th>ID</th>
              <th>Fotografia</th>
              <th>Produkti</th>
              <th>Cmimi</th>
              <th>Sasia</th>
              <th>Cmimi Total</th>
              <th>
                <a href="action.php?clear=all" class="badge-danger badge p-1"
                onclick="return confirm('A jeni te sigurt qe doni te fshini shporten tuaj? ');">
                  <i class="fas fa-trash"></i>&nbsp;&nbsp;Fshije shporten</a>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
              require 'config.php';
              $stmt = $conn->prepare("SELECT * FROM cart");
              $stmt->execute();
              $result = $stmt->get_result();
              $grand_total = 0;
              while($row = $result->fetch_assoc()):
             ?>
             <tr>
               <td><?= $row['idcart'] ?></td>
               <input type="hidden" class="pid" value="<?= $row['idcart'] ?>">
               <td><img src="<?= $row['product_image'] ?>" width="50"></td>
               <td><?= $row['product_name'] ?></td>
               <td><i class="fas fa-euro-sign"></i>&nbsp;<?= number_format((int)$row['product_price'],2) ?></td>
               <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
               <td><input type="number" class="form-control itemQty" value="<?= $row['qty']?>" style="width: 75px;">  </td>
               <td><i class="fas fa-euro-sign"></i>&nbsp;<?= number_format((int)$row['total_price'],2);?></td>
               <td>
                 <a href="action.php?remove=<?= $row['idcart'] ?>" class="text-danger lead" onclick="return confirm('A deshironi ta fshini produktin ?');">
                 <i class="fas fa-trash-alt"></i></a>
               </td>
             </tr>
             <?php $grand_total += (int)$row['total_price']; ?>
          <?php endwhile;  ?>
          <tr>
            <td colspan="3">
              <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Kthehu te produktet</a>
            </td>
            <td colspan="2"> <b>Totali</b> </td>
            <td><i class="fas fa-euro-sign"></i>&nbsp;<?= number_format($grand_total,2); ?></td>
            <td>
              <a href="checkout.php" class="btn btn-info"><i class="fas fa-credit-card"></i>&nbsp;&nbsp;Blej</a>
            </td>
          </tr>
          </tbody>
        </table>

      </div>
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

    $(".itemQty").on('change',function(){
      var $el = $(this).closest('tr');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'action.php',
        method: 'post',
        cache: false,
        data: {qty:qty,pid:pid,pprice:pprice},
        success: function(response) {
          console.log(response);
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
