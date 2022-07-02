const product_picker = document.getElementById('product_picker');
const treesContainer = document.querySelector('.trees .trees-list');
const pathsContainer = document.querySelector('.paths .paths-list');
const changePriceButton = document.querySelector('.change-product-price');
let productId;

$('#product_picker').on('change', function(e) {
    productId = e.target.value;
    changePriceButton.style.visibility = 'visible';

    if (productId) {
        $.ajax({
            url: config.routes.getProductPathsAndTrees,
            type: 'POST',
            data: {
                id: productId,
                _token: config.token
            }
        }).
        done((data) => {
            treesContainer.innerHTML = '';
            pathsContainer.innerHTML = '';

            treesContainer.innerHTML += '<li>شجر المنتج</li>';
            data.trees.forEach((tree) => {
                let treeRow = `
                        <li draggable="true" class="draggable">
                            <span class="tree-code">${tree.product_tree_code}</span>
                            <span class="tree-type">${tree.product_tree_type == 1 ? 'آخرى' : 'قياسي' }</span>
                            <span class="tree-budget">${tree.total_budget}</span>
                        </li>
                `;
                treesContainer.innerHTML += (treeRow);
            });

            pathsContainer.innerHTML += '<li>المسارات</li>';
            data.paths.forEach((path) => {
                let totalTime = 0;
                pathTotalTime = path.get_path_steps.forEach(step => {
                    totalTime += step.production_time_rate;
                })
                let treeRow = `
                        <li draggable="true" class="draggable">
                            <span class="path-code">${path.path_code}</span>
                            <span class="path-type">${path.path_type == 1 ? 'آخرى' : 'قياسي' }</span>
                            <span class="path-budget">${path.piece_total_budget}</span>
                            <span class="path-time"><span>${totalTime}</span> دقيقة</span>
                        </li>
                `;
                pathsContainer.innerHTML += (treeRow);
            });

            setTimeout(() => {
                getAllDragableItems();
                addEventListeners();

            }, 200);
        }).fail(err => {
            console.log(err);
        })
    }


});

// Drag And Drop
let listItems;

function getAllDragableItems() {
    listItems = Array.from(document.querySelectorAll('.draggable'));
    console.log(listItems);
}

function addEventListeners() {
    const draggables = document.querySelectorAll('.draggable');

    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', dragStart);
    })

    draggables.forEach(item => {
        item.addEventListener('dragover', dragOver);
        item.addEventListener('drop', dragDrop);
        item.addEventListener('dragenter', dragEnter);
        item.addEventListener('dragleave', dragLeave);
    })
}

let draggableItemData;

function dragStart() {
    // console.log('started dragging');
    draggableItemData = this;
    console.log('START DRAGING: ', draggableItemData);
}

function dragOver(e) {
    e.preventDefault();
}

function dragDrop() {
    if (this.classList.contains('tree-paster')) {
        document.querySelector('.tree-paster .tree-code').innerText = draggableItemData.querySelector('.tree-code').innerText;
        document.querySelector('.tree-paster .tree-budget').innerText = draggableItemData.querySelector('.tree-budget').innerText;
    }

    if (this.classList.contains('path-paster')) {
        document.querySelector('.path-paster .path-code').innerText = draggableItemData.querySelector('.path-code').innerText;
        document.querySelector('.path-paster .path-budget').innerText = draggableItemData.querySelector('.path-budget').innerText;
    }
    this.classList.remove('over');
    calculateTotalStandardCost();
}

function dragEnter() {
    console.log('ENTERXXXXX: ', this.classList)
    if (this.classList.contains('tree-paster') || this.classList.contains('path-paster')) {
        this.classList.add('over');
    }
}

function dragLeave() {
    this.classList.remove('over');
}

function calculateTotalStandardCost() {
    let treeBudget = +(document.querySelector('.tree-paster .tree-budget').innerText);
    let pathBudget = +(document.querySelector('.path-paster .path-budget').innerText);

    if (treeBudget && pathBudget) {
        document.querySelector('#standardCost').value = (treeBudget + pathBudget).toFixed(3);
        Toast.fire({
            icon: 'success',
            title: 'تم حساب التكلفة الفعلية بنجاح!'
        })
    }
}

// Change The Product Price 
$(changePriceButton).on('click', function() {
    let price = document.querySelector('#standardCost').value;
    let product_id = productId;

    $.ajax({
        url: config.routes.updateProductStandardCost,
        type: 'POST',
        data: {
            price,
            product_id,
            _token: config.token
        }
    }).
    done((data) => {
        window.location.href = 'standard-cost';
    })
    .fail((error) => {

    });
    
});


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