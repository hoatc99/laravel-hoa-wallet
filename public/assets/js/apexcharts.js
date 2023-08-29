const renderLineChart = (chartId, currentChart, series, xcategories) => {
    if (currentChart !== null) {
        currentChart.destroy();
    }
    let options_line = {
        series: series,
        chart: {
            height: 350,
            type: "line",
            dropShadow: {
                enabled: true,
                color: "#000",
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2,
            },
            fontFamily: '"Nunito Sans",sans-serif',
            zoom: {
                enabled: true,
            },
            toolbar: {
                show: true,
            },
        },
        dataLabels: {
            enabled: false,
        },
        colors: ["#fa896b", "#3dd9eb"],
        stroke: {
            curve: "smooth",
        },
        grid: {
            borderColor: "rgba(0,0,0,0.3)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false,
                },
            },
        },
        xaxis: {
            categories: xcategories,
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
            tickAmount: 10,
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    val /= 1000;
                    return val.toLocaleString() + "K";
                },
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            theme: "dark",
        },
    };

    chart_line = new ApexCharts(chartId, options_line);
    chart_line.render();

    return chart_line;
};
