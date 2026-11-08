async function deliveryAPI(action, data = {}) {
    const fd = new FormData(); fd.append('action', action);
    Object.entries(data).forEach(([k, v]) => fd.append(k, v));
    const r = await fetch(BASE_URL + '/ajax/delivery.php', { method: 'POST', body: fd });
    return r.json();
}
async function loadDeliveries() {
    const box = document.getElementById('deliveryBox');
    if (!box) return;
    const d = await deliveryAPI('list');
    box.innerHTML = d.items.length ? d.items.map(x => `<div class="card order"><h3>Order #${x.order_id}</h3><p>Customer: ${esc(x.customer)}</p><p>Address: ${esc(x.delivery_address)}</p><p>Status: <b>${esc(x.status)}</b></p><select onchange="updateDelivery(${x.id},this.value)"><option value="">Update</option><option>Picked Up</option><option>On the Way</option><option>Delivered</option></select></div>`).join('') : '<div class="card">No assigned deliveries.</div>';
}
async function loadHistory() {
    const box = document.getElementById('historyBox');
    if (!box) return;
    const d = await deliveryAPI('history');
    box.innerHTML = d.items.length ? d.items.map(x => `<div class="card"><h3>Order #${x.order_id}</h3><p>Customer: ${esc(x.customer)}</p><p>Address: ${esc(x.delivery_address)}</p><p>Status: ${esc(x.status)}</p></div>`).join('') : '<div class="card">No delivery history.</div>';
}
async function updateDelivery(id, status) {
    if (status) {
        await deliveryAPI('status', { id, status });
        loadDeliveries();
    }
}
function esc(v) {
    return String(v).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m]));
}
loadDeliveries();
loadHistory();