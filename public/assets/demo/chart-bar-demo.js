var ctxRegister = document.getElementById("myBarChart");
var labelsRegister = JSON.parse(document.getElementById("myBarChart").getAttribute("data-labels"));
var valuesRegister = JSON.parse(document.getElementById("myBarChart").getAttribute("data-values"));

var myBarChart = new Chart(ctxRegister, {
  type: 'bar',
  data: {
    labels: labelsRegister,  // Labels untuk 5 bulan terakhir
    datasets: [{
      label: "Activity Register",  // Label pada chart
      backgroundColor: "rgba(2,117,216,1)",  // Warna batang
      borderColor: "rgba(2,117,216,1)",  // Warna border batang
      data: valuesRegister,  // Data untuk activity register
    }],
  },
  options: {
    scales: {
      xAxes: [{
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: Math.max(...valuesRegister) + 10,  // Sesuaikan dengan data terbesar
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
