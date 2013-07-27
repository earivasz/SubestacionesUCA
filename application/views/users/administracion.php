<script type="text/javascript" src="<?=base_url()?>js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxcore.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxdata.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxbuttons.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxlistbox.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxmenu.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxgrid.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxgrid.filter.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxgrid.sort.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxgrid.selection.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxpanel.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxcalendar.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxdatetimeinput.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jqxcheckbox.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/gettheme.js"></script>
<script type="text/javascript">
function generatedata(rowscount, hasNullValues) {
    // prepare the data
    var data = new Array();
    if (rowscount === undefined) rowscount = 100;
    var firstNames =
    [
        "Andrew", "Nancy", "Shelley", "Regina", "Yoshi", "Antoni", "Mayumi", "Ian", "Peter", "Lars", "Petra", "Martin", "Sven", "Elio", "Beate", "Cheryl", "Michael", "Guylene"
    ];

    var lastNames =
    [
        "Fuller", "Davolio", "Burke", "Murphy", "Nagase", "Saavedra", "Ohno", "Devling", "Wilson", "Peterson", "Winkler", "Bein", "Petersen", "Rossi", "Vileid", "Saylor", "Bjorn", "Nodier"
    ];

    var productNames =
    [
        "Black Tea", "Green Tea", "Caffe Espresso", "Doubleshot Espresso", "Caffe Latte", "White Chocolate Mocha", "Caramel Latte", "Caffe Americano", "Cappuccino", "Espresso Truffle", "Espresso con Panna", "Peppermint Mocha Twist"
    ];

    var priceValues =
    [
         "2.25", "1.5", "3.0", "3.3", "4.5", "3.6", "3.8", "2.5", "5.0", "1.75", "3.25", "4.0"
    ];

    for (var i = 0; i < rowscount; i++) {
        var row = {};
        var productindex = Math.floor(Math.random() * productNames.length);
        var price = parseFloat(priceValues[productindex]);
        var quantity = 1 + Math.round(Math.random() * 10);

        row["id"] = i;
        row["available"] = productindex % 2 === 0;
        if (hasNullValues === true) {
            if (productindex % 2 !== 0) {
                var random = Math.floor(Math.random() * rowscount);
                row["available"] = i % random === 0 ? null : false;
            }
        }
        row["firstname"] = firstNames[Math.floor(Math.random() * firstNames.length)];
        row["lastname"] = lastNames[Math.floor(Math.random() * lastNames.length)];
        row["name"] = row["firstname"] + " " + row["lastname"]; 
        row["productname"] = productNames[productindex];
        row["price"] = price;
        row["quantity"] = quantity;
        row["total"] = price * quantity;

        var date = new Date();
        date.setFullYear(2013, Math.floor(Math.random() * 11), Math.floor(Math.random() * 27));
        date.setHours(0, 0, 0, 0);
        row["date"] = date;
       
        data[i] = row;
    }

    return data;
}    
    
$(document).ready(function () {
            var theme = getDemoTheme();

            var data = generatedata(500);
            var source =
            {
                localdata: data,
                datafields:
                [
                    { name: 'name', type: 'string' },
                    { name: 'productname', type: 'string' },
                    { name: 'available', type: 'bool' },
                    { name: 'date', type: 'date'},
                    { name: 'quantity', type: 'number' }
                ],
                datatype: "array"
            };

            var dataAdapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid").jqxGrid(
            {
                width: 685,
                source: dataAdapter,
                showfilterrow: true,
                filterable: true,
                theme: theme,
                selectionmode: 'multiplecellsextended',
                columns: [
                  { text: 'Name', columntype: 'textbox', filtertype: 'textbox', filtercondition: 'starts_with', datafield: 'name', width: 115 },
                  {
                      text: 'Product', filtertype: 'checkedlist', datafield: 'productname', width: 220
                  },
                  { text: 'Available', datafield: 'available', columntype: 'checkbox', filtertype: 'bool', width: 67 },
                  { text: 'Ship Date', datafield: 'date', filtertype: 'date', width: 210, cellsalign: 'right', cellsformat: 'd' },
                  { text: 'Qty.', datafield: 'quantity', filtertype: 'number',  cellsalign: 'right' }
                ]
            });
            $('#clearfilteringbutton').jqxButton({ height: 25, theme: theme });
            $('#clearfilteringbutton').click(function () {
                $("#jqxgrid").jqxGrid('clearfilters');
            });
        });
</script>

<div id="contenido">
    <div id="jqxgrid">
    </div>
    <input style="margin-top: 10px;" value="Remove Filter" id="clearfilteringbutton" type="button" />
</div>