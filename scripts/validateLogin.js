const validator = new window.JustValidate("#login-form");

function validateForm() {
  validator
    .addField("#email", [
      {
        rule: "required",
      },
      {
        rule: "email",
      },
    ])
    .addField("#mobile-number", [
      {
        rule: "required",
      },
      {
        rule: "minLength",
        value: 3,
      },
      {
        rule: "maxLength",
        value: 15,
      },
      {
        rule: "number",
      },
    ])
    .addField("#full-name", [
      {
        rule: "required",
      },
      {
        rule: "minLength",
        value: 3,
      },
      {
        rule: "maxLength",
        value: 15,
      },
    ])
    .addField("#username", [
      {
        rule: "required",
      },
      {
        rule: "minLength",
        value: 1,
      },
      {
        rule: "maxLength",
        value: 15,
      },
    ])
    .addField("#password", [
      {
        rule: "required",
      },
      {
        rule: "minLength",
        value: 3,
      },
      {
        rule: "password",
      },
    ]);
}

document.addEventListener("DOMContentLoaded", (event) => {
  const form = document.getElementById("register-form");

  validateForm();

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    if (validator.isValid) {
      form.submit();
    }
  });
});