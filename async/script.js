const button = document.getElementById("btnsubmit");
const message = document.getElementById("message");

button.addEventListener("click", sendData);


async function sendData() {
  const name = document.getElementById("name").value.trim();

  if (!name === "") {
    message.textContent = "Please enter a name.";
    return;
  }

  message.textContent = "Sending data...";

  const response = await fetch("/async/api/greet.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ name })
  });


  try {
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
  } catch (error) {
    message.textContent = "Error: " + error.message;
    return;
  }

  
  const data = await response.json();
  message.textContent = data.message;
}