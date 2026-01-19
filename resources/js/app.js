import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import './bootstrap';

function addToCart(id){
fetch('/api/cart/add',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({id_menu:id})})
.then(r=>r.json()).then(j=> refreshCart(j.cart));
}

function updateCart(id,act){
let action='set'; let jumlah=0; // we'll send inc/dec semantics to server
fetch('/api/cart/update',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:JSON.stringify({id_menu:id, action:act})})
.then(r=>r.json()).then(j=> refreshCart(j.cart));
}

function refreshCart(cart){
// naive: reload page for simplicity (or update DOM)
location.reload();
}

window.addToCart = addToCart; window.updateCart = updateCart;