<script type="text/javascript">
var url;
 
function createType(){
    jQuery('#dialog-form-type').dialog('open').dialog('setTitle','Tambah Type');
    jQuery('#form-type').form('clear');
    url = '<?php echo base_url('c_type/create');?>';
}
 
function updateRole(){
    var row = jQuery('#datagrid-crud-type').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form-type').dialog('open').dialog('setTitle','Edit Type');
        jQuery('#form-type').form('load',row);
        url = '<?php echo base_url('c_type/update'); ?>/' + row.type_id;
    }
}
 
function saveRole(){
    
    jQuery('#form-type').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form-type').dialog('close');
                jQuery('#datagrid-crud-type').datagrid('reload');
            } else {
                jQuery.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}
 
function removeRole(){
    var row = jQuery('#datagrid-crud-type').datagrid('getSelected');
    if (row){
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this type?',function(r){
            if (r){
              
            jQuery.post('<?php echo site_url('c_type/delete'); ?>',{type_id:row.type_id},function(result){
                    if (result.success){
                        jQuery('#datagrid-crud-type').datagrid('reload');
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
jQuery(document).ready(function() {
	
	// 1 Capitalize string - convert textbox user entered text to uppercase
	jQuery('.easyui-validatebox').keyup(function() {
		$(this).val($(this).val().toUpperCase());
    });
});
</script>
 
<!-- Data Grid -->
<table id="datagrid-crud-type" title="type" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('c_type/index'); ?>?grid=true" toolbar="#toolbar-type" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="type_id" width="30" sortable="true">id</th>
            <th field="type_name" width="50" sortable="true">Nama Type</th>
            <th field="desc" width="50" sortable="true">Deskripsi</th>
        </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar-type">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="createType()">Tambah Type</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateRole()">Edit Type</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeRole()">Hapus Type</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form-type" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-type">
    <form id="form-type" method="post" novalidate>
        <div class="form-item">
            <label for="type">type id</label><br />
            <input class="easyui-numberbox" name="type_id" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Nama Type</label><br />
            <input type="text" name="type_name" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Deskripsi</label><br />
            <input type="text" name="desc" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-type">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRole()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-type').dialog('close')">Batal</a>
</div>


