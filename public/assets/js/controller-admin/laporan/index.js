var index = new Vue({
  el: "#data-vue",

  data: {
    status: 0,
    retrieve_process: false,

    mdl_year: "",
    items: [],

    dataStatistik: {
      menunggu: 0,
      diterima: 0,
      ditolak: 0,
      total: 0,
    },

    apbn_current_page: 1,
    apbn_count_start: 1,
    apbn_total_page: 1,
    apbn_page: 1,
    apbn_perpage: 10,

    apbn_statistik: {
      menunggu: 0,
      diterima: 0,
      ditolak: 0,
      total: 0,
    },
    apbn_data: [],

    mdl_apbn_year: "",
    mdl_apbn_bulan: "",

    detail_kapal: {},
    retrieve_process: true,
  },

  methods: {
    get_bulan: function () {
      let that = this;

      let datasend = {
        params: {},
      };

      let url = "/admin/laporan/daftar-bulan/" + this.mdl_year;
      axios.get(url, datasend).then((response) => {
        that.items = response.data.data;
      });
    },

    get_stats: function () {
      let that = this;

      let url = "/admin/laporan/statistik/" + this.mdl_year;
      axios.get(url).then((response) => {
        that.dataStatistik = response.data.arrStats;
        that.dataStatistik.total =
          parseInt(that.dataStatistik.diterima) +
          parseInt(that.dataStatistik.ditolak) +
          parseInt(that.dataStatistik.menunggu);
      });
    },

    get_all: function () {
      this.get_bulan();
      this.get_stats();
    },

    tab_click: function (tab, e) {
      e.preventDefault();
      this.tab = tab;
    },

    print_laporan_bulanan: function (month) {
      let href =
        "/admin/laporan/print_bulanan?year=" +
        this.mdl_year +
        "&month=" +
        month;

      let iframe = document.getElementById("iframe-print-laporan");
      iframe.setAttribute("src", href);
    },

    print_laporan_harian: function () {
      let date = document.getElementById("datepicker").value;
      if (date == "") {
        alert("Harap Mengisi Tanggal terlebih dahulu");
      }

      let href = "/admin/laporan/print_harian?date=" + date;
      let iframe = document.getElementById("iframe-print-laporan");
      iframe.setAttribute("src", href);
    },

    // apbn
    apbn_on_change: function () {
      this.apbn_current_page = 1;
      // this.apbn_get_statistik();
      this.apbn_get_data();
    },

    apbn_print: function (e) {
      let href =
        "/admin/laporan/print_apbn?year=" +
        this.mdl_apbn_year +
        "&month=" +
        this.mdl_apbn_bulan;

      if (this.mdl_apbn_bulan == "") {
        alert("Pilih Bulan Terlebih Dahulu");
        e.stopPropagation();
        return;
      }
      let iframe = document.getElementById("iframe-print-laporan");
      iframe.setAttribute("src", href);
    },

    apbn_get_data: function () {
      let that = this;
      let params = {
        params: {
          year: this.mdl_apbn_year,
          month: this.mdl_apbn_bulan,
          page: this.apbn_current_page,
          perpage: this.apbn_perpage,
        },
      };
      let url = "/admin/laporan/apbn-data";
      axios.get(url, params).then((response) => {
        that.apbn_data = response.data.data;
        that.apbn_total_page = response.data.totalpage;
        that.apbn_count_start =
          (that.apbn_current_page - 1) * that.apbn_perpage + 1;
        that.apbn_statistik.diterima = response.data.total;
      });
    },

    apbn_pagination: function (pagejump, event) {
      event.preventDefault();
      if (
        this.apbn_current_page + pagejump >= 1 &&
        this.apbn_current_page + pagejump <= this.apbn_total_page
      ) {
        this.apbn_current_page = this.apbn_current_page + pagejump;
        this.apbn_get_data();
      }
    },

    apbn_detail: function (id, e) {
      e.preventDefault();
      let that = this;
      this.retrieve_process = false;

      axios
        .get("/admin/pengoprasian-kapal/" + id)
        .then((response) => {
          that.detail_kapal = response.data.arrData;
          that.retrieve_process = true;
        })
        .catch((error) => {
          //
        });
    },
  },

  mounted: function () {
    this.mdl_year = new Date().getFullYear();
    this.mdl_apbn_year = this.mdl_year;

    this.get_all();
    $("#datepicker").datepicker({
      orientation: "bottom auto",
      autoclose: true,
    });

    if (jsConfig.activeTab == "apbn") {
      document.getElementById("apbn-tab").click();
    }

    let iframe = document.getElementById("iframe-print-laporan");
    iframe.addEventListener("load", () => {
      if (iframe.getAttribute("src") != "#") {
        document.getElementById("btn-close").click();
      }
    });
  },
});
