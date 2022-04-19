<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>

<style>
  .hide {
    display: none;
  }
</style>
<div id="data-vue">
  <section id="section-1">
    <div class="container">
      <h2 class="text-center text-uppercase mt-5 mb-0">
        Daftar Pelayanan Kapal
      </h2>
      <hr />
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 ">
          <div class="form-group row">
            <div class="col-sm-8 mb-3">
              <div class="input-group">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="bi bi-calendar4-event"></i></span>
                </div>
                <input id="search" type="text" class="form-control datepicker" autocomplete="off" data-date-format="yyyy-mm-dd" placeholder="Tanggal Daftar">
                <div class="input-group-append">
                  <button @click="search_data()" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
              </div>
            </div>
            <div class="col-sm-4 mb-3">
              <a href="<?= base_url("/member/tambat-labuh/create"); ?>" class="btn btn-success">
                <i class="bi bi-journal-plus"></i> Form Daftar
              </a>
            </div>
          </div>

        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div>
            <canvas id="myChart" width="100%" height="30px"></canvas>
          </div>
        </div>
      </div>

      <table class="table table-bordered table-hover table-sm">
        <tr>
          <th width="7%">No.</th>
          <th width="20%" class="d-none d-md-table-cell">Tgl. Daftar</th>
          <th width="23%" class="d-none d-md-table-cell">Keagenan</th>
          <th width="30%" class="d-none d-md-table-cell">Nama Kapal</th>
          <th width="10%" class="d-none d-md-table-cell">Bendera</th>
          <th width="10%" class="d-none d-md-table-cell">Status</th>
          <th width="93%" class="d-table-cell d-md-none">Data</th>
        </tr>
        <tr v-if="items.length < 1">
          <th colspan="6" class="text-center">Belum ada Data</th>
        </tr>
        <tr v-for="(item, index) in items" @click="view_detail(item.id, $event)" data-toggle="modal" data-target="#exampleModal">
          <td>{{index + count_start}}</td>
          <td class="d-none d-md-table-cell">{{item.created_at}}</td>
          <td class="d-none d-md-table-cell">{{item.nama_agen}}</td>
          <td class="d-none d-md-table-cell">{{item.nama_kapal}}</td>
          <td class="d-none d-md-table-cell">{{item.bendera}}</td>
          <td class="d-none d-md-table-cell">
            <span v-if="item.status == 1" class="badge badge-success">Disetujui</span>
            <span v-if="item.status == 0" class="badge badge-secondary">Menunggu</span>
            <span v-if="item.status == -1" class="badge badge-danger">Ditolak</span>
            <span v-if="item.status == 2" class="badge badge-warning">Perbaikan</span>
          </td>

          <td class="d-table-cell d-md-none">
            {{item.created_at}}<br />
            <strong>{{item.nama_agen}}</strong><br />
            {{item.nama_kapal}} ({{item.bendera}})<br />
            <span v-if="item.status == 1" class="badge badge-success">Disetujui</span>
            <span v-if="item.status == 0" class="badge badge-secondary">Menunggu</span>
            <span v-if="item.status == -1" class="badge badge-danger">Ditolak</span>
            <span v-if="item.status == 2" class="badge badge-warning">Perbaikan</span>
          </td>
        </tr>
      </table>


      <nav v-if="total_page > 1" aria-label="Page navigation example">
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Status Kapal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-sm">
              <tr>
                <th width="30%">Tanggal Daftar</th>
                <td width="70%">{{detail.created_at}}</td>
              </tr>
              <tr>
                <th width="30%">Nama Agen</th>
                <td width="70%">{{detail.nama_agen}}</td>
              </tr>
              <tr>
                <th width="30%">Nama Kapal</th>
                <td width="70%">{{detail.nama_kapal}}</td>
              </tr>
              <tr>
                <th width="30%">Bendera</th>
                <td width="70%">{{detail.bendera}}</td>
              </tr>
              <tr>
                <th width="30%">Status</th>
                <td width="70%">
                  <span v-if="detail.status == 1" class="badge badge-success">Disetujui</span>
                  <span v-if="detail.status == 0" class="badge badge-secondary">Menunggu</span>
                  <span v-if="detail.status == -1" class="badge badge-danger">Ditolak</span>
                  <span v-if="detail.status == 2" class="badge badge-warning">Perbaikan</span>
                </td>
              </tr>
            </table>

            <table class="table table-bordered table-sm">
              <tr>
                <th width="30%">Keterangan</th>
                <td width="70%" v-html="detail.keterangan"></td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Oke!</button>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

<script>
  const page_config = <?= json_encode($arrConfig); ?>
</script>


<?= $this->endSection() ?>