$(function() {
  'use strict';
// COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
// SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
  if($('#chartjsBar1').length) {
    new Chart($("#chartjsBar1"), {
      type: 'bar',
      data: {
        labels: [ "Planning", "Sourcing", "Transportation"],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
            data: [3,2,6]
          }
        ]
      },
      options: {
        legend: { display: false },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 7
                }
            }]
        }
      }
    });
  }

  if($('#chartjsBar2').length) {
    new Chart($("#chartjsBar2"), {
      type: 'bar',
      data: {
        labels: [ "CARREFOUR", "COCACOLA", "NIKE", "PEPSI", "REPSOL", "ROCHE", "SEAT"],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
            data: [1,3,1,2,2,1,1]
          }
        ]
      },
      options: {
        legend: { display: false },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 7
                }
            }]
        }
      }
    });
  }


  if($('#chartjsBar3').length) {
    new Chart($("#chartjsBar3"), {
      type: 'bar',
      data: {
        labels: [ "Chemical", "Energy", "Automative", "Consumer goods & services","Retail"],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
            data: [1,2,1,5,2]
          }
        ]
      },
      options: {
        legend: { display: false },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 7
                }
            }]
        }
      }
    });
  }

  if($('#chartjsBar4').length) {
    new Chart($("#chartjsBar4"), {
      type: 'bar',
      data: {
        labels: [ "APAC", "EMEA", "LATAM", "NA"],
        datasets: [
          {
            label: "",
            backgroundColor: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
            data: [1,5,4,1]
          }
        ]
      },
      options: {
        legend: { display: false },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 7
                }
            }]
        }
      }
    });
  }




});