let search = document.getElementById("test-form");

search.addEventListener('submit', (e) => {
    e.preventDefault();

    UID = document.getElementById("username").value;

    const formData = new FormData()
    formData.append('UID', UID)
    fetch("https://localhost/api/accounting/search.php", {
        method: 'POST',
        // headers: {
        //     'UID': UID, 
        //     'api-key': key,
        //   },
        body: formData,
    }).then((response) => {
        console.log(response.json())
    })
})