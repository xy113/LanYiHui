'use strict';

var Test = require('./class');

var showMsg = function showMsg(msg) {
    alert(msg);
};

fetch('http://cugeng.cn').then(function (response) {
    console.log(response);
});
