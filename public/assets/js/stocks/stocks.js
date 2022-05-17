const addStockDialogButton = document.querySelector('.add-stock');
const stock_code = document.querySelector('.stock_code_modal');

const postAddStockButton = document.getElementById('post-stock');
const successMessage = document.querySelector('.meesages .alert-success');
const errorMessagesul = document.querySelector('.meesages .alert-danger ul');

// Set the product Code
addStockDialogButton.addEventListener('click', function() {
    stock_code.value = getRandomString(11);
    console.log(stock_code.value);
});

// Generate Product Code
function getRandomString(length) {
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for (var i = 0; i < length; i++) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }

    return result;
}

// Post Add stock
postAddStockButton.addEventListener('click', function() {
    const stock_name = document.querySelector('input[name="stock_name_modal"]').value;
    const stock_code = document.querySelector('input[name="stock_code_modal"]').value;
    const stock_place = document.querySelector('input[name="stock_place"]').value;
    const stock_manager = document.querySelector('input[name="stock_manager"]').value;

    console.log(stock_name);
    postAddStockButton.disabled = true;
    $.ajax({
        url: config.routes.addStock,
        type: 'POST',
        data: {
            stock_name: stock_name,
            stock_code: stock_code,
            stock_place: stock_place,
            stock_manager: stock_manager,
            _token: config.token
        }
    }).
    done((data) => {
            if (data.status_code == 1) {
                successMessage.style.display = 'block';
                errorMessagesul.parentElement.style.display = 'none';
                setTimeout(() => {
                    window.location.reload();
                    postAddStockButton.disabled = false;
                }, 1000);
            } else {
                let messages = '';
                errorMessagesul.innerHTML = '';
                postAddStockButton.disabled = false;
                messages = [...Object.entries(data.messages)];
                messages.forEach(message => {
                    let li = document.createElement('li');
                    li.innerText = message[1];
                    errorMessagesul.append(li);
                });

                errorMessagesul.parentElement.style.display = 'block';
                successMessage.style.display = 'none';

            }

        })
        .fail(error => {
            postAddStockButton.disabled = false;
        });

})

// =================================================================================================
// UPDATE stock
let updateStockCodeField;
let updateStockNameField;
let updateStockPlaceField;
let updateStockManagerField;
let stockId

document.querySelectorAll('.update-stock').forEach(updatestock => {
    updatestock.addEventListener('click', function(e) {
        debugger
        updateStockCodeField = e.target.parentElement.parentElement.querySelector('td.stock-table-code').innerText;
        updateStockNameField = e.target.parentElement.parentElement.querySelector('td.stock-table-name').innerText;
        updateStockPlaceField = e.target.parentElement.parentElement.querySelector('td.stock-table-place').innerText;
        updateStockManagerField = e.target.parentElement.parentElement.querySelector('td.stock-table-manager').innerText;

        document.querySelector('input[name="stock_name_update_modal"]').value = updateStockNameField;
        document.querySelector('input[name="stock_code_update_modal"]').value = updateStockCodeField;
        document.querySelector('input[name="stock_place_update_modal"]').value = updateStockPlaceField;
        document.querySelector('input[name="stock_manager_update_modal"]').value = updateStockManagerField;
        e.target.tagName == 'I' ?
            stockId = e.target.parentElement.getAttribute('data-id') :
            stockId = e.target.getAttribute('data-id');
    });
});


const postUpdateStocktButton = document.getElementById('post-update-stock');
const updateSuccessMessage = document.querySelector('.meesages .update.alert-success');
const updateErrorMessages = document.querySelector('.meesages .update.alert-danger ul');

postUpdateStocktButton.addEventListener('click', function(e) {

    let stock_name = document.querySelector('input[name="stock_name_update_modal"]').value;
    let stock_place = document.querySelector('input[name="stock_place_update_modal"]').value;
    let stock_manager = document.querySelector('input[name="stock_manager_update_modal"]').value;

    $.ajax({
        url: config.routes.updateStock,
        type: 'POST',
        data: {
            id: stockId,
            stock_name: stock_name,
            stock_place: stock_place,
            stock_manager: stock_manager,
            _token: config.token
        }
    }).
    done((data) => {
            if (data.status_code == 1) {
                updateSuccessMessage.style.display = 'block';
                updateErrorMessages.parentElement.style.display = 'none';
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            } else {
                let messages = '';
                updateErrorMessages.innerHTML = '';

                messages = [...Object.entries(data.messages)];
                messages.forEach(message => {
                    let li = document.createElement('li');
                    li.innerText = message[1];
                    updateErrorMessages.append(li);
                });

                updateErrorMessages.parentElement.style.display = 'block';
                updateSuccessMessage.style.display = 'none';

            }

        })
        .fail(error => {});
})
