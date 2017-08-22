@extends('layouts.main')
@section('style') 
.selectpicker {
    border-color: #ccc;
}
body {
    padding-top:50px;
}
th {
    text-align:center;
}
#search-box {
    padding:5%;
}
@endsection
@section('script')
<script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/zh-cn.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var idTmr;  
    function  getExplorer() {  
        var explorer = window.navigator.userAgent ;  
        //ie  
        if (explorer.indexOf("MSIE") >= 0) {  
            return 'ie';  
        }  
        //firefox  
        else if (explorer.indexOf("Firefox") >= 0) {  
            return 'Firefox';  
        }  
        //Chrome  
        else if(explorer.indexOf("Chrome") >= 0){  
            return 'Chrome';  
        }  
        //Opera  
        else if(explorer.indexOf("Opera") >= 0){  
            return 'Opera';  
        }  
        //Safari  
        else if(explorer.indexOf("Safari") >= 0){  
            return 'Safari';  
        }  
    }  
    function method(tableid) {  
        if(getExplorer()=='ie')  
        {  
            var curTbl = document.getElementById(tableid);  
            var oXL = new ActiveXObject("Excel.Application");  
            var oWB = oXL.Workbooks.Add();  
            var xlsheet = oWB.Worksheets(1);  
            var sel = document.body.createTextRange();  
            sel.moveToElementText(curTbl);  
            sel.select();  
            sel.execCommand("Copy");  
            xlsheet.Paste();  
            oXL.Visible = true;  

            try {  
                var fname = oXL.Application.GetSaveAsFilename("Excel.xls", "Excel Spreadsheets (*.xls), *.xls");  
            } catch (e) {  
                print("Nested catch caught " + e);  
            } finally {  
                oWB.SaveAs(fname);  
                oWB.Close(savechanges = false);  
                oXL.Quit();  
                oXL = null;  
                idTmr = window.setInterval("Cleanup();", 1);  
            }  

        }  
        else  
        {  
            tableToExcel(tableid)  
        }  
    }  
    function Cleanup() {  
        window.clearInterval(idTmr);  
        CollectGarbage();  
    }  
    var tableToExcel = (function() {  
        var uri = 'data:application/vnd.ms-excel;base64,',  
                template = '<html><head><meta charset="UTF-8"></head><body><table>{table}</table></body></html>',  
                base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },  
                format = function(s, c) {  
                    return s.replace(/{(\w+)}/g,  
                            function(m, p) { return c[p]; }) }  
        return function(table, name) {  
            if (!table.nodeType) table = document.getElementById(table)  
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}  
            window.location.href = uri + base64(format(template, ctx))  
        }  
    })()  
</script>  
<script type="text/javascript">

    function today() {
        var dd = new Date();
        var y = dd.getFullYear();
        var m = dd.getMonth()+1;//获取当前月份的日期
        var d = dd.getDate();
        return y+"-"+m+"-"+d;
    }
    var today = today();
    $(function () {  
        var picker1 = $('#start_date_timepicker').datetimepicker({  
            format: 'YYYY-MM-DD',  
            locale: moment.locale('zh-cn'),  
            minDate: today 
        });  
        var picker2 = $('#end_date_timepicker').datetimepicker({  
            format: 'YYYY-MM-DD',  
            locale: moment.locale('zh-cn')  
        });  

        //动态设置最小值  
        picker1.on('dp.change', function (e) {  
            picker2.data('DateTimePicker').minDate(e.date);  
        });  
        //动态设置最大值  
        // picker2.on('dp.change', function (e) {  
        //     picker1.data('DateTimePicker').maxDate(e.date);  
        // });  
    });  
</script>
@endsection
@section('content-in-main')
<!-- modal model for addleave-->
<div id="modal-switch-addleave" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">添加请假记录</span>
                </button>
                <div id="modal-switch-label" class="modal-title" style="font-size: large;">添加请假记录</div>
            </div>
            <div class="modal-body">
                <form id="leave_form" role="form" method="POST" action="/leave">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <table class="table table-hover" style="text-align: center;width: 90%;margin-left:10%;">
                        <tbody>
                            <tr>
                                <td>姓名</td>
                                <td>
                                    <select class="selectpicker btn" name="employee_id" style="width:40%;" required/>
                                        <optgroup label="姓名  ">
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>开始日期</td>
                                <td>
                                    <div class="input-group date" id="start_date_timepicker" style="width:40%;margin-left:30%;">  
                                        <input type="text" class="form-control" type="time" autocomplete="off" placeholder="开始时间" name="start_date" required/>  
                                        <span class="input-group-addon">  
                                            <span class="glyphicon glyphicon-calendar"></span>  
                                        </span>  
                                    </div>  
                                </td>
                            </tr>
                            <tr>
                                <td>结束日期</td>
                                <td>
                                    <div class="input-group date" id="end_date_timepicker" style="width:40%;margin-left:30%;">  
                                        <input type="text" class="form-control" type="time" autocomplete="off" placeholder="结束时间" name="end_date" required/>  
                                        <span class="input-group-addon">  
                                            <span class="glyphicon glyphicon-calendar"></span>  
                                        </span>  
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td>请假类型</td>
                                <td>
                                    <select id="type" class="selectpicker btn" name="type" style="width:40%;" required/>
                                        <optgroup label="类型">
                                            <option value="事假">事假</option>
                                            <option value="病假">病假</option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>备注</td>
                                <td><input id="note" class="form-control placeholder-no-fix" type="note" name="note" style="width:40%;margin-left:30%;"></td>
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

<!-- modal model for changeleave-->
<div id="modal-switch-changeleave" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">记录变动</span>
                </button>
                <div id="modal-switch-label" class="modal-title" style="font-size: large;">记录变动</div>
            </div>
            <div class="modal-body">
                <form id="leave_form" role="form" method="POST" action="/leave">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <table class="table table-hover" style="text-align: center;width: 90%;margin-left:10%;">
                        <tbody>
                            <tr>
                                <td>变动类型</td>
                                <td>
                                    <select class="selectpicker btn" style="width:40%;" required/>
                                        <optgroup>
                                            <option value="delete">删除记录</option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td>假条编号</td>
                                <td>
                                    <input id="td_leave_id" class="form-control placeholder-no-fix" type="note" style="width:40%;margin-left:30%;" readonly="readonly" value=""/>
                                </td>
                            </tr> -->
                            <tr>
                                <td>工号</td>
                                <td>
                                    <input id="td_leave_employee_id" class="form-control placeholder-no-fix" type="note" name="employee_id" style="width:40%;margin-left:30%;" readonly="readonly" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td>姓名</td>
                                <td>
                                    <input id="td_leave_name" class="form-control placeholder-no-fix" type="note" style="width:40%;margin-left:30%;" readonly="readonly" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td>起始日期</td>
                                <td>
                                    <input id="td_leave_start_date" class="form-control placeholder-no-fix" type="note" name="start_date" style="width:40%;margin-left:30%;" readonly="readonly" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td>结束日期</td>
                                <td>
                                    <div class="input-group date" id="submit_end_date_timepicker" style="width:40%;margin-left:30%;">  
                                        <input id="submit_end_date" type="text" class="form-control" type="time" autocomplete="off" placeholder="结束时间" name="end_date" required/>  
                                        <span class="input-group-addon">  
                                            <span class="glyphicon glyphicon-calendar"></span>  
                                        </span>  
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td>类型</td>
                                <td>
                                    <input id="td_leave_type" class="form-control placeholder-no-fix" type="note" name="type" style="width:40%;margin-left:30%;" readonly="readonly" value=""/>
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


<!-- content view -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <button data-toggle="modal" data-target="#modal-switch-addleave" class="btn-primary btn">添加请假记录</button>
    <div>
        <div class="col-sm-2 col-md-2" style="font-size: 200%;float: left;">
            请假情况
        </div>
        <div style="margin-left:30%;">
            <form id="leave_form" role="form" method="POST" action="/leave">
                {{ csrf_field() }}  
                    <div class="form-group">  
                        <!--指定 date标记-->  
                        显示指定员工
                        <select class="selectpicker btn" name="employee_id" required/>
                        <optgroup label="姓名">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </optgroup>
                        </select>
                    <button type="submit" class="btn btn-primary btn-sm">提交</button>
                    </div> 
            </form>
        </div>
        <div class="col-sm-2 col-md-2" style="float: right;">
            <button type="button" class="btn btn-primary" onclick="method('tableExcel')">
                导出本页表格为excel
            </button>
        </div>
    </div>

    <div class="table-responsive col-md-11">
        <table class="table table-striped" id="tableExcel">
            <thead style="text-align:center;">
                <tr>
                    <th>日期</th>
                    <th>工号</th>
                    <th>姓名</th>
                    <th>请假类型</th>
                    <th>备注</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($absenceRecords as $absenceRecord)
                    <tr>
                        @if($loop->first)
                            <th id="leave_date_{{ $absenceRecord->id }}">{{ $absenceRecord->year }}-{{ $absenceRecord->month }}-{{ $absenceRecord->day }}</th>
                        @elseif($date != $absenceRecord->year."-".$absenceRecord->month."-".$absenceRecord->day)
                            <th id="leave_date_{{ $absenceRecord->id }}">{{ $absenceRecord->year }}-{{ $absenceRecord->month }}-{{ $absenceRecord->day }}</th>
                        @else
                            <th><span id="leave_date_{{ $absenceRecord->id }}" hidden>{{ $absenceRecord->year }}-{{ $absenceRecord->month }}-{{ $absenceRecord->day }}</span></th>
                        @endif
                        <th><a id="leave_employee_id_{{ $absenceRecord->id }}" href="/employees/{{ $absenceRecord->employee->work_number }}">{{ $absenceRecord->employee->work_number }}</a></th>
                        <th id="leave_name_{{ $absenceRecord->id }}">{{ $absenceRecord->employee->name }}</th>
                        <th id="leave_type_{{ $absenceRecord->id }}">{{ $absenceRecord->type }}
                        @if ($absenceRecord->note)
                            <th>{{ $absenceRecord->note }}</th>
                        @else
                            <th></th>
                        @endif
                        <th>
                            <button id="{{ $absenceRecord->id }}" data-toggle="modal" data-target="#modal-switch-changeleave" class="btn-primary btn" onclick="change(this.id)">撤销</button>
                        </th>
                        @php
                            $date = $absenceRecord->year."-".$absenceRecord->month."-".$absenceRecord->day
                        @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="text-align: center;">
             {{ $absenceRecords->links() }} 
        </div>
    </div>
</div>
<script>
    function change(record_id){
        document.getElementById("submit_end_date").value = null;
        var start_date = "leave_date_" + record_id;
        var employee_id = "leave_employee_id_" + record_id;
        var type = "leave_type_" + record_id;
        var name = "leave_name_" + record_id;
        start_date_value = document.getElementById(start_date).innerHTML;
        employee_id_value = document.getElementById(employee_id).innerHTML;
        type_value = document.getElementById(type).innerHTML;
        name_value = document.getElementById(name).innerHTML;
        document.getElementById("td_leave_start_date").value = start_date_value;
        document.getElementById("td_leave_employee_id").value = employee_id_value;
        document.getElementById("td_leave_type").value = type_value;
        document.getElementById("td_leave_name").value = name_value;
        $('#submit_end_date_timepicker').datetimepicker({  
            format: 'YYYY-MM-DD',  
            locale: moment.locale('zh-cn'),
            minDate: start_date_value
        });  
    }
</script>
@endsection
