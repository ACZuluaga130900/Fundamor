let app = new Vue({
    el: '#app',
    data: {
        errorMessage: '',
        registers: [] //Array que guarda la consulta get all history
    },
    mounted: function () {
        /*
        * Al iniciar la pagina en el navegador se ejecuntan los tres metodos listados
        */
        this.readAllHistory();
    },
    methods: {
        readAllHistory() {

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'GET',
                url: '/maltrato_animal/model/admin.php?action=readHistory',
                responseType: 'json',
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {
                    this.registers = res.data.history;
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        }
    }
});