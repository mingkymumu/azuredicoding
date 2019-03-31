<script type="text/javascript">
var url;
 
function createRole(){
    jQuery('#dialog-form-role').dialog('open').dialog('setTitle','Tambah Menu');
    jQuery('#form-role').form('clear');
    url = '<?php echo base_url('c_role/create');?>';
}
 
function updateRole(){
    var row = jQuery('#datagrid-crud-role').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form-role').dialog('open').dialog('setTitle','Edit Menu');
        jQuery('#form-role').form('load',row);
        url = '<?php echo base_url('c_role/update'); ?>/' + row.role_id;
    }
}
 
function saveRole(){
    
    jQuery('#form-role').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form-role').dialog('close');
                jQuery('#datagrid-crud-role').datagrid('reload');
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
    var row = jQuery('#datagrid-crud-role').datagrid('getSelected');
    if (row){
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this role?',function(r){
            if (r){
            alert(row.role_id);   
            jQuery.post('<?php echo site_url('c_role/delete'); ?>',{role_id:row.role_id},function(result){
                    if (result.success){
                        jQuery('#datagrid-crud-role').datagrid('reload');
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
<table id="datagrid-crud-role" title="Menu" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('c_role/index'); ?>?grid=true" toolbar="#toolbar-role" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="role_id" width="30" sortable="true">id</th>
            <th field="role_name" width="50" sortable="true">Nama Role</th>
            <th field="desc" width="50" sortable="true">Deskripsi</th>
        </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar-role">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="createRole()">Tambah Role</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateRole()">Edit Role</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeRole()">Hapus Role</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form-role" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-role">
    <form id="form-role" method="post" novalidate>
        <div class="form-item">
            <label for="type">role id</label><br />
            <input class="easyui-numberbox" name="role_id" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Nama Role</label><br />
            <input type="text" name="role_name" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Deskripsi</label><br />
            <input type="text" name="desc" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-role">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRole()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-role').dialog('close')">Batal</a>
</div>


