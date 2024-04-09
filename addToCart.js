// Creates add to cart functionality when not connected to an account.
let addToCart=document.getElementsByClassName("addToCart");
// Need to loop through all the elements as you can not add event listeners to classes.
for(let i=0;i<addToCart.length;i++){
    addToCart[i].addEventListener("click",function(event){
        event.preventDefault();
        alert("Added to cart!");
        // Check if order key is not null.
        if(sessionStorage.getItem("order")!==null){
            let products = sessionStorage.getItem("order").split(",");
            products.push(addToCart[i].id);
            let order = "";
            for(let j =0;j<products.length;j++){
                order+=products[j];
                if(j!==products.length-1){
                    order+=",";
                }
            }
            sessionStorage.setItem("order",order);
        }
        // If it is null, create new one.
        else{
            let order = addToCart[i].id;
            sessionStorage.setItem("order",order);
        }
    });
}