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

  <script src="https://www.google.com/recaptcha/api.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
  <script src="<?= base_url("/assets/js/controller/auth/login.js"); ?>" defer></script>

</head>

<body class="my-login-page">
  <div id="data-vue">
    <header class="masthead bg-color-menu text-white text-center pt-2 pt-md-4 mb-3">
      <div class="container">

        <div class="row">
          <div class="col-md-6 text-md-left text-center">
            <a class="navbar-brand" href="/">
              <img class="" src="/assets/images/logo-ksop-kelas-ii.png" alt="..." />
            </a>
          </div>
          <!-- Masthead Avatar Image-->
          <div class="col-md-6 text-md-right text-center">
            <h1 class="masthead-heading mb-2 mb-md-4"><?= APPS_NAME; ?></h1>
          </div>
          <!-- Masthead Heading-->
        </div>
      </div>
    </header>
    <section class="h-100">
      <div class="container h-100">
        <div class="row justify-content-center h-100">
          <div class="card-wrapper">
            <div class="card fat">
              <div class="card-body">
                <h4 class="card-title">Login</h4>
                <p>Selamat Datang Member <?= FULL_APPS_NAME; ?>.</p>

                <div v-if="alert_show" class="alert alert-danger" role="alert">
                  <ul class="m-0">
                    {{msg}}
                  </ul>
                </div>

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
                    <div class="g-recaptcha" data-sitekey="6LeNoWMbAAAAAGNB6hdonIZ6ZaOiJsrSRypjvtYL"></div>
                  </div>

                  <div class="form-group m-0">
                    <button type="submit" class="btn btn-primary btn-block">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="footer">
              <p class="text-center m-0">
                <img class="" height="100px" src="/assets/images/siapmenanti-256.png" alt="..." />
              </p>
              Copyright &copy; 2021 &mdash; KSOP Kelas II Bitung
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>