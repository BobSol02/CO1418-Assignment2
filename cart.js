// Pass order to server side if not connected to an account.
// Prevent variable is used to stop refreshing as otherwise will constantly refresh.
function cart(){
    let orders = sessionStorage.getItem("order");
    if(orders!==null){
        let form = document.createElement("form");
        form.setAttribute("method","POST");
        form.setAttribute("onsubmit","return false;");
        let input = document.createElement("input");
        input.setAttribute("type","hidden");
        input.setAttribute("name","order");
        input.setAttribute("value",orders);
        form.appendChild(input);
        let prevent = document.createElement("input");
        prevent.setAttribute("type","hidden");
        prevent.setAttribute("name","prevent");
        prevent.setAttribute("value","1");
        form.appendChild(prevent);
        document.body.appendChild(form);
        form.submit();
    }
}
// Total function. Calculates total cost.
function total(){
    let prices=document.getElementsByClassName("price");
    let total = 0;
    for(let i=0;i<prices.length;i++){
        total+=Number(prices[i].id);
    }
    document.getElementById("total").innerText+=total;
}
// Remove from cart while logged in. Will pass the product to remove along with the return page to removeFromCart.php
function removeFromCartSession(){
    let removeFromCart=document.getElementsByClassName("removeFromCart");
    // Need to loop through all the elements as you can not add event listeners to classes.
    for(let i=0;i<removeFromCart.length;i++){
        removeFromCart[i].addEventListener("click",function(event){
            event.preventDefault();
            let form = document.createElement("form");
            form.setAttribute("method","POST");
            form.setAttribute("action","removeFromCart.php");
            let id = document.createElement("input");
            id.setAttribute("type","hidden");
            id.setAttribute("name","id");
            id.setAttribute("value",removeFromCart[i].id);
            form.appendChild(id);
            let url = document.createElement("input");
            url.setAttribute("type","hidden");
            url.setAttribute("name","url");
            url.setAttribute("value",window.location.href);
            form.appendChild(url);
            document.body.appendChild(form);
            form.submit();
        });
    }
}
// Remove from cart if not connected to an account.
function removeFromCart(){
    let removeFromCart=document.getElementsByClassName("removeFromCart");
    // Need to loop through all the elements as you can not add event listeners to classes.
    for(let i=0;i<removeFromCart.length;i++){
        removeFromCart[i].addEventListener("click",function(event){
            event.preventDefault();
            if(sessionStorage.getItem("order")!==null){
                // Break the order into individual products.
                let products = sessionStorage.getItem("order").split(",");
                let order = "";
                // Needed to prevent removal of all products with same id.
                let flag = false;
                for(let j=0;j<products.length;j++){
                    if(products[j]===removeFromCart[i].id && !flag){
                        flag=true;
                    }
                    else{
                        order+=products[j];
                        if(j!==products.length-1){
                            order+=",";
                        }
                    }
                }
                // Check if there are any products remaining.
                if(order.length>0)
                    sessionStorage.setItem("order",order);
                // If none are left, remove the key.
                else
                    sessionStorage.removeItem("order");
                // Needed to refresh. If refreshing normally it will remove all items with the same id.
                let url = window.location.href;
                window.location.href=url;
            }
        });
    }
}
// Checkout functionality. Will pass a checkout value and the return url to checkout.php
function checkout(){
    document.getElementById("checkout").addEventListener("click",function (event){
        alert("Checkout complete!");
        let form = document.createElement("form");
        form.setAttribute("method","POST");
        form.setAttribute("action","checkout.php");
        let checkout = document.createElement("input");
        checkout.setAttribute("type","hidden");
        checkout.setAttribute("name","checkout");
        checkout.setAttribute("value","true");
        form.appendChild(checkout);
        let url = document.createElement("input");
        url.setAttribute("type","hidden");
        url.setAttribute("name","url");
        url.setAttribute("value",window.location.href);
        form.appendChild(url);
        document.body.appendChild(form);
        form.submit();
    });
}
