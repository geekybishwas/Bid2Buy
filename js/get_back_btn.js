document.addEventListener('DOMContentLoaded', function () {
    // Get the buttons by their IDs
    const goBackBtns = document.getElementsByClassName('get_back_btn');
    // Function to handle the click event and redirect
    function redirectToPage(path) {
        window.location.href = path;
    }
    for(let i=0;i<goBackBtns.length;i++){
        goBackBtns[i].addEventListener('click',()=>{
            if(goBackBtns[i].innerHTML==='❌ Go Back'){
                redirectToPage('./homepage.html');
            }else{
                redirectToPage('../index.html');
            }
        });
    }
});