<template>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <b>
                            <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <span>
                            <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                        </span>
                    </a>
                </div>

                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item right-side-toggle" @click="cerrar_session"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-power-off"></i></a></li>
                        <li class="nav-item" v-if="usuario"><b-button pill variant="primary" class="nav-link dropdown-toggle waves-effect waves-dark profile-pic line-height-0 margin-top-0-5" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-text="usuario.nombre[0]"></b-button></li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" v-if="usuario && usuario.administrador == 1">
                        <li class="nav-small-cap">--- MENÚ</li>

                        <li><router-link to="/usuarios"><i class="fa fa-users"></i> Usuarios</router-link> </li>
                        <li><router-link to="/rubros"><i class="fa fa-list"></i> Rubros</router-link> </li>
                        <li><router-link to="/provincias"><i class="fa fa-building"></i> Provincias</router-link> </li>
                        <li><router-link to="/planes"><i class="fa fa-usd"></i> Planes</router-link> </li>

                        <li @click="cerrar_session">
                            <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-sign-out"></i>
                                <span class="hide-menu">Cerrar sesión</span>
                            </a>
                        </li>
                    </ul>

                    <ul id="sidebarnav" v-if="usuario && usuario.administrador != 1">
                        <li class="nav-small-cap">--- MENÚ</li>

                        <li><router-link to="/perfil"><i class="fa fa-list"></i> Mis publicaciones</router-link> </li>

                        <li @click="cerrar_session">
                            <a class="waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-sign-out"></i>
                                <span class="hide-menu">Cerrar sesión</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            <b-container fluid>
                <router-view></router-view>
            </b-container>
        </div>
    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from 'vuex'

    export default {
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters('usuario', ['saludo']),
            ...mapState('usuario', ['usuario'])
        },
        methods: {
            ...mapActions('usuario', ['salir']),
            ...mapMutations('usuario', ['actualizar']),
            usuario_logeado(){
                let me = this

                axios.get('/usuario/logeado').then(function (response) {
                    if(response.data.usuario){
                        me.actualizar(response.data.usuario)
                        me.saludo
                    } else {
                        window.location.href = "/";
                    }
                })
            },
            cerrar_session(){

                let me = this

                axios.post('/logout').then(function (response) {
                    if (response.status === 302 || 401) {
                        me.salir()
                        window.location.href = "/";
                    }
                    else {
                        console.log(response)
                    }
                })
                .catch(function (error) {
                    console.log(error)
                });

            }
        },
        mounted(){
            this.usuario_logeado()
        }
    }
</script>
