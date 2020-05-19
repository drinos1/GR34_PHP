<?php
  session_start();
  require 'config.php';

  if(isset($_POST['pid'])){
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pimage = $_POST['pimage'];
    $pcode = $_POST['pcode'];
    $pqty = 1;

    $stmt = $conn->prepare("SELECT product_code FROM cart WHERE product_code=?");

    $stmt->bind_param("s", $pcode);
    $stmt->execute();
    $res = $stmt->get_result();
    $r = $res->fetch_assoc();
    $code = $r['product_code'];

    if(!$code){

      $query = $conn->prepare("INSERT INTO cart(product_name, product_price, product_image, qty, total_price, product_code) VALUES (?,?,?,?,?,?)");
      $query->bind_param("sssiss", $pname, $pprice, $pimage, $pqty, $pprice, $pcode);
      $query->execute();

      echo '<div class="alert alert-success alert-dismissible mt-2">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Item added to your cart!</strong> Indicates a successful or positive action.
            </div>';

    }
    else{
      echo '<div class="alert alert-danger alert-dismissible mt-2">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Item already added to your cart!</strong> Indicates a successful or positive action.
            </div>';
    }
  }

  if(isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item'){
    $stmt = $conn->prepare("SELECT * FROM cart");
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;

    echo $rows;
  }

  if(isset($_GET['remove'])){
    $id = $_GET['remove'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE idcart=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();

    $_SESSION['showAlert']='block';
    $_SESSION['message']='Produkti u hoq nga shporta !';
    header('location:cart.php');

  }

  if(isset($_GET['clear'])){

    $stmt = $conn->prepare("DELETE FROM cart");
    $stmt->execute();
    $_SESSION['showAlert']='block';
    $_SESSION['message']='Te gjitha produktet u hoqen nga shporta !';
    header('location:cart.php');

  }

  if(isset($_POST['qty'])){

    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];

    $tprice = $qty * $pprice;

    $stmt = $conn->prepare("UPDATE cart SET qty=?, total_price=? WHERE idcart=?");
    $stmt->bind_param("isi",$qty,$tprice,$pid);
    $stmt->execute();
  }

  if(isset($_POST['action']) && isset($_POST['action']) == 'order'){
     $name = $_POST['name'];
     $email = $_POST['email'];
     $phone = $_POST['phone'];
     $products = $_POST['products'];
     $grand_total = strval($_POST['grand_total']);
     $address = $_POST['address'];
     $pmode = $_POST['pmode'];

     $data = '';

     $query = $conn->prepare("INSERT INTO orders(name, email, phone, address, pmode, products,amount_paid) VALUES (?,?,?,?,?,?,?)");
     $query->bind_param("sssssss", $name, $email, $phone, $address, $pmode, $products,$grand_total);
     $query->execute();



     $data .= ' <br><br><br><div class="text-center">
                  <h1 class="display-4 mt-2 text-danger">Faleminderit!</h1>
                  <h2 class="text-success">Porosia juaj u krye me sukses</h2>
                  <h4 class="bg-danger text-light rounded p-2">Artikujt e blere: '.$products.'</h4>
                  <h4>Emri juaj: '.$name.'</h4>
                  <h4>Email-i juaj: '.$email.'</h4>
                  <h4>Numri i telefonit: '.$phone.'</h4>
                  <h4>Totali i paguar: '.number_format($grand_total,2).'</h4>
                  <h4>Lloji i pageses: '.$pmode.'</h4>
                </div>';

    echo $data;
   }


   if (isset($_POST['actionn'])) {

    $sql = "SELECT * FROM product WHERE storage !='' ";

    if (isset($_POST['brand'])){
      $brand = implode("','", $_POST['brand']);
      $sql .= "AND brand IN('".$brand."')";
    }

    if (isset($_POST['storage'])){
      $storage = implode("','", $_POST['storage']);
      $sql .= "AND storage IN('".$storage."')";
    }

    $result = $conn->query($sql);
    $output = '';

    if ($result->num_rows>0) {
      while ($row=$result->fetch_assoc()) {
        $output .= '<div class="col-md-3 mb-2">
         <div class="card-deck">
           <div class="card p-2 border-secondary mb-2">
             <img src=" '.$row['product_image'].' " height="300" class="card-img-top">
             <div class="card-body p-1">
               <h5 class="card-title text-center text-white" style="border-radius:5px;background:#01678f;padding-top:3px;padding-bottom:3px;">'.$row['product_name'].'</h5>
               <h6 class="card-title text text">Kapaciteti:&nbsp; '.$row['storage'].'  </h6>
               <h6 class="card-title text text">Bateria:&nbsp;'.$row['batery'].'</h6>
               <h6 class="card-title text text">Ekrani:&nbsp;'.$row['screen_size'].'</h6>
               <h5 class="card-text text text-danger"><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;'.number_format($row['product_price'],2).' </h5>
             </div>
             <div class="card-footer p-1">
               <form action="index.html"class="form-submit">
                 <input type="hidden" class="pid" value="'.$row['idproduct'].'">
                 <input type="hidden" class="pname" value="'.$row['product_name'].'">
                 <input type="hidden" class="pprice" value="'.$row['product_price'].'">
                 <input type="hidden" class="pimage" value="'.$row['product_image'].'">
                 <input type="hidden" class="pcode" value="'.$row['product_code'].'">
                 <button class="btn btn btn-block addItemBtn" style="background:#1c8f01;color:white;"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Shto ne shporte</button>
               </form>
             </div>
           </div>
         </div>
       </div>';
      }
    }
    else{
      $output = "<h3>Nuk u gjend asnje produkt</h3>";
    }
    echo $output;
  }



  if (isset($_POST['aksioni'])) {

   $sql = "SELECT * FROM servisim WHERE cmimi !='' ";

   if (isset($_POST['lloji'])){
     $lloji = implode("','", $_POST['lloji']);
     $sql .= "AND lloji IN('".$lloji."')";
   }

   $result = $conn->query($sql);
   $output = '';

   if ($result->num_rows>0) {
     while ($row=$result->fetch_assoc()) {
       $output .= '<div class="col-md-3 mb-2">
         <div class="card-deck">
           <div class="card p-2 border-secondary mb-2">
             <img src=" '.$row['foto'].' " height="300" class="card-img-top">
             <div class="card-body p-1">
               <h5 class="card-title text-center text-white" style="border-radius:5px;background:#01678f;padding-top:3px;padding-bottom:3px;"> '.$row['emri'].'  </h5>
               <h5 class="card-title text-center text-danger"><img src=" '.$row['ikona'].' " height="20" width="20" alt="" >  &nbsp; '.$row['lloji'].' :&nbsp;&nbsp;<i class="fas fa-euro-sign"></i>&nbsp;'.number_format($row['cmimi'],2).'</h5>
             </div>
           </div>
         </div>
       </div>';
    }}
    else{
     $output = "<h3>Nuk u gjend asnje produkt</h3>";
   }
   echo $output;
  }



 ?>
