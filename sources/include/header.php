<?php 
  function ActivePage($href) {
            $replace = str_replace('/www/','',$_SERVER['REQUEST_URI']);
      if (strpos($replace, $href) === 0) {
        return ' active-link';
      }else if(!$replace && $href == 'index.php') {
        return ' active-link';
      }
  }
?>



<header id="header">
	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="images/logosite.svg" alt="logo du site" width="80px" height="80px"></a>
        <button id="burger-menu" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <img src="images/burger-menu.svg" width="32px" height="32px">
      </button>
      <div class="collapse navbar-collapse nav-lnks" id="navbarSupportedContent" >
        <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="nav-baar">
            <?php 

            $index ='Accueil';
            $connexion = 'Connexion';

              if (isset($_SESSION['email'])){
                echo '<li class="nav-item mr-4">
                           <img  style="width:24px" src="images/moon.png" id="icon">
                      </li>';
                echo '<li class="nav-item mr-4">
                           <a class="nav-link  nav-lnk' . ActivePage('/index.php') . '" style="color:#6FBCE8;" aria-current="page" href="index.php">Accueil</a>
                      </li>';
                echo '<li class="nav-item mr-4">
                          <a class="nav-link  nav-lnk ' .ActivePage('/profile.php') .  '" style="color:#6FBCE8;" aria-current="page" href="profile.php">Profil</a>
                      </li>';
                echo '<li class="nav-item mr-4">
                          <a class="nav-link  nav-lnk ' .ActivePage('/amis.php') . '" style="color:#6FBCE8;" aria-current="page" href="amis.php">Amis</a>';
                echo '<li class="nav-item mr-4">
                          <a class="nav-link  nav-lnk ' .ActivePage('/boutique.php') . '" style="color:#6FBCE8;" aria-current="page" href="boutique.php">Boutique</a>';
                }
                echo '  <li class="nav-item mr-4">
                          <a class="nav-link  nav-lnk ' .ActivePage('/avatar.php') . '" style="color:#6FBCE8;" aria-current="page" href="avatar.php">Avatar</a>
                        </li>';
            ?>
            <li class="nav-item mr-4">
              <a class="nav-link  nav-lnk <?= ActivePage('/Forum.php') ?>" style="color:#6FBCE8;" aria-current="page" href="forum.php">Forum</a>
            </li>
            <li class="nav-item mr-4">
              <a class="nav-link nav-lnk" style="color:#6FBCE8;" aria-current="page" href="themes.php">Thèmes</a>
            </li>           
            <li class="nav-item mr-4">
              <a class="nav-link nav-lnk" style="color:#6FBCE8;" aria-current="page" href="#">Paramètres</a>
            </li>
            

            <?php 
            if (isset($_SESSION['email'])){
              echo '<li class="nav-item mr-4">
                        <a class="nav-link active nav-lnk" style="color:#6FBCE8;" aria-current="page" href="deconnexion.php">Deconnexion</a>
                      </li>';
                    }else{
                      echo '<li class="nav-item mr-4">
                        <a class="nav-link active nav-lnk ' . ActivePage('/connexion.php') . '" style="color:#6FBCE8;" aria-current="page" href="connexion.php">Connexion</a>
                      </li>';
                    }

            ?>

          </ul>
        </div>
    </div>
  </nav>

  <script>

       var icon = document.getElementById("icon");

       icon.onclick = function(){
           document.body.classList.toggle("dark-theme"); 
           if(document.body.classList.contains("dark-theme")){
               icon.src = "images/sun.png";
           }else{
               icon.src = "images/moon.png";
           }


       }
  </script>
</header>