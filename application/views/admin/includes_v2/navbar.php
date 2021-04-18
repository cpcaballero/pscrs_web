<nav>
  <!-- <div class="nav-wrapper white">
    <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li>
        <h1>
          <ul id="dropdown" class="offset-11  dropdown-content">
            <li><a href="#">Settings</a></li>
            <li><a href="<?= base_url('Admin_FE/logout') ?>">Logout</a></li>
          </ul>
      </li>
    </ul>
    <a class=" offset-11  btn dropdown-button right" href="#" data-activates="dropdown">Hello Admin</a>
  </div> -->

  <div class="nav-wrapper white">
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

    <div class="right">
      <!-- Dropdown Trigger -->
      <a style="margin-right:1em;" class='dropdown-trigger btn' href='#' data-target='dropdown1'>
        HI <?= $_SESSION['account']['details']['fullname'] ?>
      </a>

      <!-- Dropdown Structure -->
      <ul id='dropdown1' class='dropdown-content'>
        <li><a href="<?= base_url() ?>Admin_FE/adminprofile/<?= $_SESSION['account']['details']['id'] ?>">Settings</a></li>
        <li><a href="<?= base_url('Admin_FE/logout') ?>">Logout</a></li>
      </ul>
    </div>

  </div>
</nav>