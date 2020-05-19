<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Shopping Card</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!--link rel="stylesheet" href="indeksi.css"-->
    <link rel="stylesheet" href="istyle.css">

    <script src="https://kit.fontawesome.com/55fb307a8a.js" crossorigin="anonymous"></script>


  </head>

<?php
include_once("config.php");

$fajlli=fopen("file/studentet.txt","r");
$fshijtedhenat="TRUNCATE studentet;";
$conn->query($fshijtedhenat);

while(!feof($fajlli)) {
  $rreshti=fgets($fajlli);
  $varg=explode(" ",$rreshti);
  list($emri,$mbiemri)=$varg;

  $query="INSERT INTO studentet(emri,mbiemri) VALUES('$emri','$mbiemri')";
  $conn->query($query);
}

 ?>

    <?php include("contactUs.php"); ?>
  <?php if(strlen($div)>0){ ?>

  <body>
    <div style="margin-bottom:0px;" class="alert alert-<?= $msg_type ?>">
<button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php
         echo "<strong>".$div."</strong>";
       ?>

    </div>
<?php } ?>
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
        <?php printf("<a class='nav-link active' href='%s'>%s</a>",'index.php','Produktet') ?>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="servisimi.php">Sevisimi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="checkout.php">Blej</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item" class="badge badge-danger"></span></a>
      </li>
    </ul>
  </div>
</nav>


<?php
  session_start();
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    ?>
<span><a href="#" class="btn btn-info" style="float:right;" >I kyqur&nbsp;&nbsp;<i class="fas fa-user-circle"></i></a>
</span>
    <?php } ?>

<br><br>
<div class="container-fluid">
<br>
  <div class="row">
            <div class="col-lg-3">
              <h5>Perzgjedh Produktet</h5>
              <hr><br>
              <h6 class="text-info">Zgjedh Prodhuesin</h6>
              <ul class="list-group">
                <?php
                  include_once 'C:\xampp\htdocs\shopping\config.php';
                  $stmt=$conn->prepare("SELECT DISTINCT brand FROM product ORDER BY brand");
                  $stmt->execute();
                  $result=$stmt->get_result();
                  while($row=$result->fetch_assoc()){
                 ?>
                 <li class="list-group-item">
                   <div class="form-check">
                     <label class="form-check-label">
                       <input type="checkbox" class="form-check-input product_check" value="<?=
                       $row['brand']; ?>" id="brand"><?= $row['brand']; ?>
                     </label>
                   </div>
                 </li>
              <?php } ?>
              </ul>
              <br>
              <h6 class="text-info">Zgjedh Kapacitetin</h6>
            <ul class="list-group">
              <?php
                $sql = "SELECT DISTINCT storage FROM product ORDER BY storage desc";
                $result = $conn->query($sql);
                while($row=$result->fetch_assoc()){
               ?>
               <li class="list-group-item">
                 <div class="form-check">
                   <label class="form-check-label">
                     <input type="checkbox" class="form-check-input product_check" value="<?=
                     $row['storage']; ?>" id="storage"><?= $row['storage']; ?>
                   </label>
                 </div>
               </li>
            <?php } ?>
            </ul>


            </div>


    <div class="col-lg-9">
        <h5 class="text-center" id="textChange">Produktet</h5>
        <hr>
        <div class="text-center">
          <img src="../img/loader.gif" id="loader" width="200" style="display:none;" >
        </div>
        <div id="message"> </div>

      <div class="row" id="result">
      <?php
        include_once 'C:\xampp\htdocs\shopping\config.php';
        $stmt=$conn->prepare("SELECT * FROM product");
        $stmt->execute();
        $result=$stmt->get_result();
        while($row=$result->fetch_assoc()):
       ?>
       <div class="col-md-3 mb-2">
         <div class="card-deck">
           <div class="card p-2 border-secondary mb-2">
             <img src="<?= $row['product_image'] ?>" height="300" class="card-img-top">
             <div class="card-body p-1">
               <h5 class="card-title text-center text-white" style="border-radius:5px;background:#01678f;padding-top:3px;padding-bottom:3px;"><?= $row['product_name'] ?> </h5>
               <h6 class="card-title text text">Kapaciteti:&nbsp;<?= $row['storage'] ?> </h6>
               <h6 class="card-title text text">Bateria:&nbsp;<?= $row['batery'] ?></h6>
               <h6 class="card-title text text">Ekrani:&nbsp;<?= $row['screen_size'] ?></h6>

               <h5 class="card-text text text-danger"><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2) ?> </h5>
             </div>
             <div class="card-footer p-1">
               <form action="index.html"class="form-submit">
                 <input type="hidden" class="pid" value="<?= $row['idproduct'] ?> ">
                 <input type="hidden" class="pname" value="<?= $row['product_name'] ?> ">
                 <input type="hidden" class="pprice" value="<?= $row['product_price'] ?> ">
                 <input type="hidden" class="pimage" value="<?= $row['product_image'] ?> ">
                 <input type="hidden" class="pcode" value="<?= $row['product_code'] ?> ">
                 <button class="btn btn btn-block addItemBtn" style="background:#1c8f01;color:white;"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Shto ne shporte</button>
               </form>
             </div>
           </div>
         </div>
       </div>
     <?php endwhile; ?>
     </div>
    </div>
    </div>
</div>

<!-- Contact-->

<section class="page-section" id="contact" style="margin-top:5em;">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase" style="color:white;font-weight: 400;">Na Kontaktoni</h2>
                    <h5 class="section-subheading text-muted" style="font-family:cursive;">Qendroni afer nesh permes kontaktit</h5>
                </div>

                <form id="contactForm" name="sentMessage" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <div class="row align-items-stretch mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" id="name" type="text" name="name" placeholder="Emri juaj *" value="<?= $name ?>" >
                                <?php if(strlen($name_error)>0){ ?><p  style="background:#b80000;border-radius:5px;" class="help-block text-white">&nbsp;&nbsp;<?= $name_error ?></p> <?php } ?>
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="email" type="email" name="email" placeholder="Email-i juaj *" value="<?= $email ?>">
                               <?php if(strlen($email_error)>0){ ?>  <p style="background:#b80000;border-radius:5px;" class="help-block text-white">&nbsp;&nbsp;<?= $email_error ?></p> <?php } ?>
                            </div>
                            <div class="form-group mb-md-0">
                                <input class="form-control" id="phone" type="tel" name="phone" placeholder="Nr.i telefonit *" value="<?= $phone ?>">
                                <?php if(strlen($phone_error)>0){ ?>  <p style="background:#b80000;border-radius:5px;" class="help-block text-white">&nbsp;&nbsp;<?= $phone_error ?></p> <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-textarea mb-md-0" >
                                <textarea class="form-control" id="message" name="message" placeholder="Mesazhi *"></textarea>
                                <?php if(strlen($message_error)>0){ ?><p style="background:#b80000;border-radius:5px;" class="help-block text-white">&nbsp;&nbsp;<?= $message_error; ?></p><?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" style="margin-top:20px;">
                        <div id="success"></div>
                        <a href="#contactForm"><button class="btn12" id="sendMessageButton" type="submit" name="submit" >Dergo</button></a>
                    </div>
                </form>
            </div>
        </section>
       <!-- footer Start
        ====================================================================== -->

      <section>
          <div id="s1">
            <p class="fl-left">Copyright &copy; 2020  <a href="https://www.os-templates.com/" class="a1">Domain Name</a> - All Rights Reserved</p>
            <p class="fl-right">Template by <a href="https://www.os-templates.com/" class="a1" title="Free Website Templates">OS Templates</a></p>
          </div>
      </section>
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $(".addItemBtn").click(function(e){
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pimage = $form.find(".pimage").val();
      var pcode = $form.find(".pcode").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {pid:pid, pname:pname, pprice:pprice, pimage:pimage, pcode: pcode},
        success: function(response){
          $("#message").html(response);
          window.scrollTo(0,0);
          load_cart_item_number();
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
<script type="text/javascript">
         $(document).ready(function(){

           $(".product_check").click(function(){
             $("#loader").show();

             var actionn = 'data';
             var brand = get_filter_text('brand');
             var storage = get_filter_text('storage');

             $.ajax({
                 url: 'action.php',
                 method: 'POST',
                 data:{actionn:actionn,brand:brand,storage:storage},
                 success:function(response){
                   $("#result").html(response);
                   $("#loader").hide();
                   }
             });

           });

           function get_filter_text(text_id){
             var filterData = [];
             $('#'+text_id+':checked').each(function(){
               filterData.push($(this).val());

             });
               return filterData;
           }

         });
</script><!-- -->
  </body>
</html>
