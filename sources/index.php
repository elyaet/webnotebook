<!DOCTYPE html>
<html ng-app="webNotebookApp">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/textAngular.css">
    <link rel="stylesheet" href="css/webNotebook.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-sanitize.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular-sanitize.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular.min.js'></script>
    <script src='js/ui-bootstrap-custom-0.12.1.min.js'></script>
    <script src='js/ui-bootstrap-custom-tpls-0.12.1.min.js'></script>
</head>

<body>

<div ng-controller="webNotebookCtrl" class="container-fluid">

    <!-- top navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li ng-repeat="(key, data) in json.data" ng-class="{'active': key==currentNb}"><a
                                ng-href="#{{key}}" name="{{key}}">{{key}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-offcanvas row-offcanvas-left">

        <!-- sidebar -->
        <div class="col-lg-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <p>
                <button type="button" class="btn btn-sm btn-default glyphicon glyphicon-chevron-left"
                        ng-click="currentDay.setDate(currentDay.getDate()-1)"></button>
                <button type="button" class="btn btn-sm btn-info" ng-click="today()">Today
                </button>
                <button type="button" class="btn btn-sm btn-default glyphicon glyphicon-chevron-right"
                        ng-click="currentDay.setDate(currentDay.getDate()+1)"></button>
            </p>
            <div style="display:inline-block; min-height:290px;" class="text-center">
                <datepicker ng-model="currentDay" min-date="minDate" show-weeks="false"
                            class="well well-sm"></datepicker>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for..." ng-model="searchInput"
                       ng-change="searchChange()"/>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
            <p ng-repeat="(key, value) in searchResults">
                <button type="button" class="btn btn-sm btn-default" ng-click="searchDisplay(key)">{{key}} - {{value}}
                </button>
            </p>
        </div>

        <!-- main area -->
        <div class="col-lg-9" data-spy="scroll" data-target="#sidebar-nav">
            <div ng-show="loading" class="loading">LOADING...</div>
            <div text-angular="text-angular"
                 ng-model="json.data[currentNb][currentDay.getFullYear()][currentDay.getMonth()+1][currentDay.getDate()]"
                 ta-disabled='disabled' ng-change="currentContentChange()"></div>
            <div>
            </div>
        </div>
    </div>
    <div id="footer"><!--footer-->
        <div class="container">
            <div class="row">
                <ul class="list-unstyled">
                    <li class="col-sm-4 col-xs-6">
                        <a href="mailto:elyaet@gmail.com">Contact</a>
                    </li>
                    <li class="col-sm-4 col-xs-6">
                        <a href="https://github.com/elyaet/webnotebook">GitHub</a>
                    </li>
                </ul>
            </div>
            <!--/row-->

        </div>
        <!--/container-->
    </div>
    <!--/footer-->
</div>
<script type="text/javascript" src="js/webNotebook.js"></script>
<script type="text/javascript" src="js/webNotebookCtrl.js"></script>

</body>
</html>