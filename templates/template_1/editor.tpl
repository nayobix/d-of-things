<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 ielt10 ielt9 ielt8 ielt7 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 ielt10 ielt9 ielt8 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 ielt10 ielt9 lt-ie9 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ielt10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->

<html style="" class="iegt9 js no-touch svg inlinesvg svgclippaths no-ie8compat wf-proximanova-n4-inactive wf-proximanova-n7-inactive wf-proximanova-i4-inactive wf-proximanova-i7-inactive wf-proximanova-n3-inactive wf-inactive" lang="{$smarty.const.SITE_LANGUAGE}">
<!--<![endif]-->
<head>
<!-- EDITOR -->
	<link type="text/css" rel="stylesheet" href="/geditor/lib/css/layout-default-latest.css" />
	<link type="text/css" rel="stylesheet" href="/geditor/jquery-ui/css/jquery-ui-1.10.3.custom.css" />

{literal}
	<style>
                /*
                .ui-layout-north {background: #111c24; color: white;}
                .ui-layout-west {background: #111c24; color: white;}
                .ui-layout-east {background: #111c24; color: white;}
                .ui-layout-south {background: #111c24; color: white;}
                .ui-layout-content {background: #111c24; color: black;}
                .ui-layout-center {background: #111c24; color: black;}
                .header {background: #111c24; color: black;}
                */
		.graphtype { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/graph_bg.jpg'); background-size: 120px 70px; background-repeat: no-repeat;}
		.line_chart { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/line_chart-512.png'); background-size: 120px 70px; background-repeat: no-repeat;}
		.pie_chart { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/PieChart-512.png'); background-size: 120px 70px; background-repeat: no-repeat;}
		.bar_chart { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/567102-chart_bar_1-512.png'); background-size: 120px 70px; background-repeat: no-repeat;}
		.area_chart { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/567105-chart_area_3-512.png'); background-size: 120px 70px; background-repeat: no-repeat;}
		.gauge_chart { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/circle_dashboard_meter_fuel_gauge-512.png'); background-size: 120px 70px; background-repeat: no-repeat;}
		.graphtype h3 { text-align: center; margin: 0; }
		.graphtype h4 { font-size: x-small; text-align: left }
		.graphtype .graphtypecoord { position: absolute; left: 0px; top: -15px }
		.graphtype .graphtypewidth { position: absolute; left: 0px; bottom: -15px }
		.graphtype .graphtypeheight { position: absolute; right: 0px; top: -20px }
		.buttons { position: relative; width: 100px; height: 30px; border-width: 5px; border-style:solid;}
		.buttons h3 { text-align: center; margin: 0; }

		.device_element { position: relative; width: 100px; height: 30px; }
		.device_element h3 { text-align: center; margin: 0; }
		.device_element h4 { font-size: x-small; text-align: left }
		.device_element .device_element_coord { position: absolute; left: 0px; top: -25px }
		.device_element .device_element_width { position: absolute; left: 0px; bottom: -15px }
		.device_element .device_element_height { position: absolute; right: 0px; top: -50px }
		.device_element .device_element_metric { text-align: center; }
		.switch { position: relative; width: 65px; height: 65px; border-width: 1px; background-image:url('/geditor/images/power_button_off_red.png'); background-size: 48px 48px; background-repeat: no-repeat; background-position: center bottom; }
		.sensorvalue { position: relative; width: 65px; height: 65px; border-width: 1px; background-image:url('/geditor/images/circle_dashboard_meter_fuel_gauge-512.png'); background-size: 48px 48px; background-repeat: no-repeat; background-position: center bottom; }
		.sensordoor { position: relative; width: 65px; height: 65px; background-image:url('/geditor/images/device_elements/door.open.off.png'); background-size: 100% 100%; background-repeat: no-repeat; background-position: center bottom; }
		.sensorwindow { position: relative; width: 65px; height: 65px; border-width: 1px; background-image:url('/geditor/images/device_elements/window.open.off.png'); background-size: 100% 100%; background-repeat: no-repeat; background-position: center bottom; }
		.sensorlamp { position: relative; width: 65px; height: 75px; border-width: 1px; background-image:url('/geditor/images/device_elements/lamp.turn.off.png'); background-size: 100% 100%; background-repeat: no-repeat; background-position: center bottom; }

		.control_panel { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/graph_bg.jpg'); background-size: 120px 70px; background-repeat: no-repeat;}
		.control_panel h3 { text-align: center; margin: 0; }
		.control_panel h4 { font-size: x-small; text-align: left }
		.control_panel .control_panel_coord { position: absolute; left: 0px; top: -15px }
		.control_panel .control_panel_width { position: absolute; left: 0px; bottom: -15px }
		.control_panel .control_panel_height { position: absolute; right: 0px; top: -20px }


		.editorelement { position: left; width: 120px; height: 70px; border-width: 1px; border-style:solid; background-image:url('/geditor/images/graph_bg.jpg'); background-size: 120px 70px; background-repeat: no-repeat;}
		.editorelement h3 { text-align: center; margin: 0; }
		.editorelement h4 { font-size: x-small; text-align: left }

		.make_dots {
			background-image: url("/geditor/images/bg.gif");
			background-position: left top;
			background-repeat: repeat;
		}
		.make_rows_on_dots {
			left: 5px; 
			top: 5px; 
			position: absolute; 
			z-index: 1; 
			background-color: rgb(255, 254, 246);
			background-repeat: no-repeat;
		}
		.mark_red { border-color: red; }
		.mark_black { border-color: black; }
		.ui-resizable-helper { border: 1px dotted gray; }
	</style>
	<!-- LAYOUT v 1.3.0 -->
	<script type="text/javascript" src="/geditor/jquery-ui/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="/geditor/jquery-ui/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="/geditor/lib/js/jquery.layout-latest.js"></script>

	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js"></script>
	<script type="text/javascript" src="/geditor/lib/js/debug.js"></script>
	<script type="text/javascript">
	$(document).ready($(function() {
		
		//X-editable section
		$.fn.editable.defaults.mode = 'inline';
		$('.editorElementTextArea').editable({
			type: 'textarea',
			title: ''
		});

		$( "#accordion" ).accordion({ heightStyle: "content", collapsible: true });
		$( ".myaccordion" ).accordion();

		 var $elementstodashboard = $( ".elementstodashboard" );
		 var $elementsindashboard = $( ".elementsindashboard" );
		 var $dashboard = $( "#dashboard" );
		 var $mybuttonsave = $( ".mybuttonsave" );
		 var $mybuttonclear = $( ".mybuttonclear" );
		 var $mybuttondelete = $( ".mybuttondelete" );
		 var $mybuttontotop = $( ".mybuttontotop" );
		 var $mybuttontobottom = $( ".mybuttontobottom" );
		 var $mybuttonzindexhigher = $( ".mybuttonzindexhigher" );
		 var $mybuttonzindexlower = $( ".mybuttonzindexlower" );

		 var DEFAULT_SCREEN_SIZE_W = 1280;
		 var DEFAULT_SCREEN_SIZE_H = 1024;
		 var DEFAULT_BACKGROUND_COLOR = "white";
		 var DEFAULT_BACKGROUND_IMAGE = "NULL";
		 var DEFAULT_BACKGROUND_POSITION = "0px 0px";

		 // Attach saveVisibleScreen in dashboard to Save button
		 $mybuttonsave.click(function() {
			 saveVisibleScreen();
		 });

		 // Attach clearElements in dashboard to Clear button
		 $mybuttonclear.click(function() {
			 clearElementsDashboard();
		 });

		 // Attach clearElements in dashboard to Clear button
		 $mybuttondelete.click(function() {
			 deleteElementsDashboard();
		 });

		 $mybuttontotop.click(function() {
			 toTop();
		 });

		 $mybuttontobottom.click(function() {
			 toBottom();
		 });

		 $mybuttonzindexhigher.click(function() {
			 zIndexHigher();
		 });

		 $mybuttonzindexlower.click(function() {
			 zIndexLower();
		 });

		 // let the elementstodashboard items be draggable
		 $elementstodashboard.draggable({ 
			helper: "clone",
			containment: 'window'
			});
		 

		 // let the dashboard be droppable, accepting the elementstodashboard items
		$dashboard.droppable({
			drop: 	function( event, ui ) {
				//Add the object to the dashboard
				addElementDashboard( ui.draggable, ui.helper );
				}
			});

		 // let the elementstodashboard be droppable as well, accepting items from the dashboard
		$elementstodashboard.droppable({
			accept: ".elementsindashboards",
			drop: 	function( event, ui ) {
				returnElementDashboard( ui.draggable );
				}
			});

		//Function for loading Options in East panel
		function loadOptionsForEdit( $event, $item ) {
			$("#east_elements").empty();
			$("#east_elements").append("<table class=\"elementInOptionsForUpdate\"><tr><td>Name</td><td>Value</td></tr>");
			$item.children().each(function(i, val) {
					var name = $(val).attr("name");
					var optgroup;

					var whattoupdate = $(val).attr("whattoupdate");
					var type = $(val).attr("type");
					var value = $(val).text();

					if(name && !optgroup && !type){
						$(".elementInOptionsForUpdate").append("<tr><td>"+name+"</td><td><input whattoupdate=\""+whattoupdate+"\" name=\""+name+"\" value=\""+value+"\"></input></td></tr>");
					} else if (name && !optgroup && type == "checkbox"){ //Checkbox types
						value = $(val).attr("value");
						var checked = value == 1 ? "checked" : " ";
						$(".elementInOptionsForUpdate").append("<tr><td>"+name+"</td><td><input type=\""+type+"\" whattoupdate=\""+whattoupdate+"\" name=\""+name+"\" value=\""+value+"\" "+checked+"></input></td></tr>");
					}

					if ($(val).hasClass("graphtypefeeds")) {
						$(val).children().each(function(i3,val3){
//<div deviceid="1" objectname="sen3" objecttype="Sensor" devicename="device1" feedid="4" value="f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8" name="dpenTEST@device1@sen3" optgroup="Sensors"></div>
//<option deviceid="1" objectname="sen3" objecttype="Sensor" devicename="device1" value="f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8" feedid="4">dpenTEST@device1@sen3</option>
							var device_optgroup = $(val3).attr("optgroup");
							var feed_name = $(val3).attr("name");
							var device_id = $(val3).attr("deviceid");
							var device_objectname = $(val3).attr("objectname");
							var device_objecttype = $(val3).attr("objecttype");
							var device_name = $(val3).attr("devicename");
							var device_feedid = $(val3).attr("feedid");
							var device_keyhash = $(val3).attr("value");
							var optgroup_to_optionsmenu = "<tr><td><a style=\"color: red\" href=\"#\" onclick=\"removeFeedFromDashboard(this);\" deviceid="+device_id+" objectname="+device_objectname+" objecttype="+device_objecttype+" devicename="+device_name+" feedid="+device_feedid+" value="+device_keyhash+" name="+device_name+" optgroup="+device_optgroup+"\>X</a></td><td>"+feed_name+"</td>";
							$(".elementInOptionsForUpdate").append(optgroup_to_optionsmenu);
						});
					}

			});

			$("#east_elements").append("</table>");
			$item.addClass("elementInDashboardForUpdate");
			if($item.hasClass('graphtype')){
				$("#east_elements").append("<button class=\"mybutton\" onclick=\"addFeedToDashboard()\" value=\"BUTTON\" name=\"BUTTON\">Add Feed</button>");
				$( ".mybutton" ).button();
			} else if ($item.hasClass('sensor')){
				$("#east_elements").append("<button class=\"mybutton\" onclick=\"addFeedToDashboard()\" value=\"BUTTON\" name=\"BUTTON\">Add Feed</button>");
				$( ".mybutton" ).button();
			} else if ($item.hasClass('switch')){
				$("#east_elements").append("<button class=\"mybutton\" onclick=\"addFeedToDashboard()\" value=\"BUTTON\" name=\"BUTTON\">Add Feed</button>");
				$( ".mybutton" ).button();
			}
		}

		//Function for loading dynamicaly changed attributes of elements in dashboard+OptionsMenu and also places them on the right position
		function loadDynamicalyChangedAttributes( $item ) {
			var $this = $item;
			var thisPos = $this.position();
			var parentPos = $dashboard.position();
			var x = thisPos.left - parentPos.left;
			var y = thisPos.top - parentPos.top;
			var width = $item.width();
			var height = $item.height();
			var positionWidth = width/2;
			var positionHeight = height/2;

			var itemcoord = 0;
			var itemwidth = 0;
			var itemheight = 0;
			if($item.hasClass("graphtype")){
				itemcoord = ".graphtypecoord";
				itemwidth = ".graphtypewidth";
				itemheight = ".graphtypeheight";
			} else if($item.hasClass("sensor")){
				itemcoord = ".device_element_coord";
				itemwidth = ".device_element_width";
				itemheight = ".device_element_height";
			} else if($item.hasClass("switch")){
				itemcoord = ".device_element_coord";
				itemwidth = ".device_element_width";
				itemheight = ".device_element_height";
			} else if($item.hasClass("control_panel")){
				itemcoord = ".control_panel_coord";
				itemwidth = ".control_panel_width";
				itemheight = ".control_panel_height";
				itemcolor = ".control_panel_color";
			} else if($item.hasClass("editorelement")){
				itemcoord = ".editorelement_coord";
				itemwidth = ".editorelement_width";
				itemheight = ".editorelement_height";
				itemcolor = ".editorelement_color";
			} else {
				alert("The element is not added in loadDynamicalyChangedAttributes");
				return;
			}
	                //Load coord, width and height of rectangle
			$this.children(itemcoord).text("" + Math.round(x).toFixed(2) + ", " + Math.round(y).toFixed(2));
	  	        $this.children(itemwidth).text(width);
   	                $this.children(itemheight).text(height);
			//Change the place of width and height marks
	                $this.children(itemwidth).css({left: positionWidth});
	                $this.children(itemheight).css({top: positionHeight});
			//Change width and height of background-image
	                //$this.css({"background-size": positionWidth+"px "+positionHeight+"px"});
	                $this.css({"background-position": "50% 50%"});


		}

		 // Add elements to Dashboard
		function addElementDashboard( $item, $helper ) {
			//$($item).appendTo($dashboard);
			if($item.hasClass('elementstodashboard')){
				//Clone the dropped element and change parent and previuousparent attributes appropriately
				var $parent_ = $item.attr("parent");
				var $previousparent_ = $item.attr("previousparent");
				var $cloned = $helper.clone(true);
				$item.css({"display": "none"});
				$item.attr( "previousparent", $parent_ );
				$item.attr( "parent", "dashboard" );
				$cloned.removeClass('ui-draggable-dragging').removeAttr("style").appendTo("."+$previousparent_);
				$cloned.draggable({
					helper: "clone",
					containment: "window"
				});
				//Add highest z-index
				$item.zIndex(getMaxZindex()+1);

				//Change the attributes of the element in order to be full classified dashboard element
				$item.addClass("elementsindashboard");
				$item.removeClass("elementstodashboard ui-draggable ui-dropable");
				$item.appendTo( $dashboard );
				//Make the new element draggable also
				$item.draggable('destroy').draggable({ 
					grid: [ 5, 5 ],
					start:	function( event, ui ) {
							$(this).parent().css('z-index', 1);
						},
		 			stop: function(event, ui){
						$(".elementsindashboard").removeClass("mark_red");
						$(".elementsindashboard").removeClass("elementInDashboardForUpdate");
						$(".elementsindashboard").addClass("mark_black");
						$(this).removeClass("mark_black");
						$(this).addClass("mark_red");
						loadOptionsForEdit(event, $(this));
						loadDynamicalyChangedAttributes($(this));
					},
					drag:	function( event, ui ) {
							loadOptionsForEdit(event, $(this));
							loadDynamicalyChangedAttributes($(this));
						},
					containment: "parent"
					
					});

				//Check for some classes or ids which you dont want to be resizable after dropping
				//if(!$item.hasClass("edelement_text_area"))
				$item.resizable({ 
					grid: [ 5, 5 ],
					animate: false,
					//Bind to resizestop event in $item element
		 			resize: function(event, ui) {
							loadOptionsForEdit(event, $(this));
							loadDynamicalyChangedAttributes($(this));
						},
					});

				loadOptionsForEdit(null, $item);
				loadDynamicalyChangedAttributes($item);
		 		$item.click(function(){
					$(".elementsindashboard").removeClass("mark_red");
					$(".elementsindashboard").removeClass("elementInDashboardForUpdate");
					$(".elementsindashboard").addClass("mark_black");
					$(this).removeClass("mark_black");
					$(this).addClass("mark_red");
					loadOptionsForEdit(null, $item);
					loadDynamicalyChangedAttributes($item);
				});
				
				//Make element visible and position absolute
				$item.css({"position": "absolute"});
				$item.css({"display": "block"});
			}
		}

		// Add elements to Dashboard for edit - comming from /editor/edit/$ID
		function addElementDashboardForEdit( $item ) {
			if($item.hasClass('elementsindashboard')){
				//Make the new element draggable also
				$item.draggable({ 
					grid: [ 5, 5 ],
					start:	function( event, ui ) {
							$(this).parent().css('z-index', 1);
						},
		 			stop: function(event, ui){
						$(".elementsindashboard").removeClass("mark_red");
						$(".elementsindashboard").removeClass("elementInDashboardForUpdate");
						$(".elementsindashboard").addClass("mark_black");
						$(this).removeClass("mark_black");
						$(this).addClass("mark_red");
						loadOptionsForEdit(event, $(this));
						loadDynamicalyChangedAttributes($(this));
					},
					drag:	function( event, ui ) {
							loadOptionsForEdit(event, $(this));
							loadDynamicalyChangedAttributes($(this));
						},
					containment: "parent"
					
					});
				$item.resizable({ 
					grid: [ 5, 5 ],
					animate: false,
					//Bind to resizestop event in $item element
		 			resize: function(event, ui) {
							loadOptionsForEdit(event, $(this));
							loadDynamicalyChangedAttributes($(this));
						},
					});
		 		
				$item.click(function(){
					$(".elementsindashboard").removeClass("mark_red");
					$(".elementsindashboard").removeClass("elementInDashboardForUpdate");
					$(".elementsindashboard").addClass("mark_black");
					$(this).removeClass("mark_black");
					$(this).addClass("mark_red");
					loadOptionsForEdit(null, $item);
					loadDynamicalyChangedAttributes($item);
				});
			}
		}

		// Delete elements from Dashboard
		function returnElementDashboard( $item ) {
			$item.addClass("elementstodashboard");
			$item.removeClass("elementsindashboard");
			$($item).appendTo( ".alreadygraphs");
		}

		// Reset element from Dashboard to East panel
		function returnElementDashboard( $item, $parentitem ) {
			$item.addClass("elementstodashboard");
			$item.removeClass("elementsindashboard");
			$($item).appendTo($parentitem);
		}

		// Save visible screen of elements on dashboard
		function saveVisibleScreen() {
			$.post( "/dashboards/savetest")
			  .done(function( data ){
					if (!data.match(/OK/)) { 
						alert("Error saving dashboard elements. Try again!\n\n" + $dashboard.html());
						return 1;
					} else {
						saveDashboard();
					}
			}).fail(function( data ) {
				alert("Remote end doesn't respond. Please contact system administrator!\n\n");						
				return 1;
			});

		}

		function saveDashboard() {
			var htmldata = $('#dashboard').html();
			var name = $("#editor_north_name").val() ? $("#editor_north_name").val() : "New Dashboard";
			var share = $("#editor_north_share").is(':checked') ? 1 : 0;
			var zoom = $("#editor_north_zoom").is(':checked') ? 1 : 0;
			var move = $("#editor_north_move").is(':checked') ? 1 : 0;
			var resolution = $('#resolutionWidth').val() + "x" + $('#resolutionHeigth').val();
			var background = $('#backgroundImage').val() + ";" + $('#backgroundColor').val() + ";" + $('#backgroundPosition').val();
			var dashboardid = $('#dashboard').attr("dashboardid");

			$.post( "/dashboards/savedashboard",{
							"htmldata": htmldata, 
							"name": name,
							"share": share,
							"zoom": zoom,
							"move": move,
							"resolution": resolution,
							"background": background,
							"dashboardid": dashboardid,
						  })
			 .done(function( data ) {
				var dataJsonParsed = $.parseJSON( data );
				if (!dataJsonParsed.response) { 
					alert("Error!");
					return 1;
				}else{
					updateAttributeById($('#dashboard'), dataJsonParsed.id);
					alert(dataJsonParsed.executed_action);
				}
			}).fail(function( data ) {
				alert("Error");						
				return 1;
			});

		}

		//update attribute of css id
		function updateAttributeById($item, value) {
			$item.attr("dashboardid", value);
		}

		//Don't need this function right now
		function saveElementsDashboard() {
			$.post( "/dashboards/savedashboardelements", function( data ) {
					var ret = new Boolean(true);
					if (!data.match(/OK/)) { 
						alert("Error!")
						return false;
					} else {
						alert("Done!");
					}
			}).fail(function( data ) {
				alert("Error");						
				return 1;
			});
		}

		// Clear elements on dashboard
		function clearElementsDashboard() {
			var $dashboard = $( "#dashboard" );
			$dashboard.empty();;
			changeDashboardSize(DEFAULT_SCREEN_SIZE_W,DEFAULT_SCREEN_SIZE_H);
			changeBackground(DEFAULT_BACKGROUND_IMAGE,DEFAULT_BACKGROUND_COLOR,DEFAULT_BACKGROUND_POSITION);
		}

		// Clear elements on dashboard
		function deleteElementsDashboard() {
			var $dashboard = $( "#dashboard" );
			$dashboard.empty();;
			changeDashboardSize(DEFAULT_SCREEN_SIZE_W,DEFAULT_SCREEN_SIZE_H);
			changeBackground(DEFAULT_BACKGROUND_IMAGE,DEFAULT_BACKGROUND_COLOR,DEFAULT_BACKGROUND_POSITION);
		}


		// Push element to Top
		function toTop() {
			var $item = $('.elementInDashboardForUpdate');
			$item.zIndex(getMaxZindex()+1);
		}

		// Push element to bottom
		function toBottom() {
			var $item = $('.elementInDashboardForUpdate');
			$item.zIndex(getMinZindex()?getMinZindex()-1:0);
		}

		// Z-index++
		function zIndexHigher() {
			var $item = $('.elementInDashboardForUpdate');
			$item.zIndex($item.zIndex()+1);
		}

		// Z-index++
		function zIndexLower() {
			var $item = $('.elementInDashboardForUpdate');
			$item.zIndex($item.zIndex()-1);
		}

		// Get Max z-index
		function getMaxZindex() {
			var array_ = [];
			//Push 0 value in the array, because at the beginning dashboard is empty and there are no elements with z-index
			array_.push("0");	
			$(".elementsindashboard").each(function(){
				if($(this).css("z-index") == "auto") {
					array_.push("0");	
				} else {
					array_.push($(this).css("z-index"));	
				}
			});
			var index_highest = Math.max.apply(Math, array_);
			//alert(index_highest);
			return index_highest;
		}

		// Get Min z-index
		function getMinZindex() {
			var array_ = [];
			$(".elementsindashboard").each(function(){
				if($(this).css("z-index") == "auto") {
					array_.push("0");	
				} else {
					array_.push($(this).css("z-index"));	
				}
			});
			var index_lowest = Math.min.apply(Math, array_);
			return index_lowest;
		}


		var availableTags = "autocompletiontest";

		$( "#autocomplete" ).autocomplete({
			source: availableTags
		});
		

		
		$( ".mybutton" ).button();
		$( "#radioset" ).buttonset();
		

		
		$( "#tabs" ).tabs();
		

		
		$( "#dialog" ).dialog({
			autoOpen: false,
			width: 400,
			buttons: [
				{
					text: "Ok",
					click: function() {
						$( this ).dialog( "close" );
					}
				},
				{
					text: "Cancel",
					click: function() {
						$( this ).dialog( "close" );
					}
				}
			]
		});

		// Link to open the dialog
		$( "#dialog-link" ).click(function( event ) {
			$( "#dialog" ).dialog( "open" );
			event.preventDefault();
		});
		

		
		$( "#datepicker" ).datepicker({
			inline: true
		});
		

		
		$( "#slider" ).slider({
			range: true,
			values: [ 17, 67 ]
		});
		

		
		$( "#progressbar" ).progressbar({
			value: 20
		});
		
		// Hover states on the static widgets
		$( "#dialog-link, #icons li" ).hover(
			function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		);

		//Don't forget to clear out all resizable components, because in other way resze-ing doesn't work
		$(".ui-resizable-handle").remove();

		//Loop over all elementsindashboard - comming from /editor/edit/$ID
		$elementsindashboard.each(function(editidx, edititem){
			addElementDashboardForEdit($(edititem));
		});
		
//end document ready execution
	}));

	//Add Feed for Chart/Sensor in Options menu
	function addFeedToDashboard() {
		// http:///data/pull/4/f4ef12415e455b93b4280318f88cbfb60d1d37d0ccdec50dff42cf86958390d8/
		<!-- $(".elementInOptionsForUpdate tbody").append("<tr><td><a style=\"color: red\" href=\"#\" onclick=\"removeFeedFromDashboard(this);\">X</a></td><td><select name=\"Feed\" value=\"FeedName\"></select></td></tr>"); -->
		var feedsToOptionsView = "<tr><td><a style=\"color: red\" href=\"#\" onclick=\"removeFeedFromDashboard(this);\">X</a></td><td><select name=\"Feed\" value=\"FeedName\">";
		var requestSensors = $.post( "/data2/pullFeedGetSensorNames/1/", function(data) {
			var dataJSON = JSON.stringify(data);
			var dataJsonParsed = $.parseJSON( dataJSON );
			var optGroup = "<optgroup label=\"Sensors\">\n";
			$.each(dataJsonParsed, function(idx, obj) {
				optGroup += "<option feedid=\""+ obj.feedid +"\" value=\"" + obj.keyhash + "\" deviceName=\""+ obj.device_name +"\" objectType=\"Sensor\" objectName=\""+obj.Sensor+"\" deviceid=\""+obj.deviceID+"\">" + obj.feed + "@" + obj.device_name + "@" + obj.Sensor + "</option>\n";
			});
			optGroup += '</optgroup>';
			feedsToOptionsView += optGroup;
		
			var requestMethods = $.post( "/data2/pullFeedGetMethodNames/1/", function(data) {
				var dataJSON = JSON.stringify(data);
				var dataJsonParsed = $.parseJSON( dataJSON );
				var optGroup = "<optgroup label=\"Methods\">\n";
				$.each(dataJsonParsed, function(idx, obj) {
					optGroup += "<option feedid=\""+ obj.feedid +"\" value=\"" + obj.keyhash + "\" deviceName=\""+ obj.device_name +"\" objectType=\"Method\" objectName=\""+obj.Method+"\" deviceid=\""+obj.deviceID+"\">" + obj.feed + "@" + obj.device_name + "@" + obj.Method + "</option>\n";
				});
				optGroup += '</optgroup>';
				feedsToOptionsView += optGroup;
			
				feedsToOptionsView += "</select></td></tr>";
				$(".elementInOptionsForUpdate tbody").append(feedsToOptionsView);
			});
		});
		

	}

	//Remove Feed for Chart/Sensor in Options menu
	function removeFeedFromDashboard(item) {
		//Remove from options menu
		$(item).closest("tr").remove();

		//Remove from selected object in the dashboard
		//$(item).closest("tr").remove();
		var device_optgroup = $(item).attr("optgroup");
		var device_id = $(item).attr("deviceid");
		var device_objectname = $(item).attr("objectname");
		var device_objecttype = $(item).attr("objecttype");
		var device_name = $(item).attr("devicename");
		var device_feedid = $(item).attr("feedid");
 		var device_keyhash = $(item).attr("value");
		$('.elementInDashboardForUpdate').children('.graphtypefeeds').children().each(function(i, val) {
			var dash_device_optgroup = $(val).attr("optgroup");
			var dash_device_id = $(val).attr("deviceid");
			var dash_device_objectname = $(val).attr("objectname");
			var dash_device_objecttype = $(val).attr("objecttype");
			var dash_device_name = $(val).attr("devicename");
			var dash_device_feedid = $(val).attr("feedid");
			var dash_device_keyhash = $(val).attr("value");
			
			if(	device_optgroup == dash_device_optgroup && 
				device_id == dash_device_id &&
				device_objectname == dash_device_objectname &&
				device_objecttype == dash_device_objecttype &&
				device_name == dash_device_name &&
				device_feedid == dash_device_feedid &&
				device_keyhash == dash_device_keyhash	
			) {
				$(val).remove();
			}
		});

	}

	//Remove element from dashboard
	function deleteElementFromDashboard(item) {
		$(".elementInDashboardForUpdate").remove();
	}

	//Update all attributes in Options menu correpsonding to those in dashboard, without Feeds - X
	function updateElementInDashboard(){
		var $optionsitem = $('.elementInOptionsForUpdate');
		var $item = $('.elementInDashboardForUpdate');
		if ($('.elementInDashboardForUpdate .graphtypefeeds')) {
			//This graphtypefeeds could be also buttontypefeeds, elementtypefeeds and so on...
			var $item_feeds = $('.elementInDashboardForUpdate .graphtypefeeds');
		}

		var $external_val;
		$optionsitem.find("input").each(function(i, val) {
			$external_val = $(val);
			$item.children().each(function(i2, val2) {
				if($external_val.attr('name') && $(val2).attr('name') && $external_val.attr('name') == $(val2).attr('name')){
					//Update dimensions of element
					updateItemTextContentAndTextPositionAndItemDimension($(val2), $(val2).attr('whattoupdate'),$external_val);
				}
			});
		});
		
		$optionsitem.find("select").each(function(i, val) {
			var optgroup = $(val).find(":selected").parent().attr("label");
			var selected_name = $(val).find(":selected").text();
			var selected_value = $(val).find(":selected").val();
			var feedid = $(val).find(":selected").attr("feedid");
			var deviceName = $(val).find(":selected").attr("devicename");
			var objectType = $(val).find(":selected").attr("objecttype");
			var objectName = $(val).find(":selected").attr("objectname");
			var deviceID = $(val).find(":selected").attr("deviceid");

			$item_feeds.append("<div optgroup=\""+optgroup+"\" name=\""+selected_name+"\" value=\""+selected_value+"\" feedid=\""+feedid+"\" deviceName=\""+deviceName+"\" objectType=\""+objectType+"\" objectName=\""+objectName+"\" deviceID=\""+deviceID+"\"></div>");
		});
	}


	//Update the provided attr with value and change item dimensions
	function updateItemTextContentAndTextPositionAndItemDimension($item, whattoupdate, $optionsitem){
		var itemvalue = $optionsitem.val();
		var position = itemvalue/2;
		var type = $item.attr("type");
		//Update text message on dashboard
		if(type == "checkbox"){
			var checkboxvalue = $optionsitem.prop("checked") ? 1 : 0;
			$item.attr("value",checkboxvalue);
		} else {
			$item.text(itemvalue);
		}

		//Change dimensions
		if (whattoupdate == "width") {
                        $item.css({left: position});
			$item.parent(".elementInDashboardForUpdate").width(itemvalue);
		} else if (whattoupdate == "height") {
                        $item.css({top: position});
			$item.parent(".elementInDashboardForUpdate").height(itemvalue);
		}
	}
	
	//Change dashboard resolution
	function changeDashboardResolution(){
		var $item = $('#ResolutionDialog');
		var prev_width = $(".make_dots").width();
		var prev_height = $(".make_dots").height();
		$('#resolutionWidth').val(prev_width);
		$('#resolutionHeigth').val(prev_height);
		$item.dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				'Save': function() {
					try {
						var width = $('#resolutionWidth').val();
						var height =  $('#resolutionHeigth').val();
						changeDashboardSize(width,height);
						$( this ).dialog( "close" );
					} catch(err) {
						alert("Invalid arguments! - " + err);
					}
				},
				'Cancel': function() {
					$( this ).dialog( "close" );
				}
			}
		});
		$item.dialog("open");
	}

	function changeDashboardSize(width,height) {
		$(".make_dots").width(width);
		$(".make_dots").height(height);
		$(".make_rows_on_dots").width(width);
		$(".make_rows_on_dots").height(height);
	}

	function changeBackground(backgroundImage,backgroundColor,backgroundPosition) {
		//Reseting background to default color and image
		if( backgroundImage == "NULL" || !backgroundImage){
			$(".make_rows_on_dots").css({"background-color": backgroundColor});
			$(".make_rows_on_dots").css({"background-image": "url("+"/geditor/images/bg.gif"+")"});
			$(".make_rows_on_dots").css({"background-position": backgroundPosition});
		}else{
			$(".make_rows_on_dots").css({"background-color": backgroundColor});
			$(".make_rows_on_dots").css({"background-image": "url("+backgroundImage+")"});
			$(".make_rows_on_dots").css({"background-position": backgroundPosition});
		}
	}


	function changeDashboardBackground(){
		var $item = $('#BackgroundImageDialog');
		$item.dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				'Save': function() {
					try {
						var backgroundImage = $('#backgroundImage').val();
						var backgroundColor =  $('#backgroundColor').val();
						var backgroundPosition =  $('#backgroundPosition').val();
						changeBackground(backgroundImage,backgroundColor,backgroundPosition);
						$( this ).dialog( "close" );
					} catch(err) {
						alert("Invalid arguments! - " + err);
					}
				},
				'Cancel': function() {
					$( this ).dialog( "close" );
				}
			}
		});
		$item.dialog("open");
	}

	</script>
	<script type="text/javascript">

	function toggleLiveResizing () {
		$.each( $.layout.config.borderPanes, function (i, pane) {
			var o = myLayout.options[ pane ];
			o.livePaneResizing = !o.livePaneResizing;
		});
	};
	
	function toggleStateManagement ( skipAlert, mode ) {
		if (!$.layout.plugins.stateManagement) return;

		var options	= myLayout.options.stateManagement
		,	enabled	= options.enabled // current setting
		;
		if ($.type( mode ) === "boolean") {
			if (enabled === mode) return; // already correct
			enabled	= options.enabled = mode
		}
		else
			enabled	= options.enabled = !enabled; // toggle option

		if (!enabled) { // if disabling state management...
			myLayout.deleteCookie(); // ...clear cookie so will NOT be found on next refresh
			if (!skipAlert)
				alert( 'This layout will reload as the options specify \nwhen the page is refreshed.' );
		}
		else if (!skipAlert)
			alert( 'This layout will save & restore its last state \nwhen the page is refreshed.' );

		// update text on button
		var $Btn = $('#btnToggleState'), text = $Btn.html();
		if (enabled)
			$Btn.html( text.replace(/Enable/i, "Disable") );
/**
		else
			//$Btn.html( text.replace(/Disable/i, "Enable") );
**/
	};

	// set EVERY 'state' here so will undo ALL layout changes
	// used by the 'Reset State' button: myLayout.loadState( stateResetSettings )
	var stateResetSettings = {
		north__size:		"auto"
	,	north__initClosed:	false
	,	north__initHidden:	false
	,	south__size:		"auto"
	,	south__initClosed:	false
	,	south__initHidden:	false
	,	west__size:		150
	,	west__resizable:	true
	,	west__initClosed:	false
	,	west__initHidden:	false
	,	east__size:			250
	,	east__initClosed:	false
	,	east__initHidden:	false
	};

	var myLayout;

	$(document).ready(function () {

		// this layout could be created with NO OPTIONS - but showing some here just as a sample...
		// myLayout = $('body').layout(); -- syntax with No Options

		myLayout = $('body').layout({

		//	reference only - these options are NOT required because 'true' is the default
			closable:					true	// pane can open & close
		,	resizable:					false	// when open, pane can be resized 
		,	slidable:					true	// when closed, pane can 'slide' open over other panes - closes on mouse-out
		,	livePaneResizing:				true

		//	some resizing/toggling settings
		,	north__slidable:			false	// OVERRIDE the pane-default of 'slidable=true'
		,	north__togglerLength_closed: '100%'	// toggle-button is full-width of resizer-bar
		,	north__spacing_closed:		20		// big resizer-bar when open (zero height)
		,	south__resizable:			false	// OVERRIDE the pane-default of 'resizable=true'
		,	south__spacing_open:		0		// no resizer-bar when open (zero height)
		,	south__spacing_closed:		20		// big resizer-bar when open (zero height)

		//	some pane-size settings
		,	west__minSize:				200
		,	east__size:					250
		,	east__minSize:				200
		,	east__maxSize:				.5 // 50% of layout width
		,	center__minWidth:			100

		//	some pane animation settings
		,	west__animatePaneSizing:	false
		,	west__fxSpeed_size:			"fast"	// 'fast' animation when resizing west-pane
		,	west__fxSpeed_open:			1000	// 1-second animation when opening west-pane
		,	west__fxSettings_open:		{ easing: "easeOutBounce" } // 'bounce' effect when opening
		,	west__fxName_close:			"none"	// NO animation when closing west-pane

		//	enable showOverflow on west-pane so CSS popups will overlap north pane
		,	west__showOverflowOnHover:	true

		//	enable state management
		,	stateManagement__enabled:	true // automatic cookie load & save enabled by default

		,	showDebugMessages:			true // log and/or display messages from debugging & testing code
		});

		// if there is no state-cookie, then DISABLE state management initially
		var cookieExists = !$.isEmptyObject( myLayout.readCookie() );
		if (!cookieExists) toggleStateManagement( true, false );

		myLayout
			// add event to the 'Close' button in the East pane dynamically...
			//.bindButton('#btnCloseEast', 'close', 'east')
	
			// add event to the 'Toggle South' buttons in Center AND South panes dynamically...
			.bindButton('.south-toggler', 'toggle', 'south')
			
	/*		// add MULTIPLE events to the 'Open All Panes' button in the Center pane dynamically...
			.bindButton('#openAllPanes', 'open', 'north')
			.bindButton('#openAllPanes', 'open', 'south')
			.bindButton('#openAllPanes', 'open', 'west')
			.bindButton('#openAllPanes', 'open', 'east')

			// add MULTIPLE events to the 'Close All Panes' button in the Center pane dynamically...
			.bindButton('#closeAllPanes', 'close', 'north')
			.bindButton('#closeAllPanes', 'close', 'south')
			.bindButton('#closeAllPanes', 'close', 'west')
			.bindButton('#closeAllPanes', 'close', 'east')

			// add MULTIPLE events to the 'Toggle All Panes' button in the Center pane dynamically...
			.bindButton('#toggleAllPanes', 'toggle', 'north')
			.bindButton('#toggleAllPanes', 'toggle', 'south')
			.bindButton('#toggleAllPanes', 'toggle', 'west')
			.bindButton('#toggleAllPanes', 'toggle', 'east')
	*/
		;

		// 'Reset State' button requires updated functionality in rc29.15+
		if ($.layout.revision && $.layout.revision >= 0.032915)
			$('#btnReset').show();

 	});

	</script>

{/literal}
<!-- EDITOR END -->

</head>
<body style="width: 100%; height: 100%;">

<!-- EDITOR -->
<!-- manually attach allowOverflow method to pane -->
<div class="ui-layout-north" onmouseover="myLayout.allowOverflow('north')" onmouseout="myLayout.resetOverflow(this)">
	<div id="editor_north">
		<button class="mybutton mybuttonsave">Save</button>
		<button class="mybutton" onclick="myLayout.close('west')">Back</button>
		<button class="mybutton mybuttonclear">Clear</button>
		<button class="mybutton mybuttondelete" >Delete</button>
		Name: <input id="editor_north_name" name="named" title="Dashboard title" value="{$userDashboard.name}"></input>
		Share: <input id="editor_north_share" type="checkbox" name="shared" value="1" {if $userDashboard.share}checked{/if}>
		Zoom: <input id="editor_north_zoom" type="checkbox" name="zoomed" value="1" {if $userDashboard.zoom}checked{/if}>
		Move: <input id="editor_north_move" type="checkbox" name="moved" value="1" {if $userDashboard.move}checked{/if}>
	</div>
</div>

<!-- allowOverflow auto-attached by option: west__showOverflowOnHover = true -->
<div class="ui-layout-west" onmouseover="myLayout.allowOverflow('west')" onmouseout="myLayout.resetOverflow(this)">
	<div id="accordion">
		<h3>Device elements</h3>
		<div class="device_elements">
				<div class="elementstodashboard device_element sensor sensorvalue" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class="ui-widget-header">Sensor Value</h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard device_element sensor sensordoor" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class=""></h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard device_element sensor sensorwindow" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class=""></h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard device_element sensor sensorlamp" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class=""></h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard device_element switch switch1" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class="ui-widget-header">Switch-1</h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard device_element switch switch2" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class="ui-widget-header">Switch-2</h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard device_element switch switch3" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class="ui-widget-header">Switch-3</h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard device_element switch switch4" parent="device_elements" previousparent="device_elements">
					<h3 name="Title" class="ui-widget-header">Switch-4</h3>
					<h4 whattoupdate="coord" class="device_element_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="device_element_width" name="Width"></h4>
					<h4 whattoupdate="height" class="device_element_height" name="Height"></h4>
					<h4 whattoupdate="metric" class="device_element_metric" name="Metric"></h4>
					<div class="graphtypefeeds">
					</div>
				</div>


		</div>


		<h3>Chart Types</h3>
			<div class="graphtypes">
				<div class="elementstodashboard graphtype line_chart mark_black" parent="graphtypes" previousparent="graphtypes" >
					<h3 name="Title" class="ui-widget-header">Line chart</h3>
					<h4 whattoupdate="coord" class="graphtypecoord" name="Coord"></h4>
					<h4 whattoupdate="width" class="graphtypewidth" name="Width"></h4>
					<h4 whattoupdate="height" class="graphtypeheight" name="Height"></h4>
					<div class="portlet-content">
					</div>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard graphtype area_chart mark_black" parent="graphtypes" previousparent="graphtypes">
					<h3 name="Title" class="ui-widget-header">Area chart</h3>
					<h4 whattoupdate="coord" class="graphtypecoord" name="Coord"></h4>
					<h4 whattoupdate="width" class="graphtypewidth" name="Width"></h4>
					<h4 whattoupdate="height" class="graphtypeheight" name="Height"></h4>
					<div class="portlet-content">
					</div>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard graphtype pie_chart mark_black" parent="graphtypes" previousparent="graphtypes">
					<h3 name="Title" class="ui-widget-header">Pie chart</h3>
					<h4 whattoupdate="coord" class="graphtypecoord" name="Coord"></h4>
					<h4 whattoupdate="width" class="graphtypewidth" name="Width"></h4>
					<h4 whattoupdate="height" class="graphtypeheight" name="Height"></h4>
					<div class="portlet-content">
					</div>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard graphtype bar_chart mark_black" parent="graphtypes" previousparent="graphtypes">
					<h3 name="Title" class="ui-widget-header">Bar chart</h3>
					<h4 whattoupdate="coord" class="graphtypecoord" name="Coord"></h4>
					<h4 whattoupdate="width" class="graphtypewidth" name="Width"></h4>
					<h4 whattoupdate="height" class="graphtypeheight" name="Height"></h4>
					<div class="portlet-content">
					</div>
					<div class="graphtypefeeds">
					</div>
				</div>
				<div class="elementstodashboard graphtype gauge_chart mark_black" parent="graphtypes" previousparent="graphtypes">
					<h3 name="Title" class="ui-widget-header">Gauge chart</h3>
					<h4 whattoupdate="coord" class="graphtypecoord" name="Coord"></h4>
					<h4 whattoupdate="width" class="graphtypewidth" name="Width"></h4>
					<h4 whattoupdate="height" class="graphtypeheight" name="Height"></h4>
					<div class="portlet-content">
					</div>
					<div class="graphtypefeeds">
					</div>
				</div>
			</div>
		<h3>Containers</h3>
		<div>
			<button onclick="myLayout.close('west')">Layout1</button>
			<button onclick="myLayout.close('west')">Layout2</button>
			<button onclick="myLayout.close('west')">Layout3</button>
			<button onclick="myLayout.close('west')">Layout4</button>
			<button onclick="myLayout.close('west')">Layout5</button>
		</div>
		<h3>Editor elements</h3>
			<div class="editorelements">
				<div class="elementstodashboard editorelement edelement_text_area mark_black" parent="editorelements" previousparent="editorelements">
					<h3 name="Title" class="ui-widget-header editorElementTextArea" data-type="textarea">Text Area</h3>
					<h4 whattoupdate="coord" class="editorelement_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="editorelement_width" name="Width"></h4>
					<h4 whattoupdate="height" class="editorelement_height" name="Height"></h4>
					<h4 whattoupdate="color" class="editorelement_color" name="Color"></h4>
				</div>
			</div>
<!--
		<h3>Already Saved Graphs</h3>
		<div class="alreadygraphs">
				<div class="elementstodashboard graphs mark_black">
					<h3 name="Title" class="ui-widget-header">Posts</h3>
					<h4 name="Coordinates">Coord</h4>
					<div class="portlet-content">
					</div>
				</div>
		</div>
-->
		<h3>Control panels</h3>
		<div class="control_panels">
				<div class="elementstodashboard control_panel control_panel1" parent="control_panels" previousparent="control_panels">
					<h3 name="Title" class="ui-widget-header">Control panel</h3>
					<h4 whattoupdate="coord" class="control_panel_coord" name="Coord"></h4>
					<h4 whattoupdate="width" class="control_panel_width" name="Width"></h4>
					<h4 whattoupdate="height" class="control_panel_height" name="Height"></h4>
					<h4 whattoupdate="color" class="control_panel_color" name="Color"></h4>
					<h4 type="checkbox" value="1" whattoupdate="timepicker" class="control_panel_timepicker" name="Timepicker" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="hoovertooltips" class="control_panel_hoovertooltips" name="HooverTooltips" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="clicktooltips" class="control_panel_clicktooltips" name="ClickTooltips" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="zoom" class="control_panel_zoom" name="Zoom" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="pan" class="control_panel_pan" name="Pan" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="manualrefresh" class="control_panel_manualrefresh" name="ManualRefresh" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="autorefresh" class="control_panel_autorefresh" name="AutoRefresh" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="refresh" class="control_panel_refresh" name="Refresh" ></h4>
					<h4 type="checkbox" value="1" whattoupdate="reset" class="control_panel_reset" name="Reset" ></h4>
				</div>
		</div>



	</div>
	<button onclick="debugData(myLayout.options.west)">West Options</button>

	<p><button onclick="myLayout.close('west')">Close Me</button></p>

</div>

<div class="ui-layout-south">
	TODO: Make Console panel for executed editor commands

	<!-- this button has its event added dynamically in document.ready -->
	<button class="south-toggler">Toggle This Pane</button>
</div>

<div class="ui-layout-east">
	<div class="header" class="tabs">Component options</div>
		<div id="east_elements">
		</div>
		<button class="mybutton" onclick="updateElementInDashboard()" value="BUTTON" name="BUTTON">UPDATE</button></button>
</div>

<div class="ui-layout-center" >
	<div class="header" class="tabs">
			<button class="mybutton mybuttonres" onclick="changeDashboardResolution();">Resolution</button>
			<button class="mybutton mybuttonimgbg" onclick="changeDashboardBackground()">Image Background</button>
			<button class="mybutton mybuttontotop" >ToTop</button>
			<button class="mybutton mybuttontobottom" >ToBottom</button>
			<button class="mybutton mybuttonzindexhigher" >Z-Index+</button>
			<button class="mybutton mybuttonzindexlower" >Z-Index-</button>
			<button class="mybutton mybuttondeleteelement" onclick="deleteElementFromDashboard()">DeleteElement</button>
	</div>

	<div class="ui-layout-content">
	
{assign var="resolution" value="x"|explode:$userDashboard.resolution}
{assign var="background" value=";"|explode:$userDashboard.background}
{if $resolution[0] && $resolution[1]}
		<div class="make_rows_on_dots" style="width: {$resolution[0]}px; height: {$resolution[1]}px; background-image: url({$background[0]}); background-color: {$background[1]}; background-position: {$background[2]}">
{else}
		<div class="make_rows_on_dots" style="width: 1280px; height: 1024px;">
{/if}

			<div unselectable="on" style=";width:100px;height:100px;position:absolute;z-index:1;;font-size:0;line-height:0;position:absolute;left:0;top:0;width:10px;height:100%;background:url(/geditor/images/left.gif) left top"></div>
			<div unselectable="on" style=";width:100px;height:100px;position:absolute;z-index:1;;font-size:0;line-height:0;position:absolute;left:0;bottom:0;height:10px;width:100%;background:url(/geditor/images/top.gif) left bottom"></div>
			<div unselectable="on" style=";width:100px;height:100px;position:absolute;z-index:1;;font-size:0;line-height:0;position:absolute;left:0;top:0;height:10px;width:100%;background:url(/geditor/images/top.gif) left top"></div>
			<div unselectable="on" style=";width:100px;height:100px;position:absolute;z-index:1;;font-size:0;line-height:0;position:absolute;right:0;top:0;width:10px;height:100%;background:url(/geditor/images/left.gif) top right"></div>
		</div>
{if $resolution[0] && $resolution[1]}	
		<div class="make_dots" style="left: 5px; top: 5px; width: {$resolution[0]}px; height: {$resolution[1]}px; position: absolute; z-index: 1;">
{else}
		<div class="make_dots" style="left: 5px; top: 5px; width: 1280px; height: 1024px; position: absolute; z-index: 1;">
{/if}
			<div id="dashboard" dashboardid="{$userDashboard.dashid}" style="width: 100%; height: 100%; z-index: 1">{$userDashboard.config}</div>
		</div>
	</div>
</div>

</div>

<div id="ResolutionDialog" title="Change Resolution">
	<form>
		<!-- workaround for width and height sizes, they have to be initiated from javascript, but now are hardcoded -->
		<p><label for="resolutionWidth">Width:</label>
{if $resolution[0] && $resolution[1]}	
		<input class="text ui-widget-content ui-corner-all" type="text" id="resolutionWidth" name="resolutionWidth" value="{$resolution[0]}" /></p>
		<p><label for="resolutionHeigth">Height:</label>
		<input class="text ui-widget-content ui-corner-all" type="text" id="resolutionHeigth" name="resolutionHeigth" value="{$resolution[1]}" /></p>
{else}
		<input class="text ui-widget-content ui-corner-all" type="text" id="resolutionWidth" name="resolutionWidth" value="1280" /></p>
		<p><label for="resolutionHeigth">Height:</label>
		<input class="text ui-widget-content ui-corner-all" type="text" id="resolutionHeigth" name="resolutionHeigth" value="1024" /></p>
{/if}
	</form>
</div>
<div id="BackgroundImageDialog" title="Change Background">
	<form>
		<p><label for="backgroundImage" >Image:</label>
		<input class="text ui-widget-content ui-corner-all" type="text" id="backgroundImage" name="backgroundImage" value="{$background[0]}" /></p>
		<p><label for="backgroundPosition" >Position:</label>
		<input class="text ui-widget-content ui-corner-all" type="text" id="backgroundPosition" name="backgroundPosition" value="{$background[2]}" /></p>
		<p><label for="backgroundColor">Color:</label>
		<input class="text ui-widget-content ui-corner-all" type="text" id="backgroundColor" name="backgroundColor" value="{$background[1]}" /></p>
	</form>
</div>

<!-- EDITOR END -->	
{include file="../`$smarty.const.TEMPLATE_DIR`/footer_editor.tpl"}
