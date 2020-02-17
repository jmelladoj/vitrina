<template>
    <div class="col-md-6 col-xs-12 p-left p-right">
        <div class="col-md-4 col-xs-12 p-left p-right">
            <div class="searching">
                <vue-bootstrap-typeahead ref="typeahead" :data="comunas" :serializer="c => c.nombre" placeholder="¿En qué lugar?"
                    :maxMatches="10"
                    @hit="comuna_seleccionada"
                />
            </div>
        </div>
        <div class="col-md-4 col-xs-12 p-left p-right">
            <div class="searching">
                <input type="text" v-model="formulario.rubro" class="form-control borde-input" placeholder="¿Qué buscas?">
            </div>
        </div>
        <div class="col-md-4 col-xs-12 p-left p-right mt-3">
            <button type="button" class="btn btn-block btn-success" @click="buscar">Realizar búsqueda</button>
        </div>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex'

    export default {
        data(){
            return {
                comunas: [],
                formulario: {
                    id_comuna: null,
                    rubro: null
                }
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            buscar(){
                let me = this

                if(!this.formulario.id_comuna || !this.formulario.rubro){
                    me.msg_error('Procura llenar todos los campos antes de realizar la búsqueda.')
                    return
                }

                window.location.href = "/resultados/" + this.formulario.id_comuna + "/" + this.formulario.rubro;
            },
            listar_comunas (){
                let me=this;
                axios.get('/comunas/1').then(function (response) {
                    me.comunas = response.data.comunas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            comuna_seleccionada(e){
                let me = this;

                var comuna = me.comunas.find(function(c) {
                    return c.id == e.id;
                });

                if(comuna){
                    me.formulario.id_comuna = comuna.id
                }
            },
        },
        beforeMount(){
            this.listar_comunas()
        }
    }
</script>
