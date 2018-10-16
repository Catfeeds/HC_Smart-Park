var dom = document.getElementById("index-pie");
var myChart = echarts.init(dom);
var app = {};
option = null;
option = {
    title : {
        show:false,
        text: '二期房源分布图',
        subtext: '',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
        data: ['已租','未租','已售出','已预订','房自留']
    },
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