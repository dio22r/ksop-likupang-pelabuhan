var apbn = new Vue({
  el: "#apbn",

  data: {},

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
  },

  mounted: function () {
    this.mdl_year = new Date().getFullYear();
    this.get_all();
    $("#datepicker").datepicker({
      orientation: "bottom auto",
      autoclose: true,
    });

    let iframe = document.getElementById("iframe-print-laporan");
    iframe.addEventListener("load", () => {
      if (iframe.getAttribute("src") != "#") {
        document.getElementById("btn-close").click();
      }
    });
  },
});
