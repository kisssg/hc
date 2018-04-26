app.title = '领用核查情况';

option = {
    title: {
        text: '领用核查情况',
        subtext: ''
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'shadow'
        }
    },
    legend: {
        data: ['领取', '已查']
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis: {
        type: 'value',
        boundaryGap: [0, 0.01]
    },
    yAxis: {
        type: 'category',
        data: ['Fangzhi','Roug','Ye','Jane','Tita','总计']
    },
    series: [
        {
            name: '领取',
            type: 'bar',
            data: [450, 234, 294, 100, 134, 3300]
        },
        {
            name: '已查',
            type: 'bar',
            data: [325, 231, 210, 99, 131, 2180]
        }
    ]
};
