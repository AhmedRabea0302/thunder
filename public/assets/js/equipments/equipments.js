const addEquipmentDialogButton = document.querySelector('.add-equipment');
const postAddEquipmentButton = document.getElementById('post-equipment');
const equipment_code = document.querySelector('input[name="equipment_codeadd"]');

const successMessage = document.querySelector('.meesages .alert-success');
const errorMessagesul = document.querySelector('.meesages .alert-danger ul');


// Set the product Code
addEquipmentDialogButton.addEventListener('click', function() {
    equipment_code.value = getRandomString(11);
});

// Generate Product Code
function getRandomString(length) {
    var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var result = '';
    for (var i = 0; i < length; i++) {
        result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
    }
    console.log(result)
    return result;
}

// Post Add Product Code
postAddEquipmentButton.addEventListener('click', function() {
    const equipment_code = document.querySelector('input[name="equipment_codeadd"]').value.trim();
    const workers_number = document.querySelector('input[name="workers_number"]').value.trim();
    const worker_hour_pay = document.querySelector('input[name="worker_hour_pay"]').value.trim();
    const equipment_waste = document.querySelector('input[name="equipment_waste"]').value.trim();
    const description = document.querySelector('textarea[name="description"]').value.trim();

    postAddEquipmentButton.disabled = true;

    $.ajax({
        url: config.routes.addEquipment,
        type: 'POST',
        data: {
            equipment_code,
            workers_number,
            worker_hour_pay,
            equipment_waste,
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
                    postAddEquipmentButton.disabled = false;
                }, 1000);
            } else {
                let messages = '';
                errorMessagesul.innerHTML = '';
                postAddEquipmentButton.disabled = false;
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
            postAddEquipmentButton.disabled = false;
        });

})

// =================================================================================================
// GET EQUIPMENT

const equipment_code_update = document.querySelector('input[name="equipment_code_update"]');
const workers_number_update = document.querySelector('input[name="workers_number_update"]');
const equipment_waste_update = document.querySelector('input[name="equipment_waste_update"]');
const description_update = document.querySelector('textarea[name="description_update"]');
const worker_hour_pay_update = document.querySelector('input[name="worker_hour_pay_update"]');

let equipmentId;
document.querySelectorAll('.update-equipment').forEach(equipmentBtn => {
    equipmentBtn.addEventListener('click', function(e) {
        equipmentId = e.target.getAttribute('data-id');

        $.ajax({
            url: config.routes.getEquipment,
            type: 'GET',
            data: {
                id: equipmentId,
                _token: config.token
            }
        }).
        done((data) => {
                equipment_code_update.value = data.equipment_code;
                workers_number_update.value = data.workers_number;
                equipment_waste_update.value = data.waste_per_hour;
                worker_hour_pay_update.value = data.worker_hour_pay;
                description_update.value = data.description;
            })
            .fail(error => {});
    });
});


// =================================================================================================
// UPDATE EQUIPMENT

const postUpdateEquipmentButton = document.getElementById('post-update-equipment');
const updateSuccessMessage = document.querySelector('.meesages .update.alert-success');
const updateErrorMessages = document.querySelector('.meesages .update.alert-danger ul');

postUpdateEquipmentButton.addEventListener('click', function(e) {

    $.ajax({
        url: config.routes.updateEquipment,
        type: 'POST',
        data: {
            id: equipmentId,
            workers_number: workers_number_update.value,
            equipment_waste: equipment_waste_update.value,
            description: description_update.value,
            worker_hour_pay: worker_hour_pay_update.value,
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