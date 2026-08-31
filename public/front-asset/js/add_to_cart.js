$(document).ready(function () {
    count();
    $(".addToCart").click(function () {
        // alert("Hello");
        let id = $(this).data("id");
        let name = $(this).data("name");
        let price = $(this).data("price");
        let discount = $(this).data("discount");
        let image = $(this).data("image");
        let qty = $(".qty").val();
        console.log(id, name, price);

        let items = {
            id: id,
            name: name,
            price: price,
            discount: discount,
            image: image,
            qty: qty,
        };

        let itemString = localStorage.getItem("shops");
        let itemArray;
        if (itemString == null) {
            itemArray = [];
        } else {
            itemArray = JSON.parse(itemString);
        }
        let status = false;
        $.each(itemArray, function (i, v) {
            if (id == v.id) {
                v.qty = Number(v.qty) + Number(qty);
                status = true;
            }
        });

        if (status == false) {
            itemArray.push(items);
        }

        let itemData = JSON.stringify(itemArray);
        localStorage.setItem("shops", itemData);
        count();
    });
    // function count() {
    //     let itemString = localStorage.getItem("shops");
    //     if (itemString) {
    //         let itemArray = JSON.parse(itemString);
    //         let count = 0;
    //         $.each(itemArray, function (i, v) {
    //             if (itemArray != 0) {
    //                 count += v.qty;
    //                 $("#item-count").text(count);
    //             } else {
    //                 $("#item-count").text("0");
    //             }
    //         });
    //     }
    // }

    function count() {
        let itemString = localStorage.getItem("shops");

        if (itemString) {
            let itemArray = JSON.parse(itemString);

            let count = 0;

            $.each(itemArray, function (i, v) {
                count += Number(v.qty);
            });

            $("#item-count").text(count);
        } else {
            $("#item-count").text(0);
        }
    }
    getData();
    function getData() {
        let itemString = localStorage.getItem("shops");
        if (itemString) {
            let itemArray = JSON.parse(itemString);

            let data = "";
            let no = 1;
            let total = 0;
            $.each(itemArray, function (i, v) {
                data += `<tr>
                        <td>${no++}</td>
                        <td>${v.name}</td>
                        <td><img src="${v.image}" width="50" height="50"></td>
                        <td>${v.price}</td>
                        <td>${v.discount}</td>
                        <td>
                        <button class="btn btn-sm btn-outline-secondary min" data-key=${i}>-</button>
                        ${v.qty}
                        <button class="btn btn-sm btn-outline-secondary max"  data-key=${i}>+</button>
                        </td>
                        <td>${Math.round(
                            (v.price - v.price * (v.discount / 100)) * v.qty,
                        )} MMk</td>
                </tr>`;
                total += Math.round(
                    (v.price - v.price * (v.discount / 100)) * v.qty,
                );
            });
            data += `<tr>
                <td colspan="6"
                align="right">Total</td>
                <td> ${total} MMK</td>
            </tr>`;

            $("tbody").html(data);
        }
    }

    $("tbody").on("click", ".min", function () {
        let key = $(this).data("key");
        // alert(key);

        let itemString = localStorage.getItem("shops");
        if (itemString) {
            let itemArray = JSON.parse(itemString);

            $.each(itemArray, function (i, v) {
                if (key == i) {
                    v.qty--;
                    if (v.qty == 0) {
                        let ans = confirm("Are you sure remove?");
                        if (ans) {
                            itemArray.splice(key, 1);
                        } else {
                            v.qty = 1;
                        }
                    }
                }
            });
            let itemData = JSON.stringify(itemArray);
            localStorage.setItem("shops", itemData);
            getData();
            count();
        }
    });

    $("tbody").on("click", ".max", function () {
        let key = $(this).data("key");
        // alert(key);

        let itemString = localStorage.getItem("shops");
        if (itemString) {
            let itemArray = JSON.parse(itemString);

            $.each(itemArray, function (i, v) {
                if (key == i) {
                    v.qty++;
                }
            });
            let itemData = JSON.stringify(itemArray);
            localStorage.setItem("shops", itemData);
            getData();
            count();
        }
    });
});
