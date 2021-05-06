$(document).ready(function () {
    $('body').on('submit', '#postMemberForm', function (event) {
       event.preventDefault();
       const [name, lastName, dateOfBirth, country, phone, sex] =
           [$('#name').val(), $('#lastName').val(), $('#dateOfBirth').val(), $('#country').val(), $('#phone').val(), $('#sex').val()];
       debugger

         let data ={
               name,
               lastName,
               dateOfBirth,
               country,
               phone,
               sex,
           };

        fetch($(this).attr('action'), {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {"Content-type": "application/json; charset=UTF-8"}

        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw response.json()
                }
            })
            .then(function(response) {
            debugger
            alert('Success : Le membre est cree');
        }) .catch(error => {
            debugger
            error.then(e  => {
                debugger
                let x = '';
                Object.values(e.data).forEach(el => {
                    if (x === '') {
                        x = el
                    } else {
                        x = `${x}\n${el}`
                    }
                });
                alert(x);
            })

        });

    });
});