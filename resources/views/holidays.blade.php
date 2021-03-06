@extends('layouts.main')

@section('script')
<script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/zh-cn.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    function today() {
        var dd = new Date();
        var y = dd.getFullYear();
        var m = dd.getMonth()+1;//获取当前月份的日期
        var d = dd.getDate();
        return y+"-"+m;
    }
    var today = today();
    $(function () {
        var picker2 = $('#addHolidayCalendar').datetimepicker({  
            format: 'YYYY-MM',  
            locale: moment.locale('zh-cn'),
            maxDate: today
        });  
        var picker1 = $('#deleteHolidayCalendar').datetimepicker({  
            format: 'YYYY-MM',  
            locale: moment.locale('zh-cn'),
            maxDate: today
        });  
        //动态设置最小值  
        picker1.on('dp.change', function (e) {  
            picker2.data('DateTimePicker').minDate(e.date);  
        });  
        //动态设置最大值  
        picker2.on('dp.change', function (e) {  
            picker1.data('DateTimePicker').maxDate(e.date);  
        });  
    });  
</script>
@endsection

@section('holidays-view')
    <div id="modal-switch-add" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">添加假期</span></button>
                    <div id="modal-switch-label" class="modal-title" style="font-size: large;">添加假期</div>
                </div>
                <div class="modal-body">
                    <form id="edit_form" role="form" method="POST" action="/holidays">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <table class="table table-hover" style="text-align: center;width: 90%;">
                            <tbody>
                                 <tr>
                                    <td>选择月份</td>
                                    <td>
                                        <div class="input-group date" id="addHolidayCalendar" style="width: 70%;margin-left: 15%;">  
                                            <input id="calendar233" type="text" class="form-control" type="time" autocomplete="off" placeholder="选择月份" name="month" required/>  
                                            <span class="input-group-addon">  
                                                <span class="glyphicon glyphicon-calendar"></span>  
                                            </span>
                                        </div>
                                    </td> 
                                </tr>
                                <tr>
                                    <td>输入日期</td>
                                    <td>
                                        <div>
                                            <textarea name="day" id="day" placeholder='例：选择月份为"2017-08",输入日期的某一天如"1,2,3(英文逗号)",则将添加的假期为"2017-08-01,2017-08-02,2017-08-03"' cols="30" rows="10" /required></textarea>
                                        </div>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="margin-top: 15px;margin-left: 90%;">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-switch-delete" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" class="close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">删除假期</span></button>
                    <div id="modal-switch-label" class="modal-title" style="font-size: large;">删除假期</div>
                </div>
                <div class="modal-body">
                    <form id="edit_form" role="form" method="POST" action="/holidays">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <table class="table table-hover" style="text-align: center;width: 90%;">
                            <tbody>
                                 <tr>
                                    <td>选择月份</td>
                                    <td>
                                        <div class="input-group date" id="deleteHolidayCalendar" style="width: 70%;margin-left: 15%;">  
                                            <input id="calendar233" type="text" class="form-control" type="time" autocomplete="off" placeholder="选择月份" name="month" required/>  
                                            <span class="input-group-addon">  
                                                <span class="glyphicon glyphicon-calendar"></span>  
                                            </span>
                                        </div>
                                    </td> 
                                </tr>
                                <tr>
                                    <td>输入日期</td>
                                    <td>
                                        <div>
                                            <textarea name="day" id="day" placeholder='例：选择月份为"2017-08",输入日期的某一天如"1,2,3(英文逗号)",则将删除的假期为"2017-08-01,2017-08-02,2017-08-03"' cols="30" rows="10" /required></textarea>
                                        </div>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="margin-top: 15px;margin-left: 90%;">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="app" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"></div>
    <script src="{{asset('vue-schedule-calendar/dist/demo.js')}}"></script>
    <!-- <script>
        $(document).ready(function(){
            $("#preMonth").click(function(){
                var month = document.getElementById("now").innerHTML;
                $.post("/holidays",{month:month});
            });
        });
    </script> -->
@endsection