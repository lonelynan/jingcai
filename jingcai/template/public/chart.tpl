<script src="__PUBLIC__/temp/js/jquery.min.js"></script>
<script src="__PUBLIC__/temp/js/jquery-labelauty.js"></script>

<script src="__PUBLIC__/temp/js/jquery-ui.min.js"></script>

<script src="__PUBLIC__/temp/js/jquery.animsition.min.js"></script>
<script src="__PUBLIC__/temp/js/echarts.js"></script>
<div class="data_wrap" style="background: #efeff5; width: 1170px; padding: 10px;">
    <div class="animsition" style="overflow: hidden;">
        <div id="main1" class="my_main2" style="width: 100%; height: 450px; float: left;"></div>
    </div>

</div>

<script>
    $(document).ready(function () {
        //插件初始化
        $(":checkbox").labelauty({
            checked_label: "",
            unchecked_label: "",
        });
        $(":radio").labelauty({
            checked_label: "",
            unchecked_label: "",
        });

        //初始化切换
        $(".animsition").animsition({

            inClass: 'fade-in-right',
            outClass: 'fade-out',
            inDuration: 1500,
            outDuration: 800,
            linkElement: '.animsition-link',
            // e.g. linkElement   :   'a:not([target="_blank"]):not([href^=#])'
            loading: true,
            loadingParentElement: 'body', //animsition wrapper element
            loadingClass: 'animsition-loading',
            unSupportCss: ['animation-duration',
                '-webkit-animation-duration',
                '-o-animation-duration'
            ],
            //"unSupportCss" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
            //The default setting is to disable the "animsition" in a browser that does not support "animation-duration".

            overlay: false,

            overlayClass: 'animsition-overlay-slide',
            overlayParentElement: 'body'
        });

        var data = {$equipment_chart};
        var my_data;
        var my_datat;

        var my_data_json;
        var my_data_name;
        var my_data_value;
        var my_data_num;
        var len

        var iNowEnd;
        var my_key;
        Sort(data)

        function Sort(data, ble) {
            my_data = [];
            my_datat = [];
            my_data_json = [];
            my_data_name = [];
            my_data_value = [];
            my_data_num = [];
            len = data.length;
            for (var i = 0; i < len; i++) {

                my_data[i] = $.extend(true,{}, data[i]);
                my_datat[i] = $.extend(true,{}, data[i]);
            }
            for (var i = 0; i < len; i++) {
                my_data_json.unshift(size('num', my_datat)[0]);
                my_data_name.unshift(my_data_json[0].name);
                my_data_value.unshift(my_data_json[0].num);

            }
            function size(key, obj) {

                var j = obj[0][key];
                var n = obj[0];
                var iNow = 0;
                for (var i = 1; i < obj.length; i++) {
                    if (obj[i][key] > j) {
                        j = obj[i][key];
                        iNow = i;
                    }
                }
                return obj.splice(iNow, 1);
            }
        }

        // 路径配置
        require.config({
            paths: {
                echarts: '__PUBLIC__/temp/js'
            }
        });
        require(
            [
                'echarts',
                'echarts/chart/bar',
                'echarts/chart/line',
                'echarts/chart/pie',
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('main1'), 'macarons');
                var ecConfig = require('echarts/config');
                var option = {
                    backgroundColor: 'white',
                    title: {
                        text: '设备图表数据',
                        x: 48,
                        y: 15,
                        textStyle: {
                            fontSize: 12
                        }
                    },
                    tooltip: {
                        trigger: 'axis',
                    },
                    toolbox: {
                        show: true,
                        y: 15,
                        x: 800,
                        itemSize: 12,
                        feature: {
                            //mark : {show: true},
                            dataView: {show: true},
                            //magicType: {show: true, type: ['line', 'bar']},
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    calculable: true,
                    grid: {
                        x: 160
                    },
                    xAxis: [
                        {
                            show: false,
                            type: 'value',
                            boundaryGap: [0, 0.01]
                        }
                    ],
                    yAxis: [
                        {
                            type: 'category',
                            data: my_data_name
                        }
                    ],
                    series: [
                        {
                            name: '设备数量',
                            type: 'bar',
                            barMaxWidth: 7,
                            itemStyle: {
                                normal: {
                                    color: '#36a2ef',
                                    label: {
                                        show: true
                                    }
                                }
                            },

                            data: my_data_value
                        }
                    ]
                };
                myChart.setOption(option);
                option.dataZoom.end = iNowEnd;
                option.series[0].data = my_data_value;
                option.yAxis[0].data = my_data_name;
                myChart.clear();
                myChart.setOption(option, true);
            }
        );
        //关闭提示
        $('.xsfx_tips  i').on('click', function () {
            $(this).parent().slideUp();
        })
    });
</script>
