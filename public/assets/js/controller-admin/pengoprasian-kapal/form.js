var form = new Vue({
  el: "#data-vue",

  data: {
    retrieve_process: false,
    lock_close_btn: true,

    save_status: false,
    msg_modal: "Harap menunggu data anda sedang diproses!",
    detail_kapal: {},

    mdl_status: "",
    mdl_keterangan: "",
  },

  methods: {
    submit: function (e) {
      e.preventDefault();
      let self = this;
      let form = document.getElementById("form-validasi");

      let conf = confirm("Apakah Anda yakin akan melakukan validasi data ini?");
      if (!conf) {
        e.stopPropagation();
        return;
      }

      form.classList.add("was-validated");
      if (form.checkValidity() === false) {
        e.stopPropagation();
        return;
      }

      let arrCheck = document.querySelectorAll(".check-stats");

      let files = [];
      arrCheck.forEach((element) => {
        file = {
          id: element.getAttribute("data-id"),
          val: element.value,
        };

        files.push(file);
      });

      let data = {
        status: this.mdl_status,
        keterangan: this.mdl_keterangan,
        files: files,
      };

      let id = form.getAttribute("data-id");
      url = "/admin/pengoprasian-kapal/" + id;
      axios
        .put(url, data)
        .then((response) => {
          self.save_status = response.data.status;
          if (response.data.status) {
            self.msg_modal = "Data berhasil tersimpan";
            self.lock_close_btn = true;
          } else {
            self.lock_close_btn = false;
          }
        })
        .catch((error) => {
          self.msg_modal = "Silahkan coba lagi!";
          self.lock_close_btn = false;
        });
    },

    on_select_change: function () {
      let arrCheck = document.querySelectorAll(".check-stats");

      let arrKet = [];
      arrCheck.forEach((element) => {
        if (element.value == 0) {
          let obj = this.fileList.find((value) => {
            return value.id == element.getAttribute("data-id");
          });

          arrKet.push(" - " + obj.keterangan + ".");
        }
      });

      if (arrKet.length > 0) {
        this.mdl_status = -1;
        this.mdl_keterangan =
          "Dokumen berikut tidak valid : \n\n" + arrKet.join("\n");
      } else {
        this.mdl_status = 1;
        this.mdl_keterangan = "";
      }
    },
  },

  mounted: function () {
    this.op_kapal_id = jsConfig.op_kapal_id;
    this.fileList = jsConfig.fileList;

    console.log(this.fileList);
  },
});
