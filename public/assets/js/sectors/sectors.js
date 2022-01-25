const postAddSectorButton = document.getElementById('post-sector');

const successMessage = document.querySelector('.meesages .alert-success');
const errorMessagesul = document.querySelector('.meesages .alert-danger ul');

// Post Add Sector
postAddSectorButton.addEventListener('click', function() {
    const sector_name = document.querySelector('input[name="sector"]').value;
    console.log(sector_name);
    postAddSectorButton.disabled = true;
    $.ajax({
        url: config.routes.addSector,
        type: 'POST',
        data: {
            sector_name: sector_name,
            _token: config.token
        }
    }).
    done((data) => {
            if (data.status_code == 1) {
                successMessage.style.display = 'block';
                errorMessagesul.parentElement.style.display = 'none';
                setTimeout(() => {
                    window.location.reload();
                    postAddSectorButton.disabled = false;
                }, 1000);
            } else {
                let messages = '';
                errorMessagesul.innerHTML = '';
                postAddSectorButton.disabled = false;
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
            postAddSectorButton.disabled = false;
        });

})

// =================================================================================================
// UPDATE SECTOR

const updateSectorField = document.getElementById('sector_name');
let sectorId

document.querySelectorAll('.update-sector').forEach(updateSector => {
    updateSector.addEventListener('click', function(e) {
        e.target.tagName == 'I' ?
            sectorId = e.target.parentElement.getAttribute('data-id') :
            sectorId = e.target.getAttribute('data-id');
        e.target.tagName == 'I' ?
            sectorName = e.target.parentElement.parentElement.previousElementSibling.innerText :
            sectorName = e.target.parentElement.previousElementSibling.innerText;
        updateSectorField.value = sectorName;
    });
});


const postUpdateSectortButton = document.getElementById('post-update-sector');
const updateSuccessMessage = document.querySelector('.meesages .update.alert-success');
const updateErrorMessages = document.querySelector('.meesages .update.alert-danger ul');

postUpdateSectortButton.addEventListener('click', function(e) {

    $.ajax({
        url: config.routes.updateSector,
        type: 'POST',
        data: {
            id: sectorId,
            name: document.getElementById('sector_name').value,
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