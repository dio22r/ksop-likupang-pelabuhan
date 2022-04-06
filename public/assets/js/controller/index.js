var index = new Vue({
  el: "#data-vue",

  data: {
    count_start: 1,
    page: 1,
    search: "",
    current_page: 1,
    total_page: 1,
    perpage: 15,

    items: [],

    detail: {},
    detail_status: false,

    retrieve_process: true,
  },

  methods: {
    get_all: function () {
      that = this;

      let datasend = {
        params: {
          page: this.current_page,
          limit: this.perpage,
          search: this.search,
        },
      };

      let url = "/all";
      axios.get(url, datasend).then((response) => {
        that.items = response.data.data;
        that.total_page = response.data.totalpage;
        that.count_start = (that.current_page - 1) * that.perpage + 1;
      });
    },

    search_data: function () {
      this.current_page = 1;
      this.search = document.getElementById("search").value;
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

      axios.get("/daftar/" + id).then((response) => {
        that.detail_status = response.data.status;
        that.detail = response.data.arrData;
        that.retrieve_process = true;
      });
    },
  },

  mounted: function () {
    $(".datepicker").datepicker({
      orientation: "bottom auto",
      autoclose: true,
    });

    this.get_all();

    console.log(page_config);
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: page_config.data_stats.label,
        datasets: [
          {
            label: "# Jumlah Tambat",
            data: page_config.data_stats.total,
            backgroundColor: ["rgba(23, 46, 89, 0.2)", "rgba(23, 46, 89, 0.2)"],
            borderColor: ["rgba(23, 46, 89, 1)", "rgba(23, 46, 89, 1)"],
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  },
});
