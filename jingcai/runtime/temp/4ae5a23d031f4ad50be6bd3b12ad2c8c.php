<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:26:"./template/index\index.tpl";i:1528097078;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/easyui/themes/icon.css">
    <script type="text/javascript" src="__PUBLIC__/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/easyui/datagrid-detailview.js"></script>
</head>
<body>

<div id="table">
    <table id="chemistry" class="easyui-datagrid" style="height:auto;"></table>
</div>
<div class="easyui-panel" style="width:100%;max-width:;padding:30px 60px;text-align:center">

    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="saveGiftPurchaseAdd()" style="width:80px">提交</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" style="width:80px">重置</a>
</div>
<div id="chemistrytb">
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true"
       onclick="appendChemistry()">添加</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true"
       onclick="removeitChemistry()">删除</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true"
       onclick="acceptChemistry()">确认</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true"
       onclick="rejectChemistry()">取消</a>
</div>
<script>
    $('#chemistry').datagrid({
        iconCls: 'icon-edit',
        toolbar: '#chemistrytb',
        onClickCell: onClickCell,
       onEndEdit: onEndEdit,

        striped: true,
        url: '',
        singleSelect: true,
        autoRowHeight: true,
        rownumbers: true,
        fitColumns: true,


        columns: [[
            { field: 'condition', title: '材料分类', width: 50 ,editor: { type: 'text'}},
            { field: 'title', title: '描述标题', width: 50 ,editor: { type: 'text'}},
            { field: 'content', title: '描述内容', width: 50 ,editor: { type: 'text'}},
        ]],
        view: detailview,
        detailFormatter: function (index, row) {
            return '<div style="padding:5px"><table id="chemistryItem-' + index + '"></table></div>';
        },
        onExpandRow: function (index, row) {

            $('#chemistryItem-' + index).datagrid({
                url: 'http://127.0.0.1:8088/index/getCategory',
                fitColumns: true,
                singleSelect: true,
                rownumbers: true,
                loadMsg: '',
                height: 'auto',
                columns: [[
                    { field: 'pid', title: '1', width: 50 },
                    { field: 'category_name', title: '2', width: 50 },
                    { field: 'parent_id', title: '3', width: 50 },

                    { field: 'DAITEMID', title: 'DAITEMID', width: 50, hidden: 'true' }
                ]],
                onResize: function () {
                    $('#chemistry').datagrid('fixDetailRowHeight', index);
                },
                onLoadSuccess: function () {
                    setTimeout(function () {
                        $('#chemistry').datagrid('fixDetailRowHeight', index);
                    }, 0);
                }
            });
            $('#chemistry').datagrid('fixDetailRowHeight', index);
        }
    })

    var editIndex = undefined;
    function endEditing() {

        if (editIndex == undefined) {
            return true
        }
        if ($('#chemistry').datagrid('validateRow', editIndex)) {
            $('#chemistry').datagrid('endEdit', editIndex);
            editIndex = undefined;
            return true;
        } else {
            return false;
        }
    }

    function onClickCell(index, field) {

        if (editIndex != index) {
            if (endEditing()) {
                $('#chemistry').datagrid('selectRow', index)
                    .datagrid('beginEdit', index);
                var ed = $('#chemistry').datagrid('getEditor', {index: index, field: field});

                if (ed) {
                    ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                }
                editIndex = index;
            } else {
                setTimeout(function () {
                    $('#chemistry').datagrid('selectRow', editIndex);
                }, 0);
            }
        }
    }

    function onEndEdit(index, row) {
        var ed = $(this).datagrid('getEditor', {
            index: index,
            field: 'ids'
        });
       // row.ids = $(ed.target).textbox('getText');
    }

    function appendChemistry() {
        if (endEditing()) {

            $('#chemistry').datagrid('appendRow', {unitvalueaa: ''});
            // $('#chemistry').datagrid('appendRow',{status:'P'});
            editIndex = $('#chemistry').datagrid('getRows').length - 1;
            $('#chemistry').datagrid('selectRow', editIndex)
                .datagrid('beginEdit', editIndex);
        }
    }

    function removeitChemistry() {
        if (editIndex == undefined) {
            return
        }
        $('#chemistry').datagrid('cancelEdit', editIndex)
            .datagrid('deleteRow', editIndex);
        editIndex = undefined;
    }

    function acceptChemistry() {
        if (endEditing()) {

            $('#chemistry').datagrid('acceptChanges');
        }
    }

    function rejectChemistry() {
        $('#chemistry').datagrid('rejectChanges');
        editIndex = undefined;
    }
    function saveGiftPurchaseAdd() {
        if (endEditing()) {
            $.messager.confirm('确认', '确定要提交所有的数据?', function (r) {
                if (r) {
                    //化学json
                    chemistry = JSON.stringify($('#chemistry').datagrid("getRows"));
                    alert(JSON.stringify(chemistry));


                    $.ajax({
                        type: "post",
                        //url: 'resultinput/addResultinput',
                        dataType: 'json',
                        data: json,
                        success: function (data, textStatus) {

                            if (data.resultCode == 1) {
                                $.messager.alert('SECCESS','录入实测数据成功');
                                $('#ff').form('clear');
                            } else {
                                if (data.errorType == "user") {
                                    showAlertMsg("提示", data.msg, "warning");
                                } else {
                                    showRightBottomMsg("系统提示", data.msg, 'slide', 5000);
                                }
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert(textStatus + errorThrown);
                        }
                    });
                }
            });
        }
    }
</script>
</body>
</html>