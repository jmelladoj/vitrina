<template>
    <div class="video-block section-padding">
        <div class="main-items">
            <div class="row justify-content-md-center">
                <div class="messages text-center col-md-12">
                    Ingresa a vitrinalaboral.cl
                    <hr>
                </div>
            </div>
            <div class="my-all-lisitngs">
                <div class="row justify-content-md-center">
                    <div class="col-lg-12 col-sm-12">
                        <div class="help-tabs feedback">
                            <div class="row lr-row" v-show="formulario == 0">
                                <div class="col-md-6">
                                    <div class=" locatins">
                                        <div class="heading">
                                            <h3>Iniciar sesión</h3>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    class="card-input"
                                                    v-model="$v.inicio_sesion.email.$model"
                                                    :state="$v.inicio_sesion.email.$dirty ? !$v.inicio_sesion.email.$error : null"
                                                    aria-describedby="inicio_sesion-email"
                                                    placeholder="Ingresa tu correo"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="inicio_sesion-email">
                                                    Ingresa un correo válido.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    type="password"
                                                    class="card-input"
                                                    v-model="$v.inicio_sesion.password.$model"
                                                    :state="$v.inicio_sesion.password.$dirty ? !$v.inicio_sesion.password.$error : null"
                                                    aria-describedby="inicio_sesion-password"
                                                    placeholder="Ingresa tu contraseña"
                                                    @keyup.enter="iniciar_sesion"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="inicio_sesion-password">
                                                    Campo de alfabético, mínimo de 3 caracteres.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="prcy-btn">
                                            <button class="save-btn1" @click="iniciar_sesion">Ingresar </button>
                                        </div>
                                        <div class="mt-4 col-lg-12 col-sm-12 p-left p-right text-right">
                                            <div class="card-inputs pm-20-bottom">
                                                ¿Olvidaste tu Contraseña?, <a href="javascript:void(0)" @click="formulario = 1">pincha acá</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class=" locatins">
                                        <div class="heading">
                                            <h3>Regístrate</h3>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    class="card-input"
                                                    v-model="$v.registro.nombre.$model"
                                                    :state="$v.registro.nombre.$dirty ? !$v.registro.nombre.$error : null"
                                                    aria-describedby="registro-nombre"
                                                    placeholder="Ingresa tu nombre completo"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="registro-nombre">
                                                    Campo de alfabético, mínimo de 3 caracteres.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    class="card-input"
                                                    v-model="$v.registro.telefono.$model"
                                                    :state="$v.registro.telefono.$dirty ? !$v.registro.telefono.$error : null"
                                                    aria-describedby="registro-telefono"
                                                    placeholder="Ingresa un teléfono"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="registro-telefono">
                                                    Campo de númerico, ingresa un teléfono con formato 987654321.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    class="card-input"
                                                    v-model="$v.registro.email.$model"
                                                    :state="$v.registro.email.$dirty ? !$v.registro.email.$error : null"
                                                    aria-describedby="registro-email"
                                                    placeholder="Ingresa un correo"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="registro-email">
                                                    Ingresa un email válido y que no exista en nuestros registros.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    id="fecha"
                                                    class="card-input"
                                                    v-model="$v.registro.fecha_nacimiento.$model"
                                                    :state="$v.registro.fecha_nacimiento.$dirty ? !$v.registro.fecha_nacimiento.$error : null"
                                                    aria-describedby="registro-fecha_nacimiento"
                                                    placeholder="Fecha de nacimiento"
                                                    @focus="texto_input_fecha"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="registro-fecha_nacimiento">
                                                    Campo de alfanúmerico, mínimo de 6 caracteres.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    type="password"
                                                    class="card-input"
                                                    v-model="$v.registro.password.$model"
                                                    :state="$v.registro.password.$dirty ? !$v.registro.password.$error : null"
                                                    aria-describedby="registro-password"
                                                    placeholder="Ingresa tu contraseña"
                                                    @focus="texto_input_fecha"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="registro-password">
                                                    Ingresa una fecha válida.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="prcy-btn">
                                            <button class="save-btn1" @click="registrar_usuario">Regístrate </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row lr-row" v-show="formulario == 1">
                                <div class="col-md-12">
                                    <div class=" locatins">
                                        <div class="heading">
                                            <h3>Recupera tu contraseña</h3>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 p-left p-right">
                                            <b-form-group>
                                                <b-form-input
                                                    class="card-input"
                                                    v-model="$v.password.email.$model"
                                                    :state="$v.password.email.$dirty ? !$v.password.email.$error : null"
                                                    aria-describedby="password-email"
                                                    placeholder="Ingresa el correo asociado a tu cuenta"
                                                ></b-form-input>

                                                <b-form-invalid-feedback id="password-email">
                                                    Ingresa un email válido.
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </div>
                                        <div class="prcy-btn">
                                            <button class="save-btn1" @click="recuperar_password">Recuperar contraseña </button>
                                        </div>
                                        <div class="mt-4 col-lg-12 col-sm-12 p-left p-right text-right">
                                            <div class="card-inputs">
                                                Inicia sesión o regístrate <a href="javascript:void(0)" @click="formulario = 0">pincha acá</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { required, email, minLength, maxLength, numeric, alpha, minValue } from 'vuelidate/lib/validators'
    import { mapMutations, mapState } from 'vuex'

    export default {
        data(){
            return {
                formulario: 0,
                registro: {
                    nombre: '',
                    telefono: null,
                    email: '',
                    fecha_nacimiento: '',
                    password: ''
                },
                inicio_sesion:{
                    email: '',
                    password: ''
                },
                password:{
                    email: ''
                }
            }
        },
        validations:{
            inicio_sesion: {
                email:{
                    required,
                    minLength: minLength(3),
                    email
                },
                password:{
                    required,
                    minLength: minLength(3),
                }
            },
            registro: {
                nombre: {
                    required,
                    minLength: minLength(3)
                },
                telefono: {
                    required,
                    numeric,
                    minLength: minLength(9),
                    maxLength: maxLength(9)
                },
                email: {
                    required,
                    minLength: minLength(3),
                    email,
                    async isUnique (value) {
                        if (value === '' || value.length < 3) return true

                        const response = await fetch(`/usuarios/unico/${value}`)
                        return await response.json()
                    }
                },
                fecha_nacimiento: {
                    required,
                    minValue: value => value < new Date().toISOString()
                },
                password: {
                    required,
                     minLength: minLength(6)
                }
            },
            password: {
                email: {
                    required,
                    minLength: minLength(9),
                }
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            ...mapMutations('usuario', ['actualizar']),
            texto_input_fecha(){
                $('#fecha').prop('type','date')
            },
            usuario_logeado(){
                let me = this

                axios.get('/usuario/logeado').then(function (response) {
                    if(response.data.usuario.administrador == 1){
                        window.location.href = "/usuarios"
                    } else {
                        window.location.href = "/perfil"
                    }
                })
            },
            iniciar_sesion(){
                if(this.$v.inicio_sesion.$invalid){
                    this.$v.inicio_sesion.$touch()
                    return
                }

                let me = this

                axios.post('/login',{
                    'email': me.inicio_sesion.email,
                    'password': me.inicio_sesion.password
                }).then(function (response) {
                    me.usuario_logeado()
                }).catch(function (error) {
                    if (error.response.status == 422){
                        me.inicio_sesion.password = ''
                        me.msg_error('Las credenciales introducidas son incorrectas.')
                    }
                })
            },
            registrar_usuario(){
                if(this.$v.registro.$invalid){
                    this.$v.registro.$touch()
                    return
                }

                let me=this;

                axios.post('/register',{
                    'nombre': me.registro.nombre,
                    'email': me.registro.email,
                    'password': me.registro.password,
                    'fecha_nacimiento': me.registro.fecha_nacimiento,
                    'telefono': me.registro.telefono
                }).then(function (response) {
                    window.location.href = "/perfil";
                }).catch(function (error) {
                    console.log(error)
                });
            },
            recuperar_password(){
                if(this.$v.password.$invalid){
                    this.$v.password.$touch()
                    return
                }

                let me = this

                axios.post('/recuperar/contraseña', {
                    'email': me.password.email
                }).then(response => {
                    me.msg_success('Te hemos enviado un correo con una contraseña provisoria.')
                    me.password.email = ''
                    me.formulario = 0
                }).catch(e => {
                    me.msg_error('Hemos tenido problemas al enviarte un correo, por favor, prueba de nuevo.')
                    me.password.email = ''
                });
            }
        }
    }
</script>
