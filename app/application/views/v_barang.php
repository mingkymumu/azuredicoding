<script type="text/javascript">
var url;
 
function createBarang(){
    jQuery('#dialog-form-barang').dialog('open').dialog('setTitle','Tambah Barang');
    jQuery('#form-barang').form('clear');
    url = '<?php echo base_url('c_barang/create'); ?>';
}
 
function updateBarang(){
    var row = jQuery('#datagrid-crud-barang').datagrid('getSelected');
    if(row){
        jQuery('#dialog-form-barang').dialog('open').dialog('setTitle','Edit Barang');
        jQuery('#form-barang').form('load',row);
        url = '<?php echo base_url('c_barang/update'); ?>/' + row.kode_barang;
    }
}
 
function saveBarang(){
    jQuery('#form-barang').form('submit',{
        url: url,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
                jQuery('#dialog-form-barang').dialog('close');
                jQuery('#datagrid-crud-barang').datagrid('reload');
            } else {
                jQuery.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}
 
function removeBarang(){
    var row = jQuery('#datagrid-crud-barang').datagrid('getSelected');
    if (row){
        jQuery.messager.confirm('Confirm','Are you sure you want to remove this barang?',function(r){
            if (r){
                jQuery.post('<?php echo site_url('c_barang/delete'); ?>',{kode_barang:row.kode_barang},function(result){
                    if (result.success){
                        jQuery('#datagrid-crud-barang').datagrid('reload');
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
<table id="datagrid-crud-barang" title="barang" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo base_url('c_barang/index'); ?>?grid=true" toolbar="#toolbar-barang" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
    <thead>
        <tr>
            <th field="kode_barang" width="30" sortable="true">Kode Barang</th>
            <th field="nama_barang" width="50" sortable="true">Nama Barang</th>
            <th field="tipe" width="50" sortable="true">type</th>
            <th field="deskripsi" width="50" sortable="true">deskripsi</th>
            <th field="harga_beli" width="50" sortable="true">Harga Beli</th>
            <th field="harga_jual" width="50" sortable="true">Harga Jual</th>
            <th field="satuan" width="50" sortable="true">Satuan</th>
          </tr>
    </thead>
</table>
 
<!-- Toolbar -->
<div id="toolbar-barang">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="createBarang()">Tambah Barang</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="updateBarang()">Edit Barang</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeBarang()">Hapus Barang</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="$('#datagrid-crud-barang').datagrid('toExcel','dg.xls')">ExportToExcel</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" onclick="$('#datagrid-crud-barang').datagrid('print','DataGrid')">Print</a>
</div>
 
<!-- Dialog Form -->
<div id="dialog-form-barang" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-barang">
    <form id="form-barang" method="post" novalidate>
        <div class="form-item">
            <label for="type">kode barang</label><br />
            <input type="text" name="kode_barang" class="easyui-textbox"           />
        </div>
        <div class="form-item">
            <label for="type">nama barang</label><br />
            <input type="text" name="nama_barang" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">deskripsi</label><br />
            <input type="text" name="deskripsi" class="easyui-validatebox" required="true" size="53" maxlength="50" />
        </div>
        <div class="form-item">
            <label for="type">Type</label><br />
             <input id="tipe" class="easyui-combobox" name="tipe"
                   data-options="valueField:'type_name',textField:'type_name',url:'<?php echo base_url(); ?>c_type/getValCombo'">
        </div>
        <div class="form-item">
            <label for="type">Harga Beli</label><br />
            <input class="easyui-numberbox" name="harga_beli" data-options="precision:2,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" class="easyui-validatebox" required="true" />
        </div>
        <div class="form-item">
            <label for="type">Harga Jual</label><br />
            <input class="easyui-numberbox" name="harga_jual" data-options="precision:2,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" class="easyui-validatebox" required="true" />
        </div>
        <div class="form-item">
            <label for="type">Satuan</label><br />
            <input id="satuan" class="easyui-combobox" name="satuan"
                   data-options="valueField:'nama_satuan',textField:'nama_satuan',url:'<?php echo base_url(); ?>c_satuan/getValCombo'">
        </div>
    </form>
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-barang">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveBarang()">Simpan</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-barang').dialog('close')">Batal</a>
</div>