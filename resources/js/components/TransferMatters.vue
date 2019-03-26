<template>
  <div class="h-100">
    <p>{{employeeTest}}</p>
    <div v-if="!gridstackflag" class="container-fluid" id="transfer-matters">
      <div class="row">
        <div class="col-md-9">
          <div class="card shadow rounded">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <div>
                  <h2 class="mb-0">{{title}}</h2>
                  <!-- <p class="mb-0" v-html="subTitle"> -->
                  <p class="mb-0">
                    <strong>From</strong>
                    :{{startDate}}
                    <strong>To</strong>
                    :{{endDate}}
                    <!-- <strong>Employee</strong>
                    :{{employee}}-->
                    <strong>Document Set</strong>
                    :{{docgen}}
                  </p>

                  <template v-if="error">
                    <error-message :message="errorMessage"></error-message>
                  </template>
                </div>
                <div>
                  <a href="#" title="Save the dashboard widget with these settings">
                    <i class="material-icons md-36">save</i>
                  </a>
                  <a href="#" title="Back to the dashboard" v-on:click="returnToDashBoard">
                    <i class="material-icons md-36">zoom_out</i>
                  </a>
                  <!-- <a href="#" v-if="gridstackflag && minimized" title="Maximize" v-on:click="maximizeWidget"><i class="material-icons">open_with</i></a>
                  <a href="#" title="Minimize" v-if="maximized" v-on:click="minimizeWidget"><i class="material-icons">indeterminate_check_box</i></a>-->
                </div>
              </div>
            </div>

            <div class="card-body">
              <canvas class="canvas" id="TransferMattersChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow rounded">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <div>
                  <h2>Filters</h2>
                </div>
                <div>
                  <a href="#" title="Refresh">
                    <i class="material-icons">refresh</i>
                  </a>
                </div>
              </div>
            </div>

            <div class="card-body">
              <form>
                <div class="form-group row">
                  <label for="name" class="col-sm-4 col-form-label text-md-right">Filter Date By:</label>
                  <div class="col-md-6">
                    <input type="radio" id="thisWeek" value="thisWeek" v-model="dateFilterType">
                    <label for="one">This Week</label>
                    <br>
                    <input type="radio" id="thisMonth" value="thisMonth" v-model="dateFilterType">
                    <label for="two">This Month</label>
                    <br>
                    <input type="radio" id="thisYear" value="thisYear" v-model="dateFilterType">
                    <label for="three">This Year</label>
                    <br>
                    <input
                      type="radio"
                      id="customDateInput"
                      value="customDateInput"
                      v-model="dateFilterType"
                    >
                    <label for="four">Custom Dates</label>
                  </div>
                </div>
                <template v-if="dateFilterType === 'customDateInput'">
                  <div class="form-group row">
                    <label for="year" class="col-md-4 col-form-label text-md-right">From</label>
                    <div class="col-md-6">
                      <input
                        class="form-control"
                        type="text"
                        id="startDate"
                        v-model="startDate"
                        @change="onApply"
                        required
                      >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="year" class="col-md-4 col-form-label text-md-right">To</label>
                    <div class="col-md-6">
                      <input
                        class="form-control"
                        type="text"
                        id="endDate"
                        v-model="endDate"
                        @change="onApply"
                        required
                      >
                      <!-- 
                    <input
                      v-model="endDate"
                      id="endDate"
                      type="date"
                      class="form-control"
                      value
                      required
                      @change="onApply"
                      >-->
                    </div>
                  </div>
                </template>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!gridstackflag" class="row mt-5">
      <div class="col-md-9">
        <div class="card shadow rounded">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <div>
                <h2>Data</h2>
              </div>
              <div>
                <a href="#" title="Refresh">
                  <i class="material-icons">refresh</i>
                </a>
              </div>
            </div>
          </div>

          <div class="card-body">
            <table
              id="transferMattersTable"
              class="table table-striped table-bordered nowrap"
              style="width:100%"
            >
              <thead>
                <tr>
                  <th>File Ref</th>
                  <th>Description</th>
                  <th>Date Instructed</th>
                  <th>Belongs To</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div v-if="gridstackflag" class="table container">
      <div class="table-row card-header">
        <table>
          <tr>
            <td class="report-heading" title>
              <h2 class="mb-0">{{title}}</h2>
              <p class="mb-0" v-html="subTitle"></p>
            </td>
            <td>
              <a href="#" title="View details and change settings" v-on:click="displayWidgetPage">
                <i class="material-icons md-36">zoom_in</i>
              </a>
            </td>
          </tr>
        </table>
      </div>

      <div class="table-row body">
        <div class="table-cell body-content-outer-wrapper">
          <div class="body-content-inner-wrapper">
            <div class="body-content">
              <div class="row">
                <div class="col-md-12">
                  <canvas class="canvas" id="TransferMattersChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Chart from "chart.js";
//import * from "jquery";
export default {
  props: {
    msg: String,
    gridstackflag: Boolean
  },
  data: {},

  data() {
    return {
      dateFilterType: "customDateInput",
      thisWeek: true,
      thisMonth: false,
      thisYear: false,
      customDateInput: false,
      recordId: 1,
      title: "Transfer Matters",
      description: "Source of Business with Fee Estimate",
      dashboard: "Conveyancing",
      id: "TransferMatters",
      widgetId: 1,
      employeeId: 5,
      visible: 1,
      xPos: 0,
      yPos: 0,
      width: 6,
      height: 8,
      startDate: "2010-03-01",
      endDate: "2019-03-01",
      startDay: null,
      endDay: null,
      startMonth: null,
      endMonth: null,
      startYear: null,
      endYear: null,
      startPeriod: null,
      endPeriod: null,
      fromAmount: null,
      toAmount: null,
      employee: "Rick Jordan",
      employeeGroup: null,
      matter: null,
      matterGroup: null,
      party: null,
      matterActiveFlag: null,
      partyActiveFlag: null,
      docgen: "Transfers",
      entity: null,
      role: null,
      stageReached: null,
      employeeTest: "nobody",
      labelList: null,
      grid: null,
      minimized: true,
      maximized: false,
      xPos: null,
      yPos: null,
      width: null,
      height: null,
      error: false,
      errorMessage: null
    };
  },
  computed: {
    subTitle: function() {
      var returnString = " ";
      if (this.startDate)
        returnString += " <strong>From</strong>: " + this.startDate;
      if (this.endDate) returnString += " <strong>To</strong>: " + this.endDate;
      if (this.employee)
        returnString += " <strong>Employee</strong>: " + this.employee;
      if (this.docgen)
        returnString += " <strong>Document Set</strong>: " + this.docgen;
      return returnString;
    }
  },
  methods: {
    onApply(e) {
      console.log("At Changed on Date Invoked");

      // this.loadChart();
      // console.log(e.target.value);
      // this.employeeTest = e.target.value;
      // console.log("method function ", this.employee);
      // this.employee = e.target.value;
    },
    displayWidgetPage: function(event) {
      window.location.href = "/dashboard/conveyancing/" + this.id;
    },
    returnToDashBoard: function(event) {
      window.history.back();
    },
    loadChart: function() {
      var labelList = [
        "Claudette Findlay",
        "Jennifer Daly",
        "Jenny (Limited)",
        "Jenny Oliver",
        "Kelvin Davis-Smith",
        "Susan Ferencak-Schoon",
        "Tracy Lezar"
      ];
      this.labelList = labelList;
      var dataList = [49, 1, 5, 32, 8, 35, 36];
      var colourlist = [
        "#B0CBE2",
        "#E7F6E1",
        "#A2B468",
        "#F933CE",
        "#C2919F",
        "#2AB55F",
        "#3C9303"
      ];

      let chartData = {
        labels: labelList,
        datasets: [
          {
            data: dataList,
            backgroundColor: colourlist
          }
        ]
      };
      let chartOptions = {
        // onClick: graphClickEvent,
        responsive: true,
        //maintainAspectRatio: false,
        // aspectRatio: 1,
        title: {
          //   display: thisWidget.widgetChart.showTitle,
          fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
          fontSize: 14
        },
        legend: {
          display: false
        },
        scales: {
          xAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ],
          yAxes: [
            {
              ticks: {
                min: 0
              }
            }
          ]
        }
      };

      new Chart(document.getElementById("TransferMattersChart"), {
        type: "horizontalBar",
        data: chartData,
        options: chartOptions
      });
    }

    // setFilters: function(event) {
    //   console.log(this.widget);

    //   if (this.startDate) {
    //     var startDate = document.getElementById("startDate");
    //   }
    //   if (this.endDate) {
    //     var endDate = document.getElementById("endDate");
    //   }

    //   if (this.labelList) {
    //     this.labelList.forEach(function(item) {
    //       var select = document.getElementById("employeeList");
    //       select.options[select.options.length] = new Option(item, item);
    //     });
    //     document.getElementById("employeeList").value = this.employee;
    //   }
    // }
  },
  mounted() {
    // var dateTime = new Date(this.startDate);
    // this.startDate = moment(dateTime).format("YYYY-MM-DD");

    // var dateTime = new Date(this.endDate);
    // this.endDate = moment(dateTime).format("YYYY-MM-DD");

    this.loadChart();
    if (this.gridstackflag) {
      //  console.log("true"); //Max this
    } else {
      //  console.log("false"); //dont think I need to do anything here
    }
  },
  watch: {
    startDate: function() {
      console.log("startDate will Refresh from Watch");
    },
    endDate: function() {
      console.log("endDate will Refresh");
    },
    dateFilterType: function() {
      //console.log(this.dateFilterType, "was watched");
      switch (this.dateFilterType) {
        case "thisWeek":
          this.startDate = moment()
            .startOf("week")
            .format("YYYY-MM-DD");
          this.endDate = moment()
            .endOf("week")
            .format("YYYY-MM-DD");
          break;
        case "thisMonth":
          this.startDate = moment()
            .startOf("month")
            .format("YYYY-MM-DD");
          this.endDate = moment()
            .endOf("month")
            .format("YYYY-MM-DD");
          break;
        case "thisYear":
          this.startDate = moment()
            .startOf("year")
            .format("YYYY-MM-DD");
          this.endDate = moment()
            .endOf("year")
            .format("YYYY-MM-DD");
          break;
        case "customDateInput":
          //  console.log("this Custom");
          break;
        default:
          console.log("this not working");
      }
    },
    labelList: function() {
      // console.log(this.labelList, "was watched");
    },

    employee: function(newVal, oldVal) {
      //not working
      // console.log("watched widget employee", this.employee);
    },

    deep: true
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
</style>
