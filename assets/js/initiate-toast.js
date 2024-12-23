/*
* Workday - A time clock application for employees
* URL: https://codecanyon.net/item/workday-a-time-clock-application-for-employees/23076255
* Support: official.codefactor@gmail.com
* Version: 7.0
* Author: Brian Luna
* Copyright 2023 Codefactor
*/
(function() {
    'use strict';
    
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));

    var toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl);
    });

    toastList.forEach(toast => toast.show()); 

})();