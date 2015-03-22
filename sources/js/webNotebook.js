var app = angular.module("webNotebookApp", ['textAngular']);

$(document).ready(function(){  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
});
});