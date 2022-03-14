/* global CONNECTED,angular,console */
function redirectUrl() {
    var url = window.location.href;
    var parse = url.split("/");
    var getThreshold = parse[5].split("=");
    if (getThreshold.length > 1) {
        return true;
    }
    return false;
}
/**
 *
 * @param email
 * @returns {boolean}
 */
function validateEmail(email) {

    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email.trim());
}

/**
 *
 * @param a
 * @param b
 * @returns {number}
 */
function compareStrings(a, b) {

    // Assuming you want case-insensitive comparison
    a = a.toLowerCase();
    b = b.toLowerCase();

    return (a < b) ? -1 : (a > b) ? 1 : 0;
}

$('#messageAlertM').iziModal({
    radius: 10,
    headerColor: '#17a2b8',
    icon: 'fa fa-info',
    padding: '',
    appendTo: '',
    width: 350,
    transitionIn: 'bounceInDown',
    transitionOut: 'bounceOutDown'
});

function opening(scope) {
    var test = scope.dataEvent && scope.dataEvent.id;
    if (!test) {
        scope.dataEvent = {
            id: null,
            start: scope.dst,
            end: scope.dend,
//            object: 'SSI TEST',
//            platform: 'No-platform',
//            service: 'No-service',
//            impact_client: 'Bas',
//            plan_action: '- KafKa pdf<div>- intégration mail</div><div>- intégration log</div><div>- intégration&nbsp;</div>&nbsp;',
//            localization: 'Analakely',
//            description: '- Test by Jean Samuel RANDRIANASOLO<div>- changement de processus</div><div>- modification base</div>',
//            kpi_a_suivre: null,
//            author: 'hardinah',
//            mop: null,
//            status: "NOUVEAU",
//            type: 'DBA',
//            impact_local: 'IT',
//            categorie: 'Standard',
//            suscategorie: null,
//            urgence: 'Bas',
//            priorite: 'Bas',
//            risk: 'Bas',
//            reason: 'Incident',
//            detailImpactCom: null,
//            etap: 'Validation',
//            listTicket: 'SSI',
//            cycleValidation: 'NOUVEAU',
//            observer: 'Jean Samuel RANDRIANASOLO,',
//            intervenant: null,
//            requester: null,
//            tester: 'Jean Samuel RANDRIANASOLO,',
//            livrable_source: 'Jean Samuel RANDRIANASOLO,',
//            addvalid2: false,
//            addvalid3: false
            object: null,
            platform: null,
            service: null,
            tester: null,
            intervenant: null,
            impact_client: null,
            plan_action: null,
            livrable_source: null,
            localization: null,
            description: null,
            kpi_a_suivre: null,
            author: CONNECTED,
            mop: null,
            status: "NOUVEAU",
            requester: null,
            type: null,
            impact_local: null,
            observer: null,
            categorie: null,
            suscategorie: null,
            urgence: null,
            priorite: null,
            risk: null,
            reason: null,
            detailImpactCom: null,
            etap: 'Plannification',
            cycleValidation: 'NOUVEAU',
            addvalid2: false,
            addvalid3: false
        }
    }
    scope.oldEvent = Object.assign({}, scope.dataEvent);
}

$('#modalEvent').iziModal({
    headerColor: '',
    padding: '',
    appendTo: '',
    onOpening: function () {
        init_js();
        var scope = angular.element(document.getElementById('cal')).scope();
        opening(scope);
        scope.get();
    },
    onClosing: function () {
        var scope = angular.element(document.getElementById('cal')).scope();
        scope.files = [];
        scope.file_names = [];
        scope.dataEvent = {};
        scope.get();
        scope.oldEvent = null;
        var urlRedirect = redirectUrl();
        if (urlRedirect === true)
            window.location.href = BASE_URL + "calendar";
    }
});
$('#messageAlertM').iziModal({
    headerColor: '',
    padding: '',
    appendTo: '',
    width: 400,
    onClosing: function () {
        var scope = angular.element(document.getElementById('cal')).scope();
        if (scope.start) {
            scope.dataEvent = {};
        }
        scope.get();
    }
});
$('#errorAlert').iziModal({
    headerColor: '',
    padding: '',
    appendTo: '',
    width: 400
});
function split(val) {

    return val.split(/,\s*/);
}

function extractLast(term) {

    return split(term).pop();
}

$('.singledata').autocomplete({
    source: function (request, response) {

        var scope = angular.element(document.getElementById('cal')).scope();
        var data = scope.list_ldap;
        response($.ui.autocomplete.filter(data, extractLast(request.term)));
    },
    minLength: 0,
    delay: 100
});
$('#service_kpi').on("keydown", function (event) {
    if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
    }
}).autocomplete({
    source: function (request, response) {
        var scope = angular.element(document.getElementById('cal')).scope();
        var data = scope.list_service;
        var data_array = [];
        if (data && data.length) {
            for (var i in data) {
                data_array.push(data[i].name);
            }
            var resp = $.ui.autocomplete.filter(data_array, extractLast(request.term));
            response(resp);
            if (!resp || !resp.length) {
                if (request.term && request.term.length)
                    $('#service_kpi_to_save').css("display", "block");
                else
                    $('#service_kpi_to_save').css("display", "none");
            } else {
                $('#service_kpi_to_save').css("display", "none");
            }
        } else {
            if (request.term && request.term.length)
                $('#service_kpi_to_save').css("display", "block");
            else
                $('#service_kpi_to_save').css("display", "none");
        }
    },
    minLength: 0,
    delay: 100
});
$('#platform_kpi').on("keydown", function (event) {
    if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
    }
}).autocomplete({
    source: function (request, response) {
        var scope = angular.element(document.getElementById('cal')).scope();
        var data = scope.list_platform;
        var data_array = [];
        if (data && data.length) {
            for (var i in data) {
                data_array.push(data[i].name);
            }
            var resp = $.ui.autocomplete.filter(data_array, extractLast(request.term));
            response(resp);
            if (!resp || !resp.length) {
                if (request.term && request.term.length)
                    $('#platform_kpi_to_save').css("display", "block");
                else
                    $('#platform_kpi_to_save').css("display", "none");
            } else {
                $('#platform_kpi_to_save').css("display", "none");
            }
        } else {
            if (request.term && request.term.length)
                $('#platform_kpi_to_save').css("display", "block");
            else
                $('#platform_kpi_to_save').css("display", "none");
        }
    },
    minLength: 0,
    delay: 100
});
$('#list_ticket').on("keydown", function (event) {
    if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
    }
}).autocomplete({
    source: function (request, response) {
        var scope = angular.element(document.getElementById('cal')).scope();
        var data = scope.listTicket;
        var data_array = [];
        if (data && data.length) {
            for (var i in data) {
                data_array.push(data[i].object);
            }
            var resp = $.ui.autocomplete.filter(data_array, extractLast(request.term));
            response(resp);
        }
    },
    minLength: 0,
    delay: 100
});
$('.multiple_auto_completion').on("keydown", function (event) {

    if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
    }
}).autocomplete({
    source: function (request, response) {

        var scope = angular.element(document.getElementById('cal')).scope();
        var data = scope.list_ldap;
        response($.ui.autocomplete.filter(data, extractLast(request.term)));
    },
    focus: function () {

        // prevent value inserted on focus
        return false;
    },
    select: function (event, ui) {

        var terms = split(this.value);
        // remove the current input
        terms.pop();
        var idx = terms.indexOf(ui.item.value);
        // add the selected item
        if (idx < 0) {
            terms.push(ui.item.value);
        }
        // add placeholder to get the comma-and-space at the end
        terms.push("");
        this.value = terms.join(", ");
        return false;
    },
    minLength: 0,
    delay: 100
});
// initialisation des variables
function init_js(module) {
    var fileInput = document.querySelector(".input-file"),
            button = document.querySelector(".input-file-trigger");
    if (module) {
        fileInput = document.querySelector("." + module + "input-file"),
                button = document.querySelector("." + module + "input-file-trigger");
    }

    // action lorsque la "barre d'espace" ou "Entrée" est pressée
    button.addEventListener("keydown", function (event) {
        if (event.keyCode == 13 || event.keyCode == 32) {
            fileInput.focus();
        }
    });
    // action lorsque le label est cliqué
    button.addEventListener("click", function (event) {
        fileInput.focus();
        return false;
    });
    // affiche un retour visuel dès que input:file change
    var names = [];
    var files = [];
    fileInput.addEventListener("change", function (event) {
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            var file_name = $(this).get(0).files[i].name;
            files.push($(this).get(0).files[i]);
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(file_name)[1];
            ext = ext.toLowerCase();
            var element = "";
            switch (ext) {
                case 'png':
                    element = 'fa fa-image';
                    break;
                case 'jpg':
                    element = 'fa fa-image';
                    break;
                case 'jpeg':
                    element = 'fa fa-image';
                    break;
                case 'zip':
                    element = 'fa fa-file-archive';
                    break;
                case 'rar':
                    element = 'fa fa-file-archive';
                    break;
                case '7zip':
                    element = 'fa fa-file-archive';
                    break;
                case 'tar':
                    element = 'fa fa-file-archive';
                    break;
                case 'gz':
                    element = 'fa fa-file-archive';
                    break;
                case 'xlsx':
                    element = 'fa fa-file-excel';
                case 'xlsm':
                    element = 'fa fa-file-excel';
                    break;
                case 'xls':
                    element = 'fa fa-file-excel';
                    break;
                case 'csv':
                    element = 'fa fa-file-excel';
                    break;
                case 'mp3':
                    element = 'fa fa-file-audio';
                    break;
                case 'pdf':
                    element = 'fa fa-file-pdf';
                    break;
                case 'mp4':
                    element = 'fa fa-file-video';
                    break;
                case 'mkv':
                    element = 'fa fa-file-video';
                    break;
                case 'avi':
                    element = 'fa fa-file-video';
                    break;
                case 'docx':
                    element = 'fa fa-file-word';
                    break;
                case 'doc':
                    element = 'fa fa-file-word';
                    break;
                case 'pptx':
                    element = 'fa fa-file-powerpoint';
                    break;
                case 'ppt':
                    element = 'fa fa-file-powerpoint';
                    break;
                default:
                    element = 'fa fa-file';
                    break;
            }
            var fn = $(this).get(0).files[i].name;
            names.push({clazz: element, fn: fn.trim()});
        }

        $("input[name=file]").val(names);
        angular.element(this).scope().fileNameChanged(files, names);
    });
}