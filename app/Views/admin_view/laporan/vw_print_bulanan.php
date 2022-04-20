<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= APPS_NAME; ?> KSOP BITUNG | <?= $title; ?> </title>
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

          <table class="table table-bordered table-sm">
            <tr>
              <th width="5%" style="border-bottom:1px solid #555;">No.</th>
              <th width="20%" style="border-bottom:1px solid #555;">Nama Agen</th>
              <th width="18%" style="border-bottom:1px solid #555;">Nama Kapal</th>
              <th width="10%" style="border-bottom:1px solid #555;">GT / DWT</th>
              <th width="5%" style="border-bottom:1px solid #555;">LOA</th>
              <th width="5%" style="border-bottom:1px solid #555;">Bendera</th>
              <th width="17%" style="border-bottom:1px solid #555;">Dermaga</th>
              <th width="20%" style="border-bottom:1px solid #555;">ETA / ETD</th>
            </tr>
            <?php if (count($arrData) < 1) { ?>
              <tr>
                <th colspan="8" class="text-center"> Belum Ada Data</th>
              </tr>
            <?php } else { ?>
              <?php foreach ($arrData as $key => $arrVal) { ?>

                <tr>
                  <td rowspan="2" style="vertical-align: middle; border-bottom:1px solid #555;" class="text-center"><?= (int) $key + 1 ?></td>
                  <td><?= $arrVal["nama_agen"]; ?></td>
                  <td><?= $arrVal["nama_kapal"]; ?></td>
                  <td><?= $arrVal["gt"] . " / " . $arrVal["dwt"] ?></td>
                  <td><?= $arrVal["loa"]; ?></td>
                  <td><?= $arrVal["bendera"]; ?></td>
                  <td><?= $arrVal["tambat"] ? $arrVal["tambat"] : $arrVal["labuh"]; ?></td>
                  <td>
                    <?= $arrVal["eta_date"] . " " . $arrVal["eta_time"]; ?> / <br />
                    <?= $arrVal["etd_date"] . " " . $arrVal["etd_time"]; ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="4" style="border-bottom:1px solid #555;">
                    diajukan: <?= $arrVal["created_at"]; ?> ~
                    diproses: <?= $arrVal["proceed_at"]; ?> /
                    <?php
                    $diajukan = new DateTime($arrVal["created_at"]);
                    $diproses = new DateTime($arrVal["proceed_at"]);
                    $interval = $diajukan->diff($diproses);

                    $diff = $interval->format('%d:%h:%i');
                    list($day, $hour, $minutes) = explode(":", $diff);

                    echo $day ? $day . "hari" : "";
                    echo !$day && $hour ? $hour . "jam" : "";
                    echo !$day && !$hour && $minutes ? $minutes . "m " : "";
                    ?>
                  </td>
                  <td colspan="2" style="border-bottom:1px solid #555;">oleh: <?= $arrVal["nama_user"]; ?></td>
                  <td style="border-bottom:1px solid #555;">status: <strong><?= $arrStatus[$arrVal["status"]]; ?></strong></td>
                </tr>
              <?php } ?>
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