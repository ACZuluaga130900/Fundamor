<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, 
  initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/3b5ef9eb52.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/estilos.css">
  <title>Usuarios</title>
</head>

<body>
  <header></header>

  <section class="main" id="app">

    <section class="usuarios">

      <div class="container">

        <div class="row">
          <div class="col-md-12">
            <h3 class="titulo-principal">Usuarios registrados</h3>
          </div>
        </div>

        <div class="row">

          <div class="table-responsive col-12">
            <table class="table">
              <thead>
                <tr class="titulos">
                  <th scope="col">No. identificación</th>
                  <th scope="col">Nombre Completo</th>
                  <th scope="col">Correo electrónico</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr class="text-center" v-for="register in registers">
                  <th>{{ register.documento_identidad }}</th>
                  <th>{{ register.nombres }} {{ register.apellidos }}</th>
                  <th>{{ register.email }}</th>
                  <th>{{ register.estado }}</th>
                  <th class="botones">
                    <button @click="selectUser(register,1)" class="btn btn-warning" data-toggle="modal"
                      data-target="#ModalUpdate">
                      <i class="fas fa-pen"></i>
                    </button>
                    <button @click="selectUser(register,2)" class="btn btn-danger">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </th>
                </tr>
              </tbody>
            </table>
          </div>


        </div>

      </div>
    </section>

    <section class="boton-flotante">
      <div class="boton">
        <input type="checkbox" id="btn-mas">
        <div class="redes">
          <a href="#" data-toggle="modal" data-target="#ModalCreate">
            <i class="fas fa-user-plus"></i></a>
        </div>
        <div class="btn-mas">
          <label for="btn-mas" class="icono"><i class="fas fa-plus"></i></label>
        </div>
      </div>
    </section>

    <section class="registrar_usuario">

      <div class="modal fade" id="ModalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="container">
              <!-- Header del recuadro registrar usuario -->
              <div class="modal-header">
                <h5 class="modal-title" id="ModalCreateLabel">Registrar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate>
                  <!-- Fila del campo de texto nombre(s) -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="nombre">Nombre(s)</label>
                      <input v-model="newUser.first_name" type="text" class="form-control" id="validationCustom01"
                        placeholder="Nombre(s)" required>
                    </div>
                  </div>

                  <!-- Fila del campo de texto apellidos -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="apellidos">Apellidos</label>
                      <input v-model="newUser.last_name" type="text" class="form-control" id="apellidos"
                        placeholder="Apellidos" required>
                    </div>
                  </div>


                  <div class="form-row">
                    <div class="col-12">
                      <label for="update_tipo_documento">Documento de identidad</label>
                    </div>
                  </div>

                  <!-- Fila tipo de documento y numero de documento -->
                  <div class="form-row">
                    <!-- Tipo de documento -->
                    <div class="col-md-4">
                      <select v-model="newUser.document_type" class="custom-select" id="tipo_documento" required>
                        <option selected value="">Tipo de documento</option>
                        <option v-for="document_type in document_types">{{ document_type.descripcion }}</option>
                      </select>
                    </div>

                    <!-- Campo numero de documento -->
                    <div class="col-8">
                      <input v-model="newUser.document_number" type="text" class="form-control" id="numero_documento"
                        placeholder="Número de documento" required>
                    </div>

                  </div>

                  <!-- Fila del seleccionador Rol del usuario -->
                  <div class="form-row">
                    <div class="col-md-12">
                      <label for="rol_usuario">Rol del usuario</label>
                      <select v-model="newUser.user_rol" class="custom-select" id="rol_usuario" required>
                        <option selected value="">Seleccione un Rol</option>
                        <option v-for="rol in rols">{{ rol.descripcion }}</option>
                      </select>
                    </div>

                  </div>

                  <!-- Fila del campo de texto correo electronico -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="correo_electronico">Correo Electrónico</label>
                      <input v-model="newUser.email" type="text" class="form-control" id="correo_electronico"
                        placeholder="Correo electrónico" required>
                    </div>

                  </div>

                  <!-- Fila del campo de texto numero telefonico -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="numero_telefonico">Número telefónico</label>
                      <input v-model="newUser.telephone_number" type="text" class="form-control" id="numero_telefonico"
                        placeholder="Número telefónico" required>
                    </div>

                  </div>

                  <!-- Fila del campo de texto nombre de usuario -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="nombre_usuario">Nombre de usuario</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="validatedInputGroupPrepend">@</span>
                        </div>
                        <input v-model="newUser.user_name" type="text" class="form-control" id="nombre_usuario"
                          placeholder="Nombre de usuario" required>
                      </div>

                    </div>
                  </div>

                  <!-- Fila del campo de texto contraseña -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="inputPassword">Contraseña</label>
                      <input v-model="newUser.password" type="password" class="form-control" id="inputPassword"
                        placeholder="Contraseña" required>
                    </div>
                  </div>

                  <!-- Fila de botones -->
                  <div class="form-row botones">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="createUser()">Crear usuario</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="actualizar_usuario">

      <div class="modal fade" id="ModalUpdate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="container">
              <!-- Header del recuadro actualizar usuario -->
              <div class="modal-header">
                <h5 class="modal-title" id="ModalUpdateLabel">Actualizar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate>
                  <!-- Fila del campo de texto nombre(s) -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="nombre">Nombre(s)</label>
                      <input v-model="clickedUser.first_name" type="text" class="form-control" id="update_nombre"
                        placeholder="Nombre(s)" required>
                    </div>
                  </div>

                  <!-- Fila del campo de texto apellidos -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="apellidos">Apellidos</label>
                      <input v-model="clickedUser.last_name" type="text" class="form-control" id="update_apellidos"
                        placeholder="Apellidos" required>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col-12">
                      <label for="update_tipo_documento">Documento de identidad</label>
                    </div>
                  </div>

                  <!-- Fila tipo de documento y numero de documento -->
                  <div class="form-row">
                    <!-- Tipo de documento -->
                    <div class="col-md-4">
                      <select v-model="clickedUser.document_type" class="custom-select" id="update_tipo_documento"
                        required>
                        <option selected value="">Tipo de documento</option>
                        <option v-for="document_type in document_types">{{ document_type.descripcion }}</option>
                      </select>
                    </div>

                    <!-- Campo numero de documento -->
                    <div class="col-8">
                      <input v-model="clickedUser.document_number" type="text" class="form-control"
                        id="update_numero_documento" placeholder="Número de documento" required>
                    </div>

                  </div>

                  <!-- Fila del seleccionador Rol del usuario -->
                  <div class="form-row">
                    <div class="col-md-12">
                      <label for="rol_usuario">Rol del usuario</label>
                      <select v-model="clickedUser.user_rol" class="custom-select" id="update_rol_usuario" required>
                        <option selected value="">Seleccione un Rol</option>
                        <option v-for="rol in rols">{{ rol.descripcion }}</option>
                      </select>
                    </div>

                  </div>

                  <!-- Fila del campo de texto correo electronico -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="correo_electronico">Correo Electrónico</label>
                      <input v-model="clickedUser.email" type="text" class="form-control" id="update_correo_electronico"
                        placeholder="Correo electrónico" required>
                    </div>

                  </div>

                  <!-- Fila del campo de texto numero telefonico -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="numero_telefonico">Número telefónico</label>
                      <input v-model="clickedUser.telephone_number" type="text" class="form-control"
                        id="update_numero_telefonico" placeholder="Número telefónico" required>
                    </div>

                  </div>

                  <!-- Fila del campo de texto nombre de usuario -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="nombre_usuario">Nombre de usuario</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="validatedInputGroupPrepend">@</span>
                        </div>
                        <input v-model="clickedUser.user_name" type="text" class="form-control"
                          id="update_nombre_usuario" placeholder="Nombre de usuario" disabled>
                      </div>

                    </div>
                  </div>

                  <!-- Fila del campo de texto contraseña -->
                  <div class="form-row">
                    <div class="col-12">
                      <label for="inputPassword">Contraseña</label>
                      <input v-model="clickedUser.password" type="password" class="form-control"
                        id="update_inputPassword" placeholder="Contraseña" required>
                    </div>
                  </div>

                  <!-- Fila de botones -->
                  <div class="form-row botones">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="updateUser()">Actualizar usuario</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </section>

  <footer></footer>

  <!-- Vue.js 2.5.16 -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

  <!-- Axios -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>

  <!-- Crypto -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

  <!-- Sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>

  <script src="../../controller/admin_users.js"></script>

  <script src="js/jquery.min.js"></script>

  <script src="js/util.js"></script>

  <!-- <script src="js/validaciones.js"></script> -->

</body>


</html>