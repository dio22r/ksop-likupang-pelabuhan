<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="/admin">
    <img class="" src="/assets/images/logo-ksop-kelas-ii.png" width="200px" alt="..." />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto ">

    </ul>
    <ul class="navbar-nav ">
      <?php foreach ($arrMenu as $key => $arrVal) { ?>
        <?php
        $activeClass = $currentTag = "";
        if ($arrVal["id"] == $ctl_id) {
          $activeClass = "active";
          $currentTag = '<span class="sr-only">(current)</span>';
        }
        ?>
        <li class="nav-item font-weight-bold ml-3 mr-3 <?= $activeClass ?>">
          <a class="nav-link" href="<?= $arrVal["href"] ?>"><?= $arrVal["title"] ?><?= $currentTag ?></a>
        </li>
      <?php } ?>
      <li class="nav-item dropdown ">
        <a class="nav-link ml-3 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="bi bi-person-circle"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <h6 class="dropdown-header"><?= $nama ?></h6>
          <div class="dropdown-divider"></div>

          <a class="dropdown-item" href="<?= base_url("/admin/tutorial"); ?>">
            <i class="bi bi-flag-fill"></i> Tutorial
          </a>

          <a class="dropdown-item" href="<?= base_url('/admin/ganti-password'); ?>">
            <i class="bi bi-shield-lock-fill"></i> Ganti Password
          </a>
          <a class="dropdown-item" href="<?= base_url('/admin/logout'); ?>">
            <i class="bi bi-lock-fill"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>