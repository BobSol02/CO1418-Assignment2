document.getElementById("searchButton").addEventListener("click",function (){
    let search = document.getElementById("search").value.toLowerCase().split(" ");
    let exist = true;
    //109 different products
    for(let i = 1;i<110;i++){
        // Check if the search string exists. If it does not hide the product.
        for(let j=0;j<search.length;j++){
            if(!document.getElementById(i).className.toLowerCase().includes(search[j]))
                exist=false;
        }
        if(!exist)
            document.getElementById(i).style.display="none";
        else
            document.getElementById(i).style.display="";
        exist = true;
    }
});