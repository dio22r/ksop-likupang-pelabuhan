<?= $this->extend('layout/member') ?>

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
      <div class="card">
        <div class="card-header">
          Data
        </div>
        <div class="card-body">
          <table class="table table-sm table-bordered">
            <tr>
              <th>Status</th>
              <td>
                <?php if ($arrData["status"] == 1) { ?>
                  <span class="badge badge-success">Disetujui</span>
                <?php } elseif ($arrData["status"] == -1) { ?>
                  <span class="badge badge-danger">Ditolak</span>
                <?php } elseif ($arrData["status"] == 2) { ?>
                  <span class="badge badge-warning">Menunggu Perbaikan</span>
                <?php } else { ?>
                  <span class="badge badge-secondary">Menunggu</span>
                <?php } ?>

                <?php if ($arrData["deleted_at"]) { ?>
                  / <span class="badge badge-danger">
                    <i class="bi bi-trash-fill"></i> dihapus
                  </span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>Tanggal Daftar</th>
              <td><?= $arrData["created_at"]; ?></td>
            </tr>
            <tr>
              <th width="30%">Nama Kapal</th>
              <td width="70%"><?= $arrData["nama_kapal"]; ?></td>
            </tr>
            <tr>
              <th>Bendera</th>
              <td><?= $arrData["bendera"]; ?></td>
            </tr>
            <tr>
              <th>GT / DWT / Jenis Kapal</th>
              <td><?= $arrData["gt"] . " / " . $arrData["dwt"] . " / " . $arrData["nama_jenis_kapal"]; ?></td>
            </tr>
            <tr>
              <th>LOA</th>
              <td><?= $arrData["loa"]; ?></td>
            </tr>
            <tr>
              <th>Pemilik / Principle</th>
              <td><?= $arrData["pemilik"]; ?></td>
            </tr>
            <tr>
              <th>Nama Agen</th>
              <td><?= $arrData["nama_agen"]; ?></td>
            </tr>
            <tr>
              <th>Nama Nahkoda</th>
              <td><?= $arrData["nama_nahkoda"]; ?></td>
            </tr>
            <tr>
              <th>Trayek</th>
              <td><?= $arrData["trayek"]; ?></td>
            </tr>
            <tr>
              <th>Jenis Pelayaran</th>
              <td><?= $arrData["jenis_pelayaran"]; ?></td>
            </tr>
            <tr>
              <th>ETA / ETD</th>
              <td>
                <?= $arrData["etd_date"] . " " . $arrData["etd_time"]; ?> /
                <?= $arrData["eta_date"] . " " . $arrData["eta_time"]; ?>
              </td>
            </tr>
            <tr>
              <th>Pelabuhan Asal / Tujuan</th>
              <td><?= $arrData["pelabuhan_asal"] . " / " . $arrData["pelabuhan_tujuan"]; ?></td>
            </tr>
            <tr>
              <th>Labuh yang diminta</th>
              <td><?= $arrData["labuh"]; ?></td>
            </tr>
            <tr>
              <th>Tambat yang diminta</th>
              <td><?= $arrData["tambat"]; ?></td>
            </tr>
            <tr>
              <th>Dock yang diminta</th>
              <td><?= $arrData["dock"]; ?></td>
            </tr>
            <tr>
              <th>PBM dan JPT yang ditunjuk</th>
              <td><?= $arrData["pbm"]; ?></td>
            </tr>
            <tr>
              <th>Rencana Kerja Bongkar / Muat</th>
              <td><?= $arrData["rkbm"]; ?></td>
            </tr>
            <tr>
              <th>Rencana Kegiatan Kapal</th>
              <td><?= $arrData["rencana_kegiatan"] ? "Niaga" : "Non-Niaga"; ?></td>
            </tr>
          </table>

          <h5>Data Barang </h5>

          <table class="table table-sm table-bordered">
            <tr>
              <th width="10%">No</th>
              <th width="40%">Uraian</th>
              <th width="25%" class="text-center" colspan="2">Bongkar</th>
              <th width="25%" class="text-center" colspan="2">Muat</th>

            </tr>
            <?php if (count($arrDataBarang["barang"]) < 1 && count($arrDataBarang["nonbarang"]) < 1) { ?>
              <tr>
                <td colspan="7" class="text-center">Belum Ada Data</td>
              </tr>
            <?php } ?>

            <?php
            $totalBongkar = 0;
            $totalMuat = 0;
            ?>

            <?php foreach ($arrDataBarang["barang"] as $key => $arrVal) { ?>
              <tr>
                <td width="10%" class="text-center"><?= $key + 1 ?></td>
                <td width="40%"><?= $arrVal["uraian"]; ?></th>
                <td width="15%" class="text-center"><?= floatval($arrVal["bongkar"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
                <td width="15%" class="text-center"><?= floatval($arrVal["muat"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
              </tr>
              <?php
              $totalBongkar += $arrVal["bongkar"];
              $totalMuat += $arrVal["muat"];
              ?>
            <?php } ?>
            <?php if (count($arrDataBarang["barang"]) > 0) { ?>
              <tr>
                <th colspan="2" class="text-center">Jumlah</th>
                <th width="15%" class="text-center"> <?= $totalBongkar ?> </th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="15%" class="text-center"> <?= $totalMuat ?></th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="10%"></th>
              </tr>
            <?php } ?>
            <?php foreach ($arrDataBarang["nonbarang"] as $key => $arrVal) { ?>
              <tr>
                <td width="10%" class="text-center"><?= $key + 1 ?></td>
                <td width="40%"><?= $arrVal["uraian"]; ?></th>
                <td width="15%" class="text-center"><?= floatval($arrVal["bongkar"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
                <td width="15%" class="text-center"><?= floatval($arrVal["muat"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
              </tr>
            <?php } ?>
          </table>

          <h5> Upload Lampiran </h5>
          <div class="alert alert-info">
            File yang di unggah harus berupa <strong>pdf / jpg</strong> dan ukuran file tidak lebih dari <strong>5 MB</strong>
          </div>
          <form id="form-perbaikan" data-id="<?= $arrData["id"]; ?>" method="post" enctype="multipart/form-data">
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
                      <a target="_blank" href="<?= base_url("/member/file-lampiran/" . $arrVal["id_file"]) . "/"; ?>" class="btn btn-outline-info btn-sm">
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

<script>
  var jsConfig = {
    fileList: <?= json_encode($arrFile); ?>,
  };
</script>
<?= $this->endSection() ?>