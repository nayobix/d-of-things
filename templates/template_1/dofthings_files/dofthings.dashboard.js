// Plots objects
var graphics = [];
// Device elements
var device_elements = [];

var cpanelOptions = {
    hooverTooltips: true,
    clickTooltips: true,
    zoom: true,
    pan: true,
    autoRefresh: false,
    autoRefreshTime: 300,
    setinterval_id: 0,
}
//Flot default options
var options_line = {
    series: {
        lines: {show: true},
        points: {
            radius: 1,
            show: false,
        },

        /*	autoMarkings: {
         enabled: true,
         showMinMax: true,
         showAvg: true,
         minMaxAlpha: 0.2
         },
         */
        valueLabels: {
            show: true,
            showMaxValue: true,
            showMinValue: true,
            showLastValue: true,
            labelFormatter: function (v) {
                return v;
            },
            showAsHtml: false,
            align: "center",
        },
    },
    legend: {
        position: "nw",
        noColumns: 1,
        margin: [0, 0],
        backgroundColor: null,
        backgroundOpacity: 1,
    },
    xaxis: {
        mode: "time",
        timeformat: " %H:%M %d/%m",
        timezone: "browser",
        //axisLabel: "Time",
        color: "#45AFA6",
        font: {
            size: 10,
            variant: "small-caps",
            weight: "bold",
        },
        autoscaleMargin: null,
    },
    yaxis: {
        axisLabelFontSizePixels: 10,
        autoscaleMargin: 0.03,
        //axisLabel: "Temp",
        color: "#45AFA6",
        font: {
            size: 10,
            variant: "small-caps",
            weight: "bold",
        },
    },
    grid: {
        clickable: true,
        borderWidth: 0.5,
        autoHighlight: true,
        minBorderMargin: 5,
        hoverable: true,
    },
    crosshair: {mode: "x"},
    zoom: {
        interactive: true
    },
    pan: {
        interactive: true
    }
};

var options_pie = {
    series: {
        pie: {
            show: true,
            label: {
                show: true,
                radius: 3 / 4,
                background: {opacity: 0.8, color: '#000'}
            },
        }
    },
    grid: {
        hoverable: true,
        clickable: true,
    },
    legend: {
        show: false,
    },
    grid: {
        hoverable: true
    }
};

var options_area = {
    series: {
        lines: {show: true, fill: true},
        points: {
            radius: 1,
            show: false,
        },
        /*	autoMarkings: {
         enabled: true,
         showMinMax: true,
         showAvg: true,
         minMaxAlpha: 0.2
         }
         */
        valueLabels: {
            show: true,
            showMaxValue: true,
            showMinValue: true,
            showLastValue: true,
            labelFormatter: function (v) {
                return v;
            },
            showAsHtml: false,
            align: "center",
        },

    },
    legend: {
        position: "nw",
        noColumns: 1,
        margin: [0, 0],
        backgroundColor: null,
        backgroundOpacity: 1,
    },
    xaxis: {
        mode: "time",
        timeformat: " %H:%M %d/%m",
        timezone: "browser",
        //axisLabel: "Time",
        color: "#45AFA6",
        font: {
            size: 10,
            variant: "small-caps",
            weight: "bold",
        },
        autoscaleMargin: null,
    },
    yaxis: {
        axisLabelFontSizePixels: 10,
        autoscaleMargin: 0.03,
        //axisLabel: "Temp",
        color: "#45AFA6",
        font: {
            size: 10,
            variant: "small-caps",
            weight: "bold",
        },
    },
    grid: {
        clickable: true,
        borderWidth: 0.5,
        autoHighlight: true,
        minBorderMargin: 5,
        hoverable: true,
    },
    crosshair: {mode: "x"},
    zoom: {
        interactive: true
    },
    pan: {
        interactive: true
    }
};

var options_bar = {
    series: {
        bars: {
            show: true,
            barWidth: 60 * 60 * 100,
            align: 'center'
        },
        valueLabels: {
            show: true,
            showMaxValue: true,
            showMinValue: true,
            showLastValue: true,
            labelFormatter: function (v) {
                return v;
            },
            showAsHtml: false,
            align: "center",
	}
    },
    legend: {
        position: "nw",
        noColumns: 1,
        margin: [0, 0],
        backgroundColor: null,
        backgroundOpacity: 1,
    },
    xaxis: {
        mode: "time",
        timeformat: " %H:%M %d/%m",
        timezone: "browser",
        //axisLabel: "Time",
        color: "#45AFA6",
        font: {
            size: 10,
            variant: "small-caps",
            weight: "bold",
        },
        autoscaleMargin: .10,
    },
    yaxes: {
        axisLabelFontSizePixels: 10,
        autoscaleMargin: 0.03,
        //axisLabel: "Temp",
        color: "#45AFA6",
        font: {
            size: 10,
            variant: "small-caps",
            weight: "bold",
	}
    },
    grid: {
        clickable: true,
        borderWidth: 0.5,
        autoHighlight: true,
        minBorderMargin: 5,
        hoverable: true,
    },
    crosshair: {mode: "x"},
    zoom: {
        interactive: true
    },
    pan: {
        interactive: true
    }

};

var options_gauge = {
  series: {
    grow: {
      active: true,
      duration: 1500
    },
    gauges: {
      debug: {
          log: false,
          layout: false
      },
      show: true,
      frame: {
         show: false
      },
      cell: {
           border: {
               show: false
           },
      },
      // gauge: {
      //   background: {
      //       color: "gray"
      //   }
      // }
     label: {
        show: false,
        margin: "auto", // a specified number, or 'auto'
        background: {
            color: null,
            opacity: 0
        },
        font: {
            size: 10,
            family: "sans-serif"
        },
        color: "#45AFA6",
        formatter: function(label, value) {
            return label;
        }
      },
    }
 },
    zoom: {
        interactive: false
    },
    pan: {
        interactive: false
    }
};

function dashboardsInitialization() {
    var $dashboards_selected = $('#dashboards_selected');
    $dashboards_selected.children(".dashboard_selected").each(function (i, objtag) {
        $tag = $(objtag);
        //alert("Tag: " + $tag.attr('id'));
        setResolution($tag.attr('id'), $tag.attr('resolution'));
        setBackground($tag.attr('id'), $tag.attr('background'));
        //Get all elements added to the dashboard and work on them to be added properly here in main screen dashboards
        detectElementTypeAndAddToDashboard($tag.attr('id'));
    });
    initializeFlotGraphics();
    try {
        console.log("mqtt connecting...");
        mqttConnect();
    } catch (err) {
        console.log("mqtt not encrypted. disabling it...Error: "+err);
    }
}

//Set resolution
function setResolution(item, attr) {
    item = "#" + item;
    var attrSplited = attr.split("x");
    var width = attrSplited[0];
    var height = attrSplited[1];
    $(item).css({"width": width});
    $(item).css({"height": height});
    $(item).css({"height": height});
    $(item).css({"border-style": "solid"});

}

//Set resolution
function setBackground(item, attr) {
    item = "#" + item;
    var attrSplited = attr.split(";");
    //Now show up the dashboard, after all elements are ready and all unneeded are hidden 
    var url = attrSplited[0];
    var color = attrSplited[1];
    var position = attrSplited[2];
    $(item).css({"background-image": "url('" + url + "')"});
    $(item).css({"background-position": position});
    $(item).css({"background-color": color});
    $(item).css({"background-repeat": "no-repeat"});
    $(item).css({"position": "relative"});

}

function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        //float: 'left',
        top: y - 80,
        left: x - 10,
        border: '1px solid #fdd',
        padding: '8px',
        'background-color': '#4863A0',
        opacity: 1,
        'z-index': 999,
    }).appendTo("body").fadeIn(200);
}

// On mobile hover effetch is missing, so make it also clickable
function updateTooltipHover(item, event) {
    $("#tooltip").remove();

    if (item) {
        title = $(item).attr("title");

        var contents = "";
        contents = title;
        showTooltip(event.pageX, event.pageY, contents);
    }
}

//Have to click on hover just somewhere on the graphic	
function updateLegend(event, plotitem, item, pos) {
    $("#tooltip").remove();

    if (event.type == "plothover" && !cpanelOptions.hooverTooltips)
        return;

    if (event.type == "plotclick" && !cpanelOptions.clickTooltips)
        return;

    var axes = plotitem.getAxes();
    if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max ||
            pos.y < axes.yaxis.min || pos.y > axes.yaxis.max)
        return;

    var i, j, dataset = plotitem.getData();
    var d = new Date(pos.x);
    var contents = "Date: " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds() + " " + d.getDate() + "/" + d.getMonth() + "<br>";
    for (i = 0; i < dataset.length; ++i) {
        var series = dataset[i];

        // find the nearest points, x-wise
        for (j = 0; j < series.data.length; ++j)
            if (series.data[j][0] > pos.x)
                break;

        // now interpolate
        var y, p1 = series.data[j - 1], p2 = series.data[j];
        if (p1 == null)
            y = p2[1];
        else if (p2 == null)
            y = p1[1];
        else
            y = p1[1] + (p2[1] - p1[1]) * (pos.x - p1[0]) / (p2[0] - p1[0]);

        contents = contents + "" + series.label + "= " + (y*1).toFixed(1) + "<br>";
    }

    showTooltip(pos.pageX, pos.pageY, contents);
}

//Detect the type of worked element - graphtype, buttontype and add it to dashboardid_* div as graphic or button
function detectElementTypeAndAddToDashboard(item) {
    var origitem = item;
    var counter = 0;
    item = "#" + item;
    //Detect graphtypes
    $(item).children(".graphtype").each(function (i, objtag) {
        var $tag = $(objtag);
        var graphtype = 0; //1 - Line, 2 - Area, 3 - Pie, 0 - Unknown
        var graphtypestring = ""; //line_chart, area_chart, pie_chart, Unknown
        var orig_tag_style = $tag.attr("style");

        $tag.css({"display": "none"});
        if ($tag.hasClass('area_chart')) {
            graphtype = 2;
            graphtypestring = "area_chart";
        } else if ($tag.hasClass('line_chart')) {
            graphtype = 1;
            graphtypestring = "line_chart";
        } else if ($tag.hasClass('pie_chart')) {
            graphtype = 3;
            graphtypestring = "pie_chart";
        } else if ($tag.hasClass('bar_chart')) {
            graphtype = 4;
            graphtypestring = "bar_chart";
        } else if ($tag.hasClass('gauge_chart')) {
            graphtype = 5;
            graphtypestring = "gauge_chart";
        } else {
            alert("Unknown device element!");
            return true;
        }

        var chart_title;
        $(objtag).children("h3").each(function (i2, objtag2) {
            if ($(objtag2).attr("name") == "Title") {
                chart_title = $(objtag2).text();
            }
        });

        //Loop over all feeds of graph and count it
        var count = 0;
        var graphic = [];
        var optionstmp = {};
        //Don't forget to map hidden div and visible flotvhart div, if any info is needed later
        var mappingAttr = "graphtype_mapping_" + counter;
        $tag.attr("mapping", mappingAttr);
        //Add the flot placeholder to dashboard
        var flot_placeholder = origitem + "_" + graphtypestring + "_" + counter + "_placeholder";

        //Append the placeholder and after you get the count update it properly
        $(item).append("<div title=\"" + chart_title + "\" id=\"" + flot_placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"graphtype_new " + graphtypestring + "\" feedscount=\"0\"></div>");

        $(objtag).children(".graphtypefeeds").children().each(function (i2, objtag2) {
            //<div deviceid="1" objectname="sen4" objecttype="Sensor" devicename="device1" feedid="4" value="f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8" name="dpenTEST@device1@sen4" optgroup="Sensors"></div>
            var data = [];
            var data_pie = 0;
            var objtag2_feedid = $(objtag2).attr("feedid");
            var objtag2_keyhash = $(objtag2).attr("value");
            var objtag2_devicename = $(objtag2).attr("devicename");
            var objtag2_deviceid = $(objtag2).attr("deviceid");
            var objtag2_objecttype = $(objtag2).attr("objecttype");
            var objtag2_objectname = $(objtag2).attr("objectname");
            var url = "/dataPull/pull/" + objtag2_feedid + "/" + objtag2_keyhash + "/" + objtag2_devicename + "/" + objtag2_deviceid + "/" + objtag2_objecttype + "/" + objtag2_objectname;

            //Get the data of the feed
            //$.post( "/dataPull/pull/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8/device1/1/Sensor/sen4/1111111111/1234567899", function( postdata ) {
            //$.post( url+"/1111111111/1113089736", function( postdata ) {
            //Array of {"_id":{"$id":"543abea8591255d60bd31de9"},"objectValue":4,"timestamp":1413089736}

            graphic.push({
                url: url,
                label: $(objtag2).attr("name"),
            });

            if (graphtypestring == "line_chart") {
                //Add the data into the dataset
                optionstmp = options_line;
            } else if (graphtypestring == "pie_chart") {
                optionstmp = options_pie;
            } else if (graphtypestring == "area_chart") {
                optionstmp = options_area;
            } else if (graphtypestring == "bar_chart") {
                //initializeFlotGraphics("#"+flot_placeholder,dataset,options_bar);
                optionstmp = options_bar;
            } else if (graphtypestring == "gauge_chart") {
                optionstmp = options_gauge;
            }
            //POST
            //});

            count++;
        });

        //Add all flot graphics and on second step initialize them
        addFlotGraphic(counter, "#" + flot_placeholder, graphic, graphtype, count, optionstmp)

        //Updating placeholder with feedscount
        $("#" + flot_placeholder).attr("feedscount", count);

        //$(item).append("<div title=\""+chart_title+"\" id=\""+flot_placeholder+"\" mapping=\""+mappingAttr+"\" class=\"graphtype_new " + graphtypestring +"\" feedscount=\""+ count +"\"></div>");
        $("#" + flot_placeholder).attr("style", orig_tag_style);

        //Count of graphtypes
        counter++;
    });
    //Detect graphtypes - END

    //Detect device_elements
    var counter = 0;
    $(item).children(".device_element").each(function (i, objtag) {
        var $tag = $(objtag);
        var device_element = -1; //0 - Sensor; 2 - Switch1, 3 - Switch2
        var typestring = ""; //sensor, switch1, switch2, ....
        var orig_tag_style = $tag.attr("style");

        $tag.css({"display": "none"});
        if ($tag.hasClass('sensorvalue')) {
            device_element = 0;
            typestring = "sensorvalue";
        } else if ($tag.hasClass('switch1')) {
            device_element = 1;
            typestring = "switch1";
        } else if ($tag.hasClass('switch2')) {
            device_element = 2;
            typestring = "switch2";
        } else if ($tag.hasClass('switch3')) {
            device_element = 3;
            typestring = "switch3";
        } else if ($tag.hasClass('switch4')) {
            device_element = 4;
            typestring = "switch4";
        } else if ($tag.hasClass('sensordoor')) {
            device_element = 5;
            typestring = "sensordoor";
        } else if ($tag.hasClass('sensorwindow')) {
            device_element = 6;
            typestring = "sensorwindow";
        } else if ($tag.hasClass('sensorlamp')) {
            device_element = 7;
            typestring = "sensorlamp";
        } else {
            alert("Unknown device element!");
            return true;
        }

        var device_element_title;
        $(objtag).children("h3").each(function (i2, objtag2) {
            if ($(objtag2).attr("name") == "Title") {
                device_element_title = $(objtag2).text();
            }
        });

        //Loop over all feeds of graph and count it
        var count = 0;
        var dataset = [];
        //Don't forget to map hidden div and visible flotvhart div, if any info is needed later
        var mappingAttr = "deviceelementtype_mapping_" + counter;
        $tag.attr("mapping", mappingAttr);
        //Construct the placeholder to dashboard as add also device_element counter
        var placeholder = origitem + "_" + typestring + "_" + counter + "_placeholder";

        $(objtag).children(".graphtypefeeds").children().each(function (i2, objtag2) {
            //<div deviceid="1" objectname="sen4" objecttype="Sensor" devicename="device1" feedid="4" value="f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8" name="dpenTEST@device1@sen4" optgroup="Sensors"></div>

            //Limit to just one feed
            if (count > 0) {
                alert("Limit to only one feed on device element!");
                return false;
            }

            var data = [];
            var objtag2_feedid = $(objtag2).attr("feedid");
            var objtag2_keyhash = $(objtag2).attr("value");
            var objtag2_devicename = $(objtag2).attr("devicename");
            var objtag2_deviceid = $(objtag2).attr("deviceid");
            var objtag2_objecttype = $(objtag2).attr("objecttype");
            var objtag2_objectname = $(objtag2).attr("objectname");

            //Get the data of the feed
            //$.post( "/dataPull/pull/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8/device1/1/Sensor/sen4/1111111111/1234567899", function( postdata ) {
            $.post("/dataPull/pullLast/" + objtag2_feedid + "/" + objtag2_keyhash + "/" + objtag2_devicename + "/" + objtag2_deviceid + "/" + objtag2_objecttype + "/" + objtag2_objectname + "/1111111111/1111111111", function (postdata) {
                //Array of {"_id":{"$id":"543abea8591255d60bd31de9"},"objectValue":4,"timestamp":1413089736}
                var dataJSON = JSON.stringify(postdata);
                var dataJsonParsed = $.parseJSON(dataJSON);
                //It is allowed only one feed so get the element in json
                var obj = dataJsonParsed[0];
                dataset = dataJsonParsed[0];
                //obj.timestamp obj.objectValue

                //data.push(dataJsonParsed);
                //Add the data into the dataset
                //dataset.push({
                //	label: $(objtag2).attr("name"),
                //	data: data,
                //});

                initializeDeviceElements("#" + placeholder, device_element, dataset);
                //Save device_element for later update
                //through websockets
                device_elements.push({
                    item: $tag,
                    placeholder: "#" + placeholder,
                    device_element: device_element,
                    dataset: dataset,
                    class_base: typestring,
                    class_on: "open",
                    class_off: "close"
                });

            });
            //Get the data of the feed - END

            //Count of feeds
            count++;
        });

        //Add bindings and styling to the elements according to their type sensor switch1 switch2 switch3 ...
        if (device_element == 0) { //Sensor
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\">NaN</div>");
            $("#" + placeholder).attr("style", orig_tag_style);
            $("#" + placeholder).css({"border": "solid"});
            //Add click binding
            $("#" + placeholder).click(function (e) {
                updateTooltipHover("#" + placeholder, e);
            });
        } else if (device_element == 1) { //Method - Switch1
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\"></div>");
            $("#" + placeholder).attr("style", orig_tag_style);

            //Add click binding
            $("#" + placeholder).click(function () {
                var ret = executeAction(item, "#" + placeholder, device_element, dataset);
            });

        } else if (device_element == 2) { //Method - Switch2
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\"></div>");
            $("#" + placeholder).attr("style", orig_tag_style);
        } else if (device_element == 3) { //Method - Switch3
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\"></div>");
            $("#" + placeholder).attr("style", orig_tag_style);
        } else if (device_element == 4) { //Method - Switch4
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\"></div>");
            $("#" + placeholder).attr("style", orig_tag_style);
            $("#" + placeholder).css({"border": "solid"});

            //Add click binding
            $("#" + placeholder).click(function () {
                var ret = executeAction(item, "#" + placeholder, device_element, dataset);
            });
        } else if (device_element == 5) { //Method - sensordoor
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\"></div>");
            $("#" + placeholder).attr("style", orig_tag_style);
        } else if (device_element == 6) { //Method - sensorwindow
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\"></div>");
            $("#" + placeholder).attr("style", orig_tag_style);
        } else if (device_element == 7) { //Method - sensorlamp
            $(item).append("<div title=\"" + device_element_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"device_element_new " + typestring + "\" feedscount=\"" + count + "\"></div>");
            $("#" + placeholder).attr("style", orig_tag_style);
        }

        counter++;

    });
    //Detect device_elements - END

    //Detect control_panels
    var counter = 0;
    $(item).children(".control_panel").each(function (i, objtag) {
        var $tag = $(objtag);
        var control_panel = -1; //0, 1, 2
        var typestring = ""; //sensor, switch1, switch2, ....
        var orig_tag_style = $tag.attr("style");

        $tag.css({"display": "none"});
        if ($tag.hasClass('control_panel1')) {
            control_panel = 0;
            typestring = "control_panel1";
        } else {
            alert("Unknown control panel!");
            return true;
        }

        var control_panel_title;
        $(objtag).children("h3").each(function (i2, objtag2) {
            if ($(objtag2).attr("name") == "Title") {
                control_panel_title = $(objtag2).text();
            }
        });

        //Loop over all h4 childs
        var count = 0;
        var dataset = [];
        //Don't forget to map hidden div and visible flotvhart div, if any info is needed later
        var mappingAttr = "control_panel_mapping_" + counter;
        $tag.attr("mapping", mappingAttr);
        //Construct the placeholder to dashboard as add also device_element counter
        var placeholder = origitem + "_" + typestring + "_" + counter + "_placeholder";

        //Add placeholder element for the control panel
        $(item).append("<div title=\"" + control_panel_title + "\" id=\"" + placeholder + "\" mapping=\"" + mappingAttr + "\" class=\"control_panel_new " + typestring + "\" panelelements=\"" + count + "\"></div>");

        $(objtag).children("h4").each(function (i2, objtag2) {
            //<h4 class="control_panel_timepicker" name="Timepicker" whattoupdate="timepicker" value="1" type="checkbox"></h4>
            //<h4 class="control_panel_hoovertooltips" name="HooverTooltips" whattoupdate="hoovertooltips" value="1" type="checkbox"></h4>
            //<h4 class="control_panel_clicktooltips" name="ClickTooltips" whattoupdate="clicktooltips" value="1" type="checkbox"></h4>
            //<h4 class="control_panel_zoom" name="Zoom" whattoupdate="zoom" value="1" type="checkbox"></h4>
            //<h4 class="control_panel_pan" name="Pan" whattoupdate="pan" value="1" type="checkbox"></h4>
            //<h4 class="control_panel_manualrefresh" name="ManualRefresh" whattoupdate="manualrefresh" value="1" type="checkbox"></h4>
            //<h4 class="control_panel_autorefresh" name="AutoRefresh" whattoupdate="autorefresh" value="1" type="checkbox"></h4>
            //<h4 class="control_panel_reset" name="Reset" whattoupdate="reset" value="1" type="checkbox"></h4>

            var objtag2_class = $(objtag2).attr("class");
            var objtag2_name = $(objtag2).attr("name");
            var objtag2_value = $(objtag2).attr("value");
            var objtag2_type = $(objtag2).attr("type");

            if (objtag2_name == "Timepicker" && objtag2_value == 1) {
                addControlPanelTimepicker("#" + placeholder, $(objtag2));
            } else if (objtag2_name == "HooverTooltips" && objtag2_value == 1) {
                addControlPanelHooverTooltips("#" + placeholder, objtag2);
            } else if (objtag2_name == "ClickTooltips" && objtag2_value == 1) {
                addControlPanelClickTooltips("#" + placeholder, objtag2);
            } else if (objtag2_name == "Zoom" && objtag2_value == 1) {
                addControlPanelZoom("#" + placeholder, objtag2);
            } else if (objtag2_name == "Pan" && objtag2_value == 1) {
                addControlPanelPan("#" + placeholder, objtag2);
            } else if (objtag2_name == "ManualRefresh" && objtag2_value == 1) {
                addControlPanelManualRefresh("#" + placeholder, objtag2);
            } else if (objtag2_name == "AutoRefresh" && objtag2_value == 1) {
                addControlPanelAutoRefresh("#" + placeholder, objtag2);
            } else if (objtag2_name == "Refresh" && objtag2_value == 1) {
                addControlPanelRefresh("#" + placeholder, objtag2);
            } else if (objtag2_name == "Reset" && objtag2_value == 1) {
                addControlPanelReset("#" + placeholder, objtag2);
            }

            //Count of feeds
            count++;
        });

        $("#" + placeholder).attr("panelelements", count);
        $("#" + placeholder).attr("style", orig_tag_style);
        $("#" + placeholder).css({"border-width": "thin"});
        $("#" + placeholder).css({"border-style": "solid"});

        counter++;

    });
    //Detect control_panels - END

    //Now show up the dashboard, after all elements are ready and all unneeded are hidden	
    $(item).css({"display": "block"});
}

//Control panel stuff
//<h4 class="control_panel_reset" name="Reset" whattoupdate="reset" value="1" type="checkbox"></h4>

function addControlPanelTimepicker(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"Timepicker\" class=\"" + _class + "\">");
    $(item).append("<input style=\"width: 50%; float:left\" type=\"text\" name=\"timerange_start\" id=\"timerange_start\" />");
    $(item).append("<input style=\"width: 50%; float:right\" type=\"text\" name=\"timerange_end\" id=\"timerange_end\"/>");
    $(item).append("</div>");
    $(item).append("<hr>");
}

function addControlPanelHooverTooltips(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"HooverTooltips\" style=\"float:left\" class=\"" + _class + "\">Hoover Tooltips");
    $(item).append("<input type=\"checkbox\" style=\"float:right\" type=\"text\" name=\"hoovertooltips\" id=\"hoovertooltips\" value=\"1\" checked/>");
    $(item).append("</div>");
    $(item).append("<hr>");

    var bindItem = "#hoovertooltips";
    $(bindItem).click(function () {
        cpanelOptions.hooverTooltips = !cpanelOptions.hooverTooltips;
    });
}

function addControlPanelClickTooltips(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"ClickTooltips\" style=\"float:left\" class=\"" + _class + "\">Click Tooltips");
    $(item).append("<input type=\"checkbox\" style=\"float:right\" type=\"text\" name=\"clicktooltips\" id=\"clicktooltips\" value=\"1\" checked/>");
    $(item).append("</div>");
    $(item).append("<hr>");

    var bindItem = "#clicktooltips";
    $(bindItem).click(function () {
        cpanelOptions.clickTooltips = !cpanelOptions.clickTooltips;
    });

}

function addControlPanelZoom(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"Zoom\" style=\"float:left\" class=\"" + _class + "\">Zoom");
    $(item).append("<input type=\"checkbox\" style=\"float:right\" type=\"text\" name=\"zoom\" id=\"zoom\" value=\"1\" checked/>");
    $(item).append("</div>");
    $(item).append("<hr>");

    var bindItem = "#zoom";
    $(bindItem).click(function () {
        cpanelOptions.zoom = !cpanelOptions.zoom;
    });
}

function addControlPanelPan(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"Pan\" style=\"float:left\" class=\"" + _class + "\">Pan");
    $(item).append("<input type=\"checkbox\" style=\"float:right\" type=\"text\" name=\"pan\" id=\"pan\" value=\"1\" checked/>");
    $(item).append("</div>");
    $(item).append("<hr>");

    var bindItem = "#pan";
    $(bindItem).click(function () {
        cpanelOptions.pan = !cpanelOptions.pan;
    });
}

function addControlPanelManualRefresh(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"ManualRefresh\" style=\"float:left\" class=\"" + _class + "\">");
    $(item).append("<button style=\"float:left\" class=\"form-action-save button small\" value=\"REFRESH\" name=\"submit\" id=\"manualrefresh\" type=\"submit\"><i class=\"button-icon icon-cog\"></i>Refresh");
    $(item).append("</button>");
    $(item).append("</div>");
    $(item).append("<hr>");

    var bindItem = "#manualrefresh";
    $(bindItem).click(function () {
        alert(1);
    });
}

function addControlPanelAutoRefresh(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"AutoRefresh\" style=\"float:left\" class=\"" + _class + "\">Auto Refresh");
    $(item).append("<input type=\"text\" style=\"width: 30%; float:right\" type=\"text\" name=\"autorefreshtime\" id=\"autorefreshtime\" value=\"300\"/>");
    $(item).append("<input type=\"checkbox\" style=\"float:right\" type=\"text\" name=\"autorefresh\" id=\"autorefresh\" value=\"1\"/>");
    $(item).append("</div>");
    $(item).append("<hr>");

    var bindItemCheckBox = "#autorefresh";
    var bindItemValue = "#autorefreshtime";
    $(bindItemCheckBox).click(function () {
        cpanelOptions.autoRefresh = !cpanelOptions.autoRefresh;
        cpanelOptions.autoRefreshTime = $(bindItemValue).val();
        if (cpanelOptions.autoRefreshTime < 30)
            cpanelOptions.autoRefreshTime = 30; //Min refreshtime is 30 seconds

        if (cpanelOptions.autoRefreshTime > 3600)
            cpanelOptions.autoRefreshTime = 3600; //Max refreshtime is 1 hour

        if (cpanelOptions.autoRefresh)
            cpanelOptions.setinterval_id = setInterval(refreshContentsOnPage, cpanelOptions.autoRefreshTime * 1000, true);
        else
            clearInterval(cpanelOptions.setinterval_id);
    });

    $(bindItemValue).change(function () {
        cpanelOptions.autoRefreshTime = $(bindItemValue).val();
        if (cpanelOptions.autoRefreshTime < 30)
            cpanelOptions.autoRefreshTime = 30; //Min refreshtime is 30 seconds

        if (cpanelOptions.autoRefreshTime > 3600)
            cpanelOptions.autoRefreshTime = 3600; //Max refreshtime is 1 hour

        if (cpanelOptions.autoRefresh) {
            clearInterval(cpanelOptions.setinterval_id);
            cpanelOptions.setinterval_id = setInterval(refreshContentsOnPage, cpanelOptions.autoRefreshTime * 1000, true);
        }

    });
}

function addControlPanelReset(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"Reset\" style=\"float:left\" class=\"" + _class + "\">");
    var bindItem = $(item).append("<button style=\"float:left\" class=\"form-action-save button small\" value=\"RESET\" name=\"submit\" id=\"reset\" type=\"submit\"><i class=\"button-icon icon-cog\"></i>Reset");
    $(item).append("</button>");
    $(item).append("</div>");
    $(item).append("<hr>");

    var bindItem = "#reset";
    $(bindItem).click(function () {
        //Reload page, in order to get default settings
        location.reload();
    });
}
function addControlPanelRefresh(item, elem) {
    var _class = $(elem).attr("class");
    $(item).append("<div title=\"Refresh\" style=\"float:left\" class=\"" + _class + "\">");
    var bindItem = $(item).append("<button style=\"float:left\" class=\"form-action-save button small\" value=\"REFRESH\" name=\"submit\" id=\"refresh\" type=\"submit\"><i class=\"button-icon icon-cog\"></i>Refresh");
    $(item).append("</button>");
    $(item).append("</div>");

    var bindItem = "#refresh";
    $(bindItem).click(function () {
        refreshContentsOnPage(false);
    });
}

function refreshContentsOnPage(end_is_now) {
    var timeStart = Date.parse($("#timerange_start").attr("value")) / 1000; //It is in milliseconds, so convert it
    if (end_is_now) //Auto refresh page with newest data from server
        var timeEnd = new Date().getTime() / 1000 | 0;
    else
        var timeEnd = Date.parse($("#timerange_end").attr("value")) / 1000;

    for (idx = 0; idx < graphics.length; idx++) {

        graphics[idx].timestart = timeStart;
        graphics[idx].timeend = timeEnd;
        graphics[idx].dataset = [];
        graphics[idx].fetched = 0;
        graphics[idx].rendered = 0;

        initFlotGraphic(graphics[idx], 0); //Start always from 0 elemnt of urls
    }
}
//Control panel stuff END

//Flot stuff with default values
function addFlotGraphic(idx, item, graphic, graphtype, feedscount, options) {
    graphics.push({
        plot: {},
        placeholder: item,
        graphic: graphic,
        dataset: [],
        options: options,
        index: idx,
        graphtype: graphtype,
        feedscount: feedscount,
        timestart: 1111111111,
        timeend: 1113089736,
        fetched: 0,
        rendered: 0,
    });
}

function initFlotGraphic(graph, j) {

    if (j == graph.graphic.length) {

        graph.fetched = 1;

        graph.plot = $.plot($(graph.placeholder), graph.dataset, graph.options);

        $(graph.placeholder).bind("plothover", function (event, pos, item) {
            setTimeout(updateLegend(event, graph.plot, item, pos), 50);
        });

        $(graph.placeholder).bind("plotclick", function (event, pos, item) {
            setTimeout(updateLegend(event, graph.plot, item, pos), 50);
        });

        graph.rendered = 1;

        if (graph.options && graph.options.zoom && graph.options.zoom.interactive == true) {
                addArrow(graph.plot, graph.placeholder, 'left', 55, 20, {left: -20});
                addArrow(graph.plot, graph.placeholder, 'right', 25, 20, {left: 20});
                addArrow(graph.plot, graph.placeholder, 'up', 40, 5, {top: -20});
                addArrow(graph.plot, graph.placeholder, 'down', 40, 35, {top: 20});

                addZoomButton(graph.plot, graph.placeholder, 'none', 40, 35, {top: 20});
	}

        return;
    }

    var data = [];
    var data_pie = 0;
    var label = graph.graphic[j].label;
    var start = graph.timestart;
    var end = graph.timeend;

    $.post(graph.graphic[j].url + "/" + start + "/" + end, function (postdata) {
        var dataJSON = JSON.stringify(postdata);
        var dataJsonParsed = $.parseJSON(dataJSON);

        if (graph.graphtype == 1) { //Line chart
            $.each(dataJsonParsed, function (idx, obj) {
                timestamp = obj.timestamp * 1000;
                data.push([timestamp, obj.objectValue]);
            });

            //Add the data into the dataset
            graph.dataset.push({
                label: label,
                data: data,
            });

            initFlotGraphic(graph, j + 1);

        } else if (graph.graphtype == 3) { //Pie chart
            $.each(dataJsonParsed, function (idx, obj) {
                timestamp = obj.timestamp * 1000;
                data_pie = data_pie + obj.objectValue;
            });

            //Add the data into the dataset
            graph.dataset.push({
                label: label,
                data: data_pie,
            });

            initFlotGraphic(graph, j + 1);

        } else if (graph.graphtype == 2) { //Area chart
            $.each(dataJsonParsed, function (idx, obj) {
                timestamp = obj.timestamp * 1000;
                data.push([timestamp, obj.objectValue]);
            });

            //Add the data into the dataset
            graph.dataset.push({
                label: label,
                data: data,
            });

            initFlotGraphic(graph, j + 1);

        } else if (graph.graphtype == 4) { //Bar chart
            $.each(dataJsonParsed, function (idx, obj) {
                timestamp = obj.timestamp * 1000;
                data.push([timestamp, obj.objectValue]);
            });

            //Add the data into the dataset
            graph.dataset.push({
                label: label,
                data: data,
            });

            initFlotGraphic(graph, j + 1);
        } else if (graph.graphtype == 5) { //Gauge chart
            $.each(dataJsonParsed, function (idx, obj) {
                timestamp = obj.timestamp * 1000;
                data.push([timestamp, obj.objectValue]);
            });

            //Add the data into the dataset
            graph.dataset.push({
                label: label,
                data: data,
            });

            initFlotGraphic(graph, j + 1);
        }
        //POST
    });
}

function initializeFlotGraphics() {
    for (idx = 0; idx < graphics.length; idx++) {
        initFlotGraphic(graphics[idx], 0); //Start always from 0 elemnt of urls
    }
}
//Flot stuff End

function switchClassesAccordingToValue(item, classTrue, classFalse, value, compare) {
    if (value > compare) {
        $(item).addClass(classTrue);
        $(item).removeClass(classFalse);
    } else {
        $(item).addClass(classFalse);
        $(item).removeClass(classTrue);
    }
}

function addClassAccordingToValue(item, classTrue, classFalse, value, compare) {
    if (value > compare) {
        $(item).addClass(classTrue);
    } else {
        $(item).addClass(classFalse);
    }
}

function switchClasses(item, classFrom, classTo) {
    $(item).addClass(classTo);
    $(item).removeClass(classFrom);
}


//deviceElements stuff
function initializeDeviceElements(item, device_element, obj) {
    if (obj && obj.objectValue >= 0) {
        if (device_element == 0) { //Sensor
            $(item).html(obj.objectValue);
        } else if (device_element == 1) { //Method - Switch1
            if (obj.objectValue > 0) {
                $(item).html("ON");
                switchClasses(item, "device_element1_btn_off", "device_element1_btn_on");
            } else {
                $(item).html("OFF");
                switchClasses(item, "device_element1_btn_on", "device_element1_btn_off");
            }
        } else if (device_element == 2) { //Method - Switch2
            $(item).append("<table class=\"device_element2_btn_table\"><tr><td class=\"device_element2_btn_table_on_notactive\">ON</td></tr><tr><td class=\"device_element2_btn_table_off_notactive\">OFF</td></tr></table>");
            itemon = item + " .device_element2_btn_table_on_notactive";
            itemoff = item + " .device_element2_btn_table_off_notactive";

            if (obj.objectValue > 0) {
                $(".device_element2_btn_table .device_element2_btn_table_on_notactive").addClass("device_element2_btn_table_on");
            } else {
                $(".device_element2_btn_table .device_element2_btn_table_off_notactive").addClass("device_element2_btn_table_off");
            }
            //Add click binding
            $(itemon).click(function () {
                var ret = executeAction(item, itemon, device_element, obj);
            });

            $(itemoff).click(function () {
                var ret = executeAction(item, itemoff, device_element, obj);
            });
        } else if (device_element == 3) { //Method - Switch3
            $(item).append("<table class=\"device_element3_btn_table\"><tr><td class=\"device_element3_btn_table_on_notactive\">ON</td></tr><tr><td class=\"device_element3_btn_table_off_notactive\">OFF</td></tr></table>");
            itemon = item + " .device_element3_btn_table_on_notactive";
            itemoff = item + " .device_element3_btn_table_off_notactive";

            addClassAccordingToValue(item, "device_element3_btn_table_on", "device_element3_btn_table_off", obj.objectValue, 0);

            //Add click binding
            $(itemon).click(function () {
                var ret = executeAction(item, itemon, device_element, obj);
            });

            $(itemoff).click(function () {
                var ret = executeAction(item, itemoff, device_element, obj);
            });
        } else if (device_element == 4) { //Method - Switch4
            $(item).append("<table class=\"device_element3_btn_table\"><tr><td class=\"device_element3_btn_table_on_notactive\">ON</td></tr><tr><td class=\"device_element3_btn_table_off_notactive\">OFF</td></tr></table>");
            itemon = item + " .device_element3_btn_table_on_notactive";
            itemoff = item + " .device_element3_btn_table_off_notactive";

            addClassAccordingToValue(item, "device_element3_btn_table_on", "device_element3_btn_table_off", obj.objectValue, 0);

            //Add click binding
            $(itemon).click(function () {
                var ret = executeAction(item, itemon, device_element, obj);
            });

            $(itemoff).click(function () {
                var ret = executeAction(item, itemoff, device_element, obj);
            });
        } else if (device_element == 5) { //Sensor - sensordoor
            addClassAccordingToValue(item, "sensordoor_open", "sensordoor_close", obj.objectValue, 0);
        } else if (device_element == 6) { //Sensor - sensorwindow
            addClassAccordingToValue(item, "sensorwindow_open", "sensorwindow_close", obj.objectValue, 0);
        } else if (device_element == 7) { //Sensor - sensorlamp
            addClassAccordingToValue(item, "sensorlamp_open", "sensorlamp_close", obj.objectValue, 0);
        }

    } else {
        $(item).html("NaN");
    }
}

function executeAction(parentitem, item, device_element, dataset) {

    if (dataset != null && device_element == 1) { //Method - Switch with 1 state - Switch1
        //({_id:{$id:"5450ac94591255190db2873a"}, FeedID:"4", FeedKeyHash:"f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8", deviceName:"device1", deviceID:1, objectType:"Method", objectName:"openDoor", objectAction:"URL", objectValue:1, timestamp:1414573201})
        //Always inverse the current value and update html content for user response. This update will be updated properly after post returns the current value of the device
        if (dataset.objectValue != null && dataset.objectValue == 0) {
            $(item).html("ON");
            switchClasses(item, "device_element1_btn_off", "device_element1_btn_on");
        } else {
            $(item).html("OFF");
            switchClasses(item, "device_element1_btn_on", "device_element1_btn_off");
        }
        //Inverse the value !!!
        var value = dataset.objectValue > 0 ? 0 : 1;
        $.post("/dataExecute/execute/" + dataset.FeedID + "/" + dataset.FeedKeyHash, {
            "objectType": dataset.objectType,
            "objectName": dataset.objectName,
            "objectAction": dataset.objectAction,
            "objectValue": value,
        })
                .done(function (data) {
                    var dataJSON = JSON.stringify(data);
                    var dataJsonParsed = $.parseJSON(dataJSON);
                    if (dataJsonParsed.response) {
                        //alert("Executed!");
                        //Check the returned value from the device and update accordingly
                        if (dataJsonParsed.cur_value != null && dataJsonParsed.cur_value > 0) {
                            $(item).html("ON");
                            switchClasses(item, "device_element1_btn_off", "device_element1_btn_on");
                        } else {
                            $(item).html("OFF");
                            switchClasses(item, "device_element1_btn_on", "device_element1_btn_off");
                        }
                        //Update accordingly the dataset
                        dataset.objectValue = dataJsonParsed.cur_value;
                        return 0;
                    } else {
                        //Return the old value
                        if (!dataset.objectValue) {
                            $(item).html("OFF");
                            switchClasses(item, "device_element1_btn_on", "device_element1_btn_off");
                        } else {
                            $(item).html("ON");
                            switchClasses(item, "device_element1_btn_off", "device_element1_btn_on");
                        }

                        alert("Error!");
                        return 1;
                    }
                }).fail(function (data) {
            //Return the old value
            if (!dataset.objectValue) {
                $(item).html("OFF");
                switchClasses(item, "device_element1_btn_on", "device_element1_btn_off");
            } else {
                $(item).html("ON");
                switchClasses(item, "device_element1_btn_off", "device_element1_btn_on");
            }
            alert("Error!");
            return 1;
        });

    } else if (dataset != null && device_element == 2) { //Method - Switch with 2 states - Switch2
        //({_id:{$id:"5450ac94591255190db2873a"}, FeedID:"4", FeedKeyHash:"f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8", deviceName:"device1", deviceID:1, objectType:"Method", objectName:"openDoor", objectAction:"URL", objectValue:1, timestamp:1414573201})
        //Always inverse the current value and update html content for user response. This update will be updated properly after post returns the current value of the device
        if ($(item).hasClass("device_element2_btn_table_on_notactive")) {
            $(item).addClass("device_element2_btn_table_on");
            switchClasses(parentitem + " .device_element2_btn_table_off_notactive", "device_element2_btn_table_off", "device_element2_btn_table_off_notactive");
            value = 1; //ON
        } else if ($(item).hasClass("device_element2_btn_table_off_notactive")) {
            $(item).addClass("device_element2_btn_table_off");
            switchClasses(parentitem + " .device_element2_btn_table_on_notactive", "device_element2_btn_table_on", "device_element2_btn_table_on_notactive");
            value = 0; //OFF
        }

        $.post("/dataExecute/execute/" + dataset.FeedID + "/" + dataset.FeedKeyHash, {
            "objectType": dataset.objectType,
            "objectName": dataset.objectName,
            "objectAction": dataset.objectAction,
            "objectValue": value,
        })
                .done(function (data) {
                    var dataJSON = JSON.stringify(data);
                    var dataJsonParsed = $.parseJSON(dataJSON);
                    if (dataJsonParsed.response) {
                        //Check the returned value from the device and update accordingly
                        if (dataJsonParsed.cur_value != null && dataJsonParsed.cur_value > 0) {
                            $(parentitem + " .device_element2_btn_table_on_notactive").addClass("device_element2_btn_table_on");
                            switchClasses(parentitem + " .device_element2_btn_table_off_notactive", "device_element2_btn_table_off", "device_element2_btn_table_off_notactive");
                        } else {
                            $(parentitem + " .device_element2_btn_table_off_notactive").addClass("device_element2_btn_table_off");
                            switchClasses(parentitem + " .device_element2_btn_table_on_notactive", "device_element2_btn_table_on", "device_element2_btn_table_on_notactive");
                        }
                        return 0;
                    } else {
                        //Return the old value
                        if (!value) {
                            $(parentitem + " .device_element2_btn_table_off_notactive").addClass("device_element2_btn_table_off");
                            switchClasses(parentitem + " .device_element2_btn_table_on_notactive", "device_element2_btn_table_on", "device_element2_btn_table_on_notactive");
                        } else {
                            $(parentitem + " .device_element2_btn_table_on_notactive").addClass("device_element2_btn_table_on");
                            switchClasses(parentitem + " .device_element2_btn_table_off_notactive", "device_element2_btn_table_off", "device_element2_btn_table_off_notactive");
                        }

                        alert("Error!");
                        return 1;
                    }
                }).fail(function (data) {
            //Return the old value
            if (!value) {
                $(parentitem + " .device_element2_btn_table_off_notactive").addClass("device_element2_btn_table_off");
                switchClasses(parentitem + " .device_element2_btn_table_on_notactive", "device_element2_btn_table_on", "device_element2_btn_table_on_notactive");
            } else {
                $(parentitem + " .device_element2_btn_table_on_notactive").addClass("device_element2_btn_table_on");
                switchClasses(parentitem + " .device_element2_btn_table_off_notactive", "device_element2_btn_table_off", "device_element2_btn_table_off_notactive");
            }
            alert("Error!");
            return 1;
        });
    }

}
//deviceElements stuff End

// little helper for taking the repetitive work out of placing
// panning arrows
function addArrow(plot, placeholder, dir, right, top, offset) {
    $('<img class="flotPanButton" src="/flot/images/arrow-' + dir + '.gif" style="right:' + right + 'px;top:' + top + 'px">').appendTo(placeholder).click(function (e) {
        e.preventDefault();
        plot.pan(offset);
    });
}

// zoom button
function addZoomButton(plot, placeholder, dir, right, top, offset) {
    // add zoom out button 
    $('<div class="flotZoomButton" style="right:60px;top:5px">zoom out</div>').appendTo(placeholder).click(function (e) {
        e.preventDefault();
        plot.zoomOut();
    });
}
