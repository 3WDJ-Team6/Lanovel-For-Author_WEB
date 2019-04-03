// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create( "chartdiv3", am4charts.XYChart );
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.maskBullets = false;

var xAxis = chart.xAxes.push( new am4charts.CategoryAxis() );
var yAxis = chart.yAxes.push( new am4charts.CategoryAxis() );

xAxis.dataFields.category = "x";
yAxis.dataFields.category = "y";

xAxis.renderer.grid.template.disabled = true;
xAxis.renderer.minGridDistance = 40; //구매수익, 대여수익, 정산수익

yAxis.renderer.grid.template.disabled = true;
yAxis.renderer.inversed = true;
yAxis.renderer.minGridDistance = 30;

var series = chart.series.push( new am4charts.ColumnSeries() );
series.dataFields.categoryX = "x";
series.dataFields.categoryY = "y";
series.dataFields.value = "value";
series.sequencedInterpolation = true;
series.defaultState.transitionDuration = 3000;

// Set up column appearance 크기, 색깔
var column = series.columns.template;
column.strokeWidth = 2;
column.strokeOpacity = 1;
column.stroke = am4core.color( "#ffffff" );
column.tooltipText = "{x}, {y}: {value.workingValue.formatNumber('#.')}";
column.width = am4core.percent( 100 );
column.height = am4core.percent( 100 );
column.propertyFields.fill = "color";

//글자
var bullet2 = series.bullets.push(new am4charts.LabelBullet());
bullet2.label.text = "{value}";
bullet2.label.fill = am4core.color("#fff");
bullet2.zIndex = 1;
bullet2.fontSize = 11;
bullet2.interactionsEnabled = false;

//색깔

var colors = {
  "critical": chart.colors.getIndex(0).brighten(-0.8),
  "bad": chart.colors.getIndex(1).brighten(-0.6),
  "medium": chart.colors.getIndex(1).brighten(-0.4),
  "good": chart.colors.getIndex(1).brighten(-0.2),
  "verygood": chart.colors.getIndex(1).brighten(0)
};

chart.data = [ {
  "x": "구매수",
  "y": "1월",
  "color": colors.medium,
  "value": 20
}, {
  "x": "구매수",
  "y": "2월",
  "color": colors.good,
  "value": 15
}, {
  "x": "구매수",
  "y": " ",
  "color": colors.verygood,
  "value": 25
}, {
  "x": "구매수",
  "y": "총계",
  "color": colors.verygood,
  "value": 15
}, {
  "x": "구매수",
  "y": "평균",
  "color": colors.verygood,
  "value": 12
},

{
  "x": "구매수익",
  "y": "1월",
  "color": colors.bad,
  "value": 30
}, {
  "x": "구매수익",
  "y": "2월",
  "color": colors.medium,
  "value": 24
}, {
  "x": "구매수익",
  "y": " ",
  "color": colors.good,
  "value": 25
}, {
  "x": "구매수익",
  "y": "총계",
  "color": colors.verygood,
  "value": 15
}, {
  "x": "구매수익",
  "y": "평균",
  "color": colors.verygood,
  "value": 25
},

{
  "x": "대여수",
  "y": "1월",
  "color": colors.bad,
  "value": 33
}, {
  "x": "대여수",
  "y": "2월",
  "color": colors.bad,
  "value": 14
}, {
  "x": "대여수",
  "y": " ",
  "color": colors.medium,
  "value": 20
}, {
  "x": "대여수",
  "y": "총계",
  "color": colors.good,
  "value": 19
}, {
  "x": "대여수",
  "y": "평균",
  "color": colors.good,
  "value": 25
},

{
    "x": "대여수익",
    "y": "1월",
    "color": colors.bad,
    "value": 33
  }, {
    "x": "대여수익",
    "y": "2월",
    "color": colors.bad,
    "value": 14
  }, {
    "x": "대여수익",
    "y": " ",
    "color": colors.medium,
    "value": 20
  }, {
    "x": "대여수익",
    "y": "총계",
    "color": colors.good,
    "value": 19
  }, {
    "x": "대여수익",
    "y": "평균",
    "color": colors.good,
    "value": 25
  },

{
  "x": "총수익",
  "y": "1월",
  "color": colors.critical,
  "value": 31
}, {
  "x": "총수익",
  "y": "2월",
  "color": colors.critical,
  "value": 24
}, {
  "x": "총수익",
  "y": " ",
  "color": colors.bad,
  "value": 25
}, {
  "x": "총수익",
  "y": "총계",
  "color": colors.medium,
  "value": 15
}, {
  "x": "총수익",
  "y": "평균",
  "color": colors.good,
  "value": 15
},

{
  "x": "정산수익",
  "y": "1월",
  "color": colors.critical,
  "value": 12
}, {
  "x": "정산수익",
  "y": "2월",
  "color": colors.critical,
  "value": 14
}, {
  "x": "정산수익",
  "y": " ",
  "color": colors.critical,
  "value": 15
}, {
  "x": "정산수익",
  "y": "총계",
  "color": colors.bad,
  "value": 25
}, {
  "x": "정산수익",
  "y": "평균",
  "color": colors.medium,
  "value": 19
}
];