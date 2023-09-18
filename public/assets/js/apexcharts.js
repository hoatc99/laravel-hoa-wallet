const xaxisFormat = ['dd', 'MM'];
const tooltipFormat = ['dd/MM/yyyy', 'MM/yyyy'];
const annotationXAxis = [new Date().setHours(0), new Date().setDate(0)];
const annotationXAxisLabel = ['Hôm nay', 'Tháng này'];

const renderLineChart = (chartId, currentChart, series, xcategories, statisticType) => {
    if (currentChart !== null) {
        currentChart.destroy();
    }
    let options_line = {
        series: series,
        chart: {
            height: 350,
            type: "area",
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
        colors: ["#3dd9eb", "#615dff"],
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
            type: "datetime",
            categories: xcategories,
            labels: {
                format: xaxisFormat[statisticType],
                style: {
                    colors: "#a1aab2",
                },
                datetimeUTC: false,
            },
        },
        yaxis: {
            type: "currency",
            labels: {
                formatter: function (val) {
                    const suffixes = ["", "K", "M", "B", "T"];
                    let suffixIndex = 0;

                    while (val >= 1000) {
                        val /= 1000;
                        suffixIndex++;
                    }

                    return val.toFixed(1) + suffixes[suffixIndex];
                },
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            x: {
                format: tooltipFormat[statisticType],
            },
            y: {
                formatter: function (val) {
                    return val.toLocaleString();
                },
            },
            theme: "dark",
        },
        annotations: {
            xaxis: [
                {
                    x: annotationXAxis[statisticType],
                    borderColor: "#999",
                    yAxisIndex: 0,
                    label: {
                        show: true,
                        text: annotationXAxisLabel[statisticType],
                        style: {
                            color: "#fff",
                            background: "#6610f2",
                        },
                    },
                },
            ],
        },
    };

    let chart_line = new ApexCharts(chartId, options_line);
    chart_line.render();

    return chart_line;
};
