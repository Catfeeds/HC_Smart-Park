var dom = document.getElementById("index-pie");
var myChart = echarts.init(dom);
var app = {};
option = null;
option = {
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
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
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
    color:['#0071c4','#93d6fc','#5bbaf0', '#b7d4e4', '#3ba2dc'],
    series : [
        {
            name: '二期房源分布图',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[
                {value:42, name:'已租'},
                {value:123, name:'未租'},
                {value:12, name:'已售出'},
                {value:8, name:'已预订'},
                {value:46, name:'房自留'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
;
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}


// 折线图
// 每月出租房源趋势图
var dom1 = document.getElementById("index-line-room");
var myChart = echarts.init(dom1);
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
    myChart.setOption(option1, true);
}

// 每月企业入驻数据
var dom1 = document.getElementById("index-line-enterprise");
var myChart = echarts.init(dom1);
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
    myChart.setOption(option2, true);
}