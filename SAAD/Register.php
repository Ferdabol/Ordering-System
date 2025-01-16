<?php
  include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
	<link rel="stylesheet" href="employee.css">
    <style>
        *{
            color: white;
        }

        input{
            background-color: rgb(240, 248, 255,0.2);
        }
    </style>
</head>
<body>
    <div style="position: fixed;top: 30px;left: 30px;color: white;">
        <button class="btn btn-success"><a href="LogIn.php" style="color: white;"> Login</a></button>
    </div>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
          <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
              <div class="card shadow-2-strong card-registration">
                <div class="card-body p-4 p-md-5">
                  <h3 class="mb-4 pb-2 pb-md-0 mb-md-5" style="color: black;">Registration Form</h3>
                  <form method="post">
      
                    <div class="row">
                      <div class="col-md-6 mb-4">
      
                        <div  class="form-outline">
                          <input type="text" id="firstName" class="form-control form-control-lg" placeholder="Firstname" name="firstname" required/>
                          <label class="form-label" for="firstName">First Name</label>
                        </div>
      
                      </div>
                      <div class="col-md-6 mb-4">
      
                        <div class="form-outline">
                          <input type="text" id="lastName" class="form-control form-control-lg" placeholder="Lastname" name="lastname" required/>
                          <label class="form-label" for="lastName">Last Name</label>
                        </div>
      
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
        
                          <div  class="form-outline">
                            <input type="password" id="firstName" class="form-control form-control-lg" placeholder="Password" name="password" required/>
                            <label class="form-label" for="firstName">Password</label>
                          </div>
        
                        </div>
                        <div class="col-md-6 mb-4">
        
                          <div class="form-outline">
                            <input type="password" id="lastName" class="form-control form-control-lg" placeholder="Re-Enter Password" name="repassword" required/>
                            <label class="form-label" for="lastName">Re-Enter Password</label>
                          </div>
        
                        </div>
                      </div>
      
                    <div class="row">
                      <div class="col-md-6 mb-4 d-flex align-items-center">
      
                        <div class="form-outline datepicker w-100">
                          <input type="email" class="form-control form-control-lg" placeholder="Email" id="email" name="email" required/>
                          <label for="email" class="form-label">Email</label>
                        </div>
      
                      </div>
                      <div class="col-md-6 mb-4">
                        <input type="email" class="form-control form-control-lg" placeholder="Phone Number" id="email" name="email" required/>
                        <label for="email" class="form-label">Phone Number</label>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
        
                          <div  class="row form-outline p-3">
                            <label class="form-label" for="firstName">Country</label>
                            <select name="country" class="btn btn-light" required>
                                <option value="">Select Country</option>
                                <option value="Philippines">Philippines</option>
                                <option value="United States">United States</option>
                                <option value="China">China</option>
                                <option value="Spain">Spain</option>
                                <option value="India">India</option>
                                <option value="France">France</option>
                                <option value="Egypt">Egypt</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Russia">Russia</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Germany">Germany</option>
                                <option value="Japan">Japan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Italy">Italy</option>
                                <option value="Turkey">Turkey</option>
                                <option value="South Korea">South Korea</option>
                                <option value="Canada">Canada</option>
                                <option value="Australia">Australia</option>
                                <option value="Mexico">Mexico</option>
                            </select>
                          </div>
        
                        </div>
                        <div class="col-md-6 mb-4">
        
                            <div  class="row form-outline p-3">
                              <label class="form-label" for="firstName">Language</label>
                              <select name="language" class="btn btn-light" required>
                                <option value="">Select Language</option>
                                <option value="English">English</option>
                                <option value="Tagalog">Tagalog</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Hindi">Hindi</option>
                                <option value="French">French</option>
                                <option value="Standard Arabic">Standard Arabic</option>
                                <option value="Bengali">Bengali</option>
                                <option value="Russian">Russian</option>
                                <option value="Portuguese">Portuguese</option>
                                <option value="Indonesian">Indonesian</option>
                                <option value="Urdu">Urdu</option>
                                <option value="German">German</option>
                                <option value="Japanese">Japanese</option>
                                <option value="Swahili">Swahili</option>
                                <option value="Marathi">Marathi</option>
                                <option value="Telugu">Telugu</option>
                                <option value="Wu">Wu Chinese</option>
                                <option value="Turkish">Turkish</option>
                                <option value="Korean">Korean</option>
                                <option value="Italian">Italian</option>
                              </select>
                            </div>
          
                          </div>
                      </div>
      
                    <div class="row">
                      <div class="col-md-6 mb-4 pb-2">

                        <div class="form-outline">
                          <input type="email"  class="form-control form-control-lg" name="email" required/>
                          <label class="form-label" >Email</label>
                        </div>
      
                      </div>
                      <div class="col-md-6 mb-4 pb-2">
      
                        <div class="form-outline">
                          <input type="number"  class="form-control form-control-lg" name="number" required/>
                          <label class="form-label" >Phone Number</label>
                        </div>
      
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4 pb-2">
  
                          <div class="form-outline">
                            <input type="text" class="form-control form-control-lg" name="address" required/>
                            <label class="form-label" >Address</label>
                          </div>
        
                        </div>
                        <div class="col-md-6 mb-4 pb-2">
        
                          <div class="row form-outline">
                            <select name="toe" class="btn btn-light" required>
                              <option value="">Select Type of Employment</option>
                              <option value="Full Time">Full Time</option>
                              <option value="Part Time">Part Time</option>
                              <option value="Contract">Contract</option>
                              <option value="Temporary">Temporary</option>
                              <option value="Freelance/Self-employed">Freelance/Self-employed</option>
                              <option value="Internship">Internship</option>
                              <option value="Apprenticeship">Apprenticeship</option>
                              <option value="Permanent">Permanent</option>
                              <option value="Zero-hour contract">Zero-hour contract</option>
                              <option value="Seasonal">Seasonal</option>
                            </select>
                          </div>
        
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4 pb-2">
  
                          <div class="form-outline">
                            <input type="text" class="form-control form-control-lg" placeholder="Optional" name="wd"/>
                            <label class="form-label">Working Days / week</label>
                          </div>
        
                        </div>
                        <div class="col-md-6 mb-4 pb-2">
        
                          <div class="form-outline">
                            <input type="text" id="phoneNumber" class="form-control form-control-lg" placeholder="Optional" name="wh"/>
                            <label class="form-label">Work Hours / day</label>
                          </div>
        
                        </div>
                      </div>
      
                    <div class="mt-4 pt-2">
                      <button class="btn btn-primary btn-lg" type="submit" name="submit">Register</button>
                    </div>
      
                  </form>


<?php
  
  if(isset($_POST["submit"])){
    if(isset($_POST["id"])){
      $id = $_POST["id"];
      $password = $_POST["password"];
      $repassword = $_POST["repassword"];
      $result = mysqli_query($conn, "SELECT * FROM accounts WHERE Employee_ID = '$id' AND Account_Status = 'Not Registered'");
      $check = mysqli_num_rows($result);

      if($check == 0){
        echo"<div style='position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);padding: 20px;border-radius: 5px;' class='text-center bg-danger'>
                <div class='row'>Employee ID is already registered or doesn't exist!</div><br>
                <div class='row'><a href='Register.php' style='color:white'>CLOSE</a>
            </div>";  
      }else if($password != $repassword){
        echo"<div style='position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);padding: 10px;border-radius: 5px;' class='text-center bg-danger'>
                <div class='row'>Password do not match!</div><br>
                <div class='row'><a href='Register.php' style='color:white'>CLOSE</a>
            </div>";
      }
      else{
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $position = $_POST["position"];
        $mainpassword = $hash;
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $country = $_POST["country"];
        $language = $_POST["language"];
        $email = $_POST["email"];
        $number = $_POST["number"];
        $address = $_POST["address"];
        $toe = $_POST["toe"];
        $wd = $_POST["wd"];
        $wh = $_POST["wh"];

        mysqli_query($conn, "INSERT INTO info (Employee_ID,Position,picture,Firstname,Lastname,Contact,Email,Address,Type_of_Employment,Working_Days,Working_Hours,Birthday,Gender,Country,Language,Bio) VALUES ('$id','$position','profiles/noprofile.png','$firstname','$lastname','$number','$email','$address','$toe','$wd','$wh','$dob','$gender','$country','$language','No Bio')");
        mysqli_query($conn, "UPDATE accounts SET Password = '$mainpassword', Account_Status = 'Registered' WHERE Employee_ID = '$id'");
        echo"<div style='position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);padding: 20px;border-radius: 5px;color:green' class='text-center bg-danger'>
              <div class='row'>Success!</div><br>
              <div class='row'><a href='Register.php' style='color:white'>CLOSE</a>
            </div>"; 
      }
    }
  }
?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</body>
</html>