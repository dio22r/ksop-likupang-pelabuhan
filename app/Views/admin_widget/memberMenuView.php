<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="/admin">
    <img class="" src="<?= base_url('assets/images/ksop-likupang.png') ?>" width="200px" alt="..." />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto ">

    </ul>
    <ul class="navbar-nav ">
      <li class="nav-item dropdown ">
        <a class="nav-link ml-3 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="bi bi-person-circle"></i> <?= $nama ?>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">

          <a class="dropdown-item" href="<?= base_url("/tutorial"); ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>

          <a class="dropdown-item" href="<?= base_url("/tutorial"); ?>">
            <i class="bi bi-speedometer2"></i> Permohonan
          </a>

          <a class="dropdown-item" href="<?= base_url("/tutorial"); ?>">
            <i class="bi bi-flag-fill"></i> Tutorial
          </a>

          <a class="dropdown-item" href="<?= base_url('/member/ganti-password'); ?>">
            <i class="bi bi-shield-lock-fill"></i> Ganti Password
          </a>
          <a class="dropdown-item" href="<?= base_url('/logout'); ?>">
            <i class="bi bi-lock-fill"></i> Logout
          </a>
        </div>
      </li>

      <li class="nav-item text-center ml-3">
        <img class="" src="<?= base_url('assets/images/Kerja-dengan-hati.png') ?>" alt="..." />
      </li>
    </ul>
  </div>
</nav>