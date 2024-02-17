<html>
<head>
    <title>QUIZ GAME</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <style>
    .gradient-custom {
/* fallback for old browsers */
background: #6a11cb;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
}
</style>
</head>
<?php
#require "header.php";
?>
<body>
    <?php
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: index.php");
        exit;
    }
    else {
    
    
        echo "
        <section class=\"vh-100 gradient-custom\">
        <div class=\"container py-5 h-100\">
          <div class=\"row d-flex justify-content-center align-items-center h-100\">
            <div class=\"col-12 col-md-8 col-lg-5 col-xl-5\">
              <div class=\"card bg-dark text-white\" style=\"border-radius: 1rem;\">
                <div class=\"card-body p-5 text-center\">
      
                  <div class=\"mb-md-5 mt-md-4 pb-5\">
                  <form method=\"POST\" action=\"action.php\">
      
                    <h2 class=\"fw-bold mb-2 text-uppercase\">Login</h2>
                    <p class=\"text-white-50 mb-5\">Please enter Customer ID</p>
      
                    <div class=\"form-outline form-white mb-4\">
                      <input type=\"username\" id=\"typeUsername\" name=\"customer_id\" class=\"form-control form-control-lg\" />
                      <label class=\"form-label\" for=\"typeUsername\">UID</label>
                    </div>
      
                    <button class=\"btn btn-outline-light btn-lg px-5\" type=\"submit\">Proceed</button>
      
                  </form>
                  </div>
      
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
        ";
        
    }
    ?>
    
</body>
</html>
