var index = new Vue({
  el: "#data-vue",

  data: {
    count_start: 1,
    page: 1,
    search: "",
    current_page: 1,
    total_page: 1,
    perpage: 20,

    status: 1,
    retrieve_process: false,

    detail: {},
    items: [],
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

      let url = "/admin/user-management/all";
      axios.get(url, datasend).then((response) => {
        that.items = response.data.data;
        that.total_page = response.data.totalpage;
        that.count_start = (that.current_page - 1) * that.perpage + 1;
      });
    },

    on_search: function (e) {
      e.preventDefault();
      this.current_page = 1;
      this.get_all();
    },

    tab_click: function (status, e) {
      e.preventDefault();
      this.status = status;
      this.current_page = 1;
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
        .get("/admin/user-management/" + id)
        .then((response) => {
          that.detail = response.data.arrData;
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
          .delete("/admin/user-management/" + id)
          .then((response) => {
            alert("Data berhasil dihapus!");
            document.getElementById("btn-close").click();
            that.get_all();
          })
          .catch((error) => {
            alert("Data gagal terhapus, silahkan coba lagi!");
          });
      }
    },
  },

  mounted: function () {
    this.get_all();
  },
});
