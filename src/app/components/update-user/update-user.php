<style>
    @import url(https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css);
</style>
<template id="update-modal">
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">資料更新</h1>
        </div>
        <div class="modal-body">
          <label for="account">帳號：</label>
          <input id="account" type="text" readonly />
          <label for="name">姓名：</label>
          <input id="name" type="text" readonly />
          <label for="birth">生日：</label>
          <input id="birth" type="date" readonly />
          <label for="email">信箱：</label>
          <input id="email" type="email" required />
          <label for="tel">手機：</label>
          <input id="tel" type="tel" required />
          <label for="addr">地址：</label>
          <input id="addr" type="text" />
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            取消
          </button>
          <button type="button" class="btn btn-primary">確定</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

    "use strict";
    fetch("./components/update-user/update-user.html")
      .then((stream) => stream.text())
      .then((text) => define(text));
    
    function define(html) {
      class UpdateUser extends HTMLElement {
        constructor() {
          // establish prototype chain
          super();
    
          // attaches shadow tree and returns shadow root reference
          // https://developer.mozilla.org/en-US/docs/Web/API/Element/attachShadow
          const shadow = this.attachShadow({ mode: "open" });
          shadow.innerHTML = html;
          const template = shadow.getElementById("update-modal").content;
    
          shadow.appendChild(template.cloneNode(true));
        }
    
        // connectedCallback() {
        //   this._modal = this.shadowRoot.querySelector(".modal");
        //   this.shadowRoot.querySelector("button").addEventListener('click',        this._showModal.bind(this));
        //   this.shadowRoot.querySelector(".close").addEventListener('click', this._hideModal.bind(this));
        // }
    
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
      }
    
      // let the browser know about the custom element
      customElements.define("update-user", UpdateUser);
    }
</script>
