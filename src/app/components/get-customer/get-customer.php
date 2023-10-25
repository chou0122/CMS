<style>
    @import url(https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css);

:host div#table {
    display: grid;
    grid-template-columns: repeat(2, auto) repeat(9, 1fr);
    grid-auto-flow: row;
}

:host div#table > div {
    border: solid 1px black;
    padding: .2rem .75rem;
}
</style>
<link rel="stylesheet" href="./components/get-customer/get-customer.css" />
<template id="result-table">
  <span>會員資料查詢</span>
  <div id="table"></div>

  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">...</div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Close
          </button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    "use strict";
fetch("./components/get-customer/get-customer.html")
  .then((stream) => stream.text())
  .then((text) => define(text));

function define(html) {
  class GetCustomer extends HTMLElement {
    constructor() {
      // establish prototype chain
      super();

      // attaches shadow tree and returns shadow root reference
      // https://developer.mozilla.org/en-US/docs/Web/API/Element/attachShadow
      const shadow = this.attachShadow({ mode: "open" });
      shadow.innerHTML = html;
      const template = shadow.getElementById("result-table").content;

      shadow.appendChild(template.cloneNode(true));
    }

    connectedCallback() {
      this.getUserData();
    }

    getUserData() {
      const xhttp = new XMLHttpRequest();
      xhttp.open("GET", "http://localhost/cms/get-user-info.php", true);
      xhttp.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );
      xhttp.send();

      const $this = this;
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          $this.displayData(JSON.parse(this.responseText));
        }
      };
    }

    displayData(data) {
      let html =
        "<div>刪除</div><div>id</div><div>姓名</div><div>帳號</div><div>生日</div><div>電子信箱</div><div>密碼</div><div>連絡電話</div><div>地址</div><div>建立時間</div><div>更新時間</div>";
      data.forEach((cus) => {
        html += `<div name="row_${cus.id}">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Launch demo modal
            </button>
                    <button class="btn btn-danger btn-sm remove-item" data-id="${cus.id}" data-name="${cus.name}">刪除</button>
                </div>`;
        html += `<div name="row_${cus.id}">${cus.id}</div>`;
        html += `<div name="row_${cus.id}">${cus.name}</div>`;
        html += `<div name="row_${cus.id}">${cus.acco}</div>`;
        html += `<div name="row_${cus.id}">${cus.birth}</div>`;
        html += `<div name="row_${cus.id}">${cus.email}</div>`;
        html += `<div name="row_${cus.id}">${cus.pw}</div>`;
        html += `<div name="row_${cus.id}">${cus.tel}</div>`;
        html += `<div name="row_${cus.id}">${cus.addr}</div>`;
        html += `<div name="row_${cus.id}">${cus.createtime}</div>`;
        html += `<div name="row_${cus.id}">${cus.updatetime}</div>`;
      });
      this.shadowRoot.getElementById("table").innerHTML = html;

      this.handleDeleteUserListener(
        this.shadowRoot.querySelectorAll(".remove-item")
      );
    }

    handleDeleteUserListener(arrayOfElements) {
      arrayOfElements.forEach((element) => {
        element.onclick = (event) => {
          this.deleteUser(event.target.dataset);
        };
      });
    }

    deleteUser(obj) {
      if (confirm(`確認刪除${obj.name}(代號：${obj.id})？`)) {
        const xhttp = new XMLHttpRequest();
        xhttp.open(
          "DELETE",
          `http://localhost/cms/delete-user.php?id=${obj.id}`,
          true
        );
        xhttp.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        xhttp.send();

        const $this = this;
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText === "SUCCESS") {
              alert("刪除成功！");
              let childArray = Array.prototype.slice.call(
                $this.shadowRoot.querySelectorAll(`div[name='row_${obj.id}']`)
              );
              childArray.forEach((child) =>
                child.parentNode.removeChild(child)
              );
            }
          }
        };
      }
    }
  }

  // let the browser know about the custom element
  customElements.define("get-customer", GetCustomer);
}

</script>