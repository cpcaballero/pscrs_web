<nav>
  <div class="nav-wrapper white">
    <div class="row">

      <div class="col s2">
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      </div>

      <div class="col s10">
        <div class="right">
          <a class='dropdown-trigger btn' href='#' data-target='dropdown1'>
            HI <?= $_SESSION['account']['details']['firstname'] ?>
          </a>

          <!-- Dropdown Structure -->
          <ul id='dropdown1' class='dropdown-content'>
            <li><a href="<?= base_url('Subscribers_FE/profile_settings') ?>">Profile Settings</a></li>
            <li><a href="<?= base_url('Subscribers_FE/logout') ?>">Logout</a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</nav>