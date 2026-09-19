$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | CART KEY
    |--------------------------------------------------------------------------
    */
    const CART_KEY = "shops";


    /*
    |--------------------------------------------------------------------------
    | GET CART
    |--------------------------------------------------------------------------
    */
    function getCart() {
        let cartString = localStorage.getItem(CART_KEY);

        if (!cartString) {
            return [];
        }

        try {
            let cart = JSON.parse(cartString);

            if (!Array.isArray(cart)) {
                return [];
            }

            return cart;
        } catch (error) {
            return [];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE CART
    |--------------------------------------------------------------------------
    */
    function saveCart(cart) {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    }


    /*
    |--------------------------------------------------------------------------
    | CART COUNT
    |--------------------------------------------------------------------------
    */
    function count() {

        let cart = getCart();

        let totalQty = 0;

        $.each(cart, function (i, item) {

            let qty = Number(item.qty);

            if (!isNaN(qty) && qty > 0) {
                totalQty += qty;
            }

        });

        $("#item-count").text(totalQty);
    }


    /*
    |--------------------------------------------------------------------------
    | MAKE COUNT AVAILABLE GLOBALLY
    |--------------------------------------------------------------------------
    */
    window.updateCartCount = count;


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */
    window.addToCart = function (cartData) {

        let cart = getCart();

        let newItem = {
            id: cartData.id,
            name: cartData.name,
            price: Number(cartData.price) || 0,
            discount: Number(cartData.discount) || 0,
            image: cartData.image || "",
            qty: Number(cartData.qty) || 1,

            variant_id:
                cartData.variant_id !== undefined
                    ? cartData.variant_id
                    : null,

            variant_sku:
                cartData.variant_sku || null,

            variant_stock:
                cartData.variant_stock !== undefined
                    ? Number(cartData.variant_stock)
                    : null,

            selected_options:
                cartData.selected_options || []
        };


        /*
        |--------------------------------------------------------------------------
        | FIND SAME PRODUCT + SAME VARIANT
        |--------------------------------------------------------------------------
        */

        let existingIndex = cart.findIndex(function (item) {

            let sameProduct =
                Number(item.id) === Number(newItem.id);

            let sameVariant =
                String(item.variant_id ?? "null") ===
                String(newItem.variant_id ?? "null");

            return sameProduct && sameVariant;

        });


        /*
        |--------------------------------------------------------------------------
        | SAME PRODUCT + SAME VARIANT
        |--------------------------------------------------------------------------
        */

        if (existingIndex !== -1) {

            cart[existingIndex].qty =
                Number(cart[existingIndex].qty) +
                Number(newItem.qty);

        }

        /*
        |--------------------------------------------------------------------------
        | NEW PRODUCT / DIFFERENT VARIANT
        |--------------------------------------------------------------------------
        */

        else {

            cart.push(newItem);

        }


        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        saveCart(cart);

        /*
        |--------------------------------------------------------------------------
        | UPDATE NAVBAR COUNT
        |--------------------------------------------------------------------------
        */

        count();

    };


    /*
    |--------------------------------------------------------------------------
    | NORMAL ADD TO CART BUTTON
    |
    | This is for Related Products / other .addToCart buttons.
    |--------------------------------------------------------------------------
    */

    $(document).on("click", ".addToCart", function (e) {

        /*
        | Product Detail button has its own handler.
        | It does NOT have .addToCart anymore.
        */

        let id = $(this).data("id");
        let name = $(this).data("name");
        let price = $(this).data("price");
        let discount = $(this).data("discount");
        let image = $(this).data("image");

        /*
        | Try to get quantity from nearby quantity input.
        | If not found, use 1.
        */

        let qtyInput = $(this)
            .closest(".card, .product-card, .product-item")
            .find(".qty")
            .first();

        let qty = qtyInput.length
            ? Number(qtyInput.val())
            : 1;

        if (!qty || qty < 1) {
            qty = 1;
        }


        /*
        | Add normal product
        */

        window.addToCart({

            id: id,
            name: name,
            price: price,
            discount: discount,
            image: image,
            qty: qty,

            variant_id: null,
            variant_sku: null,
            variant_stock: null,
            selected_options: []

        });

    });


    /*
    |--------------------------------------------------------------------------
    | CART TABLE
    |--------------------------------------------------------------------------
    */

    function getData() {

        let cart = getCart();

        let data = "";

        let no = 1;

        let total = 0;


        if (cart.length === 0) {

            $("tbody").html(`
                <tr>
                    <td colspan="7" class="text-center">
                        Your cart is empty.
                    </td>
                </tr>
            `);

            return;
        }


        $.each(cart, function (i, item) {

            let price = Number(item.price) || 0;

            let discount = Number(item.discount) || 0;

            let qty = Number(item.qty) || 0;


            let finalPrice =
                price - (price * (discount / 100));


            let subTotal =
                Math.round(finalPrice * qty);


            total += subTotal;


            data += `
                <tr>

                    <td>
                        ${no++}
                    </td>

                    <td>
                        ${item.name}
                    </td>

                    <td>
                        <img
                            src="${item.image}"
                            width="50"
                            height="50"
                        >
                    </td>

                    <td>
                        ${price}
                    </td>

                    <td>
                        ${discount}%
                    </td>

                    <td>

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary min"
                            data-key="${i}"
                        >
                            -
                        </button>

                        <span class="mx-2">
                            ${qty}
                        </span>

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary max"
                            data-key="${i}"
                        >
                            +
                        </button>

                    </td>

                    <td>
                        ${subTotal} MMK
                    </td>

                </tr>
            `;
        });


        data += `
            <tr>

                <td
                    colspan="6"
                    align="right"
                >
                    <strong>Total</strong>
                </td>

                <td>
                    <strong>
                        ${total} MMK
                    </strong>
                </td>

            </tr>
        `;


        $("tbody").html(data);
    }


    /*
    |--------------------------------------------------------------------------
    | DECREASE QUANTITY
    |--------------------------------------------------------------------------
    */

    $("tbody").on("click", ".min", function () {

        let key = Number($(this).data("key"));

        let cart = getCart();


        if (!cart[key]) {
            return;
        }


        cart[key].qty =
            Number(cart[key].qty) - 1;


        /*
        | Remove when quantity becomes 0
        */

        if (cart[key].qty <= 0) {

            let answer =
                confirm("Are you sure you want to remove this item?");


            if (answer) {

                cart.splice(key, 1);

            } else {

                cart[key].qty = 1;

            }

        }


        saveCart(cart);

        getData();

        count();

    });


    /*
    |--------------------------------------------------------------------------
    | INCREASE QUANTITY
    |--------------------------------------------------------------------------
    */

    $("tbody").on("click", ".max", function () {

        let key = Number($(this).data("key"));

        let cart = getCart();


        if (!cart[key]) {
            return;
        }


        cart[key].qty =
            Number(cart[key].qty) + 1;


        saveCart(cart);

        getData();

        count();

    });


    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    count();

    getData();

});
