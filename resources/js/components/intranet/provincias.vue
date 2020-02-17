<template>
    <div>
        <titulo-pagina titulo="Provincias"></titulo-pagina>

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
                        <template v-slot:empty="scope">
                            <center><h5>No hay registros</h5></center>
                        </template>

                        <template v-slot:cell(index)="data">
                            {{ data.index + 1 }}
                        </template>


                        <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="success" title="Añadir comunas" @click="abrir_modal_comuna(row.item)">
                                <i class="fa fa-plus"></i>
                            </b-button>

                            <b-button size="xs" variant="warning" title="Actualizar información" @click="abrir_modal_provincia(row.item)">
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

        <b-modal ref="modal_provincia" :title="modal_provincia.titulo" no-close-on-backdrop scrollable static>
            <b-form>
                <b-form-group label="Nombre de provincia">
                    <b-form-input
                        v-model="$v.provincia.nombre.$model"
                        :state="$v.provincia.nombre.$dirty ? !$v.provincia.nombre.$error : null"
                        aria-describedby="provincia-nombre"
                    ></b-form-input>

                    <b-form-invalid-feedback id="provincia-nombre">
                        Campo de alfanúmerico, mínimo de 3 caracteres.
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.provincia.$invalid" v-show="modal_provincia.accion == 1" size="md" variant="success" @click="crear_actualizar_provincia"> Guardar </b-button>
                <b-button :disabled="$v.provincia.$invalid" v-show="modal_provincia.accion == 2" size="md" variant="warning" @click="crear_actualizar_provincia"> Actualizar </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_provincia"> Cerrar </b-button>
            </template>
        </b-modal>

        <b-modal ref="modal_comuna" size="lg" :title="modal_comuna.titulo" no-close-on-backdrop scrollable static>
            <b-form>

                <b-row>
                    <b-col cols="8">
                        <b-form-group>
                            <b-form-input
                                v-model="$v.comuna.nombre.$model"
                                :state="$v.comuna.nombre.$dirty ? !$v.comuna.nombre.$error : null"
                                aria-describedby="comuna-nombre"
                                placeholder="Nombre de comuna"
                            ></b-form-input>

                            <b-form-invalid-feedback id="comuna-nombre">
                                Campo de alfanúmerico, mínimo de 3 caracteres.
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </b-col>
                    <b-col cols="4">
                        <b-button class="mt-0" block :disabled="$v.comuna.$invalid" v-show="modal_comuna.accion == 1" size="md" variant="success" @click="crear_actualizar_comuna"> Guardar </b-button>
                        <b-button class="mt-0" block :disabled="$v.comuna.$invalid" v-show="modal_comuna.accion == 2" size="md" variant="warning" @click="crear_actualizar_comuna"> Actualizar </b-button>
                    </b-col>
                </b-row>



                <b-row>
                    <b-col lg="6" class="my-1">
                        <b-form-group label="Búsqueda" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="filterInput" class="mb-0" >
                        <b-input-group size="sm">
                            <b-form-input v-model="filter_comuna" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                            <b-input-group-append>
                                <b-button :disabled="!filter_comuna" @click="filter_comuna = ''">Limpiar</b-button>
                            </b-input-group-append>
                        </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col lg="6" class="my-1">
                        <b-form-group label="Ordenar" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="sortBySelect" class="mb-0">
                            <b-input-group size="sm">
                                <b-form-select v-model="sortBy_comuna" id="sortBySelect" :options="sortOptions_comuna" class="w-75">
                                    <template v-slot:first>
                                        <option value="">Sin ordenar</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-model="sortDesc_comuna" size="sm" :disabled="!sortBy_comuna" class="w-25">
                                    <option :value="false">Asc</option>
                                    <option :value="true">Desc</option>
                                </b-form-select>
                            </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col lg="6" class="my-1">
                        <b-form-group label="Por página" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="perPageSelect" class="mb-0">
                            <b-form-select v-model="perPage_comuna" id="perPageSelect" size="sm" :options="pageOptions_comuna"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col lg="6" class="my-1">
                        <b-pagination v-model="currentPage_comuna" :total-rows="totalRows_comuna" :per-page="perPage_comuna" align="fill" size="sm" class="my-0" ></b-pagination>
                    </b-col>
                </b-row>

                <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="comunas" :fields="fields_comuna" :current-page="currentPage_comuna" :per-page="perPage_comuna" :filter="filter_comuna" :sort-by.sync="sortBy_comuna" :sort-desc.sync="sortDesc_comuna" @filtered="onFiltered_comuna" >
                    <template v-slot:empty="scope">
                        <center><h5>No hay registros</h5></center>
                    </template>

                    <template v-slot:cell(index)="data">
                        {{ data.index + 1 }}
                    </template>


                    <template v-slot:cell(acciones)="row">
                        <b-button size="xs" variant="warning" title="Actualizar información" @click="editar_comuna(row.item)">
                            <i class="fa fa-pencil"></i>
                        </b-button>

                        <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar(row.item.id)">
                            <i class="fa fa-trash"></i>
                        </b-button>
                    </template>
                </b-table>
            </b-form>

            <template slot="modal-footer">
                <b-button size="md" variant="danger" @click="cerrar_modal_comuna"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_provincia"><i class="ti-plus"></i></b-button>
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
                comunas: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                fields_comuna: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 150],
                sortBy: '',
                sortDesc: false,
                filter: null,
                totalRows_comuna: 1,
                currentPage_comuna: 1,
                perPage_comuna: 15,
                pageOptions_comuna: [15, 50, 100, 150, 200, 150],
                sortBy_comuna: '',
                sortDesc_comuna: false,
                filter_comuna: null,
                modal_provincia: {
                    titulo: '',
                    accion: 0
                },
                modal_comuna: {
                    titulo: '',
                    accion: 0
                },
                provincia: {
                    id: 0,
                    nombre: ''
                },
                comuna: {
                    id: 0,
                    nombre: ''
                }
            }
        },
        validations:{
            provincia: {
                nombre: {
                    required,
                    minLength: minLength(3)
                }
            },
            comuna: {
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
            },
            sortOptions_comuna() {
                return this.fields_comuna.filter(f => f.sortable).map(f => {
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
            onFiltered_comuna(filteredItems) {
                this.totalRows_comuna = filteredItems.length
                this.currentPage = 1
            },
            listar_provincias(){
                let me = this

                axios.get('/provincias/1').then(function (response) {
                    me.items = response.data.provincias
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_comunas_provincias(){
                let me = this

                axios.get('/provincias/comuna/' + me.provincia.id).then(function (response) {
                    me.comunas = response.data.comunas
                    me.totalRows_comuna = me.comunas.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_provincia(data = []) {
                let me = this

                me.limpiar_datos_provincia()
                me.modal_provincia.titulo = data.id == undefined ? "Agregar provincia" : "Modificar provincia"
                me.modal_provincia.accion = data.id == undefined ? 1 : 2

                if(me.modal_provincia.accion == 2){
                    me.provincia.id = data.id
                    me.provincia.nombre = data.nombre

                    this.$v.provincia.$touch(true)
                }

                this.$refs['modal_provincia'].show()
            },
            abrir_modal_comuna(data = []) {
                let me = this

                me.provincia.id = data.id
                me.modal_comuna.titulo = me.comuna.id == 0 ? "Agregar comunas a " + data.nombre : "Modificar comunas a " + data.nombre

                me.limpiar_datos_comuna()
                me.listar_comunas_provincias()

                this.$refs['modal_comuna'].show()
            },
            editar_comuna(data = []){
                let me = this

                me.modal_comuna.accion = 2
                me.provincia.id = data.provincia_id
                me.comuna.id = data.id
                me.comuna.nombre = data.nombre

                this.$v.comuna.$touch(true)
            },
            cerrar_modal_comuna() {
                this.modal_comuna.titulo = ""
                this.modal_comuna.accion = 0

                this.provincia.id = 0

                this.$refs['modal_comuna'].hide()
            },
            cerrar_modal_provincia() {
                this.modal_provincia.titulo = ""
                this.modal_provincia.accion = 0
                this.$refs['modal_provincia'].hide()
            },
            limpiar_datos_provincia() {
                this.provincia.id = 0
                this.provincia.nombre = ''

                this.$v.$reset();
            },
            limpiar_datos_comuna() {
                this.modal_comuna.accion = 1
                this.comuna.id = 0
                this.comuna.nombre = ''

                this.$v.$reset();
            },
            crear_actualizar_provincia() {
                if(this.$v.provincia.$invalid){
                    this.$v.provincia.$touch()
                    return
                }

                let me = this

                axios.post('/provincia/crear/actualizar',{
                        'id': me.provincia.id,
                        'nombre': me.provincia.nombre
                    }).then(function (response) {
                        me.listar_provincias()
                        me.$store.commit('msg_success', me.provincia.id == 0 ? 'Registro agregado exitosamente.' :  'Registro actualizado exitosamente.')

                        if(me.provincia.id == 0){
                            me.limpiar_datos_provincia()
                        } else {
                            me.cerrar_modal_provincia()
                        }

                    }).catch(function (error) {
                        console.log(error)
                })
            },
            crear_actualizar_comuna() {
                if(this.$v.comuna.$invalid){
                    this.$v.comuna.$touch()
                    return
                }

                let me = this

                axios.post('/comuna/crear/actualizar',{
                        'id': me.comuna.id,
                        'nombre': me.comuna.nombre,
                        'provincia_id': me.provincia.id
                    }).then(function (response) {
                        me.listar_comunas_provincias()
                        me.msg_success(me.comuna.id == 0 ? 'Registro agregado exitosamente.' :  'Registro actualizado exitosamente.')
                        me.limpiar_datos_comuna()

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
                        axios.post('/provincia/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_provincias();
                            me.$store.commit('msg_success', 'Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            }
        },
        mounted() {
            this.listar_provincias()
        }
    }
</script>
