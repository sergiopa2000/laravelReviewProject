let deleteButtons = document.querySelectorAll('.deleteButton');

for (const button of deleteButtons) {
    let url = button.dataset.url;
    let name = button.dataset.name;
    console.log(url);
    button.addEventListener("click", () =>{
        document.getElementById("deleteForm").action = url;
        document.querySelector("#deleteForm p").innerHTML = 'Are you sure you want to delete user ' + name + '?';
    })
}