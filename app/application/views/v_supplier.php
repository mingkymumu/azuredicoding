<script type="text/javascript">
var url;
 
function createSupplier(){
    jQuery('#dialog-form-supplier').dialog('open').dialog('setTitle','Tambah Supplier');
    jQuery('#form-supplier').form('clear');
    url = '<?php echo base_url('c_supplier/create'); ?>';
}
 
function updateSupplier()
{
    var row = jQuery('#datagrid-crud-customer').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form-supplier').dialog('open').dialog('setTitle','Edit supplier');
        jQuery('#form-supplier').form('load',row);
        url = '<?php echo base_url('c_supplier/update'); ?>/' + row.sup_id;
    }
}
 
function saveSupplier(){
    jQuery('#form-supplier').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form-supplier').dialog('close');
                jQuery('#datagrid-crud-customer').datagrid('reload');
            } else {
                jQuery.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}
 
function removeCustomer(){
    var row = jQuery('#datagrid-crud-customer').datagrid('getSelected');
    if (row){
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this supplier?',function(r){
            if (r){
                jQuery.post('<?php echo site_url('c_supplier/delete'); ?>',{sup_id:row.sup_id},function(result){
                    if (result.success){
                        jQuery('#datagrid-crud-customer').datagrid('reload');
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
<table id="datagrid-crud-customer" title="customer" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('c_supplier/index'); ?>?grid=true" toolbar="#toolbar-supplier" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="sup_id" width="30" sortable="true">Kode Suplier</th>
            <th field="sup_name" width="50" sortable="true">Nama </th>
            <th field="address" width="50" sortable="true">alamat</th>
            <th field="telp" width="50" sortable="true">telpon</th>
            
        </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar-supplier">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="createSupplier()">Tambah Supplier</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateSupplier()">Edit Supplier</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeCustomer()">Hapus Supplier</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form-supplier" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-customer">
    <form id="form-supplier" method="post" novalidate>
        <div class="form-item">
            <label for="type">kode Supplier</label><br />
            <input type="text" name="sup_id" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">nama </label><br />
            <input type="text" name="sup_name" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Alamat</label><br />
            <input type="text" name="address" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Telpon</label><br />
            <input type="text" name="telp" data-options="precision:2,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" class="easyui-validatebox" required="true" />
        </div>
        
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-customer">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveSupplier()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-supplier').dialog('close')">Batal</a>
</div>