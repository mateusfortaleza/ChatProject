const form = document.getElementById("chatForm");

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
                <div class="max-w-xs p-8 ${messageClass} ${roundedClass} shadow-md break-words overflow-hidden">
                    <p class="text-lg font-semibold">${msg.MessageName}</p>
                    <p class="text-xl break-words">${msg.MessageText}</p>
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

  const formData = {
    chatText: document.getElementById("chatText").value,
    chatUser: document.getElementById("chatUser").value,
  };

  $.ajax({
    url: "message-insert.php",
    method: "POST",
    data: formData,
  })
    .done(function () {
      reloadMessages();
    })
    .fail(function (xhr, status, error) {
      alert("Error: " + xhr.responseText);
      console.error("AJAX Error:", status, error);
    });

  document.getElementById("chatText").value = "";
});

form.addEventListener("keydown", function (e) {
  if (e.key === "Enter" && !e.shiftKey) {
    if (document.getElementById("chatText").value.trim() === "") {
      e.preventDefault();
      alert("Please enter a message");
    } else {
      form.dispatchEvent(new Event("submit"));
      e.preventDefault();
    }
  }
});
