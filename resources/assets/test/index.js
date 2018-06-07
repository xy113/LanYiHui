const Test = require('./class');

let showMsg = (msg)=>{
    alert(msg)
};

fetch('http://cugeng.cn').then(response=>{
    console.log(response);
});
