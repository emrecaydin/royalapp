/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

/* global moment:false, Chart:false, Sparkline:false */

$(function () {
    'use strict'

    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.card-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999
    })
    $('.connectedSortable .card-header').css('cursor', 'move')

    // jQuery UI sortable for the todo list
    $('.todo-list').sortable({
        placeholder: 'sort-highlight',
        handle: '.handle',
        forcePlaceholderSize: true,
        zIndex: 999999
    })

    // bootstrap WYSIHTML5 - text editor
    $('.textarea').summernote()

    $('.daterange').daterangepicker({
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        // eslint-disable-next-line no-alert
        alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    })

    /* jQueryKnob */
    $('.knob').knob()

    // jvectormap data
    /*let companyBranchRegions = {
        '1': 400, // Adana
        '3': 400, // Afyon
        '7': 400, // Ankara
        '8': 400, // Antalya
        '21': 400, // Bursa
        '26': 400, // Diyarbakır
        '28': 400, // Kayseri
        '31': 400, // Erzurum
        '25': 400, // Denizli
        '33': 400, // Gaziantep
        '40': 400, // İstanbul
        '41': 400, // İzmir
        '47': 400, // İzmir
        '52': 400, // Kocaeli
        '53': 400, // Konya
        '55': 400, // Malatya
        '57': 400, // Mardin
        '58': 400, // Mersin
        '67': 400, // Samsun
        '72': 400, // Sivas
        '73': 400, // Tekirdağ
        '75': 400, // Trabzon
    }

    let cities = {
        'city1': 1,
        'city2': 2,
        'city3': 3,
        'city4': 4,
        'city6': 5,
        'city7': 6,
        'city8': 7,
        'city10': 8,
        'city11': 9,
        'city12': 10,
        'city16': 11,
        'city17': 12,
        'city18': 13,
        'city19': 14,
        'city20': 15,
        'city21': 16,
        'city22': 17,
        'city23': 18,
        'city24': 19,
        'city25': 20,
        'city26': 21,
        'city28': 22,
        'city29': 23,
        'city30': 24,
        'city31': 25,
        'city32': 26,
        'city33': 27,
        'city34': 28,
        'city35': 29,
        'city36': 30,
        'city37': 31,
        'city39': 32,
        'city58': 33,
        'city40': 34,
        'city41': 35,
        'city45': 36,
        'city46': 37,
        'city47': 38,
        'city50': 39,
        'city51': 40,
        'city52': 41,
        'city53': 42,
        'city54': 43,
        'city55': 44,
        'city56': 45,
        'city42': 46,
        'city57': 47,
        'city59': 48,
        'city60': 49,
        'city61': 50,
        'city62': 51,
        'city63': 52,
        'city65': 53,
        'city66': 54,
        'city67': 55,
        'city69': 56,
        'city70': 57,
        'city72': 58,
        'city73': 59,
        'city74': 60,
        'city75': 61,
        'city76': 62,
        'city68': 63,
        'city77': 64,
        'city78': 65,
        'city80': 66,
        'city81': 67,
        'city5': 68,
        'city15': 69,
        'city44': 70,
        'city49': 71,
        'city14': 72,
        'city71': 73,
        'city13': 74,
        'city9': 75,
        'city38': 76,
        'city79': 77,
        'city43': 78,
        'city48': 79,
        'city64': 80,
        'city27': 81,
    }

    let cityNames = {
        'city1': 'Adana',
        'city2': 'Adıyaman',
        'city3': 'Afyon',
        'city4': 'Ağrı',
        'city5': 'Amasya',
        'city6': 'Ankara',
        'city7': 'Antalya',
        'city8': 'Artvin',
        'city9': 'Aydın',
        'city10': 'Balıkesir',
        'city11': 'Bilecik',
        'city12': 'Bingöl',
        'city13': 'Bitlis',
        'city14': 'Bolu',
        'city15': 'Burdur',
        'city16': 'Bursa',
        'city17': 'Çanakkale',
        'city18': 'Çankırı',
        'city19': 'Çorum',
        'city20': 'Denizli',
        'city21': 'Diyarbakır',
        'city22': 'Edirne',
        'city23': 'Elazığ',
        'city24': 'Erzincan',
        'city25': 'Erzurum',
        'city26': 'Eskişehir',
        'city27': 'Gaziantep',
        'city28': 'Giresun',
        'city29': 'Gümüşhane',
        'city30': 'Hakkari',
        'city31': 'Hatay',
        'city32': 'Isparta',
        'city33': 'Mersin',
        'city34': 'İstanbul',
        'city35': 'İzmir',
        'city36': 'Kars',
        'city37': 'Kastamonu',
        'city38': 'Kayseri',
        'city39': 'Kırklareli',
        'city40': 'Kırşehir',
        'city41': 'Kocaeli',
        'city42': 'Konya',
        'city43': 'Kütahya',
        'city44': 'Malatya',
        'city45': 'Manisa',
        'city46': 'K.Maraş',
        'city47': 'Mardin',
        'city48': 'Muğla',
        'city49': 'Muş',
        'city50': 'Nevşehir',
        'city51': 'Niğde',
        'city52': 'Ordu',
        'city53': 'Rize',
        'city54': 'Sakarya',
        'city55': 'Samsun',
        'city56': 'Siirt',
        'city57': 'Sinop',
        'city58': 'Sivas',
        'city59': 'Tekirdağ',
        'city60': 'Tokat',
        'city61': 'Trabzon',
        'city62': 'Tunceli',
        'city63': 'Ş.Urfa',
        'city64': 'Uşak',
        'city65': 'Van',
        'city66': 'Yozgat',
        'city67': 'Zonguldak',
        'city68': 'Aksaray',
        'city69': 'Bayburt',
        'city70': 'Karaman',
        'city71': 'Kırıkkale',
        'city72': 'Batman',
        'city73': 'Şırnak',
        'city74': 'Bartın',
        'city75': 'Ardahan',
        'city76': 'Iğdır',
        'city77': 'Yalova',
        'city78': 'Karabük',
        'city79': 'Kilis',
        'city80': 'Osmaniye',
        'city81': 'Düzce'
    }*/

    /**
     * @param code
     * @returns {string[]|*}
     */
/*    function getCity(code) {
        if ('city' + code in cities) {
            return cities['city' + code];
        }
        return cities['city40'];
    }*/

    // World map by jvectormap
   /* $('#world-map').vectorMap({
        map: 'turkey_1_mill_en',
        backgroundColor: 'transparent',
        onRegionClick: function (event, code) {
            let cityCode = getCity(code);
            alert(cityCode);
        },
        onRegionOver: function (event, code) {

        },
        regionStyle: {
            initial: {
                fill: 'rgba(255, 255, 255, 0.7)',
                'fill-opacity': 1,
                stroke: 'rgba(0,0,0,.2)',
                'stroke-width': 1,
                'stroke-opacity': 1
            }
        },
        series: {
            regions: [{
                values: companyBranchRegions,
                scale: ['#ffffff', '#0154ad'],
                normalizeFunction: 'polynomial'
            }]
        },
        onRegionLabelShow: function (e, el, code) {
            /!*if (typeof visitorsData[code] !== 'undefined') {
                el.html(el.html() + ': ' + visitorsData[code] + ' new visitors')
            }*!/
        }, labels: {
            regions: {
                render: function (code) {
                    let showOnly = [1, 3, 6, 7, 16, 20, 21, 22, 25, 27, 33, 34, 35, 38, 41, 42, 44, 47, 55, 58, 59, 61]; // plate codes
                    let plateCode = cities['city' + code];
                    if (showOnly.indexOf(plateCode) !== -1) {
                        return plateCode < 10 ? '0' + plateCode : plateCode;
                    }
                },
                offsets: function (code) {
                    return {
                        '40': [-5, 5],
                        '41': [-5, 25],
                        '8': [-5, -15],
                    }[code];
                }
            }
        }
    })*/

    // Sparkline charts
    /*    var sparkline1 = new Sparkline($('#sparkline-1')[0], {width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9'})
        var sparkline2 = new Sparkline($('#sparkline-2')[0], {width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9'})
        var sparkline3 = new Sparkline($('#sparkline-3')[0], {width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9'})

        sparkline1.draw([1000, 1200, 920, 927, 931, 1027, 819, 930, 1021])
        sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921])
        sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21])*/

    // The Calender
    $('#calendar').datetimepicker({
        format: 'L',
        inline: true
    })

    // SLIMSCROLL FOR CHAT WIDGET
    $('#chat-box').overlayScrollbars({
        height: '250px'
    })

    /* Chart.js Charts */
    // Sales chart
    //var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');

    var salesChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                label: 'Digital Goods',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [28, 48, 40, 19, 86, 27, 90]
            },
            {
                label: 'Electronics',
                backgroundColor: 'rgba(210, 214, 222, 1)',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [65, 59, 80, 81, 56, 55, 40]
            }
        ]
    }

    var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    /*    var salesChart = new Chart(salesChartCanvas, {
            type: 'line',
            data: salesChartData,
            options: salesChartOptions
        })*/

    // Donut Chart
    //var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
    var pieData = {
        labels: [
            'Instore Sales',
            'Download Sales',
            'Mail-Order Sales'
        ],
        datasets: [
            {
                data: [30, 12, 20],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12']
            }
        ]
    }
    var pieOptions = {
        legend: {
            display: false
        },
        maintainAspectRatio: false,
        responsive: true
    }
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // eslint-disable-next-line no-unused-vars
    /*    var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: pieData,
            options: pieOptions
        })*/


    // Sales graph chart
    //var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
    // $('#revenue-chart').get(0).getContext('2d');

    var salesGraphChartData = {
        labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [
            {
                label: 'Masada Bekleyen Çağrı',
                fill: false,
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432, 9000, 10000]
            }
        ]
    }

    var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: '#efefef'
                },
                gridLines: {
                    display: false,
                    color: '#efefef',
                    drawBorder: false
                }
            }],
            yAxes: [{
                ticks: {
                    stepSize: 5000,
                    fontColor: '#efefef'
                },
                gridLines: {
                    display: true,
                    color: '#efefef',
                    drawBorder: false
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    // eslint-disable-next-line no-unused-vars
    /*var salesGraphChart = new Chart(salesGraphChartCanvas, {
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
    })*/


    //-------------
    //- BAR CHART -
    //-------------

    /*let areaChartData = {
        labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [
            {
                label: 'Toplam Kapanan Çağrı',
                backgroundColor: 'rgba(40,167,68,0.9)',
                borderColor: 'rgba(40,167,68,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [79, 55, 77, 76, 56, 55, 77]
            },
            {
                label: 'Toplam Açılan Çağrı',
                backgroundColor: 'rgba(30, 162, 184, 1)',
                borderColor: 'rgba(30, 162, 184, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [89, 59, 80, 81, 56, 55, 78]
            },
            {
                label: 'Devam Eden Çağrı',
                backgroundColor: 'rgba(220, 52, 69, 1)',
                borderColor: 'rgba(220, 52, 69, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [10, 4, 3, 3, 5, 0, 0]
            },
        ]
    }


    let barChartCanvas = $('#barChart').get(0).getContext('2d')
    let barChartData = $.extend(true, {}, areaChartData)
    let temp0 = areaChartData.datasets[0]
    let temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    let barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    let barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });*/


    /*
     * DONUT CHART
     * -----------
     */

    /*let donutTotalData = [
        {
            label: 'Call Center',
            data: 30,
            color: '#3c8dbc'
        },
        {
            label: 'Network',
            data: 20,
            color: '#0073b7'
        },
        {
            label: 'Yazılım ve Ar-Ge',
            data: 5,
            color: '#00c0ef'
        }
        ,
        {
            label: 'Linux',
            data: 30,
            color: '#00c000'
        },
        {
            label: 'Zayıf Akım',
            data: 15,
            color: '#0143b5'
        }
    ]
    $.plot('#donut-chart-total', donutTotalData, {
        series: {
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.25,
                label: {
                    show: true,
                    radius: 2 / 3,
                    formatter: labelFormatter,
                    threshold: 0.1
                }

            }
        },
        legend: {
            show: false
        }
    });*/


    /*let donutClosedData = [
        {
            label: 'Call Center',
            data: 45,
            color: '#3c8dbc'
        },
        {
            label: 'Network',
            data: 20,
            color: '#0073b7'
        },
        {
            label: 'Yazılım ve Ar-Ge',
            data: 5,
            color: '#00c0ef'
        }
        ,
        {
            label: 'Linux',
            data: 20,
            color: '#00c000'
        },
        {
            label: 'Zayıf Akım',
            data: 10,
            color: '#0143b5'
        }
    ]
    $.plot('#donut-chart-closed', donutClosedData, {
        series: {
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.25,
                label: {
                    show: true,
                    radius: 2 / 3,
                    formatter: labelFormatter,
                    threshold: 0.1
                }

            }
        },
        legend: {
            show: false
        }
    });*/


    /*let donutDelayedData = [
        {
            label: 'Call Center',
            data: 10,
            color: '#3c8dbc'
        },
        {
            label: 'Network',
            data: 5,
            color: '#0073b7'
        },
        {
            label: 'Yazılım ve Ar-Ge',
            data: 35,
            color: '#00c0ef'
        }
        ,
        {
            label: 'Linux',
            data: 10,
            color: '#00c000'
        },
        {
            label: 'Zayıf Akım',
            data: 40,
            color: '#0143b5'
        }
    ]
    $.plot('#donut-chart-delayed', donutDelayedData, {
        series: {
            pie: {
                show: true,
                radius: 1,
                innerRadius: 0.25,
                label: {
                    show: true,
                    radius: 2 / 3,
                    formatter: labelFormatter,
                    threshold: 0.1
                }

            }
        },
        legend: {
            show: false
        }
    });*/


    /*
     * END DONUT CHART
     */

    /*
 * Custom Label formatter
 * ----------------------
 */
    function labelFormatter(label, series) {
        return '<div style="font-size:12px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + '<br>'
            + Math.round(series.percent) + '%</div>'
    }

})
