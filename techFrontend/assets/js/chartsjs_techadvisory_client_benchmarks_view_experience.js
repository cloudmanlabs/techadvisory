$(function() {
  'use strict';
// COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
// SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
 
if($('#chartjsBar1').length) {
    new Chart($("#chartjsBar1"), {
      type: 'bar',
      data: {
        labels: [ "Vendor 4", "Vendor 3", "Vendor 2", "Vendor 5", "Vendor 1"],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
            data: [8,7,5,4.3,3]
          }
        ]
      },
      options: {
        legend: { display: false },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 10
                }
            }]
        }
      }
    });
  }

  

});