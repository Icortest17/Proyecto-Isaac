



function actualizar(cantidad, id){
    let url = 'carrito/actualizarCarrito.php'
    let formData = new FormData()
    formData.append('action', 'agregar')
    formData.append('id', id)
    formData.append('cantidad', cantidad)


    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(response => response.json())
    .then(data => {
        if(data.ok){

            let divsubtotal = document.getElementById("subtotal_" + id);
            divsubtotal.innerHTML = data.sub + "€"

            let total = 0.00
            let list = document.getElementsByName('subtotal[]')

            for(let i = 0; i < list.length; i++){
                total += parseFloat(list[i].innerHTML.replace(/[€,]/g, ""))
            }
            
            total = new Intl.NumberFormat('es-EU', {
                minimumFractionDigits: 2
            }).format(total)
            document.getElementById('total').innerHTML = total + '€'

        }
    })
}

function eliminar(cantidad, id){

    let botonElimina = document.getElementById('btn-elimina')
     id = botonElimina.value

    let url = 'carrito/actualizarCarrito.php'
    let formData = new FormData()
    formData.append('action', 'eliminar')
    formData.append('id', id)
    


    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(response => response.json())
    .then(data => {
        if(data.ok){
            location.reload()
        }
    })
}