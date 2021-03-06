<template>
    <div>
        <titulo-pagina titulo="Rubros"></titulo-pagina>

        <b-row>
            <b-col>
                <b-card>
                    <b-row>
                        <b-col lg="6" class="my-1">
                            <b-form-group label="Búsqueda" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="filterInput" class="mb-0" >
                            <b-input-group size="sm">
                                <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                                <b-input-group-append>
                                    <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                </b-input-group-append>
                            </b-input-group>
                            </b-form-group>
                        </b-col>

                        <b-col lg="6" class="my-1">
                            <b-form-group label="Ordenar" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="sortBySelect" class="mb-0">
                                <b-input-group size="sm">
                                    <b-form-select v-model="sortBy" id="sortBySelect" :options="sortOptions" class="w-75">
                                        <template v-slot:first>
                                            <option value="">Sin ordenar</option>
                                        </template>
                                    </b-form-select>
                                    <b-form-select v-model="sortDesc" size="sm" :disabled="!sortBy" class="w-25">
                                        <option :value="false">Asc</option>
                                        <option :value="true">Desc</option>
                                    </b-form-select>
                                </b-input-group>
                            </b-form-group>
                        </b-col>

                        <b-col lg="6" class="my-1">
                            <b-form-group label="Por página" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="perPageSelect" class="mb-0">
                                <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
                            </b-form-group>
                        </b-col>

                        <b-col lg="6" class="my-1">
                            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0" ></b-pagination>
                        </b-col>
                    </b-row>

                    <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="items" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" @filtered="onFiltered" >
                        <template v-slot:empty>
                            <center><h5>No hay registros</h5></center>
                        </template>

                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>


                        <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="warning" title="Actualizar información" @click="abrir_modal_rubro(row.item)">
                                <i class="fa fa-pencil"></i>
                            </b-button>

                            <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar(row.item.id)">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </template>
                    </b-table>
                </b-card>
            </b-col>
        </b-row>

        <b-modal ref="modal_rubro" :title="modal_rubro.titulo" no-close-on-backdrop scrollable static>
            <b-form>
                <b-form-group label="Nombre de rubro">
                    <b-form-input
                        v-model="$v.rubro.nombre.$model"
                        :state="$v.rubro.nombre.$dirty ? !$v.rubro.nombre.$error : null"
                        aria-describedby="rubro-nombre"
                    ></b-form-input>

                    <b-form-invalid-feedback id="rubro-nombre">
                        Campo de alfanúmerico, mínimo de 3 caracteres.
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.rubro.$invalid" v-show="modal_rubro.accion == 1" size="md" variant="success" @click="crear_actualizar_rubro"> Guardar </b-button>
                <b-button :disabled="$v.rubro.$invalid" v-show="modal_rubro.accion == 2" size="md" variant="warning" @click="crear_actualizar_rubro"> Actualizar </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_rubro"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_rubro"><i class="ti-plus"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { required, minLength, between } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                items: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'usuariosAsociados', label: 'Usuarios asociados', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 250],
                sortBy: '',
                sortDesc: false,
                filter: null,
                modal_rubro: {
                    titulo: '',
                    accion: 0
                },
                rubro: {
                    id: 0,
                    nombre: ''
                }
            }
        },
        validations:{
            rubro: {
                nombre: {
                    required,
                    minLength: minLength(3)
                }
            }
        },
        computed: {
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods: {
            ...mapMutations(['msg_success', 'msg_error']),
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            listar_rubros(){
                let me = this

                axios.get('/rubros/1').then(function (response) {
                    me.items = response.data.rubros
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_rubro(data = []) {
                let me = this

                me.limpiar_datos_rubro()
                me.modal_rubro.titulo = data.id == undefined ? "Agregar rubro" : "Modificar rubro"
                me.modal_rubro.accion = data.id == undefined ? 1 : 2

                if(me.modal_rubro.accion == 2){
                    me.rubro.id = data.id
                    me.rubro.nombre = data.nombre

                    this.$v.rubro.$touch(true)
                }

                this.$refs['modal_rubro'].show()
            },
            cerrar_modal_rubro() {
                this.modal_rubro.titulo = ""
                this.modal_rubro.accion = 0
                this.$refs['modal_rubro'].hide()
            },
            limpiar_datos_rubro() {
                this.rubro.id = 0
                this.rubro.nombre = ''

                this.$v.$reset();
            },
            crear_actualizar_rubro() {
                if(this.$v.rubro.$invalid){
                    this.$v.rubro.$touch()
                    return
                }

                let me = this

                axios.post('/rubro/crear/actualizar',{
                        'id': me.rubro.id,
                        'nombre': me.rubro.nombre
                    }).then(function (response) {
                        me.listar_rubros()
                        me.$store.commit('msg_success', me.rubro.id == 0 ? 'Registro agregado exitosamente.' :  'Registro actualizado exitosamente.')

                        if(me.rubro.id == 0){
                            me.limpiar_datos_rubro()
                        } else {
                            me.cerrar_modal_rubro()
                        }

                    }).catch(function (error) {
                        console.log(error)
                })
            },
            borrar(id) {
                swal.fire({
                    title: '¿Deseas borrar el registro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡bórralo!'
                }).then((result) => {
                    if (result.value) {
                        let me = this
                        axios.post('/rubro/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_rubros();
                            me.$store.commit('msg_success', 'Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            }
        },
        mounted() {
            this.listar_rubros()
        }
    }
</script>
