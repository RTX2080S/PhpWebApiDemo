
var sending = false;
var app = angular.module("ngApp", []);

app.service('isLoadingService', function () {
    this.BeginSending = function (btnSelector) {
        $(btnSelector).isLoading();
    };
    this.FinishSending = function (btnSelector) {
        $(btnSelector).isLoading('hide');
    };
});

app.service('notificationService', function () {
    this.notify = function (response) {
        if (response.data === '1')
            $('#actionSection').html('<h3><span class="label label-success">Success! Your notes have been sent! </span></h3>');
        else
            $('#actionSection').html('<h3><span class="label label-warning">Please check your input! </span></h3>');
    };
    this.showError = function () {
        $('#actionSection').html('<h3><span class="label label-error">Server error, please try later! </span></h3>');
    };
});

app.controller("contactCtrl", function ($scope, $http, isLoadingService, notificationService) {
    $scope.sending = false;
    $scope.user = {
        name: '',
        phone: '',
        email: '',
        comment: ''
    };
    $scope.Submit = function () {
        $scope.sending = true;
        isLoadingService.BeginSending('#btnSubmit');
        $http({
            method: 'POST',
            url: 'contactUs/Controllers/NotesController.php',
            data: { action: 'leaveNote', content: $scope.user }
        }).then(function successCallback(response) {
            notificationService.notify(response);
            isLoadingService.FinishSending('#btnSubmit');
            $scope.sending = false;
        }, function errorCallback(response) {
            notificationService.showError();
            isLoadingService.FinishSending('#btnSubmit');
            $scope.sending = false;
        });
    };
});
