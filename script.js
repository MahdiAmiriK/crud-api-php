// Benutzerdaten vom Server abrufen und anzeigen
function getUsers() {
  fetch("index.php?action=read")
    .then((res) => res.json())
    .then((result) => {
      if (result.status === "success") {
        const userList = document.getElementById("userList");
        userList.innerHTML = "";

        result.data.forEach((user) => {
          const userItem = document.createElement("div");
          userItem.className = "user-item";

          const userInfo = document.createElement("div");
          userInfo.className = "user-info";
          userInfo.textContent = `Name: ${user.name}, Email: ${user.email}`;

          const actions = document.createElement("div");
          actions.className = "user-actions";

          const editBtn = document.createElement("button");
          editBtn.className = "edit-btn";
          editBtn.textContent = "Edit";
          editBtn.addEventListener("click", () => editUser(user));

          const deleteBtn = document.createElement("button");
          deleteBtn.className = "delete-btn";
          deleteBtn.textContent = "Delete";
          deleteBtn.addEventListener("click", () => deleteUser(user));

          actions.appendChild(editBtn);
          actions.appendChild(deleteBtn);

          userItem.appendChild(userInfo);
          userItem.appendChild(actions);

          userList.appendChild(userItem);
        });
      }
    });
}

// Formular mit vorhandenen Nutzerdaten füllen
function editUser(user) {
  document.getElementById("formName").value = user.name;
  document.getElementById("formEmail").value = user.email;
  document.getElementById("submitBtn").textContent = "Update";

  // Bearbeitungsmodus merken
  myForm.dataset.editingId = user.id;
}

// Nutzer löschen (per POST mit ID)
function deleteUser(user) {
  fetch("index.php?action=delete", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: user.id }),
  })
    .then((res) => res.json())
    .then((result) => {
      getUsers();
    });
}

// Formular absenden (Neuanlage oder Update)
const myForm = document.getElementById("myForm");
myForm.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(myForm);
  const editingId = myForm.dataset.editingId;

  const data = {
    name: formData.get("name"),
    email: formData.get("email"),
  };

  if (editingId) {
    // Update bestehender Eintrag
    data.id = editingId;

    fetch("index.php?action=update", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((result) => {
        delete myForm.dataset.editingId;
        document.getElementById("submitBtn").textContent = "Submit";
        getUsers();
      });
  } else {
    // Neuer Eintrag
    fetch("index.php?action=create", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((result) => {
        getUsers();
      });
  }

  // Formular zurücksetzen
  myForm.reset();
});

// Beim Laden der Seite: Daten anzeigen
window.onload = getUsers;
