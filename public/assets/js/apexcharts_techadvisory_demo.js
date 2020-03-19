$(function () {
    'use strict';



    // Apex Radar chart start
    var options = {
        chart: {
            height: 600,
            type: 'radar',
            parentHeightOffset: 0,
        },
        colors: ["#7a00c3", "#f77fb9", "#4d8af0", "#01e396", "#fbbc06"],
        grid: {
            borderColor: "rgba(77, 138, 240, .1)",
            padding: {
                bottom: -15
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left'
        },
        series: [{
            name: 'Vendor 1',
            data: [80, 50, 30, 40, 100],
        }, {
            name: 'Vendor 2',
            data: [20, 30, 40, 80, 20],
        }, {
            name: 'Vendor 3',
            data: [22, 88, 44, 101, 63],
        }, {
            name: 'Vendor 4',
            data: [44, 21, 99, 33, 77],
        }, {
            name: 'Vendor 5',
            data: [11, 22, 57, 92, 32],
        }],


        stroke: {
            width: 0
        },
        fill: {
            opacity: 0.4
        },
        markers: {
            size: 0
        },
        labels: ['Fit Gap', 'Vendor', 'Experience', 'Innovation', 'Impl. & Commercials']
    }

    var chart = new ApexCharts(
        document.querySelector("#apexRadar1"),
        options
    );

    chart.render();
    // Apex Radar chart end


    // Apex Heat chart start
    function generateData(count, yrange) {
        var i = 0;
        var series = [];
        while (i < count) {
            var x = 'w' + (i + 1).toString();
            var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

            series.push({
                x: x,
                y: y
            });
            i++;
        }
        return series;
    }


    var options = {
        chart: {
            height: 300,
            type: 'heatmap',
            parentHeightOffset: 0
        },
        grid: {
            borderColor: "rgba(77, 138, 240, .1)",
            padding: {
                bottom: -15
            }
        },
        dataLabels: {
            enabled: false
        },
        colors: ["#7a00c3"],
        series: [{
            name: 'Vendor 5',
            data: generateData(5, {
                min: 0,
                max: 90
            })
        },
        {
            name: 'Vendor 4',
            data: generateData(5, {
                min: 0,
                max: 90
            })
        },
        {
            name: 'Vendor 3',
            data: generateData(5, {
                min: 0,
                max: 90
            })
        },
        {
            name: 'Vendor 2',
            data: generateData(5, {
                min: 0,
                max: 90
            })
        },
        {
            name: 'Vendor 1',
            data: generateData(5, {
                min: 0,
                max: 90
            })
        }
        ],
        xaxis: {
            type: 'category',
            categories: ['Fit Gap', 'Vendor', 'Experience', 'Innovation', 'Impl. & Commercials'],
            labels: {
                style: {
                    fontSize: '17px',
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '17px',
                },
            },
        },
        title: {
            text: ''
        },
    }

    var chart = new ApexCharts(
        document.querySelector("#apexHeatMap"),
        options
    );

    chart.render();
    // Apex Heat chart end





});
