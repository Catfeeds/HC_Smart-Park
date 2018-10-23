var dom = document.getElementById("index-pie");
var myChart = echarts.init(dom);
var app = {};
option = null;
option = {
    color:['#0071c4','#93d6fc','#5bbaf0', '#b7d4e4', '#3ba2dc'],
    title : {
        text: '二期房源分布图',
        textStyle: {
            color: '#667690',
            fontSize:22,
            fontWeight: 500,
        },
        padding: 5,
        left: 10,
        top: 10,
        subtext: '',
        x:'left'
    },
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    toolbox: {
        show: true,
        right: 30,
        top: 20,
        feature:{
            saveAsImage:{}
        }
    },
    legend: {
        orient: 'vertical',
        right: 80,
        top: 110,
        itemGap: 38,
        data: ['已租','未租','已售出','已预订','房自留']
    },
    series: [
        //内层饼状图
        {
            name:'二期房源分布图1',
            type:'pie',
            selectedMode: 'single',
            radius: [0, '30%'],

            label: {
                normal: {
                    position: 'inner'
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:[
                {value:42, name:'已租'},
                {value:123, name:'未租'},
                {value:12, name:'已售出'},
                {value:8, name:'已预订'},
                {value:46, name:'房自留'}
            ]
        },
        //外层饼状图
        {
            name:'二期房源分布图2',
            type:'pie',
            radius: ['40%', '55%'],
            label: {
                normal: {
                    formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                    backgroundColor: '#eee',
                    borderColor: '#aaa',
                    borderWidth: 1,
                    borderRadius: 4,
                    rich: {
                        a: {
                            color: '#999',
                            lineHeight: 22,
                            align: 'center'
                        },
                        hr: {
                            borderColor: '#aaa',
                            width: '100%',
                            borderWidth: 0.5,
                            height: 0
                        },
                        b: {
                            fontSize: 16,
                            lineHeight: 33
                        },
                        per: {
                            color: '#eee',
                            backgroundColor: '#334455',
                            padding: [2, 4],
                            borderRadius: 2
                        }
                    }
                }
            },
            data:[
                {value:42, name:'已租'},
                {value:123, name:'未租'},
                {value:12, name:'已售出'},
                {value:12, name:'已预订'},
                {value:46, name:'房自留'}
            ]
        }
    ]
};
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}

// echarts表单异步获取数据
$.get('/api/charts.index/room_status').done(function (data) {
    //填入数据
    myChart.setOption({
        series: [{
            name: '二期房源分布图1',
            data: data
        },{
            name: '二期房源分布图2',
            data: data
        }]
    });
});






// 折线图
// 每月出租房源趋势图
var dom1 = document.getElementById("index-line-room");
var myChart1 = echarts.init(dom1);
var app = {};
option1 = null;
option1 = {
    title : {
        text: '每月出租房源趋势图',
        textStyle: {
            color: '#667690',
            fontSize:22,
            fontWeight: 500,
        },
        padding: 5,
        left: 10,
        top: 10,
        subtext: '',
        x:'left'
    },
    toolbox: {
        show: true,
        right: 30,
        feature:{
            saveAsImage:{}
        }
    },
    color:['#0071c4','#93d6fc','#5bbaf0', '#b7d4e4', '#3ba2dc'],
    xAxis: {
        type: 'category',
        data: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
    },
    yAxis: {
        type: 'value'
    },
    series: [{
        data: [8, 2, 3, 5, 5, 1, 7, 22, 3, 6, 12, 6],
        type: 'line'
    }]
};
;
if (option1 && typeof option1 === "object") {
    myChart1.setOption(option1, true);
}
$.get('/api/charts.index/room_month_status').done(function (data) {
    //填入数据
    myChart1.setOption({
        series: [{
            data: data.data
        }]
    });
});





// 每月企业入驻数据
var dom2 = document.getElementById("index-line-enterprise");
var myChart2 = echarts.init(dom2);
var app = {};
option2 = null;
option2 = {
    title : {
        text: '每月企业入驻数据',
        textStyle: {
            color: '#667690',
            fontSize:22,
            fontWeight: 500,
        },
        padding: 5,
        left: 10,
        top: 10,
        subtext: '',
        x:'left'
    },
    toolbox: {
        show: true,
        right: 30,
        feature:{
            saveAsImage:{}
        }
    },
    color:['#0071c4','#93d6fc','#5bbaf0', '#b7d4e4', '#3ba2dc'],
    xAxis: {
        type: 'category',
        data: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
    },
    yAxis: {
        type: 'value'
    },
    series: [{
        data: [0, 12, 3,7, 5, 7, 7, 12, 5, 6, 8, 6],
        type: 'line'
    }]
};
;
if (option2 && typeof option2 === "object") {
    myChart2.setOption(option2, true);
}
$.get('/api/charts.index/enterprise_entry_month').done(function (data) {
    //填入数据
    myChart2.setOption({
        series: [{
            data: data.data
        }]
    });
});




//注册用户数
var dom3 = document.getElementById("index-line-user");
var myChart3 = echarts.init(dom3);
var app = {};
option3 = null;
option3 = {
    title: {
        text: '每月注册用户',
        textStyle: {
            color: '#667690',
            fontSize:22,
            fontWeight: 500,
        },
        padding: 5,
        left: 10,
        top: 10,
        subtext: '',
        x:'left',
    },
    tooltip: {
        trigger: 'axis'
    },
    legend: {
        orient: 'vertical',
        right: 0,
        top: 80,
        itemGap: 38,
        data:['注册用户']
    },
    toolbox: {
        show: true,
        right: 30,
        feature: {
            saveAsImage: {}
        }
    },
    color:['#0071c4','#93d6fc','#5bbaf0', '#b7d4e4', '#3ba2dc'],
    xAxis:  {
        type: 'category',
        boundaryGap: false,
        data: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name:'注册用户',
            type:'line',
            data:[11, 15, 13, 12, 13, 10, 11, 15, 13, 12, 13, 10],
        },
    ]
};
if (option3 && typeof option3 === "object") {
    myChart3.setOption(option3, true);
}
$.get('/api/charts.index/user_month').done(function (data) {
    //填入数据
    myChart3.setOption({
        series: [{
            data: data.data
        }]
    });
});



//各楼层入驻情况
var dom4 = document.getElementById("index-line-floor");
var myChart4 = echarts.init(dom4);
var app = {};
option4 = null;
option4 = {
    color:['#0071c4','#93d6fc','#5bbaf0', '#b7d4e4', '#3ba2dc'],
    title: {
        text: '各楼层入驻情况',
        textStyle: {
            color: '#667690',
            fontSize:22,
            fontWeight: 500,
        },
        padding: 5,
        left: 10,
        top: 10,
        subtext: '',
        x:'left',
    },
    toolbox: {
        show: true,
        right: 30,
        feature: {
            saveAsImage: {}
        }
    },
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : ['一楼', '二楼', '三楼', '四楼', '五楼', '六楼', '七楼', '八楼', '九楼', '十楼', '十一楼', '十二楼', '十三楼', '十四楼', '十五楼', '十六楼', '十七楼', '十八楼', '十九楼', '二十楼', '二十一楼', '二十二楼', '二十三楼'],
            axisTick: {
                alignWithLabel: true
            }
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'直接访问',
            type:'bar',
            barWidth: '60%',
            data:[0, 0 , 0, 0, 10, 8, 5, 3, 3, 6, 5, 2, 4 ,6 ,5, 5,2,1,3,5,1,2,3]
        }
    ]
};
;
if (option4 && typeof option4 === "object") {
    myChart4.setOption(option4, true);
}
$.get('/api/charts.index/one_floor_entry').done(function (data) {
    //填入数据
    myChart4.setOption({
        series: [{
            data: data.data
        }]
    });
});
