document.addEventListener('DOMContentLoaded', function () {
    // Get the buttons by their IDs
    const userProfile = document.getElementById('profile_pic');
    const userDetailBox = document.getElementById('user_detail_box');
    function switchUserDetail(){
        userDetailBox.classList.toggle('hide');
    }
    userProfile.addEventListener('click',switchUserDetail);
});