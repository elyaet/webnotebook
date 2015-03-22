var app = angular.module("webNotebookApp", ['ui.bootstrap', 'textAngular']);

$(document).ready(function(){  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
});
});