<script type="text/javascript">
var url;
 
function createCustomer(){
    jQuery('#dialog-form-customer').dialog('open').dialog('setTitle','Tambah customer');
    jQuery('#form-customer').form('clear');
    url = '<?php echo base_url('c_customer/create'); ?>';
}
 
function updateCustomer()
{
    var row = jQuery('#datagrid-crud-customer').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form-customer').dialog('open').dialog('setTitle','Edit Customer');
        jQuery('#form-customer').form('load',row);
        url = '<?php echo base_url('c_customer/update'); ?>/' + row.cust_id;
    }
}
 
function saveCustomer(){
    jQuery('#form-customer').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form-customer').dialog('close');
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
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this customer?',function(r){
            if (r){
                jQuery.post('<?php echo site_url('c_customer/delete'); ?>',{cust_id:row.cust_id},function(result){
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
<table id="datagrid-crud-customer" title="customer" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('c_customer/index'); ?>?grid=true" toolbar="#toolbar-customer" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="cust_id" width="30" sortable="true">Kode Customer</th>
            <th field="cust_name" width="50" sortable="true">Nama </th>
            <th field="address" width="50" sortable="true">alamat</th>
            <th field="telp" width="50" sortable="true">telpon</th>
            <th field="disc_persen" width="50" sortable="true">Diskon Persen</th>
            <th field="disc_rupiah" width="50" sortable="true">Diskon rupiah</th>
        </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar-customer">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="createCustomer()">Tambah Barang</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateCustomer()">Edit Barang</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeCustomer()">Hapus Barang</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form-customer" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-customer">
    <form id="form-customer" method="post" novalidate>
        <div class="form-item">
            <label for="type">kode Customer</label><br />
            <input type="text" name="cust_id" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">nama </label><br />
            <input type="text" name="cust_name" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Alamat</label><br />
            <input type="text" name="address" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Telpon</label><br />
            <input type="text" name="telp" data-options="precision:2,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" class="easyui-validatebox" required="true" />
        </div>
        <div class="form-item">
            <label for="type">Disc Persen</label><br />
            <input class="easyui-numberbox" name="disc_persen" data-options="precision:2,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" class="easyui-validatebox" required="true" />
        </div>
        <div class="form-item">
            <label for="type">Disc Rupiah</label><br />
            <input class="easyui-numberbox" name="disc_rupiah" data-options="precision:2,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" class="easyui-validatebox" required="true" />
        </div>
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-customer">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveCustomer()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-customer').dialog('close')">Batal</a>
</div>