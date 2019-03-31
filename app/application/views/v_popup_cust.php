<div id="dialog-pop-customer" class="easyui-dialog" style="width:600px; height:400px; padding: 10px 20px" closed="true" buttons="#dialog-buttons-pop-cust">
   <table id="datagrid-pop-customer" title="customer" class="easyui-datagrid" style="width:auto; height: auto;" url="<?php echo site_url('c_customer/index'); ?>?grid=true" toolbar="#toolbar-customer" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true">
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
</div>
 
<!-- Dialog Button -->
<div id="dialog-buttons-pop-cust">
     <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form-customer').dialog('close')">close</a>
</div>