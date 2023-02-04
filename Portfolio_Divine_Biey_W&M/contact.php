<?php

// Show all errors (for educational purposes)
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// Constanten (connectie-instellingen databank)
define('DB_HOST', 'localhost:3306');
define('DB_USER', 'divine');
define('DB_PASS', 'Divine1409!');
define('DB_NAME', 'contact_form');

date_default_timezone_set('Europe/Brussels');

// Verbinding maken met de databank
try {
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Verbindingsfout: ' . $e->getMessage();
    exit;
}

$name = isset($_POST['name']) ? (string)$_POST['name'] : '';
$email = isset($_POST['email']) ? (string)$_POST['email'] : '';
$friends = isset($_POST['friends']) ? (string)$_POST['friends'] : '';
$social = isset($_POST['social']) ? (string)$_POST['social'] : '';
$google = isset($_POST['google']) ? (string)$_POST['google'] : '';
$message = isset($_POST['message']) ? (string)$_POST['message'] : '';
$msgName = '';
$msgMessage = '';
/*$findme = (array)$_POST['findme'];
    $chk="";  
    foreach((array)$findme as $chk1)  
       {  
          $chk.= $chk1.",";  
       }  
*/ 
 
if (isset($_POST['findme'])) {
    $findme = $_POST['findme'];

    $chk="";  
    foreach((array)$findme as $chk1)  
       {  
          $chk.= $chk1.",";  
       }  
}


// form is sent: perform formchecking!
if (isset($_POST['btnSubmit'])) {

    $allOk = true;

    // name not empty
    if (trim($name) === '') {
        $msgName = 'Gelieve een naam in te voeren';
        $allOk = false;
    }
    if (trim($email) === '') {
        $msgName = 'Gelieve een email in te voeren';
        $allOk = false;
    }

    if (trim($message) === '') {
        $msgMessage = 'Gelieve een boodschap in te voeren';
        $allOk = false;
    }

    // end of form check. If $allOk still is true, then the form was sent in correctly
    if ($allOk) {
        $stmt = $db->exec('INSERT INTO messages (sender, email, message, findme, added_on) VALUES (\'' . $name . '\',\'' . $email . '\',\'' . $message . '\',\'' . $chk. '\',\'' . (new DateTime())->format('Y-m-d H:i:s') . '\')');

        // the query succeeded, redirect to this very same page
        if ($db->lastInsertId() !== 0) {
            header('Location: formchecking_thanks.php?name=' . urlencode($name));
            exit();
        } // the query failed
        else {
            echo 'Databankfout.';
            exit;
        }

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css\contact.css">
    <style><?php include 'css\contact.css'; ?></style>
    <title>Portfolio</title>
</head>
<body>
    <header>
    <div class="container">
        <a href="/" class="logo"><span style="color:blueviolet;">DIV</span>INE</a>
              <nav> 
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="projects.html">Projects</a></li>
                <li><a href="cv.html">CV</a></li>
                <li><a href="blog.html">Blog</a></li>
            <li><a href="contact.php">Contact</a></li> 
            <li><a href="mymessages.php">My Messages</a></li>   
     </ul>   
    </nav>
    </div> 
    </header> 
   
	<div class="header-container"></div>
            <h1>Contact me</h1> 
            <p>You have a question or want to work
                <br>together ... get in contact!</p>
        
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h1>Testform</h1>

        <div class="text">
            <label for="name">Your name</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" class="input-text"/>
            <span class="message error"><?php echo $msgName; ?></span>
        </div>

        <div class="text">
            <label for="email">Your email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="input-text"/>
            <span class="message error"><?php echo $msgName; ?></span>
        </div>

        <div class="text">
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="5" cols="40"><?php echo $message; ?></textarea>
            <span class="message error"><?php echo $msgMessage; ?></span>
        </div>

        <div class="findme">
            <label for="gettoknow">How did you find me?</label><br>
            <input type="checkbox" id="friends" name="findme[]" value="friends">
            <label for="friends">Friends</label><br>
            <input type="checkbox" id="social" name="findme[]" value="social">
            <label for="social">Social media</label><br>
            <input type="checkbox" id="google" name="findme[]" value="google">
            <label for="google">Google</label>
            <span class="message error"><?php echo $msgName; ?></span>
        </div>

       <button class= "btnSubmit" input type="submit" id="btnSubmit" name="btnSubmit" value="Verstuur">Send</button>
    </form>
                
    <footer>
        <div class="footer-content">
          <h3>Foolish Developer</h3>
          <p>Foolish Developer is a blog website where you will find great tutorials on web
            <br> design and development. Here each tutorial is beautifully described step by step
            <br> with the required source code.</p>
        
            <ul class="socials">
                   <li><a href="#"><i class= "fa fa-facebook"></i></a></li>
                   <li><a href="#"><i class= "fa fa-twitter"></i></a></li>
                   <li><a href="#"><i class= "fa fa-youtube"></i></a></li>
                   <li><a href="#"><i class= "fa fa-instagram"></i></a></li>
                   <li><a href="#"><i class= "fa fa-linkedin-square"></i></a></li>    
        </ul> 
        
        <div class="footer-bottom">
            <p>copyright &copy;2022 <a href="#">Portfolio</a></p>
        </div>
    </div> 
        </footer>

</body>
</html>