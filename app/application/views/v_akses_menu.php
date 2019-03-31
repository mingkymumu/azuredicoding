<script>
    var x = "";
    var y = 0;
    $('#dl').datalist({
        url: '<?php echo base_url(); ?>c_role/getValCombo',
        valueField: 'role_id',
        textField: 'role_name',
        line: true,
        // todo: buat fungsi untuk load isi checkbox ke tree menu
        onClickRow: function (index, row) {

            $.ajax({
                url: '<?php echo base_url(); ?>/c_tree_menu/getJsonMenuByRole',
                type: 'POST',
                data: {id: row.role_id},
                success: function (resp) {
                    x = resp;
                    y = row.role_id;
                    setChecked(x);
                },
                dataType: 'json'
            });

        }

    });
   

    function setChecked(rows) {
        //di uncheck semua node yg ter check
        var nodes = $('#tx').tree('getChecked');
        for (var i = 0; i < nodes.length; i++)
        {
            $('#tx').tree('uncheck', nodes[i].target);
        }
        //check ulang semua node sesuai database
        for (var i = 0; i < rows.length; i++) {
            var node = $('#tx').tree('find', rows[i].id);
            $('#tx').tree('check', node.target);
        }

    }
    function saveRoleMenu()
    {
        if (y == 0)
        {
            alert('pilih Salah satu Role');
        }
        else
        {
            var nodes = $('#tx').tree('getChecked',['checked','indeterminate']);
            var arr = [];
            for( var i=0;i<nodes.length;i++)
            {
                arr[i]= nodes[i].id;
            }
               $.ajax({
                    url: '<?php echo base_url();?>/c_tree_menu/createRoleMenu',
                    type: 'POST',
                    data: {role_id: y,data:arr},
                    success: function (resp) {
                        alert(arr);
                    },
                    cache: false
                });
            }
        }
    
</script>      

<div class="easyui-layout" style="width:100%;height:100%;">
    <!--<div data-options="region:'east',split:true" title="East" style="width:20%;"></div>-->
    <div data-options="region:'west',split:true" title="West" style="width:20%;">
        <div class="easyui-panel" title="Role Menu" >
            <input id="dl" name="cc" >
        </div>
    </div>
    <div data-options="region:'center',title:'Role & Menu Administration'">
        <div class="easyui-panel"  data-options="title:'Menu Tree',tools:'#tab-tools'">
        <ul id="tx" class="easyui-tree" data-options="url:'<?php echo base_url(); ?>/c_tree_menu/generateJsonTree',checkbox:'true'">
        </ul>
       
      </div>
      <div id="tab-tools">
           <a href="javascript:void(0)" class="icon-save"  onclick="saveRoleMenu()"></a>
      </div>
    </div>
</div>