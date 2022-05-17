// Add Product to tree
const product_tree_picker = document.getElementById('product_tree_picker');
const prodcuctsTable = document.getElementById('prodcuctsTable');
const addDailyReport = document.getElementById('addDailyReport');


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
                <td style="display: none"><input type="hidden" name="product_id[]" value="${data.product.id}" /></td>
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
                    <input readonly type="number" min="0" name="total_quantity[]" class="form-control total" placeholder="قيمة الوحدة السليمة"
                    value="${(data.productStandardTreeCost + data.productStandardPathCost).toFixed(3)}" required />
                </td>
                <td style="font-family: sans-serif">
                    <input readonly type="number" min="0" name="total_quantity[]" class="form-control total" placeholder="الإجمالي" required />
                </td>
                <td>
                    <i class="fa fa-trash-o btn btn-danger" style="cursor: pointer;"></i>
                </td>
            `;

            prodcuctsTable.querySelector('tbody').appendChild(row);
            prodcuctsTable.style.display = 'block';
            addDailyReport.style.visibility = 'visible';
        })
        .fail(error => {});

})

// Calculate Total Budget For One Row
function calculateTotalBudgetForOneRow(numberOfPieces, piece_total_budget) {
    let total = numberOfPieces * piece_total_budget;
    return total.toFixed(3);
}

// Add Daily Report To database
addDailyReport.addEventListener('submit', function(e) {

    e.preventDefault();

    // Build the path Object
    let repoertObj = {};

    repoertObj.sector = document.getElementById('sector').value;
    repoertObj.date = document.getElementById('date').value;;
    repoertObj.period = document.getElementById('period').value;;
    repoertObj.stock = document.getElementById('stock').value;;
    repoertObj.tainted_stock = document.getElementById('tainted_stock').value;;
    repoertObj.product_tree_picker = document.getElementById('product_tree_picker').value;;

    console.log(pathObj);

    // Get All Path Rows
    const allPathRows = pathTable.querySelectorAll('tbody tr');

    // // Build the one-step object
    // const allPathRowsData = [];
    // allPathRows.forEach(pathRow => {
    //     let pathRowData = {};

    //     let equipmentId = +pathRow.querySelector('.equipment_id').value;
    //     let stepType = pathRow.querySelector('.type').value;
    //     let workersNumber = +pathRow.querySelector('.workers_number').value;
    //     let workerPay = +pathRow.querySelector('.worker_hour_pay').value;
    //     let productionRate = +pathRow.querySelector('.production_time_rate').value;
    //     let stepTotalBudget = +pathRow.querySelector('.total').value;

    //     pathRowData.equipmentId = equipmentId;
    //     pathRowData.stepType = stepType;
    //     pathRowData.workersNumber = workersNumber;
    //     pathRowData.workerPay = workerPay;
    //     pathRowData.productionRate = productionRate;
    //     pathRowData.stepTotalBudget = stepTotalBudget;

    //     allPathRowsData.push(pathRowData)
    // });

    // console.log(allPathRowsData);

    // // Send Data to the server
    // sendPathData(pathObj, allPathRowsData, expensesArray);
});