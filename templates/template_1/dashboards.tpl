{include file="../`$smarty.const.TEMPLATE_DIR`/header.tpl"}

<section role="main" class="app-main">
    <div class="app-main-inner">

        {if !$dashboards_visualize}
            <div class="page-header">
                <h3 class="context-section-title">  <i class="context-section-icon icon-embed"></i>{$smarty.const.DASHBOARDS} </h3>
                <p class="context-section-description">{$smarty.const.DASHBOARDS_MSG1}</p>


                <!--- Dashboards New -->
                <ul class="context-tiles block-grid three-up mobile">
                    <li class="context-tile">
                        <a class="context-tile-add tile tile-dashed icon-plus" href="/editor/new">{$smarty.const.DASHBOARDS_MSG2}</a>
                    </li>
                </ul>
                <!--- Dashboards New End -->
                <!-- closing page-header -->
            </div>


            <!--- Dashboards Listing -->
            <div class="legacy-dashboards context-section row">
                <div class="twelve columns">
                    <div class="context-section no-icon">
                        <h3 class="context-section-title">{$smarty.const.DASHBOARDS}</h3>
                        <p class="context-section-description">Total Dashboards: {$number_of_dashboards_per_user}</p>
                    </div>

                    <div class="legacy-dashboards">
                        <table class="legacy-dashboard-table table-unstyled twelve">
                            <thead>
                                <tr>
                                    <th class="legacy-dashboard-header-name">{$smarty.const.DASHBOARDS_TITLE}</th>
                                    <th class="legacy-dashboard-header-name">{$smarty.const.DASHBOARDS_ID}</th>
                                    <th class="legacy-dashboard-header-updated">{$smarty.const.DASHBOARDS_LAST_UPDATE}</th>
                                    <th class="legacy-dashboard-header-updated">{$smarty.const.DASHBOARDS_ACTION}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach item="dashboard" from=$userdashboards}
                                    <tr {if $dashboard.active == 0} style="text-decoration:line-through" {/if}>
                                        <td class="legacy-dashboard-name five"><a target="_blank" href="/dashboards/visualize/{$dashboard.dashid}">{$dashboard.name}</a></td>
                                        <td class="legacy-dashboard-name two">{$dashboard.dashid}</td>
                                        <td class="legacy-dashboard-updated">{$dashboard.last_update}</td>
                                        <td class="legacy-dashboard-name three">
                                            <a href="/editor/edit/{$dashboard.dashid}" target="_blank">{$smarty.const.DASHBOARDS_EDIT}</a>
                                            <a href="/dashboards/delete/{$dashboard.dashid}">{$smarty.const.DASHBOARDS_DELETE}</a>
                                            {if $dashboard.active == 1}
                                                <a href="/dashboards/deactivate/{$dashboard.dashid}">{$smarty.const.DASHBOARDS_DEACTIVATE}</a>
                                            {else}
                                                <a href="/dashboards/activate/{$dashboard.dashid}">{$smarty.const.DASHBOARDS_ACTIVATE}</a>
                                            {/if}
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!--- Dashboards Listing End -->

        {else}

            <!-- Dashboards Visualize -->


            <div class="page-header">
                <h3 class="context-section-title">  <i class="context-section-icon icon-embed"></i>{$smarty.const.DASHBOARDS_VISUALIZE} </h3>
                <p class="context-section-description">{$smarty.const.DASHBOARDS_MSG6}</p>
                <!-- closing page-header -->
                <div class="dashboards_view">
                    {foreach item="dashboard" from=$dashboards_dashboard}
                        <div id="dashboards_selected">
                            <!-- dashboard_{$dashboard.dashid} -->
                            <h7 class="context-section-title">  <i class="context-section-icon "></i>Title: {$dashboard.name} - ID: {$dashboard.dashid} - Size: {$dashboard.resolution} - <a href="/editor/edit/{$dashboard.dashid}" target="_blank" >{$smarty.const.DASHBOARDS_EDIT}</a></h7>
                            <p class="context-section-description">{if !$dashboard.description}{$dashboard.description}{else}{/if}</p>
                            <div id="dashboard_{$dashboard.dashid}" class="dashboard_selected" resolution="{$dashboard.resolution}" background="{$dashboard.background}" dashid="{$dashboard.dashid}" dashstyle="{$dashboard.style}" style="display: none;">
                                {$dashboard.config}
                            </div>
                            <h7 class="context-section-title">  <i class="context-section-icon "></i>Dashboard last update: {$dashboard.last_update} - Dashboard created date: {$dashboard.create_date}</h7>
                            <!-- dashboard_{$dashboard.dashid} End -->
                        </div>
                    {/foreach}
                    <!-- closing dashboards_selected -->
                </div>
            </div>
            <!-- Dashboards Visualize End -->

            <!-- All flot javascript functions -->
            <script type="text/javascript" src="/flot/jquery.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.time.js"></script>   
            <script type="text/javascript" src="/flot/jquery.flot.symbol.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.axislabels.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.autoMarkings.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.selection.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.pie.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.threshold.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.valuelabels.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.tooltip.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.crosshair.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.navigate.js"></script>
            <script type="text/javascript" src="/flot/jquery.flot.gauge.js"></script>

            <script type="text/javascript" src="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/jquery-ui-1.11.2/jquery-ui.min.js"></script>
            <script type="text/javascript" src="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/jquery-ui-timepicker-addon.js"></script>
            <script type="text/javascript" src="{$smarty.const.SITE_URL}templates/{$smarty.const.TEMPLATE_DIR}/dofthings_files/jquery-ui-timepicker-addon-i18n.min.js"></script>

            <script type="text/javascript">
                {literal}
                    $(document).ready(function () {

                        //Call functions everytime when page is realoded to initialize dashboards
                        dashboardsInitialization();


                        var startDateTextBox = $('#timerange_start');
                        var endDateTextBox = $('#timerange_end');

                        startDateTextBox.datetimepicker({
                            timeFormat: 'HH:mm z',
                            showTimezone: false,
                            onClose: function (dateText, inst) {
                                if (endDateTextBox.val() != '') {
                                    var testStartDate = startDateTextBox.datetimepicker('getDate');
                                    var testEndDate = endDateTextBox.datetimepicker('getDate');
                                    if (testStartDate > testEndDate)
                                        endDateTextBox.datetimepicker('setDate', testStartDate);
                                } else {
                                    endDateTextBox.val(dateText);
                                }
                            },
                            onSelect: function (selectedDateTime) {
                                endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
                            }
                        });

                        endDateTextBox.datetimepicker({
                            timeFormat: 'HH:mm z',
                            showTimezone: false,
                            onClose: function (dateText, inst) {
                                if (startDateTextBox.val() != '') {
                                    var testStartDate = startDateTextBox.datetimepicker('getDate');
                                    var testEndDate = endDateTextBox.datetimepicker('getDate');
                                    if (testStartDate > testEndDate)
                                        startDateTextBox.datetimepicker('setDate', testEndDate);
                                } else {
                                    startDateTextBox.val(dateText);
                                }
                            },
                            onSelect: function (selectedDateTime) {
                                startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
                            }
                        });



                    });

                </script>
                <style>
                </style>
            {/literal}
            <!-- All flot javascript functions End-->

        {/if}

        <!-- closing pp-main-inner -->
    </div>
</section>


</div>
{include file="../`$smarty.const.TEMPLATE_DIR`/footer.tpl"}
