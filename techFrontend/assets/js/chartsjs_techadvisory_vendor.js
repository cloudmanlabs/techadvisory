$(function() {
  'use strict';

  // Bar chart
  if($('#chartjsBar').length) {
    new Chart($("#chartjsBar"), {
      type: 'bar',
      data: {
        labels: [ "Transportation", "Planning", "Sourcing", "Warehousing"],
        datasets: [
          {
            label: "Population",
            backgroundColor: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
            data: [2,3,6,2]
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


  if($('#chartjsGroupedBar').length) {
    new Chart($('#chartjsGroupedBar'), {
      type: 'bar',
      data: {
        labels: ["Transportation", "Planning", "Sourcing", "Warehousing"],
        datasets: [
          {
            label: "Oracle",
            backgroundColor: "#27003d",
            data: [2,4,6,8]
          }, {
            label: "JDA",
            backgroundColor: "#5a008f",
            data: [3,2,1,0]
          }, {
            label: "GT Nexus",
            backgroundColor: "#8e00e0",
            data: [2,3,2,2]
          }
        ]
      },
      options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 9
                }
            }]
        }
      }
    });
  }


  if($('#chartjsBubble').length) {
    new Chart($('#chartjsBubble'), {
      type: 'bubble',
      data: {
        labels: "",
        datasets: [
          {
            label: ["Vendor 1"],
            backgroundColor: "#27003d",
            borderColor: "#27003d",
            data: [{
              x: 2,
              y: 7,
              r: 60
            }]
          }, {
            label: ["Vendor 2"],
            backgroundColor: "#5a008f",
            borderColor: "#5a008f",
            data: [{
              x: 1,
              y: 8,
              r: 20
            }]
          }, {
            label: ["Vendor 3"],
            backgroundColor: "#8e00e0",
            borderColor: "#8e00e0",
            data: [{
              x: 8,
              y: 5,
              r: 10
            }]
          }
        ]
      },
      options: {
        scales: {
          yAxes: [{ 
            scaleLabel: {
              display: true,
              labelString: "Av. Score"
            },
            ticks: {
                beginAtZero: true,
                max: 10
            }
          }],
          xAxes: [{ 
            scaleLabel: {
              display: true,
              labelString: "Av. Ranking"
            },
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