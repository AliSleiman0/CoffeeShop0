<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <title>Document</title>
  <link rel="stylesheet" href="style22.css" />
</head>

<body class="">
  <?php session_start();?>
  
  <div class="container">
    <header>
      <div class="title">MENU ITEMS</div>
      <div class="icon-cart">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 16 16">
          <path fill="black"
            d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0a2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0a2 2 0 0 1-4 0" />
        </svg>
        <span>0</span>
      </div>
    </header>

    <div class="listProduct">
        <?php require ('products.php'); ?>
    </div>
  </div>
      <div class="cartTab">
        <h1>Shopping Cart</h1>
        <div class="listCart">
          <div class="item"></div>
        </div>
        <div class="btn">
          <button class="close">CLOSE</button>

          <button type="button" class="btn btn-primary checkoutbtn" id="checkoutbtn" data-bs-toggle="modal" data-bs-target="#confirmOrderModal">
            Check Out
          </button>
        </div>
      </div>
      
      <div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-labelledby="confirmOrderModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmOrderModalLabel">Confirm Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form to Submit Order -->
                            <form id="myForm" action="checkoutDB.php" method="POST">
                            <input type="hidden" name="jsonData" id="jsonData" class="carts-input" value="">
                                <div class="mb-3">
                                    <label for="customerName" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="customerName" name="customerName" value="<?php echo htmlspecialchars($_SESSION['name'], ENT_QUOTES); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customerNumber" class="form-label">Your Number</label>
                                    <input type="text" class="form-control" id="customerNumber" name="customerNumber" value="<?php echo htmlspecialchars($_SESSION['number'], ENT_QUOTES); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customerEmail" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="customerEmail" name="customerEmail" value="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="customerAddress" class="form-label">Your Address</label>
                                    <input type="Address" class="form-control" id="customerAddress" name="customerAddress"  required>
                                </div>
                                <div class="mb-3">
                                    <label for="customerPassword" class="form-label">Your Password</label>
                                    <input type="password" class="form-control" id="customerPassword" name="customerPassword" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary submitOrderButton">Submit Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           <script src="app.js" type="text/javascript"></script>
  <script>
              
     document.addEventListener("DOMContentLoaded", function () {
    var submitButton = document.querySelector(".submitOrderButton");
      
    // Add click event listener to the button
    submitButton.addEventListener("click", function (event) {
      // Prevent the default form submission
      event.preventDefault();
      //alert(carts);
      // Your custom action here
      console.log("Submit button clicked!");

      const myArray = [
        { productid: "12345", quantity: 2 },
        { productid: "54321", quantity: 1 },
        { productid: "98765", quantity: 3 },
      ];
      // Convert the array to a JSON string
      const jsonString = JSON.stringify(carts);

      // Set the value of the hidden input field to the JSON string
      document.getElementById("jsonData").value = jsonString;

      // Automatically submit the form
      document.getElementById("myForm").submit();
    });
  });
  </script>
   
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
  
 
  
</html>
