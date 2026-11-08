async function adminAPI(action, data = {}) {
    const fd = new FormData();
    fd.append('action', action); Object.entries(data).forEach(([k, v]) => fd.append(k, v));
    const r = await fetch(BASE_URL + '/ajax/admin.php', { method: 'POST', body: fd });
    return r.json();
}
async function loadAdminMenu() {
    const box = document.getElementById('adminMenu');
    if (!box) return;
    const d = await adminAPI('menu');
    box.innerHTML = '<div class="card"><table><tr><th>Name</th><th>Category</th><th>Price</th><th>Action</th></tr>' + d.items.map(x => `<tr><td>${esc(x.name)}</td><td>${esc(x.category)}</td><td>${Number(x.price).toFixed(2)}</td><td><button onclick='editFood(${JSON.stringify(x)})'>Edit</button> <button onclick='deleteFood(${x.id})'>Remove</button></td></tr>`).join('') + '</table></div>';
}
function editFood(x) {
    foodId.value = x.id;
    foodCategory.value = x.category_id;
    foodName.value = x.name;
    foodDescription.value = x.description || '';
    foodPrice.value = x.price; window.scrollTo(0, 0);
}
function clearFood() {
    document.getElementById('foodForm').reset();
    foodId.value = '';
}
async function deleteFood(id) {
    if (confirm('Remove this menu item?')) {
        await adminAPI('delete_menu', { id });
        loadAdminMenu();
    }
}
const ff = document.getElementById('foodForm');
if (ff) ff.onsubmit = async e => {
    e.preventDefault();
    const d = await adminAPI('save_menu', Object.fromEntries(new FormData(ff)));
    foodMsg.textContent = d.message;
    clearFood();
    loadAdminMenu();
};
async function loadAdminOrders() {
    const box = document.getElementById('adminOrders');
    if (!box) return;
    const d = await adminAPI('orders');
    box.innerHTML = d.orders.map(o => `<div class="card order"><h3>Order #${o.id}</h3><p>Customer: ${esc(o.customer)} | ${esc(o.phone || '')}</p><p>Total: ৳${Number(o.total_amount).toFixed(2)}</p><p>Address: ${esc(o.delivery_address)}</p><p>Status: <b>${esc(o.status)}</b></p><select onchange="setOrderStatus(${o.id},this.value)"><option value="">Change status</option><option>Accepted</option><option>Rejected</option><option>Preparing</option><option>Ready for Pickup</option></select></div>`).join('');
}
async function setOrderStatus(id, status) {
    if (status) {
        await adminAPI('order_status', { id, status });
        loadAdminOrders();
    }
}
function esc(v) {
    return String(v).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m]));
}
loadAdminMenu();
loadAdminOrders();