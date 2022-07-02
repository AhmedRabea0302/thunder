// Add Product to tree
const product_tree_picker = document.getElementById('product_tree_picker');
const prodcuctsTable = document.getElementById('prodcuctsTable');
const addDailyReport = document.getElementById('addDailyReport');
let allReportRows;

$('#product_tree_picker').on('change', function(e) {
    debugger
    let product_id = e.target.value;
    let row = document.createElement('tr');
    $.ajax({
        url: config.routes.getProduct,
        type: 'GET',
        data: {
            id: product_id,
            _token: config.token
        }
    }).
    done((data) => {
            console.log(data);

            row.innerHTML = `
                <td style="display: none"><input class="product_id" type="hidden" name="product_id[]" value="${data.product.id}" /></td>
                <td style="font-family: sans-serif">${data.product.product_code}</td>
                <td>${data.product.unit}</td>
                <td>
                    <input type="number" min="1" name="product_quantity[]" class="form-control product_quantity" placeholder="الكمية السليمة" required />
                </td>
                <td style="font-family: sans-serif">
                    <input type="number" min="1" name="tainted_product_quantity[]" class="form-control tainted_product_quantity" placeholder="كمية التالف" required />
                </td>
                <td style="font-family: sans-serif">
                    <input type="text" name="tainted_unit[]" class="form-control tainted_unit" placeholder="وحدة التالف" required />
                </td>
                <td style="font-family: sans-serif">
                    <input readonly type="number" min="0" name="unit_value[]" class="form-control unit_value" placeholder="قيمة الوحدة السليمة"
                    value="${(data.productStandardTreeCost + data.productStandardPathCost).toFixed(3)}" required />
                </td>
                <td style="font-family: sans-serif">
                    <input readonly type="number" min="0" name="total[]" class="form-control total" placeholder="الإجمالي" required />
                </td>
                <td>
                    <i class="fa fa-trash-o btn btn-danger" style="cursor: pointer;"></i>
                </td>
            `;

            prodcuctsTable.querySelector('tbody').appendChild(row);
            prodcuctsTable.style.display = 'block';
            addDailyReport.style.visibility = 'visible';

            // Calculate Total Budget For one row
            allReportRows = Array.from(document.querySelectorAll('.daily-report-products tr'));
            console.log(allReportRows);
            calculateTotalBudgetForOneRow(allReportRows);
        })
        .fail(error => {});

})

// Calculate Total Budget For One Row
function calculateTotalBudgetForOneRow(allReportRows) {
    allReportRows.forEach(row => {
        let unit_value = row.querySelector('.unit_value');
        let total = row.querySelector('.total');
        let quantities = row.querySelectorAll('.product_quantity');
        quantities.forEach(quantity => {
            debugger
            quantity.addEventListener('change', function() {
                total.value = +(quantity.value * unit_value.value).toFixed(3);
            });
        })
        
    })
}

// Add Daily Report To database
addDailyReport.addEventListener('click', function(e) {

    e.preventDefault();

    // Build the Report Object
    let repoertObj = {};

    repoertObj.sector = document.getElementById('sector').value;
    repoertObj.date = document.getElementById('date').value;;
    repoertObj.period = document.getElementById('period').value;;
    repoertObj.stock = document.getElementById('stock').value;;
    repoertObj.tainted_stock = document.getElementById('tainted_stock').value;;
    repoertObj.product_tree_picker = document.getElementById('product_tree_picker').value;;

    console.log(repoertObj);

    // Build the one-roduct object
    const allReportRowsData = [];
    allReportRows.forEach(reportRow => {
        let reportRowData = {};

        let product_id = +reportRow.querySelector('.product_id').value;
        let product_quantity = reportRow.querySelector('.product_quantity').value;
        let tainted_product_quantity = +reportRow.querySelector('.tainted_product_quantity').value;
        let tainted_unit = reportRow.querySelector('.tainted_unit').value;
        let unit_value = +reportRow.querySelector('.unit_value').value;
        let total = +reportRow.querySelector('.total').value;

        reportRowData.product_id = product_id;
        reportRowData.product_quantity = product_quantity;
        reportRowData.tainted_product_quantity = tainted_product_quantity;
        reportRowData.tainted_unit = tainted_unit;
        reportRowData.unit_value = unit_value;
        reportRowData.total = total;

        allReportRowsData.push(reportRowData)
    });

    console.log(allReportRowsData);

    // Send Data to the server
    sendDailyReportData(repoertObj, allReportRowsData);
});

// Send Dailt Report to the server
function sendDailyReportData(repoertObj, allReportRowsData) {
    $.ajax({
            type: 'POST',
            url: config.routes.addDailyReport,
            data: {
                repoertObj: repoertObj,
                allReportRowsData: allReportRowsData,
                _token: config.token
            }
        })
        .done(response => {
            if (response.code == 200) {
                window.location.href = '/daily-report';
            }
            console.log('SERVER RESPONSE', response);
        })
        .fail(error => {
            console.log('SERVER ERROR: ', error);
        });
}