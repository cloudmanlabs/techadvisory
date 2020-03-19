$(function () {
    'use strict';
    // COMPLETE: ["#27003d","#410066","#5a008f", "#7400b8","#8e00e0","#9b00f5","#a50aff","#c35cff","#d285ff","#e9c2ff","#f0d6ff","#f8ebff"],
    // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],
    if ($('#chartjsLine1').length) {
        new Chart($('#chartjsLine1'), {
            type: 'line',
            data: {
                labels: [2018, 2019, 2020],
                datasets: [{
                    data: [2, 6, 3],
                    label: "Total",
                    borderColor: "#27003d",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }
                ]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 7,
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

    // SIMPLIFIED: ["#27003d","#5a008f","#8e00e0","#a50aff","#d285ff","#e9c2ff","#f8ebff"],

    if ($('#chartjsLine2').length) {
        new Chart($('#chartjsLine2'), {
            type: 'line',
            data: {
                labels: [2018, 2019, 2020],
                datasets: [{
                    data: [, 2, 1],
                    label: "Planning",
                    borderColor: "#27003d",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [, 1, 1],
                    label: "Sourcing",
                    borderColor: "#5a008f",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [2, 3, 1],
                    label: "Transportation",
                    borderColor: "#8e00e0",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }
                ]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 4,
                            stepSize: 1,
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



    if ($('#chartjsLine3').length) {
        new Chart($('#chartjsLine3'), {
            type: 'line',
            data: {
                labels: [2018, 2019, 2020],
                datasets: [{
                    data: [, , 1],
                    label: "APAC",
                    borderColor: "#27003d",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [4, 3, 4],
                    label: "EMEA",
                    borderColor: "#5a008f",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [1, 4, 3],
                    label: "LATAM",
                    borderColor: "#8e00e0",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [3, 0, 1],
                    label: "NA",
                    borderColor: "#f8ebff",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }
                ]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 5,
                            stepSize: 1,
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



    if ($('#chartjsLine4').length) {
        new Chart($('#chartjsLine4'), {
            type: 'line',
            data: {
                labels: [2018, 2019, 2020],
                datasets: [{
                    data: [1, 0, 1],
                    label: "Chemical",
                    borderColor: "#27003d",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [2, 1, 4],
                    label: "Energy",
                    borderColor: "#5a008f",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [1, 4, 2],
                    label: "Automative",
                    borderColor: "#8e00e0",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [2, 3, 3],
                    label: "Consumer goods & services",
                    borderColor: "#d285ff",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }, {
                    data: [3, 2, 1],
                    label: "Retail",
                    borderColor: "#f8ebff",
                    backgroundColor: "rgba(0,0,0,0)",
                    fill: false
                }
                ]
            },
            options: {
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 5,
                            stepSize: 1,
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





});
