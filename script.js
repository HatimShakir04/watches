let cart = [];

function addToCart(product, price) {
    cart.push({ product, price });
    alert(product + " added to cart!");
    console.log(cart);
}
