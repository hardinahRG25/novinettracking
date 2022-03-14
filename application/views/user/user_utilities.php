<style>
    .my-input {
        margin-bottom: 1em !important;
        border: 1px #aaa solid !important;
        border-radius: 5px !important;
    }

    /*  Basic styling for demo */


    .crud_style {
        font-weight: 700;
        font-family: sans-serif;
        display: flex;
        align-items: center;
        cursor: pointer;
    }


    /* Hide elements visually, but not for screenreaders by clipping it */

    .vh {
        position: absolute !important;
        clip: rect(1px, 1px, 1px, 1px);
        padding: 0 !important;
        border: 0 !important;
        height: 1px !important;
        width: 1px !important;
        overflow: hidden;
    }

    /*  Add a :before to each label and style this as the checkbox you want to have */

    .crud_style:before {
        content: '';
        width: 20px;
        height: 20px;
        background: #f2f2f2;
        border: 1px solid rgba(75, 101, 132, 0.3);
        display: inline-block;
        margin-right: 16px;
    }


    input[type="checkbox"]:checked~.crud_style:before {
        background: #20bf6b no-repeat center;
        background-size: 12px 12px;
        background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDQ1LjcwMSA0NS43IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NS43MDEgNDUuNzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0yMC42ODcsMzguMzMyYy0yLjA3MiwyLjA3Mi01LjQzNCwyLjA3Mi03LjUwNSwwTDEuNTU0LDI2LjcwNGMtMi4wNzItMi4wNzEtMi4wNzItNS40MzMsMC03LjUwNCAgICBjMi4wNzEtMi4wNzIsNS40MzMtMi4wNzIsNy41MDUsMGw2LjkyOCw2LjkyN2MwLjUyMywwLjUyMiwxLjM3MiwwLjUyMiwxLjg5NiwwTDM2LjY0Miw3LjM2OGMyLjA3MS0yLjA3Miw1LjQzMy0yLjA3Miw3LjUwNSwwICAgIGMwLjk5NSwwLjk5NSwxLjU1NCwyLjM0NSwxLjU1NCwzLjc1MmMwLDEuNDA3LTAuNTU5LDIuNzU3LTEuNTU0LDMuNzUyTDIwLjY4NywzOC4zMzJ6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
    }

    input[type="checkbox"]:focus~.crud_style {
        color: #20bf6b;
    }

    .switch {
        position: relative;
        height: 26px;
        width: 120px;
        margin: 20px auto;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 3px;
        -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    }

    .switch-label {
        position: relative;
        z-index: 2;
        float: left;
        width: 58px;
        line-height: 26px;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.35);
        text-align: center;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
        cursor: pointer;
    }

    .switch-label:active {
        font-weight: bold;
    }

    .switch-label-off {
        padding-left: 2px;
    }

    .switch-label-on {
        padding-right: 2px;
    }


    .switch-input {
        display: none;
    }

    .switch-input:checked+.switch-label {
        font-weight: bold;
        color: rgba(0, 0, 0, 0.65);
        text-shadow: 0 1px rgba(255, 255, 255, 0.25);
        -webkit-transition: 0.15s ease-out;
        -moz-transition: 0.15s ease-out;
        -ms-transition: 0.15s ease-out;
        -o-transition: 0.15s ease-out;
        transition: 0.15s ease-out;
        -webkit-transition-property: color, text-shadow;
        -moz-transition-property: color, text-shadow;
        -ms-transition-property: color, text-shadow;
        -o-transition-property: color, text-shadow;
        transition-property: color, text-shadow;
    }

    .switch-input:checked+.switch-label-on~.switch-selection {
        left: 60px;
        /* Note: left: 50%; doesn't transition in WebKit */
    }

    .switch-selection {
        position: absolute;
        z-index: 1;
        top: 2px;
        left: 2px;
        display: block;
        width: 58px;
        height: 22px;
        border-radius: 3px;
        background-color: #65bd63;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #9dd993), color-stop(100%, #65bd63));
        background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
        background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
        background-image: -ms-linear-gradient(top, #9dd993, #65bd63);
        background-image: -o-linear-gradient(top, #9dd993, #65bd63);
        background-image: linear-gradient(top, #9dd993, #65bd63);
        -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
        -webkit-transition: left 0.15s ease-out;
        -moz-transition: left 0.15s ease-out;
        -ms-transition: left 0.15s ease-out;
        -o-transition: left 0.15s ease-out;
        transition: left 0.15s ease-out;
    }
</style>
<div class="flexrow" id="user_container" ng-controller="userManagement" ng-cloak>
    <div class="flexcol card" id="card" style="border-top: 2px solid #ff9955!important;">
        <h5 class="text text-center" style="padding: 0px 10px;">
            <i class="fa fa-user"></i> Liste collaborateur
        </h5>
        <div class="card-body otherView" style="padding-top: 10px;background: #fff;overflow: auto">
            <div class="row flex">
                <button type="button" data-placement="top" data-toggle="modal" title="Add User" class="btn btn-info" data-title="Add" ng-click="editUser()"><i class="fa fa-plus"></i>
                    Ajouter
                </button>
                <div style="flex: 0.5"></div>
                <input type="search" name="search" class="form form-control" id="search1" ng-model="userfilter" placeholder="Recherche par mot clé..." style="font-size: 12px;flex: 0.5;" />
            </div>
            <div class="table-responsive" style="width:100%;padding-top: 10px;height: max-content">
                <table id="example" class="table table-hover  table-bordred table-striped" style="justify-content: center;align-items: center;width: 100%;color: #000;height: max-content">
                    <thead>
                        <th><i class="fa fa-user"></i> Nom d'utilisateur</th>
                        <th>Nom</th>
                        <th><i class="fa fa-at"></i> Email</th>
                        <th><i class="fa fa-phone"></i> Téléphone</th>
                    <tbody ng-if="users && users.length != 0">
                        <tr class="tr_hover" ng-repeat="user in users| filter:userfilter" ng-click="editUser(user)">
                            <td>
                                {{user.ldap}}
                            </td>
                            <td>
                                {{user.name}} {{user.first_name}}
                            </td>
                            <td>
                                {{user.mail}}
                            </td>
                            <td>
                                {{user.tel}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modalUser" data-iziModal-fullscreen="true" data-iziModal-icon="fa fa-edit">
        <div class="row" style="width: 100%">
            <form ng-submit="saveUser()" style="width: 100%">
                <div class="form-group row" style="display:none">
                    <label class="col-sm-3 col-form-label text-muted">Compte: </label>
                    <div class="col-sm-9">
                        <select name="compte" ng-model="user.compte" id="compte" class="form-control my-input">
                            <option value="local">Local</option>
                            <option value="ldap">LDAP</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-muted">Nom d'utilisateur: <span style="color: red">*</span></label>
                    <div class="col-sm-9">
                        <input class="form-control my-input" type="text" name="ldap" id="ldap" ng-model="user.ldap" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-muted">Nom: <span style="color: red">*</span></label>
                    <div class="col-sm-9">
                        <input class="form-control my-input" type="text" name="name" id="name" ng-model="user.name" minlength="3" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-muted">Prénom: </label>
                    <div class="col-sm-9">
                        <input class="form-control my-input" type="text" name="first_name" id="first_name" ng-model="user.first_name">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-muted">Email: <span style="color: red">*</span></label>
                    <div class="col-sm-9">
                        <input class="form-control my-input" type="email" name="mail" id="mail" ng-model="user.mail" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-muted">Tél: </label>
                    <div class="col-sm-9">
                        <input class="form-control my-input" type="tel" name="tel" id="tel" ng-model="user.tel">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-muted">Rôle: <span style="color: red">*</span></label>
                    <div class="col-sm-9">
                        <select name="access" ng-model="user.access" id="user.access" class="form-control my-input">
                            <option value="admin">Administrateur</option>
                            <option value="actor">Collaborateur</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div ng-if="!user.id">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-muted">Mot de passe: </label>
                            <div class="col-sm-9">
                                <input class="form-control my-input" type="password" name="pass" id="pass" ng-model="$parent.user.pass" pattern="(?=^.{4,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Majuscule,Miniscule,Chiffre/Charactères sperciaus, longueur>=4" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-muted">Confirmer votre mot de passe: </label>
                            <div class="col-sm-9">
                                <input class="form-control my-input" type="password" name="pass1" id="pass1" ng-model="$parent.user.pass1">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-muted"></label>
                        <div class="col-sm-9">
                            <div class="form-check" style="margin-bottom: 20px;" ng-if="user && user.id">
                                <input type="checkbox" class="form-check-input" id="show_new_pass" ng-model="$parent.show_new_pass">
                                <label class="form-check-label" for="show_new_pass" style="color: #343a40;cursor: pointer" ng-click="$('#show_new_pass').click()">Créer un nouveau mot de passe</label>
                            </div>
                        </div>
                    </div>


                    <div ng-if="user.id && show_new_pass">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-muted">Nouveau mot de passe: </label>
                            <div class="col-sm-9">
                                <input class="form-control my-input" type="password" pattern="(?=^.{4,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Majuscule,Miniscule,Chiffre/Charactères sperciaus, longueur>=4" name="new_pass" id="new_pass" ng-model="$parent.user.new_pass">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-muted">Confirmer mot de
                                passe: </label>
                            <div class="col-sm-9">
                                <input class="form-control my-input" type="password" name="new_pass1" id="new_pass1" ng-model="$parent.user.new_pass1">
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger alert-heading alert-dismissable" ng-if="error_pass" style="padding-top: 5px;padding-bottom: 5px;">
                        <article style="font-size: 12px;">{{error_pass}}</article>
                    </div>
                </div>

                <footer style="display: flex">
                    <button type="button" data-iziModal-close class="btn btn-outline-danger" ng-click="deleteUser(user)" ng-if="user && user.id" style="border-radius: 0px"><i class="fa fa-trash"></i> Supprimer
                    </button>
                    <button type="button" data-iziModal-close class="btn btn-outline-dark" ng-click="cancel()" style="border-radius: 0px;margin-left: 5px"><i class="fa fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-outline-success" style="border-radius: 0px;margin-left: auto;margin-right: 5px;"><i class="fa fa-check"></i> Enregistrer
                    </button>
                </footer>
            </form>
            <div id="myPopover1a" class="popover popover-x popover-primary" style="z-index:6">
                <div class="arrow"></div>
                <h3 class="popover-header popover-title" style="background-color: #17a2b8!important;color:#FFF!important"><span class="close pull-right" id="closepopover" data-dismiss="popover-x">&times;</span><i class="fa fa-bell"></i>&nbsp;&nbsp;A notifier pour le MEP: &nbsp;&nbsp;</h3>
                <div class="popover-body popover-content" style="max-height: 200px;overflow: auto">
                    <div class="form-check" style="margin-bottom: 5px;">
                        <input type="checkbox" class="form-check-input" id="check_all" ng-model="check_all" ng-change="activeCheckFor()">
                        <label class="form-check-label" for="check_all" style="color: #343a40;cursor: pointer">{{text_check}}</label>
                    </div>
                    <table border="0" class="table table-hover" style="border: none">
                        <tbody>
                            <tr ng-repeat="mpl in impacts_local" ng-click="activeCheckFor(mpl)">
                                <td style="border-top: 0px!important;padding: 0.3em"><i class="fa fa-square" id="active_notfi_for{{mpl.id}}" style="border: 2px solid rgb(160, 158, 158);color:#ffffff"></i>&nbsp;&nbsp;{{mpl.impacted_local}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="messageAlertM" class="modaly" style="font-size: 12px;" data-iziModal-icon="fa fa-info">
        <form ng-submit="confirmActionU()">
            <br>
            <br>
            <div class="row" style="padding:0px;justify-content: center;align-content: center;">
                <i id="icon_msg_alert" style="font-size: 5em"></i>
            </div>
            <br>
            <div class="row" style="padding:0px;justify-content: center;align-content: center;">
                <p style="text-align: center">
                <h4 class="text text-center" id="text-head" style="font-size: 22px;text-align:center!important">Voulez-vous
                    continuer?</h4>
                </p>
            </div>
            <div class="row" style="padding: 5px 0px;justify-content: center;align-content: center;">
                <p style="text-align: center">
                <h4 class="text text-center" id="messageContentM" style="text-align:center!important">{{$scope.message}}</h4>
                </p>
            </div>
            <br>
            <footer style="padding-right:0px;margin-top: 5px;font-size: 12px;">
                <div class="row" style="justify-content: center;align-content: center;">
                    <button id="btn-conf" style="font-size:18px; border-radius:100px;width:70%;border:none!important;padding:5px;"><i class="fa fa-check" id="icon-btn-con"></i> <span id="btn-text">Continuer</span></button>
                </div>
                <div class="row" style="justify-content: center;align-content: center;width: 100%">
                    <hr style="width: 150px;margin: 0px;margin-top: 15px;align-self: center">
                </div>
                <div class="row" style="justify-content: center;align-content: center">
                    <a href="javascript:void(0)" class="text text-warning" data-izimodal-close="" style="text-decoration: none;font-size:18px; border-radius:100px;border:none!important;padding:5px;text-align: center"><i class="fa fa-times"></i> Annuler</a>
                </div>
            </footer>
            <br>
        </form>
    </div>
</div>

<style>
    td {
        color: inherit;
    }

    .tr_hover:hover {
        background: #17a2b8 !important;
        color: #FFF !important;
        font-weight: 600;
    }

    .iziModal.isFullscreen {
        height: max-content !important;
    }
</style>