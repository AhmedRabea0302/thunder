const addProductDialogButton = document.querySelector('.add-product');
const postAddProductButton = document.getElementById('post-product');
const product_code = document.querySelector('input[name="product_code"]');

const successMessage = document.querySelector('.meesages .alert-success');
const errorMessagesul = document.querySelector('.meesages .alert-danger ul');


// Set the product Code
addProductDialogButton.addEventListener('click', function() {
    product_code.value = getRandomString(11);
    console.log(product_code.innerText);
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

// Post Add Product Code
postAddProductButton.addEventListener('click', function() {
    const product_type = document.querySelector('select[name="product_type"]').value.trim();
    const unit = document.querySelector('input[name="unit"]').value.trim();
    const unit_value = document.querySelector('input[name="unit_value"]').value.trim();
    const description = document.querySelector('textarea[name="description"]').value.trim();
    postAddProductButton.disabled = true;
    $.ajax({
        url: config.routes.addProduct,
        type: 'POST',
        data: {
            product_code: product_code.value,
            product_type,
            unit,
            unit_value,
            description,
            _token: config.token
        }
    }).
    done((data) => {
            if (data.status_code == 1) {
                successMessage.style.display = 'block';
                errorMessagesul.parentElement.style.display = 'none';
                setTimeout(() => {
                    window.location.reload();
                    postAddProductButton.disabled = false;
                }, 1000);
            } else {
                let messages = '';
                errorMessagesul.innerHTML = '';
                postAddProductButton.disabled = false;
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
            postAddProductButton.disabled = false;
        });

})

// =================================================================================================
// GET PRODUCT

const product_code_update = document.querySelector('.product_code_update');
const product_type_update = document.querySelector('.product_type_update');
const unit_update = document.querySelector('.unit_update');
const unit_value_update = document.querySelector('.unit_value_update');
const description_update = document.querySelector('.description_update');

let productId;
document.querySelectorAll('.update-product').forEach(updateProductBtn => {
    updateProductBtn.addEventListener('click', function(e) {
        productId = e.target.getAttribute('data-id');

        $.ajax({
            url: config.routes.getProduct,
            type: 'GET',
            data: {
                id: productId,
                _token: config.token
            }
        }).
        done((data) => {
                product_code_update.value = data.product_code;
                product_type_update.value = data.product_type;
                unit_update.value = data.unit;
                unit_value_update.value = data.unit_value;
                description_update.value = data.description;
            })
            .fail(error => {});
    });
});


// =================================================================================================
// UPDATE PRODUCT
const postUpdateProductButton = document.getElementById('post-update-product');
const updateSuccessMessage = document.querySelector('.meesages .update.alert-success');
const updateErrorMessages = document.querySelector('.meesages .update.alert-danger ul');

postUpdateProductButton.addEventListener('click', function(e) {
    $.ajax({
        url: config.routes.updateProduct,
        type: 'POST',
        data: {
            id: productId,
            product_type: product_type_update.value,
            unit: unit_update.value,
            unit_value: unit_value_update.value,
            description: description_update.value,
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