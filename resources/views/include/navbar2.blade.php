<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{URL::to('/admin')}}">
          <i class="ti-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <i class="ti-clipboard menu-icon"></i>
          <span class="menu-title">Création</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{URL::to('/ajoutercategorie')}}">Ajouter catégorie</a></li>
            <li class="nav-item"><a class="nav-link" href="{{URL::to('/ajouterproduit')}}">Ajouter produits</a></li>
            <li class="nav-item"><a class="nav-link" href="{{URL::to('/ajouterslider')}}">Ajouter slider</a></li>
            <li class="nav-item"><a class="nav-link" href="{{URL::to('/admin/articles/create')}}">Ajouter article de blog</a></li>
            <li class="nav-item"><a class="nav-link" href="{{URL::to('/admin/shipping/createpays')}}">Ajouter Pays</a></li>
            <li class="nav-item"><a class="nav-link" href="{{URL::to('/admin/shipping/create')}}">Ajouter Tarif EXP</a></li>
            <li class="nav-item"><a class="nav-link" href="{{URL::to('/cours-euro')}}">Cours Euros</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
          <i class="ti-layout menu-icon"></i>
          <span class="menu-title">Affichages</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="tables">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{URL::to('/categories')}}">Catégories</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{URL::to('/produits')}}">Produits</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{URL::to('/sliders')}}">Sliders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{URL::to('/commandes')}}">Commande</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{URL::to('/admin/articles/liste')}}">Liste des articles</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>