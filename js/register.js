


document.addEventListener('DOMContentLoaded', function () {
  //terms and condition ko lagi
  let openPopupLink = document.getElementsByClassName("pop-up-on-click")[0];
  openPopupLink.addEventListener("click", () => {

    // Open a new popup window
    const popupWindow = window.open("", "PopupWindow", "width=400,height=300,left=" + (screen.width - 400) / 2 + ",top=" + (screen.height - 300) / 2);
    // Write content to the popup window
    popupWindow.document.write(`
    <html>
    <head>
      <title>Terms and Conditions</title>
    </head>
    <body>
      <h3>Following terms and conditions are allowed On Clicking</h3>
      <p>
      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quo dicta laborum esse expedita. Consectetur similique alias optio aliquid. Placeat nesciunt eos aperiam facere vitae! Odit, non harum vel est enim, natus ut voluptatibus quam id quia, ullam illo. Ex fuga necessitatibus corrupti, expedita beatae qui repellendus corporis quibusdam earum, magni mollitia impedit sapiente natus. Facilis aliquam quidem adipisci doloribus consequatur sapiente ipsam temporibus molestiae veritatis praesentium quasi modi, vel soluta inventore esse, blanditiis consequuntur libero quo nemo dolorem eum accusantium quod facere! Impedit obcaecati illum culpa quos recusandae blanditiis est asperiores veniam iusto, ipsam fugiat labore rem tempore natus! Officiis! Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque ratione totam, et illum iure consectetur veniam. Ab culpa quia harum corrupti tempora. Facere libero quibusdam, maxime ducimus cumque reiciendis ex et dicta tenetur molestiae! Ratione veritatis quam rem, harum laudantium voluptatem ipsa ipsam quaerat quos nulla eligendi. Minus, commodi esse?</p>
    </body>
    </html>
  `);
  });
  //for registration validation msg:
  document.getElementById("register-submit").addEventListener("click", (event) => {
    event.preventDefault();
    alert("registration successful!! Login now------>");
    window.location.href = "./signin.html";
  });
  //pasword show->
  const showPW = document.getElementById("toggle-password");
  const showRepeatPW = document.getElementById("toggle-repeat-password");
  showPW.addEventListener("click", () => {
    showPW.classList.toggle("fa-eye");
    showRepeatPW.classList.toggle("fa-eye");
    showPW.classList.toggle("fa-eye-slash");
    showRepeatPW.classList.toggle("fa-eye-slash");
    const targets = document.getElementsByClassName("register-password");
    for (i = 0; i < targets.length; i++) {
      if (targets[i].type == "password") {
        targets[i].type = "text";
      } else {
        targets[i].type = "password"
      }
    }
  });
});