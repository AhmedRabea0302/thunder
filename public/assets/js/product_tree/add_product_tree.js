const product_tree_code = document.getElementById('product_tree_code');
const product_picker = document.getElementById('product_picker');


// Set the product Code
product_tree_code.value = getRandomString(14);

// Generate Product Code
function getRandomString(length) {
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for (var i = 0; i < length; i++) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }
    return result;
}


// Get Product on product picker change
const product_type = document.getElementById('product_type');
const product_unit = document.getElementById('product_unit');
const product_unit_value = document.getElementById('product_unit_value');

$('#product_picker').on('change', function(e) {
    let product_id = e.target.value;
    if (product_id != '') {
        $.ajax({
            url: config.routes.getProduct,
            type: 'GET',
            data: {
                id: product_id,
                _token: config.token
            }
        }).
        done((data) => {
                product_type.value = data.product.product_type;
                product_unit.value = data.product.unit;
                product_unit_value.value = data.product.unit_value;

                // Disable The Standard Option if the there is one for thr product tree
                if (data.productHasStTree) {
                    document.querySelector('.standard-tree').disabled = true;
                    document.querySelector('.standard-tree').innerText = 'تم إضافة شجرة مُنتج قياسية من قبل';
                    document.querySelector('.other-tree').disabled = false;
                    document.querySelector('.other-tree').innerText = 'آخرى';

                } else {
                    document.querySelector('.standard-tree').disabled = false;
                    document.querySelector('.standard-tree').innerText = 'قياسي';
                    document.querySelector('.other-tree').disabled = true;
                    document.querySelector('.other-tree').innerText = 'يجب إضافة شجرة مُنتج قياسية لهذا المُنتج أولاً';
                }
            })
            .fail(error => {});
    }
})


// Add Product to tree
const product_tree_picker = document.getElementById('product_tree_picker');
const productTreeTable = document.getElementById('productTreeTable');
const ptoductRowSlot = document.getElementById('rowproductsSlot');

$('#product_tree_picker').on('change', function(e) {
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
                <td>${data.product.description.substring(0, 10)}</td>
                <td>${data.product.product_type}</td>
                <td>${data.product.unit}</td>
                <td class="product_unit_value">${data.product.unit_value}</td>
                <td style="font-family: sans-serif">
                    <input type="number" min="0" name="product_quantity[]" class="form-control product_quantity" placeholder="الكمية" required />
                </td>
                <td style="font-family: sans-serif">
                    <input type="number" min="0" name="wasted_quantity[]" class="form-control wasted_amount" placeholder="(نسبة مئوية)" required />
                </td>
                <td style="font-family: sans-serif">
                    <input readonly type="number" min="0" name="total_quantity[]" class="form-control total" placeholder="الإجمالي" required />
                </td>
                <td>
                    <i class="fa fa-trash-o btn btn-danger" style="cursor: pointer;"></i>
                </td>
            `;

            productTreeTable.querySelector('tbody').appendChild(row);
            calculateTotalBudgetForTheTree();
        })
        .fail(error => {});

})

// Calculate Total Budget For One Row
function calculateTotalBudgetForOneRow(unit_value, quantity, wasted_amount) {
    let total = ((quantity * wasted_amount) / 100) * unit_value + (quantity * unit_value);
    return total.toFixed(3);
}

// Select All Product Tree Rows And Calculate Total Budget
const claculateTotalBudgetBtn = document.getElementById('claculateTotalBudgetBtn');

claculateTotalBudgetBtn.addEventListener('click', function(e) {
    e.preventDefault();
    calculateTotalBudgetForTheTree();

    Toast.fire({
        icon: 'success',
        title: 'تم حساب التكلفة بنجاح!'
    })
});

// Calculate Total Budget for thr tree
function calculateTotalBudgetForTheTree(e) {
    let totalBudget = 0;

    let requiredQuantityToGetDone = +(document.getElementById('quantity').value);
    const allProductTreeRows = productTreeTable.querySelectorAll('tbody tr');
    const totalBudgetField = document.getElementById('totalBudgetField');
    const addProductTreeBtn = document.getElementById('addProductTreeBtn');

    // Show Table And Adding Button
    if (allProductTreeRows.length == 1) {
        productTreeTable.style.display = 'block';
        addProductTreeBtn.style.display = 'block';
    }
    allProductTreeRows.forEach((row) => {
        let quantityField = row.querySelector('.product_quantity').value;
        let wastedAmountField = row.querySelector('.wasted_amount').value;
        let unitValueField = row.querySelector('.product_unit_value').innerText;

        let totalField = row.querySelector('.total');
        totalField.value = calculateTotalBudgetForOneRow(unitValueField, quantityField, wastedAmountField);

        totalBudget += +totalField.value;
    })

    totalBudget = +(totalBudget / requiredQuantityToGetDone);
    totalBudgetField.value = totalBudget.toFixed(3);
    product_unit_value.value = totalBudgetField.value;
    console.log(totalBudget);

}


// Delete Rwo From Tree Product
productTreeTable.addEventListener('click', function(e) {
    if (e.target.classList.contains('fa-trash-o')) {
        let row = e.target.parentElement.parentElement;
        row.style.display = 'none';
        console.log(row);
        productTreeTable.querySelector('tbody').removeChild(row);
        setTimeout(function() {
            // Recalculate Budget on deleting
            calculateTotalBudgetForTheTree();
        }, 100)
    }
});

// on Total quantity Changes

let requiredQuantityToGetDone = document.getElementById('quantity');
requiredQuantityToGetDone.addEventListener('change', calculateTotalBudgetForTheTree);
requiredQuantityToGetDone.addEventListener('keydown', calculateTotalBudgetForTheTree);

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})