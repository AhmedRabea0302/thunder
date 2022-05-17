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

// Check if the path already Contains the equipment
function checkIfThePathContainsSelectedEquipment(equipmentCode) {
    const pathTableBody = Array.from(document.querySelectorAll('#pathTable tbody tr'));
    let threshold;
    debugger
    if (pathTableBody.length > 0) {
        threshold = pathTableBody.filter(row => {
            return row.querySelector('.equipment_code').value == equipmentCode
        }).length > 0;
        debugger
    } else {
        threshold = false;
    }
    return threshold;

}
// Add Equipment to path
const equipment_picker = document.getElementById('equipment_picker');
const pathTable = document.getElementById('pathTable');
const ptoductRowSlot = document.getElementById('rowproductsSlot');

$('#equipment_picker').on('change', function(e) {
    debugger
    let equipmentId = e.target.value;
    let equipmentCode = e.target.options[e.target.selectedIndex].innerText;

    let containsEquipment = checkIfThePathContainsSelectedEquipment(equipmentCode);
    if (!containsEquipment) {
        let row = document.createElement('tr');
        if (equipmentId && equipmentId != 'يدوي') {
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
                        <input type="text" readonly name="types[]" class="form-control type" value="آلي" required />
                    </td>
                    <td style="font-family: sans-serif">
                        <input type="text" readonly name="equipment_codes[]" class="form-control equipment_code" value="${data.equipment_code}" required />
                    </td>
                    <td class="">
                        <input type="number" readonly name="wastes_per_hour[]" class="form-control waste_per_hour" value="${data.waste_per_hour}" required />
                    </td>
                    <td class="">
                        <input type="number" min="1" readonly name="workers_numbers[]" class="form-control workers_number" value="${data.workers_number}" required />
                    </td>
                    <td class="">
                        <input type="number" readonly name="worker_hour_pays[]" class="form-control worker_hour_pay" value="${data.worker_hour_pay}" required />
                    </td>
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
                        <i class="fa fa-trash-o btn btn-danger delete-step" style="cursor: pointer;"></i>
                    </td>
                `;

                    pathTable.querySelector('tbody').appendChild(row);
                    calculateTotalBudgetForThePath();

                    // Reset the selection box
                    e.target.selectedIndex = 0;
                })
                .fail(error => {});

        } else if (equipmentId == 'يدوي') {
            let id = ((Math.random() * 13791) + 12).toFixed(0);
            row.innerHTML = `
                <td style="display: none"><input type="hidden" name="equipment_id[]" class="equipment_id" value="${id}" /></td>
                <td>
                    <input type="text" readonly name="types[]" class="form-control type" value="يدوي" required />
                </td>
                <td style="font-family: sans-serif">
                    <input type="text" readonly name="equipment_codes[]" class="form-control equipment_code" value="-" required />
                </td>
                <td class="">
                    <input type="text" readonly name="wastes_per_hour[]" class="form-control waste_per_hour" value="-" required />
                </td>
                <td class="">
                    <input type="number" min="1" name="workers_numbers[]" class="form-control workers_number" value="1" required />
                </td>
                <td class="">
                    <input type="number" min="1"name="worker_hour_pays[]" class="form-control worker_hour_pay" value="1" required />
                </td>
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
                    <i class="fa fa-trash-o btn btn-danger delete-step" style="cursor: pointer;"></i>
                </td>
            `;

            pathTable.querySelector('tbody').appendChild(row);
            calculateTotalBudgetForThePath();

            // Reset the selection box
            e.target.selectedIndex = 0;
        }
    } else {
        Swal.fire({
            title: 'خطأ!',
            text: 'هذه المُعدة مُضافة للمسار من قبل!',
            icon: 'info',
            confirmButtonText: 'إغﻻق'
        })
    }
})

// Calculate Total Budget For One Row
function calculateTotalBudgetForOneRow(worker_pay, workers_number, equipment_waste, expenses) {;
    let total = ((worker_pay * workers_number) + (isNaN(equipment_waste) ? 0 : equipment_waste) + expenses) * (production_time_rate / 60);
    return total.toFixed(3);
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

        let wastePerHour = +row.querySelector('.waste_per_hour').value;
        let workersNumber = +row.querySelector('.workers_number').value;
        let worker_hour_pay = +row.querySelector('.worker_hour_pay').value;
        let production_time_rate = +row.querySelector('.production_time_rate').value;
        let expenses = +row.querySelector('.expenses').value;

        let totalForRow = row.querySelector('.total');
        totalForRow.value = calculateTotalBudgetForOneRow(worker_hour_pay, workersNumber, wastePerHour, expenses);

        totalBudget += +totalForRow.value;
    })

    totalBudget = +(totalBudget / requiredQuantityToGetDone);
    totalBudgetField.value = totalBudget.toFixed(3);

    Toast.fire({
        icon: 'success',
        title: 'تم حساب التكلفة بنجاح!'
    })
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
        });

        // Hide Modal total expense
        modalTotalExpenses.style.display = 'none';

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

// Delete Step From the table
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-step')) {
        const tableBody = document.querySelector('#pathTable tbody');
        const rowToDelete = e.target.parentElement.parentElement;
        const rowRequipmentId = +(e.target.parentElement.parentElement.querySelector('.equipment_id').value);
        console.log(rowRequipmentId);
        // Delete From UI
        if (rowToDelete) {
            tableBody.removeChild(rowToDelete);
        }

        // Remove Expense from Expenses Array
        if (expensesArray.length > 0) {
            expensesArray = expensesArray.filter(r => {
                return !(r.expenseId === rowRequipmentId)
            });
            console.log(expensesArray);
        }

        // Recalculate Total Budget
        calculateTotalBudgetForThePath();
    }
});

// Add Path To database
updatePathForm = document.getElementById('updatePathForm');

updatePathForm.addEventListener('submit', function(e) {
    e.preventDefault();

    // Calculate Total Budget Before Submitting
    calculateTotalBudgetForThePath();

    // Build the path Object
    let pathObj = {};

    let pathSector = +document.getElementById('sector_picker').value;
    let productPicker = +document.getElementById('product_picker').value;
    let pathCode = document.getElementById('path_code').value;
    let pathType = +document.getElementById('path_type').value;
    let quantity = +document.getElementById('quantity').value;
    let totalBudget = +document.getElementById('totalBudgetField').value;

    pathObj.pathSector = pathSector;
    pathObj.productPicker = productPicker;
    pathObj.pathCode = pathCode;
    pathObj.pathType = pathType;
    pathObj.quantity = quantity;
    pathObj.totalBudget = totalBudget;

    console.log(pathObj);

    // Get All Path Rows
    const allPathRows = pathTable.querySelectorAll('tbody tr');

    // Build the one-step object
    const allPathRowsData = [];
    allPathRows.forEach(pathRow => {
        let pathRowData = {};

        let equipmentId = +pathRow.querySelector('.equipment_id').value;
        let stepType = pathRow.querySelector('.type').value;
        let workersNumber = +pathRow.querySelector('.workers_number').value;
        let workerPay = +pathRow.querySelector('.worker_hour_pay').value;
        let productionRate = +pathRow.querySelector('.production_time_rate').value;
        let stepTotalBudget = +pathRow.querySelector('.total').value;

        pathRowData.equipmentId = equipmentId;
        pathRowData.stepType = stepType;
        pathRowData.workersNumber = workersNumber;
        pathRowData.workerPay = workerPay;
        pathRowData.productionRate = productionRate;
        pathRowData.stepTotalBudget = stepTotalBudget;

        allPathRowsData.push(pathRowData)
    });

    console.log(allPathRowsData);

    // Send Data to the server
    sendPathData(pathObj, allPathRowsData, expensesArray);
});

function sendPathData(pathObj, allPathRowsData, expensesArray) {
    if (validatePathFormFields()) {
        $.ajax({
                type: 'POST',
                url: config.routes.addPath,
                data: {
                    pathData: pathObj,
                    pathSteps: allPathRowsData,
                    pathExpenses: expensesArray,
                    _token: config.token
                }
            })
            .done(response => {
                if (response.code == 200) {
                    window.location.href = '/all-paths';
                }
                console.log('SERVER RESPONSE', response);
            })
            .fail(error => {
                console.log('SERVER ERROR: ', error);
            });
    }
}

// Validate Form Select Box fields
function validatePathFormFields() {

    const sectorPicker = document.getElementById('sector_picker');
    const productPicker = document.getElementById('product_picker');
    if (sectorPicker.value == 0 || productPicker.value == 0) {
        alert('من فضلك تأكد من إختيار القسم');
        return false;
    } else {
        return true;
    }
}

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

calculateTotalBudgetForThePath();


// Get path all expenses
function getAllPathExpenses() {
    $.ajax({
            type: 'GET',
            url: config.routes.getAllPathExpenses,

        })
        .done(function(response) {
            console.log(response)
            expensesArray = response;
        })
        .catch(function(error) {
            console.log(error)
        })
}

getAllPathExpenses();
