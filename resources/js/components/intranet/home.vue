<template>
    <span></span>
</template>

<script>
    import { mapState, mapGetters, mapActions, mapMutations } from 'vuex'

    export default {
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
                        if(response.data.usuario.administrador == 1){
                            me.$router.push("usuarios")
                        } else {
                            me.$router.push("perfil") 
                        }
                    } else {
                        me.cerrar_session()
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
