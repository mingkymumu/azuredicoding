<script type="text/javascript">
//definisi awal variabel isEdit untuk mengetahui form dalam keadaan edit atau new
var isEdit = false;
//memanggil fungsi untuk generate nomor bukti
jQuery(document).ready(function() {
    getNewBukti();
	// 1 Capitalize string - convert textbox user entered text to uppercase
	jQuery('.easyui-validatebox').keyup(function() {
		$(this).val($(this).val().toUpperCase());
    });
});

//fungsi clear form 
function clearForm()
{
           $('#no_bukti').textbox('setValue','');
           $('#cust_id').textbox('setValue','');
           $('#tgl').textbox('setValue','');
           $('#ppn').textbox('setValue','');
           $('#cust_name').textbox('setValue','');
           $('#total_nilai').textbox('setValue','');
           $('#datagrid-detail-jual').datagrid('loadData',{'total':0,rows:[]});
           getNewBukti();
           isEdit=false;
}

function getNewBukti()
{
     $.ajax({
		type	: 'POST',
		url     : "<?php echo base_url('c_penjualan/generateBukti'); ?>",
		cache	: false,
                success	: function(data){
			  console.log(data);
			    $('#no_bukti').textbox('setValue',data);
                    }
                });
}

function callPopup()
{
     $('#dialog-pop-customer').dialog('open').dialog('setTitle','Tambah customer');
}
function callPopupJual()
{
     $('#datagrid-pop-penjualan').datagrid('load',{berdasarkan:'',cari:''});
     $('#dialog-pop-penjualan').dialog('open').dialog('setTitle','penjualan');
}
function cari()
{
    var berdasarkan = $('#cb_dasar').combobox('getValue');
    var cr  = $('#cr').textbox('getValue');
    $.ajax({
		type	: 'POST',
		url     : "<?php echo base_url('c_customer/getBy'); ?>",
		cache	: false,
                data    :{berdasarkan:berdasarkan,cari:cr},
		success	: function(data){
			console.log(data);
			$('#datagrid-pop-customer').datagrid('reload', {
				berdasarkan: berdasarkan,
				cari: cr
				
			});
                       // $('#datagrid-pop-customer').datagrid('reload');
                    }
                });
}
function cariPenjualan()
{
    var berdasarkan = $('#cb_dasar-penjualan').combobox('getValue');
    var cr  = $('#cr-penjualan').textbox('getValue');
    $.ajax({
		type	: 'POST',
		url     : "<?php echo base_url('c_penjualan/getBy'); ?>",
		cache	: false,
                data    :{berdasarkan:berdasarkan,cari:cr},
		success	: function(data){
			console.log(data);
			$('#datagrid-pop-penjualan').datagrid('reload', {
				berdasarkan: berdasarkan,
				cari: cr
				
			});
                      //  $('#datagrid-pop-penjualan').datagrid('reload');
                    }
                });
}
 $('#cust_id').textbox({
 onClickButton:function()
    {
       callPopup();
    }});
    
 $('#no_bukti').textbox({
 onClickButton:function()
    {
       callPopupJual();
    }});
    
    
  $('#datagrid-pop-customer').datagrid({
      onClickRow : function(index,row)
      {
           $('#cust_id').textbox('setValue',row.cust_id);
           $('#cust_name').textbox('setValue',row.cust_name);
           $('#dialog-pop-customer').dialog('close');
         
      }
    
    
    });
  $('#datagrid-pop-penjualan').datagrid({
      onClickRow : function(index,row)
      {
           $('#no_bukti').textbox('setValue',row.no_bukti);
           $('#cust_id').textbox('setValue',row.cust_id);
           $('#tgl').textbox('setValue',row.tgl);
           $('#ppn').textbox('setValue',row.ppn);
           $('#cust_name').textbox('setValue',row.cust_name);
           $('#total_nilai').textbox('setValue',row.total_nilai);
           $('#datagrid-detail-jual').datagrid('reload',{no_bukti:row.no_bukti});
          // $('#datagrid-detail-jual').datagrid('reload');
           $('#dialog-pop-penjualan').dialog('close');
             isEdit=true;
      }
    
    
    });
    var editIndex = undefined;
    var nomor = 0;
    var no_bukti ="";  
       
       
        function append(){
               no_bukti = $('#no_bukti').textbox('getValue');
               nomor = $('#datagrid-detail-jual').datagrid('getRows').length; 
              //menambahkan row baru pada grid detail 
              $('#datagrid-detail-jual').datagrid('appendRow',{nomor:nomor+1,no_bukti:no_bukti});
                editIndex = $('#datagrid-detail-jual').datagrid('getRows').length-1;
                $('#datagrid-detail-jual').datagrid('selectRow', editIndex)
                        .datagrid('beginEdit', editIndex);
               
                
        }

        function removeit(){
            $('#datagrid-detail-jual').datagrid('deleteRow', editIndex);
            var x = $('#datagrid-detail-jual').datagrid('getRows').length; 
           if(x>0)
           {
               for(i=0;x;i++)
               {
                  index=i;
                  $('#datagrid-detail-jual').datagrid('updateRow', {index:index,row:{nomor:i+1}}); 
               }
           }
           nomor = $('#datagrid-detail-jual').datagrid('getRows').length;
        }
        function accept(){
                $('#datagrid-detail-jual').datagrid('acceptChanges');
                saveDetailPenjualan();
                
        }
        function reject(){
            $('#datagrid-detail-jual').datagrid('rejectChanges');
            
        }
        function getChanges(){
            var rows = $('#datagrid-detail-jual').datagrid('getRows');
              $('#datagrid-detail-jual').datagrid('acceptChanges');
              if(rows.length>0)
              {
                 var total = 0;
                for(var i=0;i<rows.length;i++)
                {
                    total+= parseFloat(rows[i]['harga_total']);
                }
                 $('#total_nilai').textbox('setValue',total);
            }
              
            //alert(rows.length+' rows are changed!');
           // console.log(total);
        }
        
        
   
     
     
     function updateRow(index,row)
     {

     var ed1 =$('#datagrid-detail-jual').datagrid('getEditor',{index:editIndex,field:'harga_satuan'})
     var ed2 =$('#datagrid-detail-jual').datagrid('getEditor',{index:editIndex,field:'nama_barang'})
         
        if (ed1 && ed2){
                  //($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                  $(ed1.target).textbox('setValue', row.harga_jual);
                  $(ed2.target).textbox('setValue', row.nama_barang);
                }
        
     }
     
     var lastIndex;
   $('#datagrid-detail-jual').datagrid({
    onClickRow:function(rowIndex){
        if (lastIndex != rowIndex){
            $(this).datagrid('endEdit', lastIndex);
            $(this).datagrid('beginEdit', rowIndex);
        }
        lastIndex = rowIndex;
    },
    onBeginEdit:function(rowIndex){
        var tot = $('#total_nilai').textbox();
        var editors = $('#datagrid-detail-jual').datagrid('getEditors', rowIndex);
         var rows = $('#datagrid-detail-jual').datagrid('getRows');
         var total = 0;
        var n1 = $(editors[2].target);
        var n2 = $(editors[3].target);
        var n3 = $(editors[4].target);
        n1.add(n2).numberbox({
            onChange:function(){
                var cost = n1.numberbox('getValue')*n2.numberbox('getValue');
                n3.numberbox('setValue',cost);
                n3.add(tot);
            }
        });
    }
});
        $.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y; //e.g. 12-03-1966 (= 12 March 1966)
	};
	$.fn.datebox.defaults.parser = function(s){
		if (!s) return new Date();
		var ss = s.split('-');
		var d = parseInt(ss[0],10);
		var m = parseInt(ss[1],10);
		var y = parseInt(ss[2],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
			return new Date(y,m-1,d);
		} else {
			return new Date();
		}
	};
        
        
 function deleteJual()
 {
     var no_bukti =$('#no_bukti').textbox('getValue') ;
      jQuery.messager.confirm('Confirm','Are you sure you want to remove this Penjualan?',function(r){
            if (r){
                jQuery.post('<?php echo site_url('c_penjualan/delete'); ?>',{no_bukti:no_bukti},function(result){
                    if (result.success){
                        alert('data '+no_bukti +'telah di hapus');
                        clearForm();
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
 
 function saveHeaderJual(){
       var url='';
       var no_bukti =$('#no_bukti').textbox('getValue') ;
       getChanges();
       if(!isEdit)
       {
           url = '<?php echo base_url('c_penjualan/createHeaderPenjualan'); ?>'
       }
       else
       {
           url ='<?php echo base_url('c_penjualan/updateHeaderPenjualan'); ?>/'+no_bukti;
       }
        jQuery('#form-penjualan').form('submit',{
        url:url ,
        onSubmit: function(){
            return jQuery(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if(result.success){
              if(isEdit)
              {
                  saveDetailPenjualan();
                  
              }
             alert('Data '+no_bukti+' Tersimpan');
             clearForm();
              
            } else {
                jQuery.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
}

    function saveDetailPenjualan()
    {
    var rows = $('#datagrid-detail-jual').datagrid('getRows');
    $.each(rows, function(i, row) {
      $('#datagrid-detail-jual').datagrid('updateRow',{
          index:i,row:{nomor:i+1}
          
      });
      $.ajax("<?php echo base_url('c_penjualan/createDetailPenjualan'); ?>", {
        type:'POST',
        dataType: 'json',
        data:row
      });
    });
    }
</script>

<div id="toolbarx" style = "padding: 5px 5px; background: #fafafa; width: 100%; border: 1px solid #ccc">
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="saveHeaderJual()"> Save </a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="clearForm()"> Add New </a>
    <a href="#" class="easyui-linkbutton" onclick="deleteJual()" iconCls="icon-remove">Delete  </a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-search"> Search </a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-print"> Print </a>
  </div>
<div class="easyui-panel" title="Header" style="padding:5px 5px;width: 100%;height: 100%" toolbar="#toolbarx">
   
    <div class="easyui-layout" data-options="fit:true">
        
        <div data-options="region:'north'" style="width:100%;height:40%; padding:1px;border:0">
            <form method="post" id="form-penjualan">
            <div class="easyui-panel" style="width:100%;padding:2px 2px;">
                <div  style="margin-bottom:5px">
                    <input id="tgl" name="tgl" class="easyui-datebox"  style="width:70%;" data-options="label:'tanggal:'">
                </div>
                <div style="margin-bottom:5px">
                    <input class="easyui-textbox" name="no_bukti" id="no_bukti" style="width:70%" data-options="label:'No.Bukti:',iconCls:'icon-search',buttonText:'search'">
                </div>
                <div style="margin-bottom:5px">
                    <input class="easyui-numberbox" id="ppn" name="ppn" style="width:70%" data-options="label:'ppn:'">
                </div>
               
                <div style="margin-bottom:5px">
                    <input id="cust_id" name="cust_id" class="easyui-textbox" data-options="iconCls:'icon-search',buttonText:'search',label:'customer:'" style="width:70%">
                </div>
                <div style="margin-bottom:5px">
                    <input id="cust_name"  class="easyui-textbox" name="cust_name" style="width:70%" data-options="label:'nama:'">
                </div>
                 <div style="margin-bottom:5px">
                     <input class="easyui-numberbox" id="total_nilai" name="total_nilai" style="width:70%" data-options="label:'total:'">
                </div>
            </div>
            </form>
            </div>
       
        <!--<div data-options="region:'east'" style="width:50%;padding:1px;border:0">-->
           
        <!--</div>-->
          <div data-options="region:'south'" style="padding:5px;height:50%">
              <table id="datagrid-detail-jual" title="Detail Penjualan" class="easyui-datagrid" style="width:auto; height: auto;" data-options="rownumbers:true,fitColumns:true,singleSelect:true,collapsible:true,url:'<?php echo base_url('c_penjualan/getJsonJualDetail'); ?>',toolbar:'#tbgrid',onSelect:function(index){editIndex=index;}" >
        <thead>
            <tr>
                <th field="nomor" width="30" sortable="false" hidden="true">nomor</th>
                <th field="no_bukti" width="30" sortable="false" hidden="true">nomor bukti</th>
                <th  data-options="field:'kode_barang',
                                   width:'30',
                                   sortable:false,
                                   editor:{
                                      type:'combogrid',
                                      options:{
                                        panelWidth:700,
                                        url :'<?php echo base_url('c_barang/index'); ?>?grid=true',
                                        idField:'kode_barang',
                                        textField:'kode_barang',
                                        mode:'remote',
                                        fitColumns:true,
                                        filter: function(q, row){
                                                var opts = $(this).combogrid('options');
                                                return row[opts.textField].indexOf(q) == 0;
	                                                          },
                                        columns:[[
                                         {field:'kode_barang',title:'kode barang',width:50,sortable:true},
                                         {field:'nama_barang',title:'Nama Barang',width:80,sortable:true},
                                         {field:'tipe',title:'tipe',width:60},
                                         {field:'deskripsi',title:'deskripsi',width:60},
                                         {field:'harga_jual',title:'harga jual',align:'right',width:60},
                                         {field:'harga_beli',title:'harga beli',align:'right',width:60}
                                        ]]
                                      
                                      ,
                                      onSelect: function(rec)
                                      {
                                       var g = $(this).datagrid('getSelected');
                                       updateRow(editIndex,g); 
                                      }
                                     }  
                                       }">kode barang </th>
                <th data-options="field:'nama_barang',width:'50',sortable:'false',editor:'textbox'" >nama barang</th>
                <th data-options="field:'qty',width:'50',sortable:'false',editor:{type:'numberbox',options:{precision:0}}">qty</th>
                <th data-options="field:'harga_satuan',width:'50',sortable:'false',editor:{type:'numberbox',options:{precision:0}}">harga satuan</th>
                <th data-options="field:'harga_total',width:'50',sortable:'false',editor:{type:'numberbox',options:{precision:0}}">harga total</th>
            </tr>
        </thead>
    </table>  
        </div>
     </div>
    </div>    

</div>    

<div id="dialog-pop-customer" class="easyui-dialog" style="width:800px; height:400px; padding: 1px 1px" closed="true" buttons="#dialog-buttons-pop-cust">
    <table id="datagrid-pop-customer" title="customer" class="easyui-datagrid" style="width:auto; height: auto;" data-options="rownumbers:true,fitColumns:true,singleSelect:true,collapsible:true,url:'<?php echo base_url('c_customer/getBy'); ?>',toolbar:'#tb'" >
        <thead>
            <tr>
                <th field="cust_id" width="30" sortable="false">Kode Customer</th>
                <th field="cust_name" width="50" sortable="false">Nama </th>
                <th field="address" width="50" sortable="false">alamat</th>
                <th field="telp" width="50" sortable="false">telpon</th>
                <th field="disc_persen" width="50" sortable="false">Diskon Persen</th>
                <th field="disc_rupiah" width="50" sortable="false">Diskon rupiah</th>
            </tr>
        </thead>
    </table>  
</div>

<!-- Dialog Button -->
<div id="dialog-buttons-pop-cust">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-pop-customer').dialog('close')">close</a>
</div>

<div id="tb" style="padding:2px 5px;">
    Berdasarkan: 
    <select id="cb_dasar" name="cb_dasar" class="easyui-combobox" panelHeight="auto" style="width:120px" >
        <option value="cust_id">ID Customer</option>
        <option value="cust_name">Nama Customer</option>
    </select>
    <input type="text" class="easyui-textbox" name="cari" id="cr"/>
    <a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="cari()">Search</a>
</div>           

  <div id="tbgrid" style="height:auto">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Accept</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reject</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>
    </div>


<div id="dialog-pop-penjualan" class="easyui-dialog" style="width:800px; height:400px; padding: 1px 1px" closed="true" buttons="#dialog-buttons-pop-penjualan">
    <table id="datagrid-pop-penjualan" title="penjualan" class="easyui-datagrid" style="width:auto; height: auto;" data-options="rownumbers:true,fitColumns:true,singleSelect:true,collapsible:true,url:'<?php echo base_url('c_penjualan/getBy'); ?>',toolbar:'#tb-penjualan'" >
        <thead>
            <tr>
                <th field="no_bukti" width="30" sortable="false">No Bukti</th>
                <th field="tgl" width="50" sortable="false" >tgl </th>
                <th field="total_nilai" width="50" sortable="false">Total Nilai</th>
                <th field="cust_name" width="50" sortable="false">Customer</th>
                <th field="cust_id" width="50" sortable="false" hidden="true">Customer</th>
                <th field="ppn" width="50" sortable="false" hidden="true">Customer</th>
                
            </tr>
        </thead>
    </table>  
</div>

<div id="dialog-buttons-pop-penjualan">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-pop-penjualan').dialog('close')">close</a>
</div>

<div id="tb-penjualan" style="padding:2px 5px;">
    Berdasarkan: 
    <select id="cb_dasar-penjualan" name="cb_dasar" class="easyui-combobox" panelHeight="auto" style="width:120px" >
        <option value="no_bukti">no bukti</option>
        <option value="cust_name">Nama Customer</option>
    </select>
    <input type="text" class="easyui-textbox" name="cari" id="cr-penjualan"/>
    <a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="cariPenjualan()">Search</a>
</div>         