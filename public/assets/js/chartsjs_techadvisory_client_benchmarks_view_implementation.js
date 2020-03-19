$(function () {
    'use strict';
    // COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
    // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],

    if ($('#chartjsBar1').length) {
        new Chart($("#chartjsBar1"), {
            type: 'bar',
            data: {
                labels: ["Vendor 3", "Vendor 2", "Vendor 4", "Vendor 1", "Vendor 5"],
                datasets: [
                    {
                        label: "",
                        backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                        data: [7, 6, 4, 3.2, 2.1]
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
                    }],
                    xAxes: [{
                        ticks: {
                            stacked: true,
                            fontSize: 17,
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
                labels: ["Vendor 1", "Vendor 2", "Vendor 3", "Vendor 4", "Vendor 5"],
                datasets: [
                    {
                        label: "Implementation",
                        backgroundColor: ["#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d", "#27003d"],
                        data: [1000000, 2000000, 1000000, 800000, 2000000],
                        stack: 'Stack 0'
                    },
                    {
                        label: "Run (5 years)",
                        backgroundColor: ["#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f", "#5a008f"],
                        data: [3000000, 2500000, 1000000, 4000000, 1900000],
                        stack: 'Stack 0'
                    }
                ]
            },
            options: {
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stacked: true,
                            callback: function (value, index, values) {
                                return '$' + value;
                            },
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
