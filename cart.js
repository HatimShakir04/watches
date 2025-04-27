// Cart functionality
const cart = {
    items: [],
    total: 0,

    // Initialize cart
    init() {
        try {
            this.loadCart();
        } catch (error) {
            console.error('Error loading cart:', error);
            this.items = [];
            this.total = 0;
        }
    },

    // Add item to cart
    addItem(item) {
        try {
            const existingItem = this.items.find(i => i.id === item.id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.items.push({...item, quantity: 1});
            }
            this.calculateTotal();
            this.saveCart();
            this.updateCartDisplay();
        } catch (error) {
            console.error('Error adding item to cart:', error);
        }
    },


    // Remove item from cart
    removeItem(itemId) {
        this.items = this.items.filter(item => item.id !== itemId);
        this.calculateTotal();
        this.saveCart();
        this.updateCartDisplay();
    },

    // Update item quantity
    updateQuantity(itemId, quantity) {
        const item = this.items.find(i => i.id === itemId);
        if (item) {
            item.quantity = quantity;
            if (item.quantity <= 0) {
                this.removeItem(itemId);
            } else {
                this.calculateTotal();
                this.saveCart();
                this.updateCartDisplay();
            }
        }
    },

    // Calculate total price
    calculateTotal() {
        this.total = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    },

    // Save cart to localStorage
    saveCart() {
        try {
            localStorage.setItem('cart', JSON.stringify(this.items));
        } catch (error) {
            console.error('Error saving cart:', error);
        }
    },

    // Load cart from localStorage
    loadCart() {
        try {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                this.items = JSON.parse(savedCart);
                this.calculateTotal();
                this.updateCartDisplay();
            }
        } catch (error) {
            console.error('Error loading cart:', error);
            this.items = [];
            this.total = 0;
        }
    },


    // Update cart display
    updateCartDisplay() {
        const cartItems = document.querySelector('.cart-items');
        const cartTotal = document.querySelector('.cart-summary p');
        
        if (cartItems) {
            cartItems.innerHTML = this.items.map(item => `
                <div class="cart-item">
                    <h3>${item.name}</h3>
                    <p>Price: $${item.price.toFixed(2)}</p>
                    <div class="quantity-control">
                        <button onclick="cart.updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="cart.updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                    </div>
                    <button onclick="cart.removeItem('${item.id}')">Remove</button>
                </div>
            `).join('');

            cartTotal.textContent = `Total: $${this.total.toFixed(2)}`;
        }
    }
};

// Initialize cart when page loads
document.addEventListener('DOMContentLoaded', function() {
    let cartItemsContainer = document.querySelector('.cart-items');
    let cartSummary = document.querySelector('.cart-summary p');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
        cartSummary.textContent = 'Total: $0.00';
        return;
    }

    let total = 0;
    cartItemsContainer.innerHTML = '';
    cart.forEach(item => {
        let itemTotal = item.price * item.quantity;
        total += itemTotal;

        let cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <h3>${item.productName}</h3>
            <p>Price: $${item.price}</p>
            <p>Quantity: ${item.quantity}</p>
            <p>Total: $${itemTotal.toFixed(2)}</p>
        `;
        cartItemsContainer.appendChild(cartItem);
    });

    cartSummary.textContent = `Total: $${total.toFixed(2)}`;
});
