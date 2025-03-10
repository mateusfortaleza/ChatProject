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
        <div class="message max-w-full p-8 ${messageClass} ${roundedClass} shadow-md break-words overflow-hidden">
          <p class="text-lg font-semibold">${msg.MessageName}</p>
          <div class="text-xl break-words">${msg.MessageText}</div>
          <span class="text-xs block mt-1">${msg.MessageDate}</span>
        </div>
        `
      );
    });
    processFileTags();
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
  })
    .done(function (response) {
      const jsonResponse = (typeof response === 'object') ? response : JSON.parse(response);
      if (jsonResponse.success) {
        reloadMessages();
        document.getElementById("chatText").value = "";
        clearFileSelection();
      } else {
        alert("Error: " + jsonResponse.message);
      }
    })
    .fail(function (xhr, status, error) {
      alert("Error: " + xhr.responseText);
      console.error("AJAX Error:", status, error);
    });

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

function updateFileLabel() {
  const fileInput = document.getElementById('chatFile');
  const fileName = document.getElementById('fileName');
  const filePreview = document.getElementById('filePreview');

  if (fileInput.files && fileInput.files.length > 0) {
    fileName.textContent = fileInput.files[0].name;
    filePreview.style.display = 'block';
    console.log('File selected:', fileInput.files[0].name);
  } else {
    clearFileSelection();
  }
}
function clearFileSelection() {
  const fileInput = document.getElementById('chatFile');
  const filePreview = document.getElementById('filePreview');

  fileInput.value = '';
  fileName.textContent = 'No file selected';
  filePreview.style.display = 'none';
}

// Process file tags in messages
function processFileTags() {
  const messages = document.querySelectorAll('#response-messages .message');

  messages.forEach(message => {
    const content = message;

    // Replace file tags with appropriate elements
    const updatedContent = ontent.replace(/\[file:([\w\-.]+\.[a-zA-Z0-9]+)]/g, (match, fileName) => {
      const fileExt = fileName.split('.').pop().toLowerCase();

      if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
        return `<div class="mt-2 rounded-md overflow-hidden">
          <img src="business.php?file=${fileName}" alt="${fileName}" class="max-w-full h-auto">
        </div>`;
      } else if (fileExt === 'pdf') {
        return `<div class="mt-2 rounded-md overflow-hidden border border-gray-200">
          <object data="business.php?file=${fileName}" type="application/pdf" width="100%" height="200px">
            <a href="business.php?file=${fileName}" class="text-blue-600 hover:text-blue-800">View PDF</a>
          </object>
        </div>`;
      } else if (['mp4', 'webm'].includes(fileExt)) {
        return `<div class="mt-2 rounded-md overflow-hidden">
        <video controls width="100%">
          <source src="business.php?file=${fileName}" type="video/${fileExt}">
          Your browser does not support the video tag.
          </video>
        </div>`;
      } else {
        return `<div class="mt-2">
          <a href="business.php?file=${fileName}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
            </svg>
            ${fileName}
          </a>
        </div>`;
      }
    });
    content.innerHTML = updatedContent;
  });
}