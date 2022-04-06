<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<style>
  .hide {
    display: none;
  }
</style>

<div id="data-vue">

  <section id="content">

    <div class="container">
      <h1 class="display-4 text-center mt-2"> User Management </h1>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Form User
            </div>
            <div class="card-body">
              <form id="form-validasi" method="post">
                <div v-if="error.length > 0" class="alert alert-danger">
                  <ul class="mb-0">
                    <li v-for="item in error">{{item}}</li>
                  </ul>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input name="nama" v-model="detail.nama" type="text" class="form-control" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Username</label>
                  <div class="col-sm-7">
                    <input name="username" v-model="detail.username" type="text" class="form-control" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Password</label>
                  <div class="col-sm-7">
                    <input name="password" v-model="detail.password" type="text" class="form-control" <?= $is_new ? "required" : "" ?>>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Role</label>
                  <div class="col-sm-6">
                    <select name="role" v-model="detail.role" class="form-control" required>
                      <?php foreach ($arrUserRole as $key => $arrVal) { ?>
                        <option value="<?= $arrVal["id"]; ?>"><?= $arrVal["title"]; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Active</label>
                  <div class="col-sm-3">
                    <select name="status" v-model="detail.status" class="form-control" required>
                      <option value="1">Aktif</option>
                      <option value="0">Non-Aktif</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-12 text-right">
                    <a href="<?= base_url("/admin/user-management"); ?>" class="btn btn-light">
                      <i class="bi bi-arrow-90deg-left"></i> Batal
                    </a>
                    <button v-on:click="submit($event)" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#notif">
                      <i class="bi bi-arrow-up-right-square"></i> Simpan
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</div>

<script>
  var jsConfig = <?= json_encode($jsConfig); ?>
</script>

<?= $this->endSection() ?>