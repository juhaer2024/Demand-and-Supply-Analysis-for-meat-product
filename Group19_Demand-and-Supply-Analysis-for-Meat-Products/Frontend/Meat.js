function toggleAddNewProduct() {
    const form = document.getElementById('add-new-product');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function addNewProduct() {
    alert("New product functionality coming soon!");
}

function deleteRow(index) {
    document.querySelector(`#table-body tr:nth-child(${index})`).remove();
}

function searchProduct() {
    let input = document.getElementById("search-box").value.toUpperCase();
    let rows = document.querySelectorAll("#table-body tr");
    rows.forEach(row => {
        let name = row.children[1].textContent.toUpperCase();
        row.style.display = name.includes(input) ? "" : "none";
    });
}
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('meatPriceChart').getContext('2d');
    const meatPriceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Beef',
                    data: [420, 430, 450, 460, 440, 470],
                    borderColor: 'red',
                    fill: false
                },
                {
                    label: 'Chicken',
                    data: [200, 210, 220, 215, 225, 230],
                    borderColor: 'black',
                    fill: false
                },
                {
                    label: 'Mutton',
                    data: [600, 620, 630, 640, 625, 650],
                    borderColor: 'gray',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Historical Meat Prices (per KG)'
                }
            }
        }
    });
});

