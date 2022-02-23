
<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://techsolutionshere.com/wp-content/themes/techsolution/assets/blog-post-css-js/meanmenu.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/styles.css">
    <link rel="icon" href="img/icon.png">

    <title>PC4U</title>
    </head>
    <body>



    <div class="navbar-area">
        <div class="mobile-nav">
            <a href="index.php" class="logo">
                PC4U
            </a>
        </div>


        <div class="main-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand text-primary" href="/index.php">
                        PC4U
                    </a>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                    <a href="/cat/cat.php" class="nav-link dropdown-toggle">Categorieën</a>
                                    <ul class="dropdown-menu">
                                    <?php 
                                    $conn = mysqli_connect('localhost','root','','pc4u');
                                    $sql = "SELECT * FROM cat";
                                    $result = mysqli_query($conn, $sql);
                            
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<li class="nav-item">
                                        <a href="/cat/'.$row['name'].'.php" class="nav-link">'.$row['name'].'</a>
                                    </li>';
                                    }
                                    
                                    
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="/index.php" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="/myorders.php" class="nav-link">Bestellingen</a>
                            </li>
                            <li class="nav-item">
                                <a href="/contact.php" class="nav-link">Contact</a>
                            </li>
                        
                            <?php if (isset($_SESSION['loggedin'])) {
                                echo '<li class="nav-item">
                                        <a href="/logout.php" class="nav-link">Uitloggen</a>
                                    </li>';
                            } else {
                                
                                echo '<li class="nav-item">
                                        <a href="/login.php" class="nav-link">Inloggen</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/register.php" class="nav-link">Registreren</a>
                                    </li>';
                            }

                            ?>

                            <?php if (isset($_SESSION['role'])) {
                                    if ($_SESSION['role'] == 'admin') { echo '<li class="nav-item">
                                        <a href="/adminportal.php" class="nav-link">Portal</a>
                                    </li>';}} 
                            ?>
                            <li class="nav-item">
                                <a href="/cart.php" class="nav-link"><i class="bi bi-cart"></i> Winkelwagen</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
 