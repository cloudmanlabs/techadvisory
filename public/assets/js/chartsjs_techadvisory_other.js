$(function () {
    'use strict';

    // Bar chart
    if ($('#chartPractice').length) {
        new Chart($("#chartPractice"), {
            type: 'bar',
            data: {
                labels: ["Transportation", "Planning", "Sourcing", "Warehousing"],
                datasets: [
                    {
                        label: "Population",
                        backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                        data: [2, 3, 6, 2]
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

    if ($('#chartIndustry').length) {
        new Chart($("#chartIndustry"), {
            type: 'bar',
            data: {
                labels: ["Chemical", "Energy", "Automative", "Consumer goods", "Retail"],
                datasets: [
                    {
                        label: "Population",
                        backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                        data: [2, 3, 6, 2, 4]
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

    if ($('#chartRegion').length) {
        new Chart($("#chartRegion"), {
            type: 'bar',
            data: {
                labels: ["APAC", "EMEA", "LATAM", "NA"],
                datasets: [
                    {
                        label: "Population",
                        backgroundColor: ["#27003d", "#5a008f", "#8e00e0", "#a50aff", "#d285ff", "#e9c2ff", "#f8ebff"],
                        data: [2, 3, 6, 2]
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
