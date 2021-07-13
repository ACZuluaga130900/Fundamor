let app = new Vue({
    el: '#app',
    data: {

        resultado: false,

        /*
        * Campos que soportan la estructura 
        * logica de la vista admin_users.html
        */

        // Campos que aportan informacion si las consulta fueron bien realizadas o no
        errorMessage: "",
        successMessage: "",

        // Objeto que guarda los campos para crear un nuevo usuario
        newUser: {
            first_name: "",
            last_name: "",
            document_type: "",
            document_number: "",
            user_rol: "",
            user_name: "",
            email: "",
            telephone_number: "",
            password: ""
        },

        // Variables temporales (Utiles para comparacion)
        temporalPassword: "",

        // Objeto que guarda los campos de un usuario seleccionado
        clickedUser: {},

        // Objeto que guarda el inicio de sesion
        login_user: {
            id_user: "",
            name_user: "",
        },

        registers: [], //Array que guarda la consulta get all users
        rols: [], //Array que guarda la consulta read all rols
        document_types: [], //Array que guarda la consulta read all document types

    },
    mounted: function () {
        /*
        * Al iniciar la pagina en el navegador se ejecuntan los tres metodos listados
        * ReadAllUsers: lista todos los usuarios registrados en el sistema
        * ReadAllRols: lista todos los roles que soporta el sistema
        * ReadAllDocumentTypes: lista todos los tipos de documentos que soporta el sistema
        */
        this.readAllUsers();
        this.readAllRols();
        this.readAllDocumentTypes();
    },
    methods: {
        /*
        * Metodo GET (request)
        * Para obtener los usuarios que existen en la base de datos.
        */
        readAllUsers() {

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'GET',
                url: '/maltrato_animal/model/admin.php?action=readUsers',
                responseType: 'json',
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {
                    this.registers = res.data.users;
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        },
        /*
        * Metodo GET (request)
        * Para obtener los roles que existen en la base de datos.
        */
        readAllRols() {

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'GET',
                url: '/maltrato_animal/model/admin.php?action=readRols',
                responseType: 'json',
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {
                    this.rols = res.data.rols;
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        },
        /*
        * Metodo GET (request)
        * Para obtener los tipos de documentos que existen en la base de datos.
        */
        readAllDocumentTypes() {

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'GET',
                url: '/maltrato_animal/model/admin.php?action=readDocumentType',
                responseType: 'json',
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {
                    this.document_types = res.data.document_types;
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        },
        /*
        * Metodo POST (request)
        * Para obtener el registro correspondiente al campo que se necesita desencriptar
        */
        readCrypto(encrypto) {

            // Organiza la variable de entrada como un Objeto para ser enviada posteriormente
            var obj = {
                text: encrypto
            };

            //Organiza el formato de campos para ser enviados por medio de request (POST)
            var formData = this.toFormData(obj);

            var text = "1";
            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'POST',
                url: '/maltrato_animal/model/admin.php?action=readCrypto',
                responseType: 'json',
                data: formData,
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {
                    var keys = []
                    keys = res.data.crypto;

                    if (keys.length == 1) {
                        var key = keys[0].llave;
                        this.decrypto(key, encrypto);
                    } else {
                        this.errorMessage = "Error, existen mas registros con el mismo encryptado";
                    }
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });

        },
        /*
        * Metodo POST (request)
        * Para obtener el registro correspondiente a un unico usuario
        */
        readUser(document) {

            // Organiza la variable de entrada como un Objeto para ser enviada posteriormente
            var obj = {
                document_number: document
            };

            //Organiza el formato de campos para ser enviados por medio de request (POST)
            var formData = this.toFormData(obj);

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'POST',
                url: '/maltrato_animal/model/admin.php?action=readUser',
                responseType: 'json',
                data: formData,
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {

                    var users = []
                    users = res.data.user;

                    if (users.length == 1) {
                        var user = users[0];
                        // Obtiene los pk (primary key, ids) de los campos document_type y user_rol, ya que estos valores son fk (foreign key) para crear un usuario.
                        var document_type = this.document_types.find(document => document.id_tipo_documento === user.document_type);
                        var user_rol = this.rols.find(rol => rol.id_rol === user.user_rol);
                        user.document_type = document_type.descripcion;
                        user.user_rol = user_rol.descripcion;
                        this.temporalPassword = user.password;
                        this.clickedUser = user;
                    } else {
                        this.errorMessage = "Error, existen mas registros con el mismo documento";
                    }
                    console.log(this.clickedUser);
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        },
        /*
        * Metodo POST (request)
        * Registra novedades en el sistema
        */
        createRegister(proceso, detalle) {

            // Organiza las variables de entrada como un Objeto para ser enviada posteriormente
            var registerHistory = {
                user: this.login_user.id_user,
                process: proceso,
                detail: detalle,
            };

            //Organiza el formato de campos para ser enviados por medio de request (POST)
            var formData = this.toFormData(registerHistory);

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'POST',
                url: '/maltrato_animal/model/admin.php?action=createHistory',
                responseType: 'json',
                data: formData,
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {

                    //Si salta un error lo guarda en la variable errorMessage
                    if (res.data.error) {
                        this.errorMessage = res.data.message;
                        console.log(this.errorMessage);
                    } else {// Si todo sale bien
                        this.successMessage = res.data.message;
                        console.log(this.successMessage);
                    }
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        },
        /*
        * Metodo POST (request)
        * Para agregar un nuevo usuario al sistema
        */
        createUser() {
            // this.validarCampos();
            // if (this.resultado != false) {

            // Encriptando password
            var resultcrypto = this.crypto(this.newUser.password, "password");

            // Obtiene los pk (primary key, ids) de los campos document_type y user_rol, ya que estos valores son fk (foreign key) para crear un usuario.
            var id_document_type = this.document_types.find(document => document.descripcion === this.newUser.document_type);
            var id_user_rol = this.rols.find(rol => rol.descripcion === this.newUser.user_rol);

            // Obtiene valores correspondientes a guardar.
            this.newUser.document_type = id_document_type.id_tipo_documento; //fk
            this.newUser.user_rol = id_user_rol.id_rol; //fk
            this.newUser.password = resultcrypto.text; //password encriptado

            // Organiza el formato de campos para ser enviados por medio de request (POST)
            var formData = this.toFormData(this.newUser);

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'POST',
                url: '/maltrato_animal/model/admin.php?action=createUser',
                responseType: 'json',
                data: formData,
                headers: { "Content-Type": "application/json" }
            })

                // then permite obtener el response (res)
                .then(res => {

                    // Variables para llevar el registo (auditoria)
                    var register_name = this.newUser.user_name;
                    var register_first = this.newUser.first_name;
                    var register_last = this.newUser.last_name;

                    // Limpia los campos obtenidos con anterioridad
                    this.newUser = {
                        first_name: "",
                        last_name: "",
                        document_type: "",
                        document_number: "",
                        user_rol: "",
                        user_name: "",
                        email: "",
                        telephone_number: "",
                        password: ""
                    };

                    // Si salta un error lo guarda en la variable errorMessage
                    if (res.data.error) {
                        this.errorMessage = res.data.message;
                        console.log(this.errorMessage);

                    } else {// Si todo sale bien, recarga el metodo readAllUsers() para visualizar todos los usuarios
                        this.readAllUsers();
                        this.createRegister("Crear Usuario", "Usuario: " + register_name + " [ " + register_first + " " + register_last + " ]");
                        this.createCrypto(resultcrypto);
                        this.successMessage = res.data.message;
                        console.log(this.successMessage);
                    }

                })

                // Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
            // }

        },
        /*
        * Metodo POST (request)
        * Para crear Crypto que se compone de una llave y un texto encriptado
        * sin los dos elementos no se puede desencriptar
        */
        createCrypto(obj) {

            //Organiza el formato de campos para ser enviados por medio de request (POST)
            var formData = this.toFormData(obj);

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'POST',
                url: '/maltrato_animal/model/admin.php?action=createCrypto',
                responseType: 'json',
                data: formData,
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {
                    //Si salta un error lo guarda en la variable errorMessage
                    if (res.data.error) {
                        this.errorMessage = res.data.message;
                        console.log(this.errorMessage);
                    } else {// Si todo sale bien imprime un mensaje exitoso
                        this.successMessage = res.data.message;
                        console.log(this.successMessage);
                    }
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        },
        /*
        * Metodo POST (request)
        * Para editar un usuario existente.
        */
        updateUser() {

            console.log(this.temporalPassword, this.clickedUser.password);

            // Si no se cambio de contraseña
            if (this.temporalPassword == this.clickedUser.password) {

                // Obtiene los pk (primary key, ids) de los campos document_type y user_rol, ya que estos valores son fk (foreign key) para crear un usuario.
                var id_document_type = this.document_types.find(document => document.descripcion === this.clickedUser.document_type);
                var id_user_rol = this.rols.find(rol => rol.descripcion === this.clickedUser.user_rol);

                // Obtiene valores correspondientes a guardar.
                this.clickedUser.document_type = id_document_type.id_tipo_documento; //fk
                this.clickedUser.user_rol = id_user_rol.id_rol; //fk

                console.log(this.clickedUser);

                // Organiza el formato de campos para ser enviados por medio de request (POST)
                var formData = this.toFormData(this.clickedUser);

                // Por medio de axios se hace la peticion (request)
                axios({
                    method: 'POST',
                    url: '/maltrato_animal/model/admin.php?action=updateUser',
                    responseType: 'json',
                    data: formData,
                    headers: { "Content-Type": "application/json" }
                })

                    //then permite obtener el response (res)
                    .then(res => {

                        // Variables para llevar el registo (auditoria)
                        var register_name = this.clickedUser.user_name;
                        var register_first = this.clickedUser.first_name;
                        var register_last = this.clickedUser.last_name;

                        // Limpia los campos obtenidos con anterioridad
                        this.clickedUser = {};

                        // Si salta un error lo guarda en la variable errorMessage
                        if (res.data.error) {
                            this.errorMessage = res.data.message;
                            console.log(this.errorMessage);
                        } else {// Si todo sale bien, recarga el metodo readAllUsers() para visualizar todos los usuarios
                            this.readAllUsers();
                            this.createRegister("Actualizar Usuario", "Usuario: " + register_name + " [ " + register_first + " " + register_last + " ]");
                            this.successMessage = res.data.message;
                            console.log(this.successMessage);
                        }

                    })

                    //Catch obtiene algun error capturado
                    .catch(err => {
                        console.log(err);
                    });
            } // Si se cambio de contraseña
            else {

                this.deleteCrypto();

                // Encriptando password
                var resultcrypto = this.crypto(this.clickedUser.password, "password");

                // Obtiene los pk (primary key, ids) de los campos document_type y user_rol, ya que estos valores son fk (foreign key) para crear un usuario.
                var id_document_type = this.document_types.find(document => document.descripcion === this.clickedUser.document_type);
                var id_user_rol = this.rols.find(rol => rol.descripcion === this.clickedUser.user_rol);

                // Obtiene valores correspondientes a guardar.
                this.clickedUser.document_type = id_document_type.id_tipo_documento; //fk
                this.clickedUser.user_rol = id_user_rol.id_rol; //fk
                this.clickedUser.password = resultcrypto.text; //password encriptado

                console.log(this.clickedUser);

                // Organiza el formato de campos para ser enviados por medio de request (POST)
                var formData = this.toFormData(this.clickedUser);

                // Por medio de axios se hace la peticion (request)
                axios({
                    method: 'POST',
                    url: '/maltrato_animal/model/admin.php?action=updateUser',
                    responseType: 'json',
                    data: formData,
                    headers: { "Content-Type": "application/json" }
                })

                    //then permite obtener el response (res)
                    .then(res => {

                        // Variables para llevar el registo (auditoria)
                        var register_name = this.clickedUser.user_name;
                        var register_first = this.clickedUser.first_name;
                        var register_last = this.clickedUser.last_name;

                        // Limpia los campos obtenidos con anterioridad
                        this.clickedUser = {};

                        // Si salta un error lo guarda en la variable errorMessage
                        if (res.data.error) {
                            this.errorMessage = res.data.message;
                            console.log(this.errorMessage);
                        } else {// Si todo sale bien, recarga el metodo readAllUsers() para visualizar todos los usuarios
                            this.readAllUsers();
                            this.createRegister("Actualizar Usuario", "Usuario: " + register_name + " [ " + register_first + " " + register_last + " ]");
                            this.createCrypto(resultcrypto);
                            this.successMessage = res.data.message;
                            console.log(this.successMessage);
                        }

                    })

                    //Catch obtiene algun error capturado
                    .catch(err => {
                        console.log(err);
                    });
            }

        },
        /*
        * Metodo POST (request)
        * Permite eliminar un texto encriptado guardado en la base de datos
        */
        deleteCrypto() {

            // Organiza la variable de entrada como un Objeto para ser enviada posteriormente
            var obj = {
                text: this.temporalPassword
            };

            // Organiza el formato de campos para ser enviados por medio de request (POST)
            var formData = this.toFormData(obj);

            // Por medio de axios se hace la peticion (request)
            axios({
                method: 'POST',
                url: '/maltrato_animal/model/admin.php?action=deleteCrypto',
                responseType: 'json',
                data: formData,
                headers: { "Content-Type": "application/json" }
            })

                //then permite obtener el response (res)
                .then(res => {
                    //Si salta un error lo guarda en la variable errorMessage
                    if (res.data.error) {
                        this.errorMessage = res.data.message;
                        console.log(this.errorMessage);
                    } else {// Si todo sale bien imprime un mensaje exitoso
                        this.successMessage = res.data.message;
                        console.log(this.successMessage);
                    }
                })

                //Catch obtiene algun error capturado
                .catch(err => {
                    console.log(err);
                });
        },
        /*
        * Metodo
        * Obtener la informacion de un usuario
        */
        selectUser(user, parametro) {

            var document = user.documento_identidad;
            console.log("Usuario: ", document);

            this.readUser(document);

            // Si el parametro es 2 cambia estado (Activo/Inactivo)
            if (parametro == 2) {
                this.sweetAlertState();
            }
        },
        /*
        * Metodo
        * Para organizar los campos a enviar por medio de un request.
        */
        toFormData(obj) {
            var fd = new FormData();
            for (var i in obj) {
                fd.append(i, obj[i]);
            }
            return fd;
        },
        /*
        * Metodo
        * Para Validar que los campos esten diligenciados
        */
        validarCampos() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        this.resultado = false;
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        this.resultado = true;
                    }
                    form.classList.add('was-validated');

                }, false);

            });

        },
        /*
        * Metodo
        * Para encriptar
        */
        crypto(text, prefijo) {

            const fecha = new Date();
            const timestamp = fecha.getTime();

            var plainText = text;
            var password = prefijo + text + timestamp;

            var passwordBytes = CryptoJS.enc.Hex.parse(password);
            var sha1Hash = CryptoJS.SHA1(passwordBytes);
            var sha1HashToBase64 = sha1Hash.toString(CryptoJS.enc.Base64);

            sha1HashToBase64Short = sha1HashToBase64.substring(0, 8);

            var aeskey = CryptoJS.enc.Utf16.parse(sha1HashToBase64Short);
            var numberaeskey = aeskey.toString();

            var x = CryptoJS.AES.encrypt(plainText, numberaeskey, {
                iv: numberaeskey,
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7
            });

            var encrypto = x.toString();

            //Guarda la encrypto y key en un objeto
            var obj = {
                key: numberaeskey,
                text: encrypto
            };

            console.log("Encriptado", obj.key, obj.text);

            //El campo encriptado en la base de datos tendra la llave solamente
            return obj;
        },
        /*
        * Metodo
        * Para desencriptar
        */
        decrypto(key, encrypto) {
            var y = CryptoJS.AES.decrypt(encrypto, key, {
                iv: key
            });

            decrypt = y.toString(CryptoJS.enc.Utf8)

            console.log("Desencriptado ", decrypt);

            return decrypt;
        },
        /*
         * Metodo Alerta para Cambiar estado Usuario
         */
        sweetAlertState() {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({

                title: '¿Desea cambiar el estado del usuario?',
                html: '<input v-model="clickedUser" class="invisible">',
                icon: 'question',
                width: '70%',

                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,

                confirmButtonText: 'Cambiar',
                cancelButtonText: 'Cancelar',

                reverseButtons: true,
                showCancelButton: true,

            }).then((result) => {
                if (result.isConfirmed) {
                    
                    if(this.clickedUser.state == 'Activo'){
                        this.clickedUser.state = 'Inactivo';
                    }else if(this.clickedUser.state == 'Inactivo'){
                        this.clickedUser.state = 'Activo';
                    }

                    this.updateUser();
                    swalWithBootstrapButtons.fire(
                        'Actualizado',
                        'El usuario ' + this.clickedUser.first_name + ' ' + this.clickedUser.last_name + ' cambio su estado a ' + this.clickedUser.state,
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'No se realizaron cambios',
                        'error'
                    )
                }
            })

        }
    }
});



