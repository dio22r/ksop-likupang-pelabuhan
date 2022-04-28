var edit = new Vue({
  el: "#data-vue",

  data: {
    sendStatus: false,
    sendError: false,
    errors: [],

    msg_modal: "",
    save_status: "",

    jenis_barang_id: "",
    bongkar: 0,
    muat: 0,

    detailBarang: {
      id: "",
      uraian: "",
      satuan: " - ",
    },

    arrDataBarang: [],
    arrDataNotBarang: [],
    jumlahBongkar: 0,
    jumlahMuat: 0,
  },

  methods: {
    submit: function (e) {
      e.preventDefault();
      let self = this;
      let form = document.getElementById("form-perbaikan");

      let conf = confirm("Apakah Anda yakin akan menyimpan data ini?");
      if (!conf) {
        e.stopPropagation();
        return;
      }

      form.classList.add("was-validated");
      if (form.checkValidity() === false) {
        e.stopPropagation();
        return;
      }

      this.sendStatus = false;
      let formData = new FormData(form);
      let arrBarang = this.arrDataBarang.concat(this.arrDataNotBarang);

      arrBarang.forEach((item, index) => {
        formData.append("jenis_barang_id[]", item.id);
        formData.append("bongkar[]", item.bongkar);
        formData.append("muat[]", item.muat);
      });

      let config = {
        headers: { "Content-Type": "multipart/form-data" },
      };

      url = form.action;
      axios
        .post(url, formData, config)
        .then((response) => {
          if (response.data.status) {
            self.sendError = false;
            self.msg_modal = "Data Berhasil terupload";
          } else {
            self.sendError = true;
            self.msg_modal =
              "Data gagal terupload dikarenakan : \n\n" +
              response.data.arrError.join("\n");
          }
          // console.log(response);
          self.sendStatus = true;
        })
        .catch((error) => {
          self.msg_modal = "Terjadi kesalahan pada sistem";
          self.sendStatus = false;
          self.sendError = true;
        });
    },

    search_jenis_barang: function () {
      this.detailBarang = this.arrJenisBarang.find((element) => {
        return element.id == this.jenis_barang_id;
      });
    },

    tambahkan_jenis_barang: function () {
      let check = this.arrDataBarang.filter((element) => {
        return element.id == this.detailBarang.id;
      });

      let check2 = this.arrDataNotBarang.filter((element) => {
        return element.id == this.detailBarang.id;
      });

      if (check.length < 1 && check2.length < 1) {
        if (!isNaN(parseFloat(this.bongkar))) {
          this.detailBarang.bongkar = parseFloat(this.bongkar);
        } else {
          this.detailBarang.bongkar = 0;
        }
        if (!isNaN(parseFloat(this.muat))) {
          this.detailBarang.muat = parseFloat(this.muat);
        } else {
          this.detailBarang.muat = 0;
        }

        if (
          (this.detailBarang.bongkar > 0 || this.detailBarang.muat > 0) &&
          this.detailBarang.bongkar >= 0 &&
          this.detailBarang.muat >= 0
        ) {
          if (this.detailBarang.type == 1) {
            this.arrDataBarang.push(this.detailBarang);
          } else {
            this.arrDataNotBarang.push(this.detailBarang);
          }

          this.count_jumlah();
        }
      } else {
        alert("Jenis barang sudah ada");
      }
    },

    delete_item: function (id) {
      this.arrDataBarang = this.arrDataBarang.filter((element) => {
        return element.id != id;
      });
      this.arrDataNotBarang = this.arrDataNotBarang.filter((element) => {
        return element.id != id;
      });
      this.count_jumlah();
    },

    count_jumlah: function () {
      this.jumlahBongkar = 0;
      this.jumlahMuat = 0;
      this.arrDataBarang.forEach((element) => {
        if (element.type == 1) {
          this.jumlahBongkar += parseFloat(element.bongkar);
          this.jumlahMuat += parseFloat(element.muat);
        }
      });
    },
  },

  mounted: function () {
    this.token = jsConfig.token;

    $(".datepicker").datepicker({
      orientation: "bottom auto",
      autoclose: true,
    });

    this.arrJenisBarang = formconfig.arrJenisBarang;
    this.arrDataBarang = formconfig.arrDataBarang.barang;
    this.arrDataNotBarang = formconfig.arrDataBarang.nonbarang;

    console.log(formconfig.arrDataBarang);

    this.count_jumlah();
  },
});
