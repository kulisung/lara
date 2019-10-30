<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title') | {{ env('APP_NAME') }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script type="text/javascript">
            $(function() {
            $('#Datepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showMonthAfterYear: true,
                    showButtonPanel: true,
                    dateFormat: 'yymm',
                    monthNamesShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"], // 月名英文改成數字
                    onClose: function(dateText, inst) {
                        var month = $("#ui-datepicker-div .ui-datepicker-month option:selected").val();//得到選中的月份
                        var parseIntok=parseInt(month) + 1;
                        if(parseIntok < 10) {  //增加0判斷
                            parseIn='0'+parseIntok;
                        }else{
                            parseIn=parseIntok;
                        }
                        var year = $("#ui-datepicker-div .ui-datepicker-year option:selected").val();//得到選中的年份
                        $('#Datepicker').val(year+parseIn);//給input賦予值，其中要對月值加1才是實際的月份
                    }
                });
            });            
        </script>
        <style type="text/css">
                .ui-datepicker-calendar {
                display: none;  //隱藏日期區塊
            }
        </style>

        <style>
            .table{
                width:100%;
                max-width: 100%;
            }
            .table>thead>tr{
                background: #edf7ff;
            }
            .table>thead>tr>th {
                white-space: nowrap;
                padding: 5px;
                /*text-align: center;*/
                font-size: 14px;
            }
    
            .table>tbody>tr:nth-child(odd){
                background: #fff;
                white-space: nowrap;
                font-size: 14px;
                line-height: 2px;
            }
            .table>tbody>tr:nth-child(even){
                background: #f7f7f7;
                white-space: nowrap;
                font-size: 14px;
                line-height: 2px;
            }
            .table>tbody>tr:hover{
                background: #e3ecfc;
            }
            .table-cont{
                /**make table can scroll**/
                max-height: 480px;
                overflow: auto;
                /** add some style**/
                /*padding: 2px;*/
                background: #ddd;
                /*margin: 1px 1px;*/
                border: 1px solid #ddd;
            }
        </style>
    </head>
    <body style="background-color:#DEFFFF;">
        @include('layouts.navbar')
        @yield('content')
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        
        <script>
            window.onload = function(){
                var tableCont = document.querySelector('#table-cont');
                function scrollHandle (e){
                    console.log(this);
                    var scrollTop = this.scrollTop;
                    this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
                }
        
                tableCont.addEventListener('scroll',scrollHandle);
            }
        </script>


    </body>
</html>
