const path_code = document.getElementById('path_code');
const product_picker = document.getElementById('product_picker');
const calculatorBtn = document.getElementById('check-expense')
const modalTotalExpenses = document.getElementById('modalTotalExpenses')

// Set the product Code
path_code.value = getRandomString(14);

// Generate Product Code
function getRandomString(length) {
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for (var i = 0; i < length; i++) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }
    return result;
}

// Add Equipment to path

const equipment_picker = document.getElementById('equipment_picker');
const pathTable = document.getElementById('pathTable');
const ptoductRowSlot = document.getElementById('rowproductsSlot');

$('#equipment_picker').on('change', function(e) {
    let equipmentId = e.target.value;
    let row = document.createElement('tr');
    if (equipmentId) {
        $.ajax({
            url: config.routes.getEquipment,
            type: 'GET',
            data: {
                id: equipmentId,
                _token: config.token
            }
        }).
        done((data) => {
                console.log(data);

                row.innerHTML = `
                    <td style="display: none"><input type="hidden" name="equipment_id[]" class="equipment_id" value="${data.id}" /></td>
                    <td>
                        <select class="form-control equipment_type" name="equipment_type[]">
                            <option value="0">آلي</option>
                            <option value="1">يدوي</option>
                        </select>
                    </td>
                    <td style="font-family: sans-serif" class="equipment_code">${data.equipment_code}</td>
                    <td class="waste_per_hour">${data.waste_per_hour}</td>
                    <td class="workers_number">${data.workers_number}</td>
                    <td class="worker_hour_pay">${data.worker_hour_pay}</td>
                    <td style="font-family: sans-serif">
                        <input type="number" min="0" name="production_time_rate[]" class="form-control production_time_rate" placeholder="مُعدل الإنتاج بالدقيقة" required />
                    </td>
                    <td style="font-family: sans-serif; display: flex; align-items: center">
                        <input type="number" min="0" readonly name="expenses[]" class="form-control expenses" placeholder="(المصروفات)" required />
                        <i class="fa fa-plus add-expenses" data-toggle="modal" data-target="#addExpensesModal"></i>
                    </td>
                    <td style="font-family: sans-serif">
                        <input readonly type="number" min="0" name="total_for_row[]" class="form-control total" placeholder="قيمة التشغيل/س" required />
                    </td>
                    <td>
                        <i class="fa fa-trash-o btn btn-danger" style="cursor: pointer;"></i>
                    </td>
                `;

                pathTable.querySelector('tbody').appendChild(row);
                calculateTotalBudgetForThePath();
            })
            .fail(error => {});

    }
})

// Calculate Total Budget For One Row
function calculateTotalBudgetForOneRow(worker_pay, workers_number, equipment_waste, expenses) {
    let total = (worker_pay * workers_number) + equipment_waste + expenses;
    return total.toFixed(2);
}

// Select All Product Tree Rows And Calculate Total Budget

const claculateTotalBudgetBtn = document.getElementById('claculateTotalBudgetBtn');

claculateTotalBudgetBtn.addEventListener('click', function(e) {
    e.preventDefault();
    calculateTotalBudgetForThePath();
});

// Calculate Total Budget for the Path
function calculateTotalBudgetForThePath(e) {
    let totalBudget = 0;

    let requiredQuantityToGetDone = +(document.getElementById('quantity').value);

    const allPathRows = pathTable.querySelectorAll('tbody tr');
    const totalBudgetField = document.getElementById('totalBudgetField');
    const addPathBtn = document.getElementById('addPathBtn');

    // Show Table And Adding Button
    if (allPathRows.length == 1) {
        pathTable.style.display = 'block';
        addPathBtn.style.display = 'block';
    }
    allPathRows.forEach((row) => {

        let equipmentType = +row.querySelector('.equipment_type').value;
        let wastePerHour = +row.querySelector('.waste_per_hour').innerText;
        let workersNumber = +row.querySelector('.workers_number').innerText;
        let worker_hour_pay = +row.querySelector('.worker_hour_pay').innerText;
        let production_time_rate = +row.querySelector('.production_time_rate').value;
        let expenses = +row.querySelector('.expenses').value;

        let totalForRow = row.querySelector('.total');
        totalForRow.value = calculateTotalBudgetForOneRow(worker_hour_pay, workersNumber, wastePerHour, expenses);

        totalBudget += +totalForRow.value;
    })

    totalBudget = +(totalBudget / requiredQuantityToGetDone);
    totalBudgetField.value = totalBudget.toFixed(2);

}

// Add Expenses

// Get EquipmentID Before Opening Expenses Modal
let equipmentId;
let expensesField;
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-expenses')) {

        equipmentId = +(e.target.parentElement.parentElement.querySelector('.equipment_id').value);
        expensesField = e.target.parentElement.parentElement.querySelector('.expenses');

        // Get the modal body and reset it
        let modal = document.getElementById('addExpensesModal').querySelector('.modal .all-expenses');
        modal.innerHTML = '';

        expensesArray.forEach(expense => {
            if (expense.expenseId == equipmentId) {

                let slot = `
                <div class="one-expense" style="display: flex; justify-content: space-between">
                    <input type="text" class="form-control expense-type" value="${expense.expenseType}" placeholder="نوع المصروفات">
                    <input type="number" min="0" class="form-control expense-value" value="${expense.expenseValue}" placeholder="قيمة المصروفات">
                    <i class="fa fa-trash-o btn btn-danger delete-expense"></i>
                </div>
                `;
                modal.innerHTML += slot;
            }
        })

    };
});

let expensesArray = [];
let expensesSlot = `
    <div class="one-expense" style="display: flex; justify-content: space-between">
        <input type="text" class="form-control expense-type" placeholder="نوع المصروفات">
        <input type="number" min="0" class="form-control expense-value" placeholder="قيمة المصروفات">
        <i class="fa fa-trash-o btn btn-danger delete-expense"></i>
    </div>
`;

let addOneExpenseBtn = document.getElementById('addExpense');
let addAllExpensesBtn = document.getElementById('addExpenses');
let allExpensesContainer = document.querySelector('.all-expenses');

// Add Expenses Slot
addOneExpenseBtn.addEventListener('click', function(e) {
    // Append One Slot
    $(allExpensesContainer).append(expensesSlot);

    // Show Calculator button
    calculatorBtn.style.display = 'block';

    // Focus on the added input
    $('.one-expense:last-of-type .expense-type').select().focus();
});

// Add Expense To expenses Array
addAllExpensesBtn.addEventListener('click', function(e) {

    let expensesRows = document.querySelectorAll('.all-expenses .one-expense');
    let expenseType;
    let expenseValue;
    let total = 0;
    let expenseObj;

    expensesRows.forEach(row => {

        expenseObj = {
            expenseId: equipmentId,
            expenseType: null,
            expenseValue: null,
        }


        expenseValue = +(row.querySelector('input.expense-value').value);
        expenseType = row.querySelector('input.expense-type').value;
        // Set Costs Object
        if ((expenseType != '') && (expenseValue != 0)) {
            //Check Expenses array conains this expense before
            let threshold = () => {
                if (expensesArray.length > 0) {

                    if (expensesArray.filter(r => { return (r.expenseType === expenseType && r.expenseId == equipmentId) }).length > 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            console.log('THREESHOLD: ', threshold());
            if (threshold() == false) {
                expenseObj.expenseValue = expenseValue;
                expenseObj.expenseType = expenseType;
                expensesArray.push(expenseObj);
            }
            total += expenseValue;

        }
    });

    expensesField.value = total;
    calculateTotalBudgetForThePath();
    $('#addExpensesModal').modal('hide');

    console.log(expensesArray)
})


// Delete Rwo From Expenses
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-expense')) {

        let expenseDivTodelete = e.target.parentElement;

        let expenseValue = +(expenseDivTodelete.querySelector('input.expense-value').value);
        let expenseType = expenseDivTodelete.querySelector('input.expense-type').value;

        // Remove Expense from Expenses Array
        if (expensesArray.length > 0) {
            expensesArray = expensesArray.filter(r => {
                return !(r.expenseType === expenseType && r.expenseValue === expenseValue && r.expenseId === equipmentId)
            });
            console.log(expensesArray);
        }

        // Remove Expense from ui
        document.querySelector('.all-expenses').removeChild(expenseDivTodelete);

        // Update Total Budget And expensesField
        let totalBudget = 0;
        expensesArray.forEach(expense => {
            totalBudget += expense.expenseId == equipmentId ? expense.expenseValue : 0;
        })
        console.log(totalBudget);

        expensesField.value = totalBudget;
        calculateTotalBudgetForExpenseModal();

        // Recalculate Budget
        calculateTotalBudgetForThePath();

    }
})

// Calculate total budget - calculator Btn
calculatorBtn.addEventListener('click', function(e) {
    calculateTotalBudgetForExpenseModal();
});

// Calculate The Total Budget for expense modal
function calculateTotalBudgetForExpenseModal() {
    let totalBudget = 0;
    let allExpenseRows = document.querySelectorAll('.all-expenses .one-expense .expense-value');

    allExpenseRows.forEach(expense => {
        totalBudget += +expense.value;
    })

    modalTotalExpenses.style.display = 'block';
    modalTotalExpenses.innerText = totalBudget;
    console.log(totalBudget);
}

// Change State From Automatic To manuall



// productTreeTable.addEventListener('click', function(e) {
//     if (e.target.classList.contains('fa-trash-o')) {
//         let row = e.target.parentElement.parentElement;
//         row.style.display = 'none';
//         console.log(row);
//         productTreeTable.querySelector('tbody').removeChild(row);
//         setTimeout(function() {
//             // Recalculate Budget on deleting
//             calculateTotalBudgetForTheTree();
//         }, 100)
//     }
// });

// // on Total quantity Changes

// let requiredQuantityToGetDone = document.getElementById('quantity');
// requiredQuantityToGetDone.addEventListener('change', calculateTotalBudgetForTheTree);
// requiredQuantityToGetDone.addEventListener('keydown', calculateTotalBudgetForTheTree);
