async function customerAPI(action, data = {}) {
    const fd = new FormData();
    fd.append('action', action);
    Object.entries(data).forEach(([k, v]) => fd.append(k, v));
    const r = await fetch(BASE_URL + '/ajax/customer.php', { method: 'POST', body: fd });
    return r.json();
}
async function loadMenu(cat = 0) {
    const r = await fetch(BASE_URL + '/ajax/customer.php?action=menu&category_id=' + cat);
    const d = await r.json();
    const box = document.getElementById('menuGrid'); if (!box) return;
    box.innerHTML = d.items.map(x => `<div class="card"><div class="food-icon">🍽️</div><h3>${esc(x.name)}</h3><p>${esc(x.description || '')}</p><p class="price">${Number(x.price).toFixed(2)}</p><button class="btn" onclick="addCart(${x.id})">Add to Cart</button></div>`).join('');
}
async function addCart(id) {
    const d = await customerAPI('add', { id });
    document.getElementById('menuMsg').textContent = d.message;
    if (d.ok) loadCart();
}
async function loadCart() {
    const box = document.getElementById('cartBox');
    if (!box) return;
    const d = await customerAPI('cart');
    if (!d.items.length) {
        box.innerHTML = '<div class="card">Your cart is empty.</div>';
        return;
    }
    let total = 0;
    let html = '<div class="card"><table><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th><th></th></tr>';
    d.items.forEach(x => { total += Number(x.subtotal); html += `<tr><td>${esc(x.name)}</td><td><input class="qty" type="number" min="1" value="${x.quantity}" onchange="changeQty(${x.id},this.value)"></td><td>৳${Number(x.price).toFixed(2)}</td><td>৳${Number(x.subtotal).toFixed(2)}</td><td><button onclick="removeCart(${x.id})">Remove</button></td></tr>` });
    html += `</table><h3>Total: ৳${total.toFixed(2)}</h3><input id="address" placeholder="Delivery address" required><button class="btn" onclick="placeOrder()">Place Order</button><p id="cartMsg" class="msg"></p></div>`; box.innerHTML = html;
}
async function changeQty(id, q) {
    await customerAPI('qty', { id, quantity: q });
    loadCart();
}
async function removeCart(id) {
    await customerAPI('remove', { id });
    loadCart();
}
async function placeOrder() {
    const address = document.getElementById('address').value;
    const d = await customerAPI('place', { address });
    document.getElementById('cartMsg').textContent = d.message || '';
    if (d.ok) setTimeout(() => location.href = BASE_URL + '/customer/orders.php', 500);
}
async function loadOrders() {
    const box = document.getElementById('ordersBox');
    if (!box) return;
    const d = await customerAPI('orders');
    if (!d.orders.length) {
        box.innerHTML = '<div class="card">No orders yet.</div>';
        return;
    }
    box.innerHTML = d.orders.map(o => `<div class="card order"><h3>Order #${o.id}</h3><p>Status: <b>${esc(o.status)}</b></p><p>Total: ৳${Number(o.total_amount).toFixed(2)}</p><p>Address: ${esc(o.delivery_address)}</p><ul>${o.items.map(i => `<li>${esc(i.name)} × ${i.quantity}</li>`).join('')}</ul><small>${o.created_at}</small></div>`).join('');
}
function esc(v) {
    return String(v).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m]));
}
document.querySelectorAll('.chip').forEach(b => b.onclick = () => {
    document.querySelectorAll('.chip').forEach(x => x.classList.remove('active'));
    b.classList.add('active');
    loadMenu(b.dataset.cat)
});
loadMenu();
loadCart();
loadOrders();