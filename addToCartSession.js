//Add to cart for logged in users. Javascript part.
let addToCart=document.getElementsByClassName("addToCart");
// Need to loop through all the elements as you can not add event listeners to classes.
for(let i=0;i<addToCart.length;i++){
    addToCart[i].addEventListener("click",function(event){
        let order = "";
        // Check if order key is not null. If it isn't add it to order variable.
        if(sessionStorage.getItem("order")!==null){
            order = sessionStorage.getItem("order");
            sessionStorage.removeItem("order");
            alert("Added to cart");
            order+=","+addToCart[i].id;
        }
        // If it is null, add only the current product to order.
        else
            order=addToCart[i].id;
        event.preventDefault();
        // Form to pass data to server side. Will redirect to addToCart.php and pass the order along with the return url.
        let form = document.createElement("form");
        form.setAttribute("method","POST");
        form.setAttribute("action","addToCart.php");
        let id = document.createElement("input");
        id.setAttribute("type","hidden");
        id.setAttribute("name","order");
        id.setAttribute("value",order);
        form.appendChild(id);
        let url = document.createElement("input");
        url.setAttribute("type","hidden");
        url.setAttribute("name","url");
        url.setAttribute("value",window.location.href);
        form.appendChild(url)
        document.body.appendChild(form);
        form.submit();
    });
}
