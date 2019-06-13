// Themes begin
am4core.useTheme(am4themes_frozen);
am4core.useTheme(am4themes_animated);
// Themes end

/**
 * Chart design taken from Samsung health app
 */

var chart2 = am4core.create("chartdiv2", am4charts.XYChart);
chart2.hiddenState.properties.opacity = 0; // this creates initial fade-in


// console.log(date_profit);
chart2.data = [];
chart2.data = date_profit;

// chart2.data = [{
//     "date": "18-01-01",
//     "profit": 0
// }, {
//     "date": "18-01-02",
//     "profit": 0
// }, {
//     "date": "18-01-03",
//     "profit": 0
// }, {
//     "date": "18-01-04",
//     "profit": 0
// }, {
//     "date": "18-01-05",
//     "profit": 0
// }, {
//     "date": "18-01-06",
//     "profit": 0
// }, {
//     "date": "18-01-07",
//     "profit": 0
// }, {
//     "date": "18-01-08",
//     "profit": 0
// }, {
//     "date": "18-01-09",
//     "profit": 0
// }, {
//     "date": "18-01-10",
//     "profit": 0
// }, {
//     "date": "18-01-11",
//     "profit": 1111
// }, {
//     "date": "18-01-12",
//     "profit": 1111
// }, {
//     "date": "18-01-13",
//     "profit": 2222
// }, {
//     "date": "18-01-14",
//     "profit": 1111
// }, {
//     "date": "18-01-15",
//     "profit": 1111
// }, {
//     "date": "18-01-16",
//     "profit": 1222
// }, {
//     "date": "18-01-17",
//     "profit": 5898
// }, {
//     "date": "18-01-18",
//     "profit": 0
// }, {
//     "date": "18-01-19",
//     "profit": 0
// }, {
//     "date": "18-01-20",
//     "profit": 0
// }, {
//     "date": "18-01-21",
//     "profit": 4531
// }, {
//     "date": "18-01-22",
//     "profit": 0
// }, {
//     "date": "18-01-23",
//     "profit": 0
// }, {
//     "date": "18-01-24",
//     "profit": 0
// }, {
//     "date": "18-01-25",
//     "profit": 0
// }, {
//     "date": "18-01-26",
//     "profit": 0
// }, {
//     "date": "18-01-27",
//     "profit": 0
// }, {
//     "date": "18-01-28",
//     "profit": 0
// }, {
//     "date": "18-01-29",
//     "profit": 0
// }, {
//     "date": "18-01-30",
//     "profit": 0
// }, {
//     "date": "18-01-31",
//     "profit": 0
// }];

chart2.dateFormatter.inputDateFormat = "YY-MM-dd";
chart2.zoomOutButton.disabled = true;

var dateAxis = chart2.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.strokeOpacity = 0;
dateAxis.renderer.minGridDistance = 10;
dateAxis.dateFormats.setKey("day", "d");
dateAxis.tooltip.hiddenState.properties.opacity = 1;
dateAxis.tooltip.hiddenState.properties.visible = true;


dateAxis.tooltip.adapter.add("x", function (x, target) {
    return am4core.utils.spritePointToSvg({
        x: chart2.plotContainer.pixelX,
        y: 0
    }, chart2.plotContainer).x + chart2.plotContainer.pixelWidth / 2;
})

var valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.inside = true;
valueAxis.renderer.labels.template.fillOpacity = 0.3;
valueAxis.renderer.grid.template.strokeOpacity = 0;
valueAxis.min = 0;
valueAxis.cursorTooltipEnabled = false;

// goal guides
var axisRange = valueAxis.axisRanges.create();
axisRange.value = 6000;
axisRange.grid.strokeOpacity = 0.1;
axisRange.label.align = "right";
axisRange.label.verticalCenter = "bottom";
axisRange.label.fillOpacity = 0.8;

valueAxis.renderer.gridContainer.zIndex = 1;

var axisRange2 = valueAxis.axisRanges.create();
axisRange2.value = 12000;
axisRange2.grid.strokeOpacity = 0.1;
axisRange2.label.text = "2x goal";
axisRange2.label.align = "right";
axisRange2.label.verticalCenter = "bottom";
axisRange2.label.fillOpacity = 0.8;

var series = chart2.series.push(new am4charts.ColumnSeries);
series.dataFields.valueY = "profit";
series.dataFields.dateX = "date";
series.tooltipText = "{valueY.value}";
series.tooltip.pointerOrientation = "vertical";
series.tooltip.hiddenState.properties.opacity = 1;
series.tooltip.hiddenState.properties.visible = true;
series.tooltip.adapter.add("x", function (x, target) {
    return am4core.utils.spritePointToSvg({
        x: chart2.plotContainer.pixelX,
        y: 0
    }, chart2.plotContainer).x + chart2.plotContainer.pixelWidth / 2;
})

var columnTemplate = series.columns.template;
columnTemplate.width = 30;
columnTemplate.column.cornerRadiusTopLeft = 20;
columnTemplate.column.cornerRadiusTopRight = 20;
columnTemplate.strokeOpacity = 0;

columnTemplate.adapter.add("fill", function (fill, target) {
    var dataItem = target.dataItem;
    if (dataItem.valueY > 6000) {
        return chart2.colors.getIndex(0);
    } else {
        return am4core.color("#a8b3b7");
    }
})

var cursor = new am4charts.XYCursor();
cursor.behavior = "panX";
chart2.cursor = cursor;
cursor.lineX.disabled = true;

var date = new Date();

var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
var lastDay = new Date();

chart2.events.on("datavalidated", function () {
    dateAxis.zoomToDates(firstDay, lastDay, false, true);
});

var middleLine = chart2.plotContainer.createChild(am4core.Line);
middleLine.strokeOpacity = 1;
middleLine.stroke = am4core.color("#000000");
middleLine.strokeDasharray = "2,2";
middleLine.align = "center";
middleLine.zIndex = 1;
middleLine.adapter.add("y2", function (y2, target) {
    return target.parent.pixelHeight;
})

cursor.events.on("cursorpositionchanged", updateTooltip);
dateAxis.events.on("datarangechanged", updateTooltip);

function updateTooltip() {
    dateAxis.showTooltipAtPosition(0.5);
    series.showTooltipAtPosition(0.5, 0);
    series.tooltip.validate(); // otherwise will show other columns values for a second
}


var label = chart2.plotContainer.createChild(am4core.Label);
label.text = "";
label.x = 90;
label.y = 50;
