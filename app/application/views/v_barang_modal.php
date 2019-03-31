<script type="text/javascript">
var url;
 
function create(){
    jQuery('#dialog-form').dialog('open').dialog('setTitle','Tambah Mobil');
    jQuery('#form').form('clear');
    url = '<?php echo site_url('crud/create'); ?>';
}
 
function update(){
    var row = jQuery('#datagrid-crud').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Mobil');
        jQuery('#form').form('load',row);
        url = '<?php echo site_url('crud/update'); ?>/' + row.id;
    }
}
 
function save(){
    jQuery('#form').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form').dialog('close');
                jQuery('#datagrid-crud').datagrid('reload');
            } else {
                jQuery.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}
 
function remove(){
    var row = jQuery('#datagrid-crud').datagrid('getSelected');
    if (row){
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this user?',function(r){
            if (r){
                jQuery.post('<?php echo site_url('crud/delete'); ?>',{id:row.id},function(result){
                    if (result.success){
                        jQuery('#datagrid-crud').datagrid('reload');
                    } else {
                        jQuery.messager.show({
                            title: 'Error',
                            msg: result.msg
                        });
                    }
                },'json');
            }
        });
    }
}
</script>
 
<!-- Data Grid -->
<table id="datagrid-crud" title="Mobil" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('crud/index'); ?>?grid=true" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="id" width="30" sortable="true">ID</th>
            <th field="type" width="50" sortable="true">Type</th>
            <th field="barang" width="50" sortable="true">Barang</th>
            <th field="harga" width="50" sortable="true">Harga</th>
        </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="create()">Tambah Mobil</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="update()">Edit Mobil</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="remove()">Hapus Mobil</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" style="width:400px; height:200px; padding: 10px 20px" closed="true" buttons="#dialog-buttons">
    <form id="form" method="post" novalidate>
        <div class="form-item">
            <label for="type">Type</label><br />
            <input type="text" name="type" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Barang</label><br />
            <input type="text" name="barang" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Harga</label><br />
            <input class="easyui-numberbox" name="harga" data-options="precision:2,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" class="easyui-validatebox" required="true" />
        </div>
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>