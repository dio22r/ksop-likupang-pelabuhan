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
      <h1 class="display-4 text-center mt-2"> Daftar Kapal </h1>
      <div class="card text-center">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link" v-on:click="tab_click(0, $event)" v-bind:class="[status == 0 ? 'active' : '']" href="#">Menunggu</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" v-on:click="tab_click(2, $event)" v-bind:class="[status == 2 ? 'active' : '']" href="#">Revisi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" v-on:click="tab_click(1, $event)" v-bind:class="[status == 1 ? 'active' : '']" href="#">Disetujui</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" v-on:click="tab_click(-1, $event)" v-bind:class="[status == -1 ? 'active' : '']" href="#">Ditolak</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" v-on:click="tab_click('deleted', $event)" v-bind:class="[status == 'deleted' ? 'active' : '']" href="#"><i class="bi bi-trash-fill"></i> Hapus </a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="form-row">
            <div class="col-sm-9 text-left">
              <span>{{String(timenow.hour).padStart(2, "0")}} : {{String(timenow.minutes).padStart(2, "0")}} : {{String(timenow.second).padStart(2, "0")}}</span>
            </div>
            <div class="col-sm-3">
              <div class="input-group input-group-sm mb-3">
                <input type="text" id="datepicker" class="datepicker form-control" placeholder="Cari Data" aria-label="Cari Data" aria-describedby="button-addon2" data-date-format="yyyy-mm-dd">
                <div class="input-group-append">
                  <button class="btn btn-primary" v-on:click="on_search($event)" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                </div>
              </div>
            </div>
          </div>

          <table class="table table-bordered table-hover table-sm">
            <tr>
              <th width="7%">No.</th>
              <th width="20%">Tgl. Daftar</th>
              <th width="23%">Keagenan</th>
              <th width="30%">Nama Kapal</th>
              <th width="10%">Bendera</th>
              <th width="10%">Status</th>
            </tr>
            <tr v-if="items.length < 1">
              <th colspan="6" class="text-center">Belum ada data</th>
            </tr>
            <tr v-else v-for="(item, index) in items" data-toggle="modal" data-target="#detail-modal" v-on:click="view_detail(item.id, $event)">
              <td>{{index + count_start}}</td>
              <td v-bind:class="{'text-danger': item.status == 0 && timenow.time > item.created_time + timelimit}">
                {{item.created_at}}
                <i v-if="item.status == 0 && timenow.time >  item.created_time + timelimit" class="bi bi-exclamation-triangle"></i>
              </td>
              <td>{{item.nama_agen}}</td>
              <td>{{item.nama_kapal}}</td>
              <td>{{item.bendera}}</td>
              <td>
                <span v-if="item.status == 1" class="badge badge-success">Disetujui</span>
                <span v-if="item.status == 0 && item.validate" class="badge badge-info">Diperbaiki</span>
                <span v-if="item.status == 0 && !item.validate" class="badge badge-secondary">Menunggu</span>
                <span v-if="item.status == -1" class="badge badge-danger">Ditolak</span>
                <span v-if="item.status == 2" class="badge badge-warning">Perbaikan</span>

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
          <h5 class="modal-title">Detail Kapal!</h5>
          <button type="button" id="btn-close" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div v-if="retrieve_process">
          <div class="modal-body">
            <table class="table table-sm table-bordered">
              <tr>
                <th>Tanggal Daftar</th>
                <td>{{ detail_kapal.created_at }}</td>
              </tr>
              <tr>
                <th width="30%">Nama Agen</th>
                <td width="70%">{{ detail_kapal.nama_agen }}</td>
              </tr>
              <tr>
                <th width="30%">Nama Kapal</th>
                <td width="70%">{{ detail_kapal.nama_kapal }}</td>
              </tr>
              <tr>
                <th>Nama Nahkoda</th>
                <td>{{ detail_kapal.nama_nahkoda }}</td>
              </tr>
              <tr>
                <th>Jenis Kapal</th>
                <td>{{ detail_kapal.nama_jenis_kapal }}</td>
              </tr>
              <tr>
                <th>Bendera</th>
                <td>{{ detail_kapal.bendera }}</td>
              </tr>
              <tr>
                <th>GT / DWT</th>
                <td>{{ detail_kapal.gt }} / {{ detail_kapal.dwt }}</td>
              </tr>
              <tr>
                <th>LOA</th>
                <td>{{ detail_kapal.loa }}</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <span v-if="detail_kapal.status == 1" class="badge badge-success">Disetujui</span>
                  <span v-if="detail_kapal.status == 0 && detail_kapal.validate" class="badge badge-info">Diperbaiki</span>
                  <span v-if="detail_kapal.status == 0 && !detail_kapal.validate" class="badge badge-secondary">Menunggu</span>
                  <span v-if="detail_kapal.status == -1" class="badge badge-danger">Ditolak</span>
                  <span v-if="detail_kapal.status == 2" class="badge badge-warning">Perbaikan</span>
                </td>
              </tr>
              <tr>
                <th>User Validator</th>
                <td>{{ detail_kapal.user_nama }}</td>
              </tr>
              <tr v-if="detail_kapal.status == 2">
                <th>&nbsp;</th>
                <td>
                  <img v-bind:src="detail_kapal.qrcodeimg" /> <br />
                  <code> {{detail_kapal.qrcodeurl}} </code>
                </td>
              </tr>
            </table>
          </div>

          <div class="modal-footer">
            <?php if ($isAllowUpdate) { ?>
              <button v-if="!detail_kapal.deleted_at" type="button" class="btn btn-sm btn-danger" v-on:click="action_delete(detail_kapal.id, $event)">
                <i class="bi bi-trash"></i> Hapus
              </button>
              <a v-bind:href="'<?= base_url("/admin/pengoprasian-kapal/form"); ?>/' + detail_kapal.id" class="btn btn-sm btn-primary">
                <i class="bi bi-check-circle"></i> Form Verifikasi !
              </a>
            <?php } ?>
            <a v-bind:href="'<?= base_url("/admin/pengoprasian-kapal/detail"); ?>/' + detail_kapal.id" class="btn btn-sm btn-light">
              <i class="bi bi-eye"></i> Lihat Detail
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