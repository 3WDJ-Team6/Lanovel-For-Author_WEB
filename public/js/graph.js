// Themes begin
am4core.useTheme(am4themes_frozen);
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "percent";
pieSeries.dataFields.category = "work_title";

// Let's cut a hole in our Pie chart the size of 30% the radius
chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
    // change the cursor on hover to make it apparent the object can be interacted with
    .cursorOverStyle = [{
        "property": "cursor",
        "value": "pointer"
    }];

pieSeries.alignLabels = false;
pieSeries.labels.template.bent = true;
pieSeries.labels.template.radius = 3;
pieSeries.labels.template.padding(0, 0, 0, 0);

pieSeries.ticks.template.disabled = true;

// Create a base filter effect (as if it's not there) for the hover to return to
var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
shadow.opacity = 0;

// Create hover state
var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

// Slightly shift the shadow and make it more prominent on hover
var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
hoverShadow.opacity = 0.7;
hoverShadow.blur = 5;

// Add a legend
chart.legend = new am4charts.Legend();

console.log(chart);

// [{
//         "num": 1,
//         "work_title": "\uc791\ud4881",
//         "status_of_work": 1,
//         "type_of_work": 1
//     },
//     {
//         "num": 3,
//         "work_title": "testtest",
//         "status_of_work": 1,
//         "type_of_work": 1
//     },
//     {
//         "num": 4,
//         "work_title": "\u3147\u3147",
//         "status_of_work": 1,
//         "type_of_work": 3
//     },
//     {
//         "num": 5,
//         "work_title": "\ucee4\ube44",
//         "status_of_work": 1,
//         "type_of_work": 1
//     },
//     {
//         "num": 6,
//         "work_title": "\uc9c4\uc9dc_\uc7ac\ubc0c\ub294_\ucc45",
//         "status_of_work": 1,
//         "type_of_work": 1
//     },
//     {
//         "num": 7,
//         "work_title": "\u3147\u3147",
//         "status_of_work": 1,
//         "type_of_work": 1
//     },
//     {
//         "num": 8,
//         "work_title": "\uae68\ube44\uae68\ube44\ub3c4\uae68\ube44",
//         "status_of_work": 1,
//         "type_of_work": 1
//     }
// ]

chart.data = [{
    "work_title": "\uc791\ud4881",
    "percent": 300
}, {
    "work_title": "\uae68\ube44\uae68\ube44\ub3c4\uae68\ube44",
    "percent": 3000
}, {
    "work_title": "Australia",
    "percent": 12
}, {
    "work_title": "Austria",
    "percent": 3000
}, {
    "work_title": "UK",
    "percent": 1000
}, {
    "work_title": "Belgium",
    "percent": 1100
}];
// console.log(element);


// for(var i = 0; i < element.length; i++){
// }
