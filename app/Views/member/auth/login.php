<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="author" content="<?= APPS_NAME; ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= APPS_NAME; ?> UPP Likupang | Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <link rel="stylesheet" type="text/css" href="<?= base_url("/assets/css/login_view.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("assets/css/admin.css"); ?>">

  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12" defer></script>

</head>

<body class="my-login-page">
  <div id="data-vue">
    <header class="masthead bg-color-menu text-white text-center pt-2 pt-md-4">
      <div class="container">

        <div class="row">
          <div class="col-md-6 text-md-left text-center">
            <a class="navbar-brand" href="/">
              <img class="" src="<?= base_url('assets/images/ksop-likupang.png') ?>" alt="..." />
            </a>
          </div>
          <!-- Masthead Avatar Image-->
          <div class="col-md-6 text-md-right text-center">
            <!-- <img class="mb-2 mb-md-4" height="70px" src="/assets/images/siapmenanti.png" alt="..." /> -->
            <img class="" src="<?= base_url('assets/images/Kerja-dengan-hati.png') ?>" alt="..." />
          </div>
          <!-- Masthead Heading-->
        </div>
        <div class="row">
          <div class="col-12">
            <h2 class="text-master-color-red font-weight-bold">Elektronik Sistem Tambat Labuh</h2>
            <h3 class="font-weight-bold">e-Sitabuh</h3>
          </div>
        </div>
      </div>
    </header>
    <section class="h-100 mt-5">
      <div class="container h-100">
        <div class="row justify-content-center h-100">
          <div class="card-wrapper">
            <div class="card fat">
              <div class="card-body">
                <h4 class="card-title">Login</h4>
                <p>Selamat Datang Member <?= FULL_APPS_NAME; ?>.</p>

                <?php if ($errors) { ?>
                  <div class="alert alert-danger" role="alert">
                    <ul class="m-0">
                      <?php foreach ($errors as $value) { ?>
                        <li><?= $value ?></li>
                      <?php } ?>
                    </ul>
                  </div>
                <?php } ?>

                <form method="POST" id="form" action="<?= $actionUrl; ?>" class="my-login-validation" v-on:submit="submit($event)">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" name="username" value="" required autofocus>

                  </div>

                  <div class="form-group">
                    <label for="password">Password
                    </label>
                    <input id="password" type="password" class="form-control" name="password" required data-eye>
                  </div>


                  <div class="form-group">
                    <label for="password">Kode Keamanan
                    </label>
                    <input id="captcha" type="text" class="form-control" name="captcha" required>
                  </div>
                  <div class="form-group">
                    <img src="<?= $captcha->inline() ?>" />
                    <button class="btn btn-light" onClick="window.location.reload();">Ganti Kode</button>
                  </div>

                  <div class="form-group m-0">
                    <button type="submit" class="btn btn-primary btn-block">
                      Login
                    </button>
                    <a href="<?= base_url('register') ?>" class="btn btn-success btn-block">
                      Pendaftaran Akun
                    </a>
                  </div>
                </form>
              </div>
            </div>


            <?= $this->include('admin_widget/footer') ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>