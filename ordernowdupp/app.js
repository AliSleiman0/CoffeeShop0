const myArray2 = [
  { productid: "8888", quantity: 2 },
  { productid: "9999", quantity: 1 },
  { productid: "7777", quantity: 3 },
];
let listProduct = [];
let carts = [];
let iconCart = document.querySelector(".icon-cart");

let closeCart = document.querySelector(".close");
let body = document.querySelector("body");
let listProductsHTML = document.querySelector(".listProduct");
let listCartHTML = document.querySelector(".listCart");
let iconCartSpan = document.querySelector(".icon-cart span");


iconCart.addEventListener("click", () => {
  body.classList.toggle("showCart");
});
closeCart.addEventListener("click", () => {
  body.classList.toggle("showCart");
});

const addToCart = (product_id) => {
  let positionThisProductInCart = carts.findIndex(
    (value) => value.product_id === product_id
  );
  if (carts.length <= 0) {
    carts = [
      {
        product_id: product_id,
        quantity: 1,
      },
    ];
    console.log("first item was added");
  } else if (positionThisProductInCart < 0) {
    carts.push({
      product_id: product_id,
      quantity: 1,
    });
    console.log("cart not empty. your item is added");
  } else {
    carts[positionThisProductInCart].quantity += 1;
    console.log("item exists in cart, quantity is incremented");
  }
  console.log(carts);
  addCartToHTML();
};

const addCartToHTML = () => {
  listCartHTML.innerHTML = "";
  let totalQuantity = 0;
  if (carts.length > 0) {
    carts.forEach((cart) => {
      let newCart = document.createElement("div");
      totalQuantity += cart.quantity;
      let productPosition = listProduct.findIndex(
        (value) => value.id == cart.product_id
      );
      let info = listProduct[productPosition];
      newCart.classList.add("item");
      newCart.dataset.id = cart.product_id;
      newCart.innerHTML = `
                <div class="image">
                    <img src="../${info.image}" alt="">
                </div>
                <div class="name">
                    ${info.title}
                </div>
                <div class="totalPrice">
                    $${info.price * cart.quantity} 
                </div>
                <div class="quantity">
                    <span class="minus"><</span>
                    <span >${cart.quantity}</span>
                    <span class="plus">></span>
                </div>
            `;
      listCartHTML.appendChild(newCart);
    });
  }
  iconCartSpan.innerText = totalQuantity;
};
listProductsHTML.addEventListener("click", (event) => {
  let positionClick = event.target;
  if (positionClick.classList.contains("addCart")) {
    let product_id = positionClick.parentElement.dataset.id;
    console.log(product_id);
    addToCart(product_id);
  }
});
listCartHTML.addEventListener("click", (event) => {
  let positionCheck = event.target;
  if (
    positionCheck.classList.contains("minus") ||
    positionCheck.classList.contains("plus")
  ) {
    let product_id = positionCheck.parentElement.parentElement.dataset.id;
    let type = "minus";
    if (positionCheck.classList.contains("plus")) {
      type = "plus";
    }
    changeQuantity(product_id, type);
  }
});
const changeQuantity = (product_id, type) => {
  let positionItemInCart = carts.findIndex(
    (value) => value.product_id == product_id
  );
  if (positionItemInCart >= 0) {
    switch (type) {
      case "plus":
        carts[positionItemInCart].quantity++;
        break;

      default:
        let valueChange = carts[positionItemInCart].quantity - 1;
        if (valueChange > 0) {
          carts[positionItemInCart].quantity = valueChange;
        } else {
          carts.splice(positionItemInCart, 1);
        }
        break;
    }
  }
  addCartToHTML();
};

const fetchProducts = () => {
  fetch("productsJSON.php")
    .then((response) => response.json())
    .then((data) => {
      listProduct = data.map((item) => ({
        id: item.id,
        title: item.title,
        image: item.image,
        price: item.price,
      }));
      console.log(listProduct); // Log the array to the console to verify
    })
    .catch((error) => {
      console.error("Error fetching products:", error);
    });
};
fetchProducts();
