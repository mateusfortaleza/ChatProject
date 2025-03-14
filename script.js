const form = document.getElementById("chatForm");
const chatText = document.getElementById("chatText");

function reloadMessages() {
  $.ajax({
    url: "message-get-all.php",
  }).done(function (data) {
    document.getElementById("response-messages").innerHTML = "";
    data.map((msg) => {
      const isSender = msg.MessageUserID == document.getElementById("chatUser").value;
      const messageClass = isSender
        ? "bg-green-200 text-gray-900 self-start"
        : "bg-blue-500 text-white self-end";
      const roundedClass = isSender
        ? "rounded-lg rounded-br-none"
        : "rounded-lg rounded-bl-none";
      document.getElementById("response-messages").insertAdjacentHTML(
        "beforeend",
        `
        <div class="message max-w-full p-8 ${messageClass} ${roundedClass} shadow-md break-words overflow-hidden">
          <p class="text-lg font-semibold">${msg.MessageName}</p>
          <div class="text-xl break-words">${msg.MessageText}</div>
          <span class="text-xs block mt-1">${msg.MessageDate}</span>
        </div>
        `
      );
    });
    window.scrollTo(0, document.body.scrollHeight);
  });
}

reloadMessages();

function messageCheckNew() {
  $.ajax({
    url: "message-check-new.php",
  }).done(function (data) {
    if (data.newMessages) {
      reloadMessages();
    }
  });
}

setInterval(messageCheckNew, 1000);


form.addEventListener("submit", function (event) {
  event.preventDefault();

  const formData = new FormData(form);
  
  $.ajax({
    url: "message-insert.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
  })
  .done(function (response) {
    const jsonResponse = (typeof response === 'object') ? response : JSON.parse(response);
    if (jsonResponse.insertMessage === "success") {
      reloadMessages();
      document.getElementById("chatText").value = "";
    } else {
      alert("Error: " + jsonResponse.message);
    }
  })
  .fail(function (xhr, status, error) {
      alert("Error: " + xhr.responseText);
      console.error("AJAX Error:", status, error);
    });
});
  
chatText.addEventListener("keydown", function (e) {
  if (e.key === "Enter" && !e.shiftKey) {
    if (this.value.trim() === "") {
      e.preventDefault();
      alert("Please enter a message");
  } else {
    form.dispatchEvent(new Event("submit"));
    e.preventDefault();
  }
}
});

