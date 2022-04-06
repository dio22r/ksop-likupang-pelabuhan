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
      <div class="card text-center">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link" v-on:click="tab_click(1, $event)" v-bind:class="[status == 1 ? 'active' : '']" href="#">Aktif</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" v-on:click="tab_click(0, $event)" v-bind:class="[status == 0 ? 'active' : '']" href="#">Non-Aktif</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="form-row justify-content-end">
            <div class="col-sm-9 text-left">
              <a href="<?= base_url("/admin/user-management/form"); ?>" class="btn btn-outline-primary btn-sm" type="button">
                <i class="bi bi-person-plus"></i> Tambah User
              </a>
            </div>
            <div class="col-sm-3">
              <div class="input-group input-group-sm mb-3">
                <input type="text" v-model="search" @keyup.enter="on_search($event)" class="form-control" placeholder="Cari Data" aria-label="Cari Data" aria-describedby="button-addon2" data-date-format="yyyy-mm-dd">
                <div class="input-group-append">
                  <button class="btn btn-primary" v-on:click="on_search($event)" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                </div>
              </div>

            </div>
          </div>

          <table class="table table-bordered table-hover table-sm">
            <tr>
              <th width="10%">No.</th>
              <th width="25%">Nama</th>
              <th width="25%">Username</th>
              <th width="20%">role</th>
              <th width="20%">Status</th>
            </tr>
            <tr v-if="items.length < 1">
              <th colspan="6" class="text-center">Belum ada data</th>
            </tr>
            <tr v-else v-for="(item, index) in items" data-toggle="modal" data-target="#detail-modal" v-on:click="view_detail(item.id, $event)">
              <td>{{index + count_start}}</td>
              <td>{{item.nama}}</td>
              <td>{{item.username}}</td>
              <td>{{item.role_name}}</td>
              <td>
                <span v-if="item.status == 1" class="badge badge-success">Aktif</span>
                <span v-else class="badge badge-danger">Non-Aktif</span>
              </td>
            </tr>
          </table>


          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item" v-bind:class="[ current_page == 1 ? 'disabled' :'' ]"><a class="page-link prev" v-on:click="pagination(-1, $event)" href="#">Prev.</a></li>
              <li class="page-item"><a class="page-link" v-on:click="pagination(-2, $event)" v-bind:class="[ current_page - 2 <= 0 ? 'hide' : '' ]" href="#">{{ current_page - 2 }}</a></li>
              <li class="page-item"><a class="page-link" v-on:click="pagination(-1, $event)" v-bind:class="[ current_page - 1 <= 0 ? 'hide' : '' ]" href="#">{{ current_page - 1 }}</a></li>
              <li class="page-item active"><a class="page-link" href="#">{{ current_page }}</a></li>
              <li class="page-item"><a class="page-link" v-on:click="pagination(1, $event)" v-bind:class="[ current_page + 1 > total_page ? 'hide' : '' ]" href="#">{{ current_page + 1 }}</a></li>
              <li class="page-item"><a class="page-link" v-on:click="pagination(2, $event)" v-bind:class="[ current_page + 2 > total_page ? 'hide' : '' ]" href="#">{{ current_page + 2 }}</a></li>
              <li class="page-item" v-bind:class="[ current_page == total_page ? 'disabled' :'' ]"><a class="page-link next" v-on:click="pagination(1, $event)" href="#">Next</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </section>


  <div class="modal fade" id="detail-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail User!</h5>
          <button type="button" id="btn-close" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div v-if="retrieve_process">
          <div class="modal-body">
            <table class="table table-sm table-bordered">
              <tr>
                <th>Nama</th>
                <td>{{ detail.nama }}</td>
              </tr>
              <tr>
                <th width="30%">Username</th>
                <td width="70%">{{ detail.username }}</td>
              </tr>
              <tr>
                <th width="30%">Role</th>
                <td width="70%">{{ detail.role_name }}</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <span v-if="detail.status == 1" class="badge badge-success">Aktif</span>
                  <span v-else class="badge badge-secondary">Non-aktif</span>
                </td>
              </tr>
            </table>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" v-on:click="action_delete(detail.id, $event)">
              <i class="bi bi-trash"></i> Hapus
            </button>
            <a v-bind:href="'<?= base_url("/admin/user-management/form"); ?>/' + detail.id" class="btn btn-sm btn-primary">
              <i class="bi bi-check-circle"></i> Edit
            </a>
          </div>

        </div>
        <div v-else>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>