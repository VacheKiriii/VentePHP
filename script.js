// Panier

let cartCount = 0;
let totalAmount = 0;
let cartItems = [];

function addToCart(name, price, image) {
  cartCount++;
  totalAmount += price;

  let item = cartItems.find(item => item.name === name);
  if (item) {
    item.quantity++;
    item.totalPrice += price;
  } else {
    cartItems.push({ name: name, price: price, quantity: 1, totalPrice: price, image: image });
  }

  saveCartToLocalStorage();
  updateCartMenu();
}

function removeFromCart(name) {
  let item = cartItems.find(item => item.name === name);
  if (item) {
    if (item.quantity === 1) {
      totalAmount -= item.totalPrice;
      cartItems = cartItems.filter(item => item.name !== name);
      cartCount--;
    } else {
      item.quantity--;
      item.totalPrice -= item.price;
      totalAmount -= item.price;
      cartCount--;
    }
    saveCartToLocalStorage();
    updateCartMenu();
  }
}

function updateCartMenu() {
  const cartItemsList = document.getElementById('cart-items');
  const cartCountElement = document.getElementById('cart-count');
  if (cartItemsList) {
    cartItemsList.innerHTML = '';

    cartItems.forEach(item => {
      const listItem = document.createElement('li');
      const quantityText = item.quantity > 1 ? ` x ${item.quantity}` : '';
      listItem.innerHTML = `
        <div class="cart-item-info">
          <img src="${item.image}" alt="${item.name}" class="cart-item-image">
          <div class="cart-item-details">
            <span class="cart-item-name">${item.name}</span>
            <span class="cart-item-price">${item.totalPrice.toFixed(2)} €</span>
          </div>
        </div>
        <div class="quantity-control">
          <button onclick="addToCart('${item.name}', ${item.price}, '${item.image}')">+</button>
          <button onclick="removeFromCart('${item.name}')">-</button>
        </div>
      `;
      cartItemsList.appendChild(listItem);
    });

    document.getElementById('total-cart-amount').innerText = totalAmount.toFixed(2);
    cartCountElement.innerText = cartCount > 0 ? cartCount : 0;
  }
}

function validatePayment() {
  window.location.href = 'https://www.paypal.com/signin';
}

function saveCartToLocalStorage() {
  localStorage.setItem('cartItems', JSON.stringify(cartItems));
  localStorage.setItem('totalAmount', totalAmount.toFixed(2));
  localStorage.setItem('cartCount', cartCount);
}

function loadCartFromLocalStorage() {
  const savedCartItems = localStorage.getItem('cartItems');
  const savedTotalAmount = localStorage.getItem('totalAmount');
  const savedCartCount = localStorage.getItem('cartCount');

  if (savedCartItems && savedTotalAmount && savedCartCount) {
    cartItems = JSON.parse(savedCartItems);
    totalAmount = parseFloat(savedTotalAmount);
    cartCount = parseInt(savedCartCount, 10);

    updateCartMenu();
  }
}

function toggleCart() {
  const cartMenu = document.getElementById('cart-menu');
  cartMenu.classList.toggle('visible');
}

function closeCart() {
  const cartMenu = document.getElementById('cart-menu');
  cartMenu.classList.remove('visible');
}

function searchProducts() {
  const searchQuery = document.getElementById('search-bar').value.toLowerCase();
  const products = document.querySelectorAll('.product');
  products.forEach(product => {
    const productName = product.querySelector('h2').innerText.toLowerCase();
    if (productName.includes(searchQuery)) {
      product.style.display = '';
    } else {
      product.style.display = 'none';
    }
  });
}

document.getElementById('search-bar').addEventListener('input', searchProducts);

window.onload = loadCartFromLocalStorage;
