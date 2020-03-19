$(function () {
  'use strict';
  // COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
  // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
  if ($('#chartjsBar1').length) {
    new Chart($("#chartjsBar1"), {
      type: 'bar',
      data: {
        labels: ["Planning", "Sourcing", "Transportation"],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
            data: [3, 2, 6]
          }
        ]
      },
      options: {
        legend: { display: false },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              max: 7,
              fontSize: 17
            }
          }]
        }
      }
    });
  }

  if ($('#chartjsBar2').length) {
    new Chart($("#chartjsBar2"), {
      type: 'bar',
      data: {
        labels: ["Vendor 3", "Vendor 4", "Vendor 2", "Vendor 1", "Vendor 5"],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
            data: [9, 8.5, 7, 3.2, 1]
          }
        ]
      },
      options: {
        legend: { display: false },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              max: 10,
              fontSize: 17
            }
          }]
        }
      }
    });
  }


  if ($('#chartjsBar3').length) {
    new Chart($("#chartjsBar3"), {
      type: 'bar',
      data: {
        labels: ["Vendor 3", "Vendor 4", "Vendor 2", "Vendor 1", "Vendor 5"],
        datasets: [
          {
            label: "Functional",
            backgroundColor: ["#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d"],
            data: [2.9, 6.3, 8.1, 7.7, 0.96],
            stack: 'Stack 0'
          },
          {
            label: "Technical",
            backgroundColor: ["#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f"],
            data: [3.8, 8.4, 9.9, 9.4, 1.2],
            stack: 'Stack 0'
          },
          {
            label: "Service",
            backgroundColor: ["#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0", "#8e00e0"],
            data: [3.5, 7.7, 9.9, 9.4, 1.1],
            stack: 'Stack 0'
          },
          {
            label: "Other",
            backgroundColor: ["#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff", "#a50aff"],
            data: [2.6, 5.6, 8.1, 7.7, 0.8],
            stack: 'Stack 0'
          }
        ]
      },
      options: {
        legend: { display: true },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              max: 50,
              stacked: true,
              fontSize: 17
            }
          }], xAxes: [{
            ticks: {
              stacked: true,
              fontSize: 17
            }
          }]
        }
      }
    });
  }



});
