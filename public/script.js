const API_URL = "../api/index.php";
const table = document.getElementById("product-table");
const form = document.getElementById("product-form");

async function loadProducts() {
    const response = await fetch(API_URL);
    const data = await response.json();
     
    table.innerHTML = "";
    data.forEach(p => { 
        row = `
            <tr>
                <td>${p.name}</td>
                <td>${p.code}</td>
                <td>R$ ${p.price.toFixed(2)}</td>
                <td>${p.quantity}</td>
                <td>
                    <button class="delete-btn" onclick="deleteProduct('${p.id}')">Excluir</button>
                </td>
            </tr>
        `;
        table.innerHTML += row;
    });
}

async function deleteProduct(id) {
    response = await fetch(API_URL + "?id=" + id, {
        method: "DELETE"
    });
    if(!response.ok){
        alert("Não foi possivel efetuar a exclusão do produto.");
    }
    loadProducts();
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    
    const product = {
        name: document.getElementById("name").value,
        code: document.getElementById("code").value,
        price: document.getElementById("price").value,
        quantity: document.getElementById("quantity").value
    };

    response = await fetch(API_URL, {
        method: "POST",
        body: JSON.stringify(product)
    });
    
    if(!response.ok){
        alert("Não foi possivel adicionar o produto.");
    }
    form.reset();
    loadProducts();
});

loadProducts();
