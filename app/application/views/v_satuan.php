<script type="text/javascript">
var url;
 
function createSatuan(){
    jQuery('#dialog-form-satuan').dialog('open').dialog('setTitle','Tambah Satuan');
    jQuery('#form-satuan').form('clear');
    url = '<?php echo base_url('c_satuan/create');?>';
}
 
function updateSatuan(){
    var row = jQuery('#datagrid-crud-satuan').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form-satuan').dialog('open').dialog('setTitle','Edit Satuan');
        jQuery('#form-satuan').form('load',row);
        url = '<?php echo base_url('c_satuan/update'); ?>/' + row.kode_satuan;
    }
}
 
function saveSatuan(){
    
    jQuery('#form-satuan').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form-satuan').dialog('close');
                jQuery('#datagrid-crud-satuan').datagrid('reload');
            } else {
                jQuery.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}
 
function removeSatuan(){
    var row = jQuery('#datagrid-crud-satuan').datagrid('getSelected');
    if (row){
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this satuan?',function(r){
            if (r){
            alert(row.kode_satuan);   
            jQuery.post('<?php echo site_url('c_satuan/delete'); ?>',{kode_satuan:row.kode_satuan},function(result){
                    if (result.success){
                        jQuery('#datagrid-crud-satuan').datagrid('reload');
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
<table id="datagrid-crud-satuan" title="Menu" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('c_satuan/index'); ?>?grid=true" toolbar="#toolbar-satuan" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="kode_satuan" width="30" sortable="true">kode satuan</th>
            <th field="nama_satuan" width="50" sortable="true">Nama Satuan</th>
            <th field="desc" width="50" sortable="true">Deskripsi</th>
        </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar-satuan">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="createSatuan()">Tambah Satuan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateSatuan()">Edit satuan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeSatuan()">Hapus satuan</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form-satuan" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-satuan">
    <form id="form-satuan" method="post" novalidate>
        <div class="form-item">
            <label for="type">kode satuan</label><br />
            <input class="easyui-numberbox" name="kode_satuan" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Nama satuan</label><br />
            <input type="text" name="nama_satuan" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Deskripsi</label><br />
            <input type="text" name="desc" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-satuan">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveSatuan()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-satuan').dialog('close')">Batal</a>
</div>


