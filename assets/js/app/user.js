/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global BASE_URL, app */

$('#modalUser').iziModal({
    headerColor: '', padding: '', appendTo: '', width: 700, zindex: 5,
    onClosing: function () {
        var scope = angular.element(document.getElementById('user_container')).scope();
        scope.user_notif = [];
        $('#closepopover').click();
    }
});

app.controller('userManagement', function ($scope, $http, $interval) {
    $interval(function () {
        $scope.get();
    }, 60000);

    $scope.get = function () {
        $scope.getUserConnected();
        $http.get(BASE_URL + "api/UserMep/usermeps").then(function (response) {
            $scope.users = response.data;
        }, function (error) {
            if (error == "Not connected") {
                document.location.href = BASE_URL;
            }
        });
    };

    $scope.configureMepNotif = function () {
        if ($scope.user) {

        }
    };
    $scope.text_check = "Tout cocher";
    $scope.activeCheckFor = function (mpl) {
        if (mpl) {
            $scope.check_all = false;
            $scope.text_check = "Tout cocher";
            if (!$scope.user_notif) {
                $scope.user_notif = [];
            }
            var id = "active_notfi_for" + mpl.id;
            if ($('#' + id).hasClass("fa-square")) {
                $('#' + id).attr("class", "fa fa-check");
                $('#' + id).css("color", "#28a745");
                $('#' + id).css("border", "#28a745");
                var idx = $scope.user_notif.indexOf(mpl.impacted_local);
                if (idx && idx < 0) {
                    $scope.user_notif.push(mpl.impacted_local);
                }
            } else {
                $('#' + id).attr("class", "fa fa-square");
                $('#' + id).css("color", "#ffffff");
                $('#' + id).css("border", "2px solid rgb(160, 158, 158)");
                for (var item in $scope.user_notif) {
                    if ($scope.user_notif[item] == mpl.impacted_local) {
                        $scope.user_notif.splice(item, 1);
                    }
                }
            }
            if ($scope.user_notif && $scope.impacts_local) {
                if ($scope.user_notif.length == $scope.impacts_local.length) {
                    $scope.check_all = true;
                    $scope.text_check = "Tout décocher";
                }
            }
        } else {
            //$('#check_all').click();
            if ($scope.check_all) {
                $scope.text_check = "Tout décocher";
                for (var item in $scope.impacts_local) {
                    if (!$scope.user_notif) {
                        $scope.user_notif = [];
                    }
                    var id = "active_notfi_for" + $scope.impacts_local[item].id;
                    $('#' + id).attr("class", "fa fa-check");
                    $('#' + id).css("color", "#28a745");
                    $('#' + id).css("border", "#28a745");
                    $scope.user_notif.push($scope.impacts_local[item].impacted_local);
                }
            } else {
                $scope.text_check = "Tout cocher";
                for (var item in $scope.impacts_local) {
                    $scope.user_notif = [];
                    var id = "active_notfi_for" + $scope.impacts_local[item].id;
                    $('#' + id).attr("class", "fa fa-square");
                    $('#' + id).css("color", "#ffffff");
                    $('#' + id).css("border", "2px solid rgb(160, 158, 158)");
                }
            }
        }
    };
    $scope.getUserConnected = function () {
        $http({method: 'GET', url: BASE_URL + "api/UserMep/userApp", params: {ldap: CONNECTED}}).then(function (response) {
            if (response.data && response.data.length > 0) {
                $scope.user_connected = response.data[0];
                var dt = response.data[0];
                var isexist = dt && dt.access.trim() == 'admin';
                if (!isexist) {
                    document.location.href = BASE_URL;
                }
            }
        }, function (error) {
            console.log(error);
            if (error.status == "Not connected") {
                document.location.href = BASE_URL;
            }
        });
    };
    $scope.editUser = function (user) {
        $scope.user_notif = []
        if (user) {
            var userChecked = {idSelect: user.id}
            var url = BASE_URL + "api/UserMep/interim";
            $http({
                method: 'GET',
                url: url,
                params: userChecked
            }).then(function (response) {
                $scope.interim = response.data;
            }, function error(response) {
                console.log(response);
            });
            $scope.user = user;
            if (user.secret) {
                $scope.user.compte = 'local';
            } else {
                $scope.user.compte = 'ldap';
            }
            if (user.notif_for_impact_local) {
                var notif_for_impact_local = user.notif_for_impact_local.split(",");
                for (var i in notif_for_impact_local) {
                    var filtered = $scope.impacts_local.filter(function (item) {
                        return item.impacted_local == notif_for_impact_local[i];
                    });
                    if (filtered && filtered.length > 0) {
                        for (var k in filtered) {
                            var id = "active_notfi_for" + filtered[k].id;
                            $('#' + id).attr("class", "fa fa-check");
                            $('#' + id).css("color", "#28a745");
                            $('#' + id).css("border", "#28a745");
                            $scope.user_notif.push(filtered[k].impacted_local);
                        }
                    }
                }
            }
            $('#compte').attr('disabled', 'disabled');
            $('#modalUser').iziModal('setTitle', "Détail utilisateur: " + user.ldap);
            $('#modalUser').iziModal('setSubtitle', "Mis à jour utilisateur");
            $('#modalUser').iziModal('open');
        } else {
            $('#compte').removeAttr('disabled');
            $scope.user = {};
            $scope.interim = $scope.users;
            $scope.user.compte = 'ldap';
            $('#modalUser').iziModal('setTitle', "Ajouter un utilisateur");
            $('#modalUser').iziModal('setSubtitle', "Nouvel utilisateur");
            $('#modalUser').iziModal('open');
        }
    };


    $scope.saveUser = function () {
        $scope.error_pass = null;
        if ($scope.user) {
            var closeModal = true;
            let error = null;
            if (!$scope.user.id) {
                if ($scope.user.pass && $scope.user.pass1) {
                    let verifyPass = $scope.user.pass.trim() === $scope.user.pass1.trim();
                    if (verifyPass === true) {
                        $scope.user.secret = $scope.user.pass;
                        $scope.user.to_encrypt = true;
                    } else {
                        error = "Vos mots de passe ne correspondent pas";
                    }
                }
            } else {
                if ($scope.user.new_pass && $scope.user.new_pass1) {
                    let verifyPass = $scope.user.new_pass.trim() === $scope.user.new_pass1.trim();
                    if (verifyPass === true) {
                        $scope.user.secret = $scope.user.new_pass;
                        $scope.user.to_encrypt = true;
                    } else {
                        error = "Vos mots de passe ne correspondent pas";
                    }
                }
            }
            if (error !== null) {
                $scope.error_pass = error;
            } else {
                if ($scope.user_notif) {
                    $('#closepopover').click();
                    $scope.user.notif_for_impact_local = $scope.user_notif.join();
                } else {

                }
                $http.put(BASE_URL + "api/UserMep/usermep/", $scope.user).then(function (response) {
                    if (response.data) {
                        if (response.data.error) {
                            $scope.error_pass = response.data.error_message;
                        } else {
                            if (closeModal === true) {
                                $scope.error_new_item = null;
                                $('#modalUser').iziModal('close');
                                $scope.get();
                                delayToasts("success", "Enregistrement effectué");
                            }
                        }
                    }
                }, function (error) {
                    if (error.status && error.status === "Not connected") {
                        document.location.href = BASE_URL;
                    }
                });
            }


        }
    };

    $scope.confirmActionU = function () {
        $http.delete(BASE_URL + "api/UserMep/usermep/" + $scope.temp_u.id).then(function (response) {
            if (response.data) {
                $('#messageAlertM').iziModal('close');
                $scope.get();
                delayToasts("success", "Utilisateur supprimé");
            }
        }, function (error) {
            if (error.status && error.status === "Not connected") {
                document.location.href = BASE_URL;
            }
        });
    };
    $scope.deleteUser = function (user) {
        $scope.temp_u = user;
        $scope.color = "#ff8a65";
        $('#icon-btn-con').attr("class", "fa fa-trash");
        $('#icon_msg_alert').attr("class", "fa fa-trash").css("color", $scope.color);
        $('#btn-conf').attr("class", "btn btn-danger").css("background", $scope.color);
        $('#btn-text').text("Supprimer");
        $('#messageAlertM').iziModal('setHeaderColor', '#ff8a65');
        $('#text-head').css("color", $scope.color);
        $('#messageAlertM').iziModal('setTitle', "Suppression utilisateur");
        $('#messageContentM').html("L'utilisateur " + user.ldap + " sera supprimé").css("color", $scope.color);
        $('#messageAlertM').iziModal('open');
    };
    $scope.cancel = function () {
        $scope.user_notif = [];
        $('#closepopover').click();
        $scope.get();
    };
    $scope.get();
});
