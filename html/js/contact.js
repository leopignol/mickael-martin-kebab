const sendMail = document.getElementById("send-mail-button");

const firstName = document.getElementById("first-name");
const lastName = document.getElementById("name");
const mail = document.getElementById("mail");
const phone = document.getElementById("phone");
const content = document.getElementById("content");

firstName.addEventListener("input", updateSendMail);
lastName.addEventListener("input", updateSendMail);
mail.addEventListener("input", updateSendMail);
phone.addEventListener("input", updateSendMail);
content.addEventListener("input", updateSendMail);

function updateSendMail() {
  sendMail.href =
    "mailto:mickael-martin-kebab@mailo.com" +
    `?subject=${encodeURIComponent(lastName.value)}%20${encodeURIComponent(firstName.value)}` +
    `%20%E2%80%93%20%3CObject%20du%20contact%3E` +
    `&body=${encodeURIComponent(content.value)}${phone.value ? "%0A%0A" + phone.value : ""}`;
}
