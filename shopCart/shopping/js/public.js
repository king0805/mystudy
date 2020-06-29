//
//删除cookie
function removeCookie(cKey) {
    setCookie(cKey, 1, -1)
}
//获取coolie
function getCookie(cKey) {
    let tempArr = document.cookie.split('; ');
    for (let i = 0; i < tempArr.length; i++) {
        let temp = tempArr[i].split('=');
        if (temp[0] == cKey) {
            return temp[1]
        }
    }
    return '';
};
//设置cookie
function setCookie(cKey, cVal, cDay) {
    let d = new Date();
    d.setDate(d.getDate() + cDay);
    document.cookie = `${cKey}=${cVal};expires=${d.toUTCString()}`;
};
//get回调异步请求
function get(url, params, callback) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            let res = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
                callback(res);
            } else {
                console.log(xhr.status);
            }

        }
    }
    xhr.open('get', `${url}?${params}`);
    xhr.send(null);
};
//post回调异步请求
function post(url, params, callback) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            let res = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
                callback(res);
            } else {
                console.log(xhr.status);
            }
        }
    }
    xhr.open('post', `${url}`);
    xhr.send(`${params}`);
};
//事件防抖
function fangDou(fn, delay) {
    let timer;
    clearTimeout(timer);
    timer = setTimeout(() => {
        fn()
    }, delay);
};
//事件节流
function jieLiu(fn, delay) {
    let timer;
    if (timer) return;
    timer = setTimeout(() => {
        fn();
        clearTimeout(timer);
    }, delay);
};
//范围随机数
function random(min, max) {
    if (min > max) {
        var ls = min;
        min = max;
        max = ls;
    };
    return Math.floor(Math.random() * (max - min + 1)) + min;
};
//字符和数值补零
function addZero(n) {
    if (typeof (n) === "string") {
        if (n.length < 2) {
            return "0" + n;
        }
        return n;
    } else {
        if (n < 10) {
            return "0" + n;
        }
        return n;
    };
};
//取最大值
function getMax(max) {
    max = max.slice(0);
    max.sort(function (a, b) {
        return b - a
    });
    return max[0];
};
//取最小值
function getMin(min) {
    min = min.slice(0);
    min.sort(function (a, b) {
        return a - b
    });
    return min[0];
};
//数组去重
function arrRemoval(arr) {
    var newArr = [];
    for (var i = 0; i < arr.length; i++) {
        if (arr.indexOf(arr[i]) == i) {
            newArr.push(arr[i]);
        }
    }
    return newArr;
};
//日期格式化
function formatDate() {
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth() + 1;
    var date = d.getDate();
    var day = d.getDay();
    var hour = d.getHours();
    var minute = d.getMinutes();
    var second = d.getSeconds();
    var millsecond = d.getMilliseconds();
    switch (day) {
        case 0:
            day = "日";
            break;
        case 1:
            day = "一";
            break;
        case 2:
            day = "二";
            break;
        case 3:
            day = "三";
            break;
        case 4:
            day = "四";
            break;
        case 5:
            day = "五";
            break;
        case 6:
            day = "六";
            break;
    };
    return {
        year: year,
        month: addZero(month),
        date: addZero(date),
        day: day,
        hour: addZero(hour),
        minute: addZero(minute),
        second: addZero(second),
        millsecond: millsecond,
    };
};
//随机十六进制颜色值
function randomColor(r, g, b) {
    var r = random(0, 225).toString(16);
    var g = random(0, 255).toString(16);
    var b = random(0, 255).toString(16);
    return "#" + addZero(r) + addZero(g) + addZero(b);
};

//获取样式的兼容处理
function getStyle(ele, attr) {
    if (ele.currentStyle) {
        return ele.currentStyle[attr];
    } else {
        return ele.getComputedStyle(ele, false)[attr];
    };
};

//取消事件冒泡
function stopBubble(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    } else {
        e.cancelBubble = true;
    }
};