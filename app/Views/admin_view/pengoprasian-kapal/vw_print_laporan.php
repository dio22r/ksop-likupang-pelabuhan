<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= FULL_APPS_NAME; ?> | Print Validasi </title>
  <!-- Tell the browser to be responsive to screen width -->

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!-- Font Awesome -->

</head>

<body onload="window.print();" style="min-width:1024px;">
  <!--  -->
  <div class="wrapper">
    <!-- Main content -->
    <section class="laporan">
      <!-- title row -->

      <?= $this->include('admin_widget/printKop') ?>

      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-12">
          <h4 class="text-center mt-3 mb-3"><?= $title ?></h4>


          <table class="table table-sm table-borderless">
            <tr>
              <th width="20%">Status</th>
              <td width="80%">
                <?php if ($arrData["deleted_at"]) { ?>
                  <strong>DIHAPUS</strong>
                <?php } else { ?>
                  <?php if ($arrData["status"] == 1) { ?>
                    <strong>DISETUJUI</strong>
                  <?php } elseif ($arrData["status"] == -1) { ?>
                    <strong>DITOLAK</strong>
                  <?php } elseif ($arrData["status"] == 2) { ?>
                    <strong>MENUNGGU PERBAIKAN</strong>
                  <?php } else { ?>
                    <strong>MENUNGGU</strong>
                  <?php } ?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>Divalidasi Oleh</th>
              <td>
                <?= isset($arrValidasi["user_nama"]) ? $arrValidasi["user_nama"] : " - "; ?> /
                <?= isset($arrValidasi["created_at"]) ? $arrValidasi["created_at"] : " - "; ?>
              </td>
            </tr>
            <tr>
              <th>Keterangan</th>
              <td><?= isset($arrValidasi["keterangan"]) ? nl2br($arrValidasi["keterangan"]) : " - "; ?></td>
            </tr>
          </table>

          <table class="table table-sm table-bordered">
            <tr>
              <th>Tanggal Daftar</th>
              <td><?= $arrData["created_at"]; ?></td>
            </tr>
            <tr>
              <th width="30%">Nama Kapal / Bendera</th>
              <td width="70%">
                <?= $arrData["nama_kapal"]; ?> /
                <?= $arrData["bendera"]; ?>
              </td>
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
                <td width="10%"><?= $key + 1 ?></td>
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
                <td width="10%"><?= $key + 1 ?></td>
                <td width="40%"><?= $arrVal["uraian"]; ?></th>
                <td width="15%" class="text-center"><?= floatval($arrVal["bongkar"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
                <td width="15%" class="text-center"><?= floatval($arrVal["muat"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
              </tr>
            <?php } ?>
          </table>

          <table class="table table-sm table-bordered">
            <tr>
              <th width="8%" class="text-center"> No. </th>
              <th width="65%">Nama Dokumen</th>
              <th width="15%" class="text-center">Dokumen</th>
              <th width="12%" class="text-center">Status</th>
            </tr>
            <?php foreach ($arrFile as $key => $arrVal) { ?>
              <tr>
                <td class="text-center"><?= $key + 1 ?></td>
                <td><?= $arrVal["keterangan"]; ?></td>
                <td class="text-center"><?= $arrVal["filename"] ? "Ada" : " - "; ?></td>
                <td class="text-center">
                  <?php if ($arrVal["filename"]) { ?>
                    <?php if ($arrValidasi) { ?>
                      <?= $arrVal["status"] == 1 ? "Disetujui" : "Ditolak"; ?>
                    <?php } else { ?>
                      <span> - </span>
                    <?php } ?>
                  <?php } else { ?>
                    <span> - </span>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </table>
        </div>
      </div>
      <!-- /.row -->
      <style>
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
          height: 150px;
          width: 150px;
          position: absolute;
        }

        .label-warper-qrcode {
          display: flex;
          justify-content: center;
          align-items: center;
          text-align: center;
          width: 150px;
          margin-top: 150px;
          font-weight: bold;
          line-height: 16px;

        }
      </style>

      <?php if ($qrcode) { ?>
        <div class="row invoice-info">
          <div class="col-4 offset-8 text-center qrcode-warper">
            <div class="img-warper-qrcode">
              <img width="150px" src="<?= $qrcode; ?>" />
            </div>
            <div class="img-warper-qrcode">
              <img width="40px" height="40px" src="<?php echo base_url("/assets/images/ksop.png"); ?>" />
            </div>
            <div class="label-warper-qrcode">
              <?= APPS_NAME; ?><br />
              KSOP KELAS II BITUNG
            </div>
          </div>
        </div>
      <?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
</body>

</html>