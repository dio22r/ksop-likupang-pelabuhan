var index = new Vue({
  el: "#data-vue",

  data: {
    count_start: 1,
    page: 1,
    search: "",
    current_page: 1,
    total_page: 1,
    perpage: 20,

    status: 0,
    retrieve_process: false,

    detail_kapal: {},
    items: [],

    timenow: {
      year: 0,
      month: 0,
      day: 0,
      hour: 0,
      minutes: 0,
      second: 0,
      time: 0,
    },

    timelimit: 60 * 60 * 1000,
  },

  methods: {
    get_all: function () {
      that = this;

      let datasend = {
        params: {
          page: this.current_page,
          limit: this.perpage,
          search: this.search,
          status: this.status,
        },
      };

      let url = "/member/tambat-labuh/list";
      axios.get(url, datasend).then((response) => {
        that.items = response.data.data;
        that.total_page = response.data.totalpage;
        that.count_start = (that.current_page - 1) * that.perpage + 1;
      });
    },

    on_search: function (e) {
      e.preventDefault();
      this.search = document.getElementById("datepicker").value;
      this.current_page = 1;
      this.get_all();
    },

    tab_click: function (status, e) {
      e.preventDefault();
      this.status = status;
      this.search = "";
      this.get_all();
    },

    pagination: function (pagejump, event) {
      event.preventDefault();
      if (
        this.current_page + pagejump >= 1 &&
        this.current_page + pagejump <= this.total_page
      ) {
        this.current_page = this.current_page + pagejump;
        this.get_all();
      }
    },

    view_detail: function (id, e) {
      e.preventDefault();
      let that = this;
      this.retrieve_process = false;

      axios
        .get("/member/tambat-labuh/detail/" + id)
        .then((response) => {
          that.detail_kapal = response.data.arrData;
          that.retrieve_process = true;
        })
        .catch((error) => {
          //
        });
    },

    action_delete: function (id, e) {
      e.preventDefault();
      let that = this;
      let conf = confirm("Apakah Anda akan Menghapus data ini?");

      if (conf) {
        axios
          .delete("/admin/pengoprasian-kapal/" + id)
          .then((response) => {
            if (response.data.status) {
              alert("Data berhasil dihapus!");
              document.getElementById("btn-close").click();
              that.get_all();
            } else {
              alert("Data tidak bisa dihapus karena sudah diproses!");
            }
          })
          .catch((error) => {
            alert("Data gagal terhapus, silahkan coba lagi!");
          });
      }
    },
  },

  mounted: function () {
    this.get_all();
    $(".datepicker").datepicker({
      orientation: "bottom auto",
      autoclose: true,
    });

    let now = new Date();

    this.timenow = {
      year: now.getFullYear(),
      month: now.getMonth(),
      day: now.getDate(),
      hour: now.getHours(),
      minutes: now.getMinutes(),
      second: now.getSeconds(),
      time: now.getTime(),
    };

    setInterval(() => {
      this.timenow.second += 1;

      if (this.timenow.second == 60) {
        this.timenow.minutes += 1;
        this.timenow.second = 0;
      }

      if (this.timenow.minutes == 60) {
        this.timenow.hour += 1;
        this.timenow.minutes = 0;
      }

      if (this.timenow.hour == 24) {
        this.timenow.day += 1;
        this.timenow.hour = 0;
      }

      this.timenow.time += 1000;
    }, 1000);

    setInterval(() => {
      this.get_all();
    }, 2 * 60 * 1000);
  },
});
