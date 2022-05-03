<?= $this->extend('layout/member') ?>


<?= $this->section('css') ?>

<link rel="stylesheet" href="<?= base_url("/assets/css/bootstrap-datepicker3.min.css") ?>">

<style>
  .hide {
    display: none;
  }

  .qrcode-warper {
    position: relative;
    vertical-align: middle;
    justify-content: center;
    display: flex;
  }

  .img-warper-qrcode {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    height: 250px;
    width: 250px;
  }
</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div id="data-vue">

  <section id="content">

    <div class="container">
      <h1 class="display-4 text-center mt-2"> Daftar Kapal </h1>
      <div class="card">
        <div class="card-header">
          Data
        </div>
        <div class="card-body">
          <?php if (isset($arrValidasi["keterangan"])) { ?>
            <div class="alert alert-warning" role="alert">
              Perbaiki Data Anda: <br />
              <div><?= nl2br($arrValidasi["keterangan"]) ?></div>
            </div>
          <?php } ?>
          <form id="form-perbaikan" action="<?= base_url('/member/tambat-labuh/edit/' . $arrData["id"]); ?>" data-id="<?= $arrData["id"]; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nama Kapal</label>
              <div class="col-sm-9">
                <input name="nama_kapal" value="<?= $arrData["nama_kapal"] ?>" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Bendera</label>
              <div class="col-sm-9">
                <input name="bendera" value="<?= $arrData["bendera"] ?>" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">GT</label>
              <div class="col-sm-4">
                <input name="gt" value="<?= $arrData["gt"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">DWT</label>
              <div class="col-sm-4">
                <input name="dwt" value="<?= $arrData["dwt"] ?>" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Jenis Kapal</label>
              <div class="col-sm-6">
                <select name="jenis_kapal" class="form-control" required>
                  <?php foreach ($arrJenisKapal as $key => $arrVal) { ?>
                    <option value="<?= $arrVal["id"] ?>" <?= $arrVal["id"] == $arrData["jenis_kapal"] ? "selected" : ""; ?>>
                      <?= $arrVal["nama"]; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">LOA</label>
              <div class="col-sm-4">
                <input name="loa" value="<?= $arrData["loa"] ?>" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Pemilik / Principle</label>
              <div class="col-sm-9">
                <input name="pemilik" value="<?= $arrData["pemilik"] ?>" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-3 col-form-label">Nama Agen</label>
              <div class="col-sm-9">
                <input name="nama_agen" value="<?= $arrData["nama_agen"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nama Nahkoda</label>
              <div class="col-sm-9">
                <input name="nama_nahkoda" value="<?= $arrData["nama_nahkoda"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Trayek</label>
              <div class="col-sm-9">
                <input name="trayek" value="<?= $arrData["trayek"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Pelayaran</label>
              <div class="col-sm-9">
                <input name="jenis_pelayaran" value="<?= $arrData["jenis_pelayaran"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">ETA</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="eta_date" value="<?= $arrData["eta_date"] ?>" type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="ETA (date)" aria-label="ETA" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-calendar4-event"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="eta_time" value="<?= $arrData["eta_time"] ?>" type="time" class="form-control" autocomplete="off" placeholder="ETA (time)" aria-label="ETA" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-clock"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">ETD</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="etd_date" value="<?= $arrData["etd_date"] ?>" type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="ETD (date)" aria-label="ETD" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-calendar4-event"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="etd_time" value="<?= $arrData["etd_time"] ?>" type="time" class="form-control" autocomplete="off" placeholder="ETA (time)" aria-label="ETA" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-clock"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Pelabuhan Asal</label>
              <div class="col-sm-9">
                <input name="pelabuhan_asal" value="<?= $arrData["pelabuhan_asal"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Pelabuhan Tujuan</label>
              <div class="col-sm-9">
                <input name="pelabuhan_tujuan" value="<?= $arrData["pelabuhan_tujuan"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Labuh yang diminta</label>
              <div class="col-sm-9">
                <select name="labuh_diminta" type="text" class="form-control" required>
                  <option value=""> - </option>
                  <?php foreach ($arrLabuh as $key => $arrVal) { ?>
                    <option value="<?= $arrVal["id"] ?>" <?= $arrVal["id"] == $arrData["labuh_diminta"] ? "selected" : ""; ?>>
                      <?= $arrVal["nama_dermaga"]; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Tambat yang diminta</label>
              <div class="col-sm-9">
                <select name="tambat_diminta" type="text" class="form-control">
                  <option value=""> - </option>
                  <?php foreach ($arrTambat as $key => $arrVal) { ?>
                    <option value="<?= $arrVal["id"] ?>" <?= $arrVal["id"] == $arrData["tambat_diminta"] ? "selected" : ""; ?>>
                      <?= $arrVal["nama_dermaga"]; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">PBM dan JPT yang ditunjuk</label>
              <div class="col-sm-9">
                <input name="pbm" value="<?= $arrData["pbm"] ?>" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Rencana Kerja Bogkar/Muat</label>
              <div class="col-sm-9">
                <select name="rkbm" class="form-control" required>
                  <option value="1" <?= 1 == $arrData["rkbm"] ? "selected" : ""; ?>>Ada</option>
                  <option value="0" <?= 0 == $arrData["rkbm"] ? "selected" : ""; ?>>Tidak Ada</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Rencana Kegiatan Kapal</label>
              <div class="col-sm-9">
                <select name="rencana_kegiatan" class="form-control" required>
                  <option value="1" <?= 1 == $arrData["rencana_kegiatan"] ? "selected" : ""; ?>>Niaga</option>
                  <option value="0" <?= 0 == $arrData["rencana_kegiatan"] ? "selected" : ""; ?>>Non Niaga</option>
                </select>
              </div>
            </div>

            <h3> Data Bongkar / Muat </h3>

            <button type="button" class="btn btn-sm btn-outline-warning mb-3" data-toggle="modal" data-target="#jenis-barang">
              <i class="bi bi-plus-lg"></i> Tambah Data Barang
            </button>
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <tr>
                  <th width="10%">No</th>
                  <th width="40%">Uraian</th>
                  <th width="20%" class="text-center" colspan="2">Bongkar</th>
                  <th width="20%" class="text-center" colspan="2">Muat</th>
                  <th width="10%" class="text-center">&times</th>
                </tr>
                <tr v-if="arrDataBarang.length < 1 && arrDataNotBarang.length < 1">
                  <td colspan="7" class="text-center">Belum Ada Data</td>
                </tr>
                <tr v-else v-for="(item, index) in arrDataBarang">
                  <td width="10%">{{index + 1}}</td>
                  <td width="40%">{{item.uraian}}</th>
                  <td width="15%" class="text-center">{{ parseFloat(item.bongkar) }} </td>
                  <td width="5%" class="text-center">{{item.satuan}} </td>
                  <td width="15%" class="text-center">{{ parseFloat(item.muat) }} </td>
                  <td width="5%" class="text-center">{{item.satuan}} </td>
                  <td width="10%" class="text-center">
                    <button @click="delete_item(item.id)" type="button" class="btn btn-sm btn-outline-danger">
                      &times
                    </button>
                  </td>
                </tr>
                <tr v-if="jumlahBongkar > 0 || jumlahMuat > 0">
                  <th colspan="2" class="text-center">Jumlah</th>
                  <th width="15%" class="text-center"> {{jumlahBongkar}}</th>
                  <th width="5%" class="text-center">T/M3</th>
                  <th width="15%" class="text-center"> {{jumlahMuat}}</th>
                  <th width="5%" class="text-center">T/M3</th>
                  <th width="10%"></th>
                </tr>
                <tr v-for="(item, index) in arrDataNotBarang">
                  <td width="10%">{{index + 1}}</td>
                  <td width="40%">{{item.uraian}}</th>
                  <td width="15%" class="text-center">{{ parseInt(item.bongkar) }} </td>
                  <td width="5%" class="text-center">{{item.satuan}} </td>
                  <td width="15%" class="text-center">{{ parseInt(item.muat)}} </td>
                  <td width="5%" class="text-center">{{item.satuan}} </td>
                  <td width="10%" class="text-center">
                    <button @click="delete_item(item.id)" type="button" class="btn btn-sm btn-outline-danger">
                      &times
                    </button>
                  </td>
                </tr>
              </table>
            </div>
            <h5> Upload Lampiran </h5>
            <div class="alert alert-info">
              File yang di unggah harus berupa <strong>pdf / jpg</strong> dan ukuran file tidak lebih dari <strong>5 MB</strong>
            </div>

            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <tr>
                  <th width="10%" class="text-center"> No. </th>
                  <th width="60%">Nama Dokumen</th>
                  <th width="15%">Dokumen</th>
                  <th width="15%">Ubah File</th>
                </tr>
                <?php foreach ($arrFile as $key => $arrVal) { ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td>
                      <?= $arrVal["keterangan"]; ?>

                      <?php if ($arrVal["filename"]) { ?>
                        <?php if ($arrData["status"] == "0" && $arrVal["status"] != 1) { ?>
                          <i class="bi bi-patch-exclamation-fill text-warning"></i>
                        <?php } elseif ($arrVal["status"] === "0") { ?>
                          <i class="bi bi-patch-exclamation-fill text-danger"></i>
                        <?php } elseif ($arrVal["status"] == 1) { ?>
                          <i class="bi bi-patch-check-fill text-success"></i>
                        <?php }  ?>
                      <?php } ?>
                    </td>
                    <td class="text-center">
                      <?php if ($arrVal["filename"]) { ?>
                        <a target="_blank" href="<?= base_url("/member/file-lampiran/" . $arrVal["id_file"]); ?>" class="btn btn-outline-info btn-sm">
                          Lihat Dokumen
                        </a>
                      <?php } else { ?>
                        <span> - </span>
                      <?php } ?>
                    </td>
                    <td class="text-center">
                      <?php if ($arrData["status"] == 2 && $arrVal["status"] != 1) { ?>
                        <input type="file" name="file[<?= $arrVal["id"]; ?>]" id="file-<?= $arrVal["id"]; ?>" accept="application/pdf, image/jpg, image/jpeg">
                      <?php } else { ?>
                        <span> - </span>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </table>
            </div>
            <div class="text-right">
              <a href="<?= base_url("/member/tambat-labuh"); ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-90deg-left"></i> Kembali
              </a>
              <?php if ($arrData["status"] == 2) { ?>
                <button @click="submit($event)" data-toggle="modal" data-target="#detail-modal" type="button" class="btn btn-primary btn-sm">
                  <i class="bi bi-save2"></i> Simpan
                </button>
              <?php } elseif ($arrData["status"] == 0) { ?>
                <button type="button" class="btn btn-success btn-sm">
                  <i class="bi bi-patch-check-fill"></i> Data Sedang Diproses.
                </button>
              <?php } ?>
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>

  <div class="modal fade" id="jenis-barang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Data Barang!</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Uraian</label>
            <div class="col-sm-9">
              <select @change="search_jenis_barang()" v-model="jenis_barang_id" class="form-control">
                <?php foreach ($arrJenisBarang as $key => $arrVal) { ?>
                  <option value="<?= $arrVal["id"]; ?>"><?= $arrVal["uraian"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Bonkar</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input v-model="bongkar" type="number" step=".01" class="form-control" autocomplete="off" />
                <div class="input-group-append">
                  <span class="input-group-text">
                    {{detailBarang.satuan}}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Muat</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input v-model="muat" type="number" step=".01" class="form-control" autocomplete="off" />
                <div class="input-group-append">
                  <span class="input-group-text">
                    {{detailBarang.satuan}}
                  </span>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button @click="tambahkan_jenis_barang()" type="button" class="btn btn-primary">
            Tambahkan
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="detail-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Notifikasi!</h5>
          <button v-if="sendError" type="button" id="btn-close" class="close " data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info">
            {{msg_modal}}
          </div>
          <div v-if="!sendStatus" class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </div>
        <div v-if="sendStatus && !sendError" class="modal-footer">
          <button type="button" @click="location.reload();" class="btn btn-primary btn-sm">
            <i class="bi bi-patch-check-fill"></i> Oke!
          </button>
        </div>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script>
  var jsConfig = {
    fileList: <?= json_encode($arrFile); ?>,
  };

  var formconfig = <?= json_encode($arrConfig); ?>
</script>

<script src="<?= base_url("/assets/js/bootstrap-datepicker.min.js") ?>" defer></script>
<script src="<?= base_url("/assets/js/controller/tambat-labuh/edit.js?v=0") ?>" defer></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<?= $this->endSection() ?>