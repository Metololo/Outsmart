<header id="header">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="../images/logosite.svg" alt="logo du site" width="80px" height="80px"></a>
        <button id="burger-menu" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <img src="../images/burger-menu.svg" width="32px" height="32px">
      </button>
      <div class="collapse navbar-collapse nav-lnks" id="navbarSupportedContent" >
        <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="nav-baar">
           <li class="nav-item mr-4">
              <a class="nav-link  nav-lnk" style="color:#6FBCE8;" aria-current="page" href="admin_dashboard.php">Accueil</a>
            </li>
           <li class="nav-item mr-4">
              <a class="nav-link  nav-lnk" style="color:#6FBCE8;" aria-current="page" href="utilisateurs">Utilisateurs</a>
            </li>
             <li class="nav-item mr-4">
              <a class="nav-link  nav-lnk " style="color:#6FBCE8;" aria-current="page" href="#">Themes</a>
            </li>
             <li class="nav-item mr-4">
              <a class="nav-link  nav-lnk " style="color:#6FBCE8;" aria-current="page" href="#">Topics</a>
            </li>
            <li class="nav-item mr-4">
              <a class="nav-link  nav-lnk " style="color:#6FBCE8;" aria-current="page" href="../deconnexion.php">Deconnexion</a>
            </li>
          </ul>
        </div>
    </div>
  </nav>
</header>

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


