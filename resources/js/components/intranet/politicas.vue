<template>
    <div>
        <titulo-pagina titulo="Políticas de privacidad"></titulo-pagina>

        <b-row>
            <b-col>
                <b-card>
                    <b-row>
                        <b-col>
                            <b-form-group>
                                <ckeditor :editor="editor" v-model="politicas" :config="editorConfig"></ckeditor>
                            </b-form-group>
                        </b-col>
                    </b-row>


                </b-card>
            </b-col>
        </b-row>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="guardar_politicas"><i class="fa fa-refresh"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { mapMutations, mapGetters } from 'vuex'

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import '@ckeditor/ckeditor5-build-classic/build/translations/es';

    export default {
        data() {
            return {
                editor: ClassicEditor,
                politicas: '',
                editorConfig: {
                    language: 'es'
                }
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            listar_politicas(){
                let me = this

                axios.get('/general/politicas').then(function (response) {
                    me.politicas = response.data.politicas.politicas
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            guardar_politicas() {
                let me = this

                axios.post('/general/politicas',{
                        'politicas': me.politicas
                    }).then(function (response) {
                        me.listar_politicas()
                        me.$store.commit('msg_success', 'Registro actualizado exitosamente.')

                    }).catch(function (error) {
                        console.log(error)
                })
            }
        },
        mounted() {
            this.listar_politicas()
        }
    }
</script>

<style>
    .ck-file-dialog-button {
        display: none !important;
    }

    .ck-editor__editable {
        min-height: 500px;
   }
</style>