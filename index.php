<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="title icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Sarwaya</title>
  </head>
  <body>

    <!-- header -->
    <header>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg fixed-top nav-menu">
    <a href="#" class="navbar-brand js-scroll-trigger text-light text-capitalize"><span class="h2 font-weight-bold text-primary">Sarwaya</span></a>
    <button class="navbar-toggler nav-button" type="button" data-toggle="collapse" data-target="#myNavbar">
      <div class="bg-light line1"></div>
      <div class="bg-light line2"></div>
      <div class="bg-light line3"></div>
    </button>
    <div class="collapse navbar-collapse justify-content-end text-capitalize font-weight-bold" id="myNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="#home" class="nav-link m-2 menu-item nav-active js-scroll-trigger">Home</a>
        </li>
        <li class="nav-item">
          <a href="#about" class="nav-link m-2 menu-item js-scroll-trigger">About</a>
        </li>
        <li class="nav-item">
          <a href="#contact" class="nav-link m-2 menu-item js-scroll-trigger">Contact</a>
        </li>
      </ul>
    </div>
    </nav>

    <!-- end of navbar -->


    <!-- banner -->
    <div class="text-light text-md-right text-center banner" id="home">
        <h2 class="lead banner-heading font-weight-bold">Welcome on Sarwaya</h2>
        <h1 class="text-primary display-4 banner-heading">Where would you like to  <span class="text-capitalize">go?</span></h1>
        <p class="lead banner-par">The safest way to buy e-tickets.</p>
      </div>
    <!-- end of banner -->


    </header>
    <!-- end of header -->

    <!-- missions -->
    <section class="p-5 mission" id="about">
      <div class="container-fluid">
        <!-- title -->
        <div class="row text-dark text-center">
          <div class="col m-4">
            <h1 class="display-4 mb-4 text-primary">About Us</h1>
            <div class="underline mb-4"></div>
            <p class="lead">Sarwaya is a safe, convenient and fair place to buy e-tickets. Fraud is prevented by strict checks and collaborations with organisations and partners.!</p>
          </div>
        </div>
        <!-- end of title -->
        <div class="row my-5">
          <div class="col-md-4 text-center">
            <i class="fas fa-cogs fa-5x text-primary mb-4"></i>
            <h1 class="text-primary mb-3">Safe</h1>
            <p class="text-muted">Sarwaya is safe. The tickets and sellers on our platform are verified based on several criteria. 
            Through partnerships with organizations and ticket providers, we offer Secure Swap tickets which are 100% valid..</p>
          </div>
          <div class="col-md-4 text-center">
            <i class="far fa-thumbs-up fa-5x text-primary mb-4"></i>
            <h1 class="text-primary mb-3">Easy</h1>
            <p class="text-muted">Listing a ticket can be done in a few clicks. Simply upload your ticket and provide the required information.
            After this, you can sit back and relax - you will be notified when your ticket has been sold and we will transfer the money to your
            bank account the next possible business day. </p>
          </div>
          <div class="col-md-4 text-center">
            <i class="far fa-handshake fa-5x text-primary mb-4"></i>
            <h1 class="text-primary mb-3">Fair</h1>
            <p class="text-muted">As a Sarwaya user you know you’ll always be paying a fair price for your tickets.
            We protect buyers from overpricing by keeping to a maximum 20% above the original price.
            As a buyer, you know you'll always be paying a fair price for tickets.</p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 text-center mb-4">
            <img src="image/car2.png" width="350" class="img-fluid camera-img">
          </div>
          <div class="col-lg-7 text-dark text-lg-right text-center mission-text">
            <h1>We know what we do</h1>
            <p class="lead">Lorem ipsum dolor sit amet consectetur 
            adipisicing elit. Mollitia, blanditiis. 
            Eos, atque quaerat, iure, nesciunt commodi
            delectus accusantium labore deserunt neque excepturi est
            doloremque impedit veritatis similique reiciendis quasi. Perferendis.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- end of missions -->  
    
    <!-- contact -->
    <section class="contact p-5" id="contact">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5 pb-4">
            <h3 class="display-4 mb-5 text-primary">Get In Touch</h3>
            <form class="contact-form">
              <div class="form-group py-4">
                <input type="text" class="form-control my-2 p-2 input" placeholder="Name">
                <label for="name" class="label">Name</label>
              </div>
            </form>
            <form class="contact-form">
              <div class="form-group py-4">
                <input type="email" class="form-control my-2 p-2 input" placeholder="Email Address">
                <label for="email" class="label">Email Address</label>
              </div>
              <div class="form-group py-4">
                <input type="message" class="form-control my-2 p-2 input" placeholder="Message">
                <label for="message" class="label">Message</label>
              </div>
              <div class="form-group py-4 my-4">
                <input type="checkbox" checked>
                <label for="check" class="text-white">Send Announcements</label>
              </div>
              <button type="submit" class="btn btn-block p-2 btn-primary font-weight-bold text-uppercase submit-button">Send</button>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- end of contact -->

    <!-- footer -->
    <footer class="bg-dark px-5">
      <div class="container-fluid">
        <div class="row text-light py-4">
          <div class="col-lg-4 col-sm-6">
            <h5 class="pb-3">About Us</h5>
            <p class="small">Sarwaya is a safe, convenient and fair place to buy e-tickets. Fraud is prevented by strict checks and collaborations with organisations and partners.!</p>
          </div>
          <div class="col-lg-2 col-sm-6">
            <h5 class="pb-3">Visit Us</h5>
            <ul class="list-unstyled">
              <li>
                <a href="#home" class="footer-link">Home</a>
              </li>
              <li>
                <a href="#about" class="footer-link">About</a>
              </li>

              <li>
                <a href="#contact" class="footer-link">Contact</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-2 col-sm-6">
            <h5 class="pb-3">Need Help?</h5>
            <ul class="list-unstyled">
              <li>
                <a href="#" class="footer-link text-upppercase">Customer Service</a>
              </li>
              <li>
                <a href="#" class="footer-link text-upppercase">Online Chat</a>
              </li>
              <li>
                <a href="#" class="footer-link text-upppercase">Support</a>
              </li>
              <li>
                <a href="#" class="text-info">sarwaya@gmail.com</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-4 col-sm-6">
            <h5 class="pb-3">Stay Connected</h5>
            <p class="small">Reach us on give email address and phone number for any inquiry and lets help you</p>
            <a href="login.php" class="text-primary">Log In</a>
            <ul class="list-inline">
              <li class="list-inline-item"><i class="fab fa-facebook-square fa-2x text-primary"></i></li>
              <li class="list-inline-item"><i class="fab fa-google-plus fa-2x text-danger"></i></li>
              <li class="list-inline-item"><i class="fab fa-instagram fa-2x text-danger"></i></li>
              <li class="list-inline-item"><i class="fab fa-twitter fa-2x text-info"></i></li>
              <li class="list-inline-item"><i class="fab fa-youtube fa-2x text-danger"></i></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col text-center text-light border-top pt-3">
            <p>&copy; 2019 Copyright, All Rights Reserved</p>
          </div>
        </div>
      </div>
    </footer>
    <!-- end of footer -->

    <script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" 
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
    <script src="script.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  </body>
  </body>
</html>