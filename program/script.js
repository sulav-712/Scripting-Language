const message = document.getElementById("message");
const button = document.getElementById("btnsubmit");

button.addEventListener("click", checkData);

async function checkData() {
  const name = document.getElementById("check").value.trim();


  if (name === "") {
    alert("Please enter a name.");
    return;
  }


  const response = await fetch("/program/api/check.php", {
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
    alert("Error: " + error.message);
    return;
  }

  const data = await response.json();
  message
}