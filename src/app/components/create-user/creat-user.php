<style>
    @import url(https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css);
</style>
<link rel="stylesheet" href="./components/create-user/create-user.css" />
<template id="create-form">
  <form id="my-form">
    <fieldset>
      <legend>帳號</legend>
      <label for="account">帳號：</label>
      <input
        id="account"
        type="text"
        name="acco"
        placeholder="請輸入帳號"
        required
      />
      <label for="password">密碼：</label>
      <input
        id="password"
        type="password"
        name="pw"
        placeholder="請輸入密碼"
        required
      />
      <label for="password">密碼確認：</label>
      <input
        id="password-confirm"
        type="password"
        placeholder="請再次輸入密碼"
        required
      />
    </fieldset>

    <fieldset>
      <legend>基本資料</legend>
      <label for="name">姓名：</label>
      <input
        id="name"
        type="text"
        name="name"
        placeholder="請輸入全名"
        maxlength="6"
        required
      />
      <label for="birth">生日：</label>
      <input
        id="birth"
        type="date"
        name="birth"
        placeholder="請輸入生日"
        required
      />
      <label for="email">信箱：</label>
      <input
        id="email"
        type="email"
        name="email"
        placeholder="請輸入電子信箱"
        pattern="^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
        required
      />
      <label for="tel">手機：</label>
      <input
        id="tel"
        type="tel"
        name="tel"
        placeholder="請輸入手機"
        pattern="^09\d{8}$"
        maxlength="10"
        required
      />
      <label for="addr">地址：</label>
      <input id="addr" type="text" name="addr" placeholder="請輸入地址" />
    </fieldset>

    <div class="action-bar">
      <button type="button" class="btn btn-secondary btn-sm" value="cancel">
        取消
      </button>
      <button type="submit" class="btn btn-primary btn-sm" value="submit">
        送出
      </button>
    </div>
  </form>
</template>
<script>
    // getUserData();

// function getUserData() {
//     const payload = encodeURI("name=new user&acco=user_account&birth=0101&email=newUser@gmail.com&pw=123&tel=0912345678");
//     const xhttp = new XMLHttpRequest();
//     xhttp.open("POST", "http://localhost/amusement-park/create-account.php", true);
//     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhttp.send(payload);

//     xhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//         //   displayData(JSON.parse(this.responseText));
//         }
//     };
// }

// function checkForm() {
//     if (!document.getElementById("account")) {
//         alert("輸入資料有誤，請確認");
//         return false;
//     }
//     return true;
// }

"use strict";
fetch("./components/create-user/create-user.html")
  .then((stream) => stream.text())
  .then((text) => define(text));

function define(html) {
  class CreateUser extends HTMLElement {
    static formAssociated = true;
    // formData = new FormData();

    constructor() {
      // establish prototype chain
      super();

      // attaches shadow tree and returns shadow root reference
      // https://developer.mozilla.org/en-US/docs/Web/API/Element/attachShadow
      const shadow = this.attachShadow({ mode: "open" });
      shadow.innerHTML = html;
      const template = shadow.getElementById("create-form").content;
      this.internals_ = this.attachInternals();

      shadow.appendChild(template.cloneNode(true));
    }

    connectedCallback() {
      this.shadowRoot.querySelectorAll("form input").forEach((element) => {
        element.addEventListener("input", (event) => {
          const value = event.target.value;
          element.setAttribute("value", value);
          //   if ($this.formData.has(event.target.name)) {
          //     $this.formData.set(event.target.name, value);
          //   } else {
          //     $this.formData.append(event.target.name, value);
          //   }
        });
      });
      this.shadowRoot
        .querySelector("form[id='my-form']")
        .addEventListener("submit", (event) => {
          event.preventDefault();
          this.checkForm();
        });
        
      //   this._modal = this.shadowRoot.querySelector(".modal");
      //   this.shadowRoot.querySelector("button").addEventListener('click',        this._showModal.bind(this));
      //   this.shadowRoot.querySelector(".close").addEventListener('click', this._hideModal.bind(this));
    }

    // disconnectedCallback() {
    //   this.shadowRoot.querySelector("button").removeEventListener('click', this._showModal);
    //   this.shadowRoot.querySelector(".close").removeEventListener('click', this._hideModal);
    // }

    // _showModal() {
    //  this._modalVisible = true;
    //  this._modal.style.display = 'block';
    // }

    // _hideModal() {
    //   this._modalVisible = false;
    //   this._modal.style.display = 'none';
    // }

    checkForm() {
      if (!this.shadowRoot.getElementById("account").value) {
        alert("輸入資料有誤，請確認");
        return false;
      }
      if (
        this.shadowRoot.getElementById("password").value !==
        this.shadowRoot.getElementById("password-confirm").value
      ) {
        alert("密碼不一致，請確認");
        return false;
      }
      this.submit();

    }

    submit() {
      const xhttp = new XMLHttpRequest();
      xhttp.open("POST", "http://localhost/cms/create-user.php", true);
      xhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );
      const formData = new FormData(
        this.shadowRoot.querySelector("form[id='my-form']")
      );
      // loop over FormData because some browsers do not support
      let payload = {};
      for (let [key, value] of formData.entries()) {
        payload[key] = value;
      }
      xhttp.send(JSON.stringify(payload));

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText === "SUCCESS") {
            alert(`用戶${payload.name}新增成功`);
          }
        }
      };
    }
  }

  // let the browser know about the custom element
  customElements.define("create-user", CreateUser);
}

</script>
