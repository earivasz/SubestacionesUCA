
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxgrid.pager.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxgrid.selection.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="<?=base_url()?>jqwidgets/gettheme.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // prepare the data
        var data = new Array();
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
            "Black Tea", "Green Tea", "Caffe Espresso", "Doubleshot Espresso", "Caffe Latte", "White Chocolate Mocha", "Cramel Latte", "Caffe Americano", "Cappuccino", "Espresso Truffle", "Espresso con Panna", "Peppermint Mocha Twist"
        ];
        var priceValues =
        [
            "2.25", "1.5", "3.0", "3.3", "4.5", "3.6", "3.8", "2.5", "5.0", "1.75", "3.25", "4.0"
        ];
        for (var i = 0; i < 100; i++) {
            var row = {};
            var productindex = Math.floor(Math.random() * productNames.length);
            var price = parseFloat(priceValues[productindex]);
            var quantity = 1 + Math.round(Math.random() * 10);
            row["firstname"] = firstNames[Math.floor(Math.random() * firstNames.length)];
            row["lastname"] = lastNames[Math.floor(Math.random() * lastNames.length)];
            row["productname"] = productNames[productindex];
            row["price"] = price;
            row["quantity"] = quantity;
            row["total"] = price * quantity;
            data[i] = row;
        }
        var source =
        {
            localdata: data,
            datatype: "array"
        };
        var pagerrenderer = function () {
            var element = $("<div style='margin-top: 5px; width: 100%; height: 100%;'></div>");
            var paginginfo = $("#jqxgrid").jqxGrid('getpaginginformation');
            for (i = 0; i < paginginfo.pagescount; i++) {
                // add anchor tag with the page number for each page.
                var anchor = $("<a style='padding: 5px;color:black;' href='#" + i + "'>" + i + "</a>");
                anchor.appendTo(element);
                anchor.click(function (event) {
                    // go to a page.
                    var pagenum = parseInt($(event.target).text());
                    $("#jqxgrid").jqxGrid('gotopage', pagenum);
                });
            }
            return element;
        };
        
        $("#jqxgrid").jqxGrid(
        {
            width: 670,
            source: source,
            pageable: true,
            autoheight: true,
            columns: [
              { text: 'First Name', datafield: 'firstname', width: 100 },
              { text: 'Last Name', datafield: 'lastname', width: 100 },
              { text: 'Product', datafield: 'productname', width: 180 },
              { text: 'Quantity', datafield: 'quantity', width: 80, cellsalign: 'right' },
              { text: 'Unit Price', datafield: 'price', width: 90, cellsalign: 'right', cellsformat: 'c2' },
              { text: 'Total', datafield: 'total', cellsalign: 'right', cellsformat: 'c2' }
            ]
        });
    });
</script>
<div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
    <div id="jqxgrid">
    </div>
</div>

