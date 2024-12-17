<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    
    <title>SSP CORPORATE WEBHOSTING IT AND LIFESTYLE</title>
    <link rel="icon" type="image/x-icon" href="assets/img/ssp_slide2o.png">
    <!-- CUSTOM STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />    
</head>	
	
<body>


   
        <div class="navbar" >
        <div class="containerin">
         <div class="navbar-header">
                <button type="button" class="navbar-togglebtn" onclick="ToggleMenuFunction()">
                <img src="assets/img/threelines.svg" alt=""/>
                </button>
                <a class="navbar-brand" href="index.html" ><strong style=""></strong>
				<img src="assets/img/earth1.svg"></img> SSP <small > Corporate</small>
           		</a>
            </div>
            <div class="navbar-collapseable" id="sspTogleNav">
                <ul class="navi-ul">
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="index.html#ABOUT">ABOUT</a></li>
                    <li><a href="index.html#PRICING">PRICING</a></li>
                    <li><a href="contact.php">CONTACT</a></li>
                    <li><a href="#">LOGIN</a></li>
                </ul><!----->
            </div> 

        </div>
    </div>
    
    
    

    
    
    <div class="sspbody">
		<div class="sectionssp">
	  <!---  -->
		  <img class="sspsect1img" src="assets/img/header.jpg" width="100px" height="100px" alt=""/> 
		  
			<div class="sectionsspOver">
           <br><br>
            <h1 >SSP CORPORATE</h1>
            <hr class="hr-set"/>

            <p>WEBHOSTING IT AND LIFESTYLE company located in Kampala Uganda.</p>
			</div>
	  <!---  -->	
		</div>
		
		
		<div class="sectionssp">
	  <!---  -->
                        Call here for more details: <a href="tel:+256754848548">+256754848548</a>
                        <br>Whatsapp here for more details: <a href="https://wa.me/+256754848548" >+256754848548</a>
                        
                        <?php
$message = "Line 1\r\nLine 2\r\nLine 3";
$message = wordwrap($message, 70, "\r\n");
$from="simon@sspcorporate.com";
$subject="simon sp";
//**



if (isset($_POST['submit'])) 
{
    
$message = wordwrap($_POST['msgdetails'], 200, "\r\n");
$from=$_POST['email'];
$subject=$_POST['yourname'];

$headers = "From: $from";
//$headers .= "MIME-Version: 1.0\r\n";
//$headers .= "Content-Type: text/html; charset=UTF-8\r\n";


if ( mail( "simon@sspcorporate.com" , $subject, $message, $headers ) )
{ echo"Mail sent <a href='contact.php'>Go back</a>"; }
else
{ echo"Mail not sent <a href='contact.php'>Go back</a>"; }

}

?>               
	  <!---  -->	
		</div>
		
		
		<div class="sectionssp">
	  <!---  -->
             <div class="mailrow">
             		<strong>QUICK QUERY FORM</strong>
             <br />
             <form action="contact.php" method="POST">
             <label></label>
             <input class="xinput" type="text" name="yourname" class="form-control" placeholder="Enter Your Name"/>
             <label></label>
             <input class="xinput" type="text" name="email" class="form-control" placeholder="Enter Your Email" />
             <label></label>
             <textarea  class="form-control" name="msgdetails" placeholder="Enter Your Project Details and Budget" rows="5" ></textarea>
             <br />
             <input class="submitinput" type="submit" name="submit" class="btn btn-primary" value="SEND QUERY" />
             </form>
             </div>
	  <!---  -->
		</div>
		
		
		<div class="sectionssp sectioncolor">
	  <!---  -->
		<div class="sspsubsection">
	  <!---  -->
        <p>
        SSP CORPORATE is a WEBHOSTING IT AND LIFESTYLE company located in Kampala Uganda, owned by Ssentongo Simon Peter.
        </p> 
	  <!---  -->	
		</div>
		<div class="sspsubsection">
	  <!---  -->
       <h4>PHYSICAL LOCATION </h4>
           <h5>Kampala, Uganda,</h5>
           <h5>Kampala,</h5>
           <h5>Uganda 256</h5>
           <br />
           <h5><strong>Email:</strong> simon@sspcorporate.com</h5>
           <h5><strong>Call:</strong> <a href="tel:+256754848548">+256754848548</a></h5>
	  <!---  -->	
		</div>
		<div class="sspsubsection">
	  <!---  -->
         <h4>SOCIAL LINKS</h4>
          <a href="https://wa.me/+256754848548" class="sosialA"> <img src="assets/img/whatsapp.svg"></img> </a>
          <a href="https://sspmade.github.io/DOC/page.html" class="sosialA"> <img src="assets/img/sspgithub.svg"></img> </a>
	  <!---  -->	
		</div>
	  <!---  -->
	  <div class="clearee"></div>
		</div>
		
		
		<div class="sspfoot" >
    	&copy 2024 sspcorporate.com | All rights reserved | Design by : <a href="http://www.sspcorporate.com" target="_blank" style="color:#7C7C7C;">www.sspcorporate.com</a> 
		</div>

	</div>



    <!-- SSP CORPORATE SCRIPTS  -->
    <script src="assets/js/sspcorporate1.js"></script>

</body>	

</html>