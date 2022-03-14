<style>
    .subject-text {
        max-width: 200px !important;
    }

    .search_edit{
        font-size: 12px;
        margin-right: 5px;
        padding: 1px;
        width: 90px;
        color: #FFFF;
        background: #2d2d2d;
        border:none;
    }

    .ranges{
        background: #009688!important;
    }


    .search_button_right{
        position: absolute;
        bottom: 3px;
        right: 10px;
        background-color: #918a6f;
        margin-bottom: 0px;
        font-size: 30px;
        z-index: 9999;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        cursor: pointer;
        transition: width 1s, height 1s, transform 1s;
    }
    .search_button_right:hover{
        background-color: #17a2b8;
        transform: rotate(360deg);
    }

    .fontSearch{
        color: #ffffff;
        font-size: 29px;
        margin-left: 12px;
        margin-top: 13px;
    }

    .repartitionNetworkType{
        color: white;
        background: #444444;
        height: 61px;
        border-radius: 3px;
        padding: 5px;
        width: 100%;
        margin-left: -4px;
    }
    .searchTicket{
        flex: 1;
        border-radius: 0;
        background: #2d2d2d;
        border: none;
        margin-top: 5px;
    }
    .event-source-text {
        color: #6c757d !important;
        padding-left: 5px !important;
    }
    .server-status {
        padding: 5px !important;
        padding-left: 0px !important;
    }
    .badge-ticket-id {
        color: #FFF !important;
        text-align: center !important;
        position: absolute !important;
        right: 30px !important;
    }
    .time-icon {
        padding: 3px !important;
        padding-left: 0px !important;
    }
    .p-new-container {
        display: flex !important;
        margin-bottom: 3px !important;
        position: relative !important;
    }
    .p-small {
        display: flex !important;
        margin-bottom: 3px !important;
    }
    .left-auto-margin {
        margin-left: auto !important;
    }
    .margin-bottom-3 {
        margin-bottom: 3px !important;
    }
    .canvas_container {
        display: flex!important;
        align-items: center!important;
        height: 100%;
    }

    .daterangepicker.ltr.show-ranges.show-calendar.opensright{
        z-index: 9999!important;
    }
</style>
<div ng-controller="noviNet" ng-cloak="" id="dashboardContent" ng-init="initCtrl();">    
    <div style="display: flex;padding-top: 20px;" id="cal">
        <div style="height: 50%;width: 100%">
            <div>
            </div>
            <div>
                <div style="background:#2d2d2d;width: 100%;flex: 1;">
                    <div  style="border: 2px solid #918a6f!important;;margin: 0.3em;margin-left: 0.15em;height: 98%;">
                        <h6 style="padding:10px;margin-bottom: 0px!important"><i class="fa fa-info"></i> {{titleLineChart}}</h6>
                        <div class="card-body tickets5" style="
                             background: rgb(248 248 248);                    
                             width: auto;
                             display: flex!important;
                             height: 85%;
                             justify-content: center;">
                            <canvas
                                class="size-1vw"
                                id="event"
                                height="150"
                                data="priority_datas"
                                labels="priority_labels">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 100%;width: 60%">
            <div style="display: flex;height: 100%;width: 100%;flex-direction: column" id="list_ticket">                
                <div style="background:#2d2d2d;width: 100%;flex: 1">
                    <div  style="border: 2px solid #918a6f!important;;margin: 0.3em;margin-left: 0.15em;">
                        <div class="row">
                            <div class="col-8">
                                <h6 style="padding:5px;margin-bottom: 0px!important"><i class="fa fa-tasks"></i>&nbsp;Répartition type internet | <font style="color:#868686">{{allTicketByUser.length}}</font>&nbsp;Tests</h6>
                            </div>
                            <div class="col-4">
                                <input type="search" name="alltciket" id="idAll" ng-model="search_ticket" class="form form-control searchTicket"  placeholder="Rechercher ... "/>
                            </div>
                        </div>
                        <div id="wrapper">
                            <div class="water-drop"></div>
                            <div class="button-floating-shadow"></div>
                            <div class="button button-floating margin-btn" data-toggle="tooltip"
                                 title="Click to show button action fot current ticket">
                                <i class="fa fa-bars" id="floating-btn-icon"></i>
                            </div>
                            <div class="button button-sub margin-btn" data-color="copy"                                 
                                 ng-click="advanceSearch()" data-toggle="tooltip"
                                 title="Recherche avancé">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <div class="row">
                            <canvas
                                class="size-1vw"
                                id="status_distribution_chart"
                                height="150"
                                data="priority_datas"
                                labels="priority_labels">
                            </canvas>
                        </div>                        
                        <div class="card-body tickets otherView" style="
                             background: #3d3b3b;
                             overflow: auto;
                             padding: 0.3em;
                             padding-top: 10px;
                             height: 89.7%!important;">   
                            <h6 style="
                                color: #4c4c4c;
                                overflow: auto;
                                padding: 2em;
                                text-align: center" 
                                ng-if="allTicketByUser.length < 1"
                                >
                                <i class="fa fa-search">Aucun résultat</i>
                            </h6>
                            <ul>
                                <li class="li-container" ng-repeat="ticket in allTicketByUser| filter:search_ticket">
                                    <div class="divHov">
                                        <h3 class="lih3 flex-vw">
                                            <i class="dot btn-outline-warning server-status" style="color:#41caa4">&bull;</i>
                                            <span class="ellipsis subject-text">Speed result : {{ticket.speed}}Mbps</span>
                                            <span class="ellipsis event-source-text">type {{ticket.effecive_network_type}} </span>
                                            <span class="badge-ticket-id" style="margin-right: 17px;"> #{{ticket.id}}</span>
                                        </h3>
                                        <p class="small p-small">
                                            <i class="fa fa-clock time-icon"></i>
                                            <span>{{ticket.create}}</span>
                                        </p>
                                        <p class="ellipsis margin-bottom-3"><i class="fa fa-info-circle"></i> Vitesse de téléchargement actuel: {{ticket.current_download_speed}} Mbps &nbsp;|Temps de traitement :
                                            {{ticket.round_trip_time}}</p>
                                        <div class="div-width-100">                               
                                            <p class="p-new-container">
                                                <span class="ellipsis" ng-show="ticket.livrable_source">
                                                    <strong class="size-8em color-aaa"><i class="fa fa-user-circle"></i></strong>
                                                    <strong class="size-8em color-bbb">
                                                        <span class="">{{ticket.livrable_source}}</span>
                                                    </strong>
                                                </span>
                                            </p>                                
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo PHP_EOL;
        include_once('modal/modal_error.html');
        echo PHP_EOL;
        include_once('modal/message_alert.html');
        echo PHP_EOL;
        include_once('modal/search.html');
        echo PHP_EOL;
        ?>
    </div>
</div>

<style>
    td{
        color: inherit;
    }
    .tr_hover:hover{
        background: #17a2b8!important;
        color:#FFF!important;
        font-weight: 600;
    }
    .iziModal.isFullscreen {
        height: max-content!important;
    }
</style>
