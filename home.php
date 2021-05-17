<?php
session_start();
?>

<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato:300'>
      <link rel="stylesheet" type="text/css" href="style.css">
      <style>
         body {
         margin: 0;
         font-family: Arial, Helvetica, sans-serif;
         }
         .mt-5
         {
          margin-top: 3rem !important;
         }
         
         #p1, #p2, #p3
         {
         color: #FF0000;
         }
        label.error {
    color: red;
    font-size: 1rem;
    size: small
}

label.error.fail-alert {
    
    border-radius: 4px;
    line-height: 1;
    padding: 2px 0 6px 6px;
   
}

input.valid.success-alert {
    border: 2px solid #4CAF50;
    color: green;
}

input.error, textarea.error {
    border: 1px solid red;
    font-weight: 300;
    color: red;
}
       
      </style>
      
      <script type="text/javascript">
    $(document).ready(function() {
  $("#basic-form").validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      m1name: {
        required: true,
        minlength: 3
      },
      m2name: {
        required: true,
        minlength: 3
      },
      m3name: {
        required: true,
        minlength: 3
      },
      email: {
        required: true,
        email: true
      },
      phone:{
        required:true,
        number:true,
        minlength:10,
        maxlength:10
      },
      domain:{
        required:true
      },
      rollno:{
        required:true,
        minlength:3,
        maxlength:3,
        number:true
      },
      description:{
        required:true
      },
      datafile:{
        required:true
      }
      },
    messages : {
      name: {
        minlength: "Name should be at least 3 characters"
      },
      m1name: {
        minlength: "Name should be at least 3 characters"
      },
      m2name: {
        minlength: "Name should be at least 3 characters"
      },
      m3name: {
        minlength: "Name should be at least 3 characters"
      },
   
      email: {
        email: "The email should be in the format: abc@domain.tld"
      },
      phone:{
        required: "Please enter your phone number",
        number: "Please enter your number as a numerical value",
        minlength:"Number should be 10 characters",
        maxlength:"Number should be 10 characters"
      },
      domain:{
        required: "Please select your domain"
      },
      rollno:{
        required:"Please enter your roll number",
        minlength:"length of roll number must be 3",
        maxlength:"roll number must be 3 characters",
        number:"no characters are allowed"
      },
      description:{
        required:"Please enter description "
      },
      datafile:{
        required:"upload file"
      }
    }
  });
});

  </script>
      </script>
   </head>
   <body>
    <section style=" padding: 2%">
      <nav class="navbar navbar-expand-lg navbar-light "style="background-color: #e3f2fd;">
      <a class="navbar-brand" style="background-color:#039BE6 ;border-radius: 2% ;padding-right: 1%">
        <img src="./assets/image/projecticon.png" width="30" height="30" class="d-inline-block align-top" alt="" >
      project</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav"  >
      
          <a class="nav-link active" href="home.html">Home </a>
          <a class="nav-link" href="faq.html" style="color: #01579B">FAQ</a>
          <a class="nav-link" href="faculty.html" style="color:#01579B ">Faculty</a>
          <a class="nav-link " href="#" tabindex="-1" aria-disabled="true" >All groups</a>
  
        </div>
      </div>
    </nav>  
    </section>   
      <div class="container register mt-5">
         <div class="row">
            <div class="col-md-3 register-left">
               <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
               <h3>Welcome</h3>
               <p>Upload your project details</p>
            </div>
            <div class="col-md-9 register-right">
               <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                     <h3 class="register-heading">Add your project</h3>
                      <div>
                        <?php
                          if(isset($_SESSION['result']))
                          {
                            echo "<p class='alert-success p-1 rounded'>".$_SESSION['result']."</p>";
                          }
                        ?>
                      </div>
                   <form id="basic-form" 
                   action="config.php" method="post" enctype="multipart/form-data">
                     <div class="row register-form" >
                        <div class="col-md-6">
                           <div class="form-group">
                              <input  type="text" class="form-control" id="name" placeholder="Leader Name" name="name"/>
                           </div>
                           <div class="form-group">
                              <input type="text" class="form-control"id="m1name" placeholder="Member1 Name" name="m1name"/>
                             
                           </div>
                           <div class="form-group">
                              <input type="text" class="form-control"id="m2name" placeholder="Member2 Name" name="m2name"/>
                             
                           </div>
                           <div class="form-group">
                              <input type="text" class="form-control"id="m3name" placeholder="Member3 Name" name="m3name"/>
                             
                           </div>
                           <div class="form-group">
                          <textarea class="form-control" id="description" rows="3" placeholder="write some description of your project" name="description"></textarea>
                        </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="Your Email *" id="email" name="email" />
                              
                           </div>
                           <div class="form-group">
                              <input type="number" name="phone" id="phone" class="form-control" placeholder="Your Phone *" value="Enter Phone Number" />
                          
                           </div>
                           <div class="form-group">
                              <select class="form-control" id="domain" name="domain">
                                 <option class="hidden"  selected disabled value="">Please select your Domain</option>
                                 <option value="AI">AI</option>
                                 <option value="ML">ML</option>
                                 <option value="Smart City">Smart City</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="roll number *" id="rollno" name="rollno" /> 
                           </div>
                           <div class="form-group">
                              <input type="file" class="form-control" id="datafile" name="datafile" />
                           </div>   
                           <div class="form-group">
                              <input type="submit" class="btn btn-primary btn-block submit" value="SUBMIT" name="register_submit"/>
                        </div> 
                        </div> 
                                         
                      </div>
                   </form>
                    </div>
                  </div>
               </div>
            </div>
         </div>
     
       <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js'></script>
   </body>
</html>