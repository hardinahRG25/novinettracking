/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global BASE_URL, calendar, moment, daySelectionMousedown, onLeftPopper, referenceElement, container, NProgress, CONNECTED, app, Infinity */


function redirectUrl() {
    var url = window.location.href;
    var parse = url.split("/");
    var getThreshold = parse[5].split("=");
    if (getThreshold.length > 1) {
        return true;
    }
    return false;
}


$('#modalSearch').iziModal({ headerColor: '#009688', padding: '', appendTo: '', width: 600, zindex: 1002, radius: 10 });
app.controller("noviNet", function ($scope, $http, $interval, $location) {

    /**
     * 
     */
    $scope.initCtrl = function () {
        //user access
        $http.get(BASE_URL + "api/NetworkTracking/index").then(function (response) {
            if (response) {
                $scope.defaultVisibility = 0;
                if (response.data.access === 'admin') {
                    $scope.defaultVisibility = 1;
                    $http.get(BASE_URL + "api/UserMep/usermeps").then(function (response) {
                        if (response) {
                            $scope.allUser = response.data;
                        }
                    });
                }
                $scope.search.all = $scope.defaultVisibility;
            }
        }, function (error) {
            if (error && error.data && error.data.status) {
                if (error.data.status === "Not connected") {
                    document.location.href = BASE_URL;
                }
            }
        });
        $scope.search = {
            limit: "100"
        };
        $scope.start = moment().subtract(10, 'day').startOf('day');
        $scope.end = moment().endOf('day');
        var sd = $scope.start.format('YYYY-MM-DD HH:mm:ss');
        var ed = $scope.end.format('YYYY-MM-DD HH:mm:ss');
        $scope.search.start = sd;
        $scope.search.end = ed;
        $scope.search.search_detail = 'avg';
        $scope.search.date_search = sd + ' - ' + ed;
        $('input[name="date_search"]').val(sd + ' - ' + ed);

        $scope.globaOpt = {
            maxSize: 30
        };
        $('#loadingdata').remove();
    };

    /**
     * Search module
     */
    $scope.advanceSearch = function () {
        $('.daterangepicker ltr show-ranges show-calendar opensright').attr('z-index', 9999);
        $('#modalSearch').iziModal('setTitle', "Recherche avancée");
        $('#modalSearch').iziModal('setIcon', "fa fa-search");
        $('#modalSearch').iziModal('setSubtitle', "Configurer vos paramètres de recherche");
        $('#modalSearch').iziModal('open');
    }
    /**
     * @description button on validation
     */
    $scope.goSearch = function (visibility) {
        $scope.getNetworkType(visibility);
        $scope.getSearchResult(visibility);
        $scope.getLineChart(500, "event");
    };
    /**
     * 
     * @param {*} text 
     * @param {*} id 
     */
    $scope.resetSearch = function () {
        $scope.search = {
            search_detail: "avg",
            all: $scope.defaultVisibility
        };
        $scope.start = moment().subtract(10, 'day').startOf('day');
        $scope.end = moment().endOf('day');
        var sd = $scope.start.format('YYYY-MM-DD HH:mm:ss');
        var ed = $scope.end.format('YYYY-MM-DD HH:mm:ss');
        $scope.search.start = sd;
        $scope.search.end = ed;
        $scope.search.user_id = null;
        $scope.search.date_search = sd + ' - ' + ed;
        $('input[name="date_search"]').val(sd + ' - ' + ed);
    };
    /**
     * 
     * @param {*} text 
     * @param {*} id 
     */
    $scope.getSearchResult = function (initAll) {
        $('#list_ticket').LoadingOverlay("show", $scope.globaOpt);
        console.log($scope.search_user_id);
        if($scope.search.all === 1 && $scope.search.search_detail == 'list' && (!$scope.search.user_id || $scope.search.user_id == null)){
            delayToasts("error", "Vous devez saisir un utilisateur si vous choisissez de voir la liste des tests", "Graphe");
            $('#list_ticket').LoadingOverlay("hide");
            $scope.resetSearch();
        }
        var url = BASE_URL + "api/NetworkTracking/userDataHistory";
        $http({
            url: url,
            method: "GET",
            params: $scope.search
        }).then(function (response) {
            if (response.data) {
                $scope.allTicketByUser = response.data;
                $('#list_ticket').LoadingOverlay("hide");
            }
        }).finally(function () {
            $('#list_ticket').LoadingOverlay("hide");
            $('#modalSearch').iziModal('close');
        });
    };

    $scope.getDay = function () {
        var daty = new Date();
        return daty.getDay();
    };


    /**
     * 
     * daterangepicker
     */
    /**
     *
     * @param {type} d
     * @returns {String}
     */
    $scope.getDate = function (d) {
        var daty = d.getFullYear() + "-" + (d.getMonth() > 10 ? d.getMonth() : "0" + d.getMonth()) + "-" + (d.getDate() > 10 ? d.getDate() : "0" + d.getDate());
        var t = (d.getHours() > 10 ? d.getHours() : "0" + d.getHours()) + ":" + (d.getMinutes() > 10 ? d.getMinutes() : "0" + d.getMinutes()) + ":" + (d.getSeconds() > 10 ? d.getSeconds() : "0" + d.getSeconds());
        return daty + " " + t;
    };
    $('input[name="date_search"]').on('keyup', function (e) {
        if (e.keyCode === 13) {
            var value = $('input[name="date_search"]').val();
            if (!value) {
                $scope.start = null;
                $scope.end = null;
                $scope.search.date_search = null;
                $scope.search.start = null;
                $scope.search.end = null;
                $scope.$apply();
                $scope.getSearchResult();
            } else {
                var date_array = value.trim().split(' - ');
                $scope.start = null;
                $scope.end = null;
                var str_d = null;
                if (date_array.length == 2) {
                    if (moment(date_array[0], "YYYY-MM-DD HH:mm:ss").isValid()) {
                        $scope.start = moment(date_array[0], "YYYY-MM-DD HH:mm:ss");
                        $scope.search.start = $scope.start.format("YYYY-MM-DD HH:mm:ss");
                    }
                    if (moment(date_array[1], "YYYY-MM-DD HH:mm:ss").isValid()) {
                        $scope.end = moment(date_array[1], "YYYY-MM-DD HH:mm:ss");
                        $scope.search.end = $scope.end.format("YYYY-MM-DD HH:mm:ss");
                    }
                } else if (date_array.length == 1) {
                    if (moment(date_array[0], "YYYY-MM-DD HH:mm:ss").isValid()) {
                        $scope.start = moment(date_array[0], "YYYY-MM-DD HH:mm:ss");
                        $scope.search.start = $scope.start.format("YYYY-MM-DD HH:mm:ss");
                    }
                }
                if ($scope.start && $scope.end) {
                    if ($scope.end.isBefore($scope.start)) {
                        var endt = $scope.end;
                        $scope.end = $scope.start;
                        $scope.search.end = $scope.end.format("YYYY-MM-DD HH:mm:ss");
                        $scope.start = endt;
                        $scope.search.start = $scope.start.format("YYYY-MM-DD HH:mm:ss");
                    }
                }
                if ($scope.search.start && $scope.search.end)
                    str_d = $scope.search.start + ' - ' + $scope.search.end;
                else if (!$scope.search.start && $scope.search.end)
                    str_d = $scope.search.end;
                else if ($scope.search.start && !$scope.search.end)
                    str_d = $scope.search.start;
                $scope.search.date_search = str_d;
                $scope.$apply();
                $('input[name="date_search"]').val(str_d);
                $scope.getSearchResult();
            }
            return false;
        }
    });

    $('input[name="date_search"]').on('focus', function (event) {
        let calendarOptions = {
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            },
            ranges: {
                'Aujourd\'hui': [moment().startOf('day'), moment().endOf('day')],
                'Hier': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                'Cette semaine': [moment().startOf('week'), moment().endOf('week')],
                '7 dernier jours': [moment().subtract(7, 'day').startOf('day'), moment().endOf('day')],
                '3 dernier jours': [moment().subtract(3, 'day').startOf('day'), moment().endOf('day')],
                'Semaine dernière': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                'Mois dernier': [moment().subtract(1, 'months').startOf('month'), moment().endOf('month')],
                '2 Dernier mois': [moment().subtract(2, 'months').startOf('month'), moment().endOf('month')],
                '3 Dernier mois': [moment().subtract(3, 'day').startOf('day'), moment().endOf('month')]
            },
            timePicker: true,
            timePicker24Hour: true,
            timePickerSeconds: true,
            linkedCalendars: false,
            alwaysShowCalendars: true,
            showCustomRangeLabel: false,
            autoApply: false,
            autoUpdateInput: false,
            startDate: $scope.start ? $scope.start : moment().subtract(3, 'day').startOf('day'),
            endDate: $scope.end ? $scope.end : moment().endOf('month')
        };
        $('input[name="date_search"]').daterangepicker(calendarOptions);
        $('input[name="date_search"]').on('apply.daterangepicker', function (ev, picker) {
            var sd = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
            var ed = picker.endDate.format('YYYY-MM-DD HH:mm:ss');
            $scope.search.start = sd;
            $scope.search.end = ed;
            $scope.start = picker.startDate;
            $scope.end = picker.endDate;
            $scope.search.date_search = sd + ' - ' + ed;
            $('input[name="date_search"]').val(sd + ' - ' + ed);
            $scope.$apply();
        });
        $('input[name="date_search"]').on('cancel.daterangepicker', function (ev, picker) {
            $scope.start = null;
            $scope.end = null;
            $scope.search.start = null;
            $scope.search.end = null;
            $scope.search.date_search = null;
            $('input[name="date_search"]').val('');
            $scope.$apply();
        });
    }
    );

    /**
     * init datepicker for date start input
     */
    $('input[name="start"]').on('focus', function () {
        var currentInputDate = $scope.dataEvent.start;
        var d = new Date();
        if (currentInputDate) {
            d = new Date(currentInputDate.trim());
            if (Object.prototype.toString.call(d) === "[object Date]") {
                // it is a date
                if (isNaN(d.getTime())) {  // d.valueOf() could also work
                    d = new Date();
                }
            } else {
                d = new Date();
            }
        }
        $('input[name="start"]').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            timePicker24Hour: true,
            autoUpdateInput: false,
            timePickerSeconds: true,
            startDate: d,
            endDate: d,
            open: "center",
            locale: {
                format: 'YYYY-MMM-DD HH:mm:ss'
            }
        }, function (start, end) {
            $scope.dataEvent.start = start.format('YYYY-MM-DD HH:mm:ss');
            $scope.dataEvent.start = start.format('YYYY-MM-DD HH:mm:ss');
            $scope.$apply();
        });
    });
    /**
     * init datepicker for date end input
     */
    $('input[name="end"]').on('focus', function () {
        var currentInputDate = $scope.dataEvent.end;
        var d = new Date();
        if (currentInputDate) {
            d = new Date(currentInputDate.trim());
            if (Object.prototype.toString.call(d) === "[object Date]") {
                // it is a date
                if (isNaN(d.getTime())) {  // d.valueOf() could also work
                    d = new Date();
                }
            } else {
                d = new Date();
            }
        }
        $('input[name="end"]').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            timePicker24Hour: true,
            autoUpdateInput: false,
            timePickerSeconds: true,
            startDate: d,
            endDate: d,
            open: "center",
            minDate: new Date($('input[name="start"]').val()),
            locale: {
                format: 'YYYY-MMM-DD HH:mm:ss'
            }
        }, function (start, end) {
            $scope.dataEvent.end = start.format('YYYY-MM-DD HH:mm:ss');
            $scope.$apply();
        });
    });


    /**
     * handle action for fullcalendar select
     * @param {type} start
     * @param {type} end
     * @param {type} today
     * @returns {undefined}
     */
    $scope.select = function (start, end, today, dashboard = null) {
        $('input').removeAttr("disabled");
        $('textarea').removeAttr("disabled");
        $('select').removeAttr("disabled");
        $("input[name='kpi_a_suivre']").removeAttr("disabled");
        $("input[type='file']").removeAttr("disabled");
        var check = $.fullCalendar.formatDate(start, 'YYYY-MM-DD');
        var today = $.fullCalendar.formatDate(today, 'YYYY-MM-DD');
        var day = new Date(check);
        var test = day.getDay() === 5 || day.getDay() === 6 || day.getDay() === 0;
        $scope.start = start;
        $scope.end = end;
        $scope.dst = $.fullCalendar.formatDate(start, "YYYY-MM-DD HH:mm:ss");
        $scope.dend = $.fullCalendar.formatDate(end, "YYYY-MM-DD HH:mm:ss");
        if (dashboard === null) {
            $scope.$apply();
        }
        if (today <= check && !test) {
            $scope.handleSelect(start, end);
        } else if (today > check) {
            var title = 'Voulez-vous continuer ?';
            var html = "La date sélectionnée est déjà passée, voulez-vous faire une régularisation ?";
            var type = "warning";
            var color = '#17a2b8';
            var confirmText = "Continuer !";
            $scope.confirmActionMain(type, title, html, color, confirmText, $scope.confirmAction);
        } else if (test) {
            var title = 'Voulez-vous continuer ?';
            var html = "Les SSI de <strong style='text-transform: uppercase'>" + $.fullCalendar.formatDate(start, 'dddd') + "</strong> sont déconseillées, voulez-vous quand même en planifier une ?";
            var type = "warning";
            var color = '#17a2b8';
            var confirmText = "Continuer !";
            $scope.confirmActionMain(type, title, html, color, confirmText, $scope.confirmAction);
        }
        if ($scope.dataEvent) {
            $scope.convertTextToLink($scope.dataEvent.description, "description");
            $scope.convertTextToLink($scope.dataEvent.detailImpactCom, "detailImpactCom");
            $scope.convertTextToLink($scope.dataEvent.plan_action, "plan_action");
        }
    };
    /**
     * open
     * @param {type} start
     * @param {type} end
     * @returns {undefined}
     */
    $scope.handleSelect = function (start, end) {
        $('#modalEvent').iziModal('setTitle', "Ajouter Evènement");
        $('#modalEvent').iziModal('setSubtitle', "Nouvel evènement");
        $('#modalEvent').iziModal('setHeaderColor', '#28a745');
        $("#modalEvent").iziModal("open");
    };


    $scope.replace = function (string) {
        var str = null;
        if (string) {
            str = string.replace(/\'/g, "'");
            str = string.replace(/\\'/g, "'");
            str = str.replace(/\"/g, '"');
            str = str.replace(/\\"/g, '"');
        }
        return str;
    };
    /**
     * set all calendar environnement and render it
     * @returns {undefined}
     */
    $scope.get = function () {
        // all init function
        $scope.getUserConnected();
        $http({
            url: BASE_URL + "api/NetworkTracking/lastInsert",
            method: "GET",
            params: { ldap: CONNECTED }
        }).then(function (response) {
            if (response.data) {
                if (response.data.success.insert === true) {
                    $scope.networkTest();
                }
            }
        }, function (error) {
            delayToasts("error", "Dernier test, une erreur s'est produite lors du chargement des informations", "Tableau de bord");
            console.log(error);
            document.location.href = BASE_URL + 'login';
        });
    };

    /**
     * 
     * @description function to test speed network and insert it into database by api
     */
    $scope.networkTest = function () {
        window.setTimeout($scope.measureConnectionSpeed(), 0);
    }

    $scope.measureConnectionSpeed = function () {
        var imageAddr = "https://hackthestuff.com/images/test.jpg";
        var downloadSize = 13055440//bps;
        var startTime, endTime;
        var download = new Image();
        startTime = (new Date()).getTime();
        var cacheBuster = "?nnn=" + startTime;
        download.src = imageAddr + cacheBuster;
        download.onload = function () {
            endTime = (new Date()).getTime();
            showResults();
        }
        download.onerror = function (err, msg) {
            $scope.speedtest = 0;
            $scope.allInfoNetwork($scope.speedtest);
        }
        startTime = (new Date()).getTime();
        var cacheBuster = "?nnn=" + startTime;
        download.src = imageAddr + cacheBuster;
        function showResults() {
            var duration = (endTime - startTime) / 1000;
            var bitsLoaded = downloadSize * 8;
            var speedBps = (bitsLoaded / duration).toFixed(2);
            var speedKbps = (speedBps / 1024).toFixed(2);
            var speedMbps = (speedKbps / 1024).toFixed(2);
            $scope.speedtest = speedMbps;
            $scope.allInfoNetwork($scope.speedtest);
        }
    }

    $scope.allInfoNetwork = function (speedRes) {
        var net = navigator.connection;
        $scope.userInfo = [];
        $.getJSON("https://api.ipify.org?format=json", function (data) {
            $scope.userInfo.adressIp = data.ip;
        });

        const dataObject = {
            userId: $scope.user_connected.id,
            adressIp: $scope.userInfo.adressIp,
            userSpeed: speedRes,
            effecive_network_type: net.effectiveType,
            current_download_speed: net.downlink,
            round_trip_time: net.rtt
        };
        $http.put(BASE_URL + "api/NetworkTracking/dataNetwork/", dataObject).then(function (response) {
            if (response.data) {
                if (response.data.error) {
                    $scope.error_pass = response.data.error_message;
                }
            }
        }, function (error) {
            if (error.status && error.status === "Not connected") {
                document.location.href = BASE_URL;
            }
        });
    }
    $scope.getUserConnected = function () {
        $http({
            method: 'GET',
            url: BASE_URL + "api/UserMep/userApp",
            params: { ldap: CONNECTED }
        }).then(function (response) {
            if (response.data && response.data.length > 0) {
                if (response.data[0].access === 'admin') {
                    $scope.defaultVisibility = 1;
                } else {
                    $scope.defaultVisibility = 0;
                }
                $scope.user_connected = response.data[0];
                $scope.goSearch($scope.defaultVisibility);
            }
        }, function (error) {
            console.log(error);
            if (error.status == "Not connected") {
                document.location.href = BASE_URL;
            }
        });
    };

    $scope.qualityNetworkType = function (arrayInput) {
        let colors = ['#ff9a9a', '#7ebde9', '#94d7b2', '#e5f7b8', 'rgb(108,117,125)', '#1d7d33', '#f37736', 'rgb(108,117,125)', '#1d7d33'];
        let labels = arrayInput.label;
        let data = arrayInput.count;
        let animated = 500;
        let fontSize = 12;
        let yAxisMinus = 0;
        if ($scope.status_chart) {
            $scope.status_chart.data.labels = labels;
            $scope.status_chart.data.datasets.forEach((dataset) => {
                dataset.data = data;
            });
            $scope.status_chart.update();
        } else {
            let ctx = document.getElementById("status_distribution_chart");
            $scope.status_chart = $scope.drawDoughnutChart(ctx, data, labels, colors, animated, fontSize, yAxisMinus);
        }
    };

    /**
     *
     * @param ctx
     * @param datasets
     * @param labels
     * @param colors
     * @param animated
     * @param fontSize
     * @param yAxisMinus
     * @returns {Array<Number>|String|Array}
     */
    $scope.drawDoughnutChart = function (ctx, datasets, labels, colors, animated, fontSize = "12", yAxisMinus = 0) {
        Chart.defaults.doughnutLabels = Chart.helpers.clone(Chart.defaults.doughnut);
        let helpers = Chart.helpers;
        let defaults = Chart.defaults;
        Chart.controllers.doughnutLabels = Chart.controllers.doughnut.extend({
            updateElement: function (arc, index, reset) {
                let _this = this;
                let chart = _this.chart,
                    chartArea = chart.chartArea,
                    opts = chart.options,
                    animationOpts = opts.animation,
                    arcOpts = opts.elements.arc,
                    centerX = (chartArea.left + chartArea.right) / 2,
                    centerY = (chartArea.top + chartArea.bottom) / 2,
                    startAngle = opts.rotation, // non reset case handled later
                    endAngle = opts.rotation, // non reset case handled later
                    dataset = _this.getDataset(),
                    circumference = reset && animationOpts.animateRotate ? 0 : arc.hidden ? 0 : _this.calculateCircumference(dataset.data[index]) * (opts.circumference / (2.0 * Math.PI)),
                    innerRadius = reset && animationOpts.animateScale ? 0 : _this.innerRadius,
                    outerRadius = reset && animationOpts.animateScale ? 0 : _this.outerRadius,
                    custom = arc.custom || {},
                    valueAtIndexOrDefault = helpers.getValueAtIndexOrDefault;

                helpers.extend(arc, {
                    // Utility
                    _datasetIndex: _this.index,
                    _index: index,

                    // Desired view properties
                    _model: {
                        x: centerX + chart.offsetX,
                        y: centerY + chart.offsetY,
                        startAngle: startAngle,
                        endAngle: endAngle,
                        circumference: circumference,
                        outerRadius: outerRadius,
                        innerRadius: innerRadius,
                        label: valueAtIndexOrDefault(dataset.label, index, chart.data.labels[index])
                    },

                    draw: function () {
                        let ctx = this._chart.ctx,
                            vm = this._view,
                            sA = vm.startAngle,
                            eA = vm.endAngle,
                            opts = this._chart.config.options;

                        let labelPos = this.tooltipPosition();
                        let segmentLabel = vm.circumference / opts.circumference * 100;
                        segmentLabel = valueAtIndexOrDefault(dataset.data, index, chart.data.datasets[index]);

                        ctx.beginPath();

                        ctx.arc(vm.x, vm.y, vm.outerRadius, sA, eA);
                        ctx.arc(vm.x, vm.y, vm.innerRadius, eA, sA, true);

                        ctx.closePath();
                        ctx.strokeStyle = vm.borderColor;
                        ctx.lineWidth = vm.borderWidth;

                        ctx.fillStyle = vm.backgroundColor;

                        ctx.fill();
                        ctx.lineJoin = 'bevel';

                        if (vm.borderWidth) {
                            ctx.stroke();
                        }

                        if (vm.circumference > 0.15) { // Trying to hide label when it doesn't fit in segment
                            ctx.beginPath();
                            ctx.font = helpers.fontString(fontSize, 'bold', opts.defaultFontFamily);
                            ctx.fillStyle = "#fff";
                            ctx.textBaseline = "top";
                            ctx.textAlign = "center";

                            // Round percentage in a way that it always adds up to 100%
                            ctx.fillText(segmentLabel, labelPos.x, labelPos.y - yAxisMinus);
                        }
                    }
                });

                let model = arc._model;
                model.backgroundColor = custom.backgroundColor ? custom.backgroundColor : valueAtIndexOrDefault(dataset.backgroundColor, index, arcOpts.backgroundColor);
                model.hoverBackgroundColor = custom.hoverBackgroundColor ? custom.hoverBackgroundColor : valueAtIndexOrDefault(dataset.hoverBackgroundColor, index, arcOpts.hoverBackgroundColor);
                model.borderWidth = custom.borderWidth ? custom.borderWidth : valueAtIndexOrDefault(dataset.borderWidth, index, arcOpts.borderWidth);
                model.borderColor = custom.borderColor ? custom.borderColor : valueAtIndexOrDefault(dataset.borderColor, index, arcOpts.borderColor);

                // Set correct angles if not resetting
                if (!reset || !animationOpts.animateRotate) {
                    if (index === 0) {
                        model.startAngle = opts.rotation;
                    } else {
                        model.startAngle = _this.getMeta().data[index - 1]._model.endAngle;
                    }
                    model.endAngle = model.startAngle + model.circumference;
                }

                arc.pivot();
            }
        });

        let config = {
            type: 'doughnutLabels',
            data: {
                datasets: [{
                    data: datasets,
                    backgroundColor: colors,
                    borderWidth: 1,
                    borderColor: 'rgba(255, 255, 255, 0.1)'
                }],
                labels: labels
            },
            options: {
                cutoutPercentage: 60,
                rotation: Math.PI,
                responsive: true,
                legend: {
                    position: 'top',
                    labels: {
                        fontColor: "#aaa"
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: animated
                },
                onClick: function (e) {
                    var element = this.getElementAtEvent(e);
                    if (element.length) {
                        if (element[0]) {
                            var chartData = element[0]['_chart'].config.data;
                            var idx = element[0]['_index'];

                            var label = chartData.labels[idx];
                            var value = chartData.datasets[0].data[idx];
                            var array = { "name": label, "id": value };
                        }
                    }
                }
            }
        };
        if (ctx !== null)
            return (new Chart(ctx, config));
        return null;
    };

    $scope.getNetworkType = function (visibility) {
        $http({
            url: BASE_URL + "api/NetworkTracking/repartitionNetworkType",
            method: "GET",
            params: $scope.search
        }).then(function (response) {
            if (response) {
                $scope.qualityNetworkType(response.data);
            }
        }, function (error) {
            delayToasts("error", "Réparition qualité internet,Une erreur s'est produite lors du chargement des informations", "Tableau de bord");
            document.location.href = BASE_URL + 'login'; r
            return false;
        });
    };
    /**
     * Line chart
     */
    /**
     * counter to active chart animation
     * @type {number}
     */
    /**
     * Chart container properties
     * @type {{impacted_platform: {path: string, loadingContainer: string, bgColor: [string], id: string, title: string, type: string}, event: {path: string, loadingContainer: string, bgColor: [string], id: string, title: string, type: string}}}
     */
    $scope.chartElement = {
        event: {
            path: "event_stat",
            id: "event",
            loadingContainer: "event",
            type: "line"
        }
    };

    /**
   * get data for chart element
   * @param duration
   * @param container
   */
    $scope.getLineChart = function (duration, container) {
        let chEl = $scope.chartElement[container];
        let loadingEl = $("#" + chEl.loadingContainer);
        loadingEl.LoadingOverlay("show", $scope.option);
        let element = chEl.path;
        let param = $scope.search;
        $http({
            method: "GET",
            url: BASE_URL + "api/NetworkTracking/my_info",
            params: param,
        }).then(
            function (response) {
                let labels = response.data.success.labels;
                let data = response.data.success.datasets;
                $scope.titleLineChart = response.data.success.title;
                if ($scope[element]) {
                    $scope[element].data.labels = labels;
                    $scope[element].data.datasets = data;
                    var array = [];
                    data.map((d) => {
                        array = [...array, ...d.data];
                    });
                    let step = $scope.defineStepSize(array);
                    $scope[element].options.scales.yAxes[0].ticks.stepSize = step;
                    // ($scope[element].options.scales.yAxes[0].ticks.max =
                    //Math.ceil(Math.max.apply(Math, array)) + step);
                    $scope[element].options.animation.duration = duration;
                    $scope[element].update();
                } else {
                    let ctx = document.getElementById(chEl.id);
                    $scope[element] = $scope.drawLineChart(
                        ctx,
                        chEl.type,
                        chEl.title,
                        data,
                        labels,
                        chEl.bgColor,
                        chEl.borderColor,
                        duration
                    );
                }
                loadingEl.LoadingOverlay("hide");
            },
            function (error) {
                loadingEl.LoadingOverlay("hide");
                if (error && error.data && error.data.status == "Not connected") {
                    window.location.reload();
                } else {
                    console.log(error);
                }
            }
        );
    };
    /**
     * define line chart step according to data
     * @param data
     * @returns {number}
     */
    $scope.defineStepSize = function (data) {
        let max = Math.max.apply(Math, data);
        if (max <= 50) {
            return 1;
        } else if (max > 50 && max <= 100) {
            return 10;
        } else {
            return 2;
        }
    };
    /**
     * Draw line chart
     * @param ctx
     * @param type
     * @param title
     * @param data
     * @param labels
     * @param bgColors
     * @param duration
     * @returns {Array<Number>|String|Array}
     */
    $scope.drawLineChart = function (
        ctx,
        type,
        title,
        data,
        labels,
        bgColors,
        borderColor,
        duration
    ) {
        return new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: data,
            },
            options: {
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,

                            },
                        },
                    ],
                },
                animation: {
                    duration: duration,
                },
                legend: {
                    labels: {
                        fontColor: "#aaa",
                    },
                },
            },
        });
    };

    /**
     * Function execjs
     */
    $scope.get();

    /**
     * CRON function 
     */
    $interval(function () {
        $http.get(BASE_URL + "api/NetworkTracking/index").then(function (response) {
            if (response) {
                let visibility = 0;
                if (response.data.access === 'admin') {
                    visibility = 1;
                }
                $scope.goSearch(visibility);
            }
        }, function (error) {
            if (error && error.data && error.data.status) {
                if (error.data.status === "Not connected") {
                    document.location.href = BASE_URL;
                }
            }
        });
    }
        , 3600000);
    $interval(function () {
        $scope.networkTest();
    }, 10800000); //10800000 =  3h en millisencodes
    $interval(function () {
        $scope.getLineChart(500, "event");
    }, 3600000);
});