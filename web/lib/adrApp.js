/**
 * Test work Andrey Khramov
 */

var adrApp = angular.module("adrApp", ['ui.bootstrap'])
               
.controller("AddressListCtrl", function($scope, $http){
    $scope.data = [];
    $scope.config = new Object();
    $scope.currentPage = 1;
    $scope.maxSize = 10;
    $scope.totalItems = 0;

    $scope.refreshButton = function() {
        init_default();
        load();
    }
    
    //  установка значения поля сортировки и ее направления
    $scope.sortBy = function(index) {
        //  меняем направление сортировки
        if ($scope.config.sortby == index) {
            if ($scope.config.sort == 'asc')
                $scope.config.sort = 'desc'
            else
                $scope.config.sort = 'asc';
        }
        //  меняем поле сортировки
        else {
            $scope.config.sortby = index;
            $scope.config.sort = 'asc';
        }
            
        load();
    }
    // функция проверяет - показывать ли иконку сортировки для столбца таблицы
    $scope.showIcon = function(index) {
        var show = index == $scope.config.sortby;
        return show ? 'true':'false';
    }
    // функция устанавливает класс для элемента с иконкой сортировки в зависимости от направления сортировки
    $scope.setClass = function() {
        return 'glyphicon glyphicon-sort-by-attributes' + ($scope.config.sort == 'desc' ? "-alt": "");
    }
    // функция устанавливает синий цвет для данных, по которым идет фильтрация или сортировка
    $scope.setStyle = function(param){
        return param ? "color:blue": "color:black";
    }
    // функция вызывается при смене значений в полях фильтра
    $scope.change = function() {
        if ($scope.filterForm.$valid) {
            load();
        }
    };
    
    //  функция инициализации параметров фильтра по умолчанию
    init_default = function() {
        $scope.config.f_country   = '',
        $scope.config.f_city      = '',
        $scope.config.f_street    = '',
        $scope.config.f_home_min  = 1,
        $scope.config.f_home_max  = 99,
        $scope.config.f_zipcode   = '',
        $scope.config.f_date      = '',
        
        $scope.config.sortby      = '',
        $scope.config.sort        = 'asc',
        
        $scope.config.page        = 1
    }
    
    //  функция загрузка данных с API
    load = function() {
        $http.get('/addresses.json', {params:$scope.config}).then(function(response){            
            $scope.data = response.data;
            $scope.totalItems = $scope.data.all;
            //  $scope.currentPage = $scope.data.current_page;
        });
    }
    
    // функция следит за значением номера текущей страницы для выполнения пагинации
    $scope.$watch('currentPage', function() {   
        $scope.config.page = $scope.currentPage;
        load();
    });
    
    init_default();
    load();
});