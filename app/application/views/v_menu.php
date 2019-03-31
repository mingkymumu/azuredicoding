<script type="text/javascript">
var url;
 
function createMenu(){
    jQuery('#dialog-form-menu').dialog('open').dialog('setTitle','Tambah Menu');
    jQuery('#form-menu').form('clear');
    url = '<?php echo base_url('c_menu/create');?>';
}
 
function updateMenu(){
    var row = jQuery('#datagrid-crud-menu').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form-menu').dialog('open').dialog('setTitle','Edit Menu');
        jQuery('#form-menu').form('load',row);
        url = '<?php echo base_url('c_menu/update'); ?>/' + row.id;
    }
}
 
function saveMenu(){
    
    jQuery('#form-menu').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form-menu').dialog('close');
                jQuery('#datagrid-crud-menu').datagrid('reload');
            } else {
                jQuery.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}
 
function removeMenu(){
    var row = jQuery('#datagrid-crud-menu').datagrid('getSelected');
    if (row){
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this menu?',function(r){
            if (r){
            alert(row.id);   
            jQuery.post('<?php echo site_url('c_menu/delete'); ?>',{id:row.id},function(result){
                    if (result.success){
                        jQuery('#datagrid-crud-menu').datagrid('reload');
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
<table id="datagrid-crud-menu" title="Menu" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('c_menu/index'); ?>?grid=true" toolbar="#toolbar-menu" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="id" width="30" sortable="true">id</th>
            <th field="title" width="50" sortable="true">Nama Menu</th>
            <th field="link" width="50" sortable="true">link</th>
            <th field="parent_id" width="50" sortable="true">parent Id</th>
            <th field="url" width="50" sortable="true">url</th>
        </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar-menu">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="createMenu()">Tambah Menu</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateMenu()">Edit Menu</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeMenu()">Hapus Menu</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form-menu" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-menu">
    <form id="form-menu" method="post" novalidate>
        <div class="form-item">
            <label for="type">id</label><br />
            <input type="text" name="id" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Nama Menu</label><br />
            <input type="text" name="title" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">link</label><br />
            <input type="text" name="link" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">parent id</label><br />
            <input class="easyui-numberbox" name="parent_id"  class="easyui-validatebox" required="true" />
        </div>
        <div class="form-item">
            <label for="type">url</label><br />
            <input type="text" name="url"  class="easyui-validatebox" required="true" />
        </div>
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-menu">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveMenu()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-menu').dialog('close')">Batal</a>
</div>


