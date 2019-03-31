<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/metro-blue/easyui.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/icon.css'); ?>">
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.easyui.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/datagrid-export.js'); ?>"></script>
        <script type="text/javascript" src="//rajaongkir.com/script/widget.js"></script>
        <script>
            var x = "";
            function convert(rows) {
                function exists(rows, parentId) {
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].id == parentId)
                            return true;
                    }
                    return false;
                }

                var nodes = [];
                // get the top level nodes

                for (var i = 0; i < rows.length; i++) {
                    var row = rows[i];
                    if (!exists(rows, row.parent_id)) {
                        nodes.push({
                            id: row.id,
                            text: row.text,
                            state: 'closed'
                        });
                    }
                }

                var toDo = [];
                for (var i = 0; i < nodes.length; i++) {
                    toDo.push(nodes[i]);
                    console.log(nodes[i]);
                }
                while (toDo.length) {
                    var node = toDo.shift();	// the parent node
                    // get the children nodes
                    for (var i = 0; i < rows.length; i++) {
                        var row = rows[i];
                        if (row.parent_id == node.id) {
                            var child = {id: row.id, text: row.text};
                            if (node.children) {
                                node.children.push(child);
                            } else {
                                node.children = [child];
                            }
                            toDo.push(child);
                        }
                    }
                }
                return nodes;
            }

            $(document).ready(function ()
            {

                // $('input[type=text]').keyup(function(e){ if (e.which >= 65) { $(this).val( $(this).val().toUpperCase() ); } });
               

                $('#tm').tree({
                    url: '<?php echo base_url('/user/coba'); ?>',
                    loadFilter: function (rows) {
                        return convert(rows);
                    },
                    onClick: function (node) {
                        getValueAjax(node.text);
                    }
                });
            });


            function addTab(title, href) {

                if (cekTab(title)) {
                    $('#tt').tabs('add', {
                        title: title,
                        closable: true,
                        href: href
                    });
                } else
                    $('#tt').tabs('select', title);
            }

            function cekTab(tabName)
            {
                var tab = $('#tt').tabs('getTab', tabName);
                return (tab == null);
            }

            function getValueAjax(title) {
                var data;
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '<?php echo base_url('c_tree_menu/geturl/'); ?>',
                    data: {title: title},
                    success: function (resp) {
                        //alert(resp);
                        data = resp;
                        if (data.trim() !== '0')
                            addTab(title, data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.responseText);
                    }
                });


            }

         
     

        </script>
        
    </head>
    <body class="easyui-layout">

        <!-- top -->
        <div data-options="region:'north',split:true" title="North Title" style="height:100px;padding:10px;">
            <span style="font-size:30px">Easy UI</span>
            <span style="float:right; font-size:30px">
                <a href="<?= base_url('logout') ?>">Logout</a>

            </span>
        </div>
        <!-- left -->
        <div data-options="region:'west',split:true" title="Main Menu" style="width:280px;padding1:1px;overflow:hidden;">
            <div class="easyui-accordion" data-options="fit:true,border:false">
                <div title="Menu" style="padding:10px;overflow:auto;" data-options="selected:true" >
                    <ul id="tm" data-options="animate:true,lines:true">
    <!--                    <li><span>Master</span>
                           <ul>
                               <li><span>Barang</span></li>
                               
                           </ul>
                       </li>-->
                    </ul>

                </div>

            </div>
        </div>

        <!-- center -->
        <div id="tt" data-options="region:'center'" title="Main Content" class="easyui-tabs" style="overflow:hidden;padding:1px">
                 <!-- <div title="welcome" style="padding:20px;overflow:hidden;" id="welcome">
                    <h1>Welcome to jQuery UI!</h1>
                </div> -->
        </div>

    </body>
</html>