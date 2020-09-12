'use strict';

// graph for recent 12 monthes
{
  const keys = Object.keys(graphDatas);

  function round(number, precision) {
    var shift = function (number, precision, reverseShift) {
      if (reverseShift) {
        precision = -precision;
      }  
      var numArray = ("" + number).split("e");
      return +(numArray[0] + "e" + (numArray[1] ? (+numArray[1] + precision) : precision));
    };
    return shift(Math.round(shift(number, precision, false)), precision, true);
  }

  const sums = [];
  keys.forEach(key => {
    sums.push(round(graphDatas[key]['Sum'], 2));
  });
  console.log(sums);
  
  var ctx = document.getElementById("myBarChart");
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: keys,
      datasets: [
        {
          label: 'Total Sales', 
          data: sums,
          borderColor: "rgba(255,0,0,1)",
          backgroundColor: '#20B2AA'
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Total Sales in each month'
      }, 
      scapes: {
        yAxes: [{
          ticks: {
            suggestedMax:100,
            suggestedMin:0,
            stepSize:10,
            callback: function(value,index,values){
              return value + 'dollar'
            }
          }
        }]
      },
    }
  });

}

// graph for selected monthes
{
  const keys = Object.keys(graphDatasSelected);

  function round(number, precision) {
    var shift = function (number, precision, reverseShift) {
      if (reverseShift) {
        precision = -precision;
      }  
      var numArray = ("" + number).split("e");
      return +(numArray[0] + "e" + (numArray[1] ? (+numArray[1] + precision) : precision));
    };
    return shift(Math.round(shift(number, precision, false)), precision, true);
  }

  const sums = [];
  keys.forEach(key => {
    sums.push(round(graphDatasSelected[key]['Sum'], 2));
  });
  console.log(sums);
  
  var ctx = document.getElementById("myBarChartSelected");
  var myBarChartSelected = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: keys,
      datasets: [
        {
          label: 'Total Sales', 
          data: sums,
          borderColor: "rgba(255,0,0,1)",
          backgroundColor: '#20B2AA'
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Total Sales in each month'
      }, 
      scapes: {
        yAxes: [{
          ticks: {
            suggestedMax:100,
            suggestedMin:0,
            stepSize:10,
            callback: function(value,index,values){
              return value + 'dollar'
            }
          }
        }]
      },
    }
  });
}