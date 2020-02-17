<template>
    <div>
        <titulo-pagina titulo="Planes"></titulo-pagina>

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

                        <template v-slot:cell(valor)="data">
                            {{ data.item.valor | currency }}
                        </template>

                        <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="warning" title="Actualizar información" @click="abrir_modal_plan(row.item)">
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

        <b-modal ref="modal_plan" :title="modal_plan.titulo" no-close-on-backdrop scrollable static>
            <b-form>
                <b-form-group label="Nombre de plan">
                    <b-form-input
                        v-model="$v.plan.nombre.$model"
                        :state="$v.plan.nombre.$dirty ? !$v.plan.nombre.$error : null"
                        aria-describedby="plan-nombre"
                    ></b-form-input>

                    <b-form-invalid-feedback id="plan-nombre">
                        Campo de alfanúmerico, mínimo de 3 caracteres.
                    </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Duración del plan (meses)">
                    <b-form-input
                        v-model="$v.plan.duracion.$model"
                        :state="$v.plan.duracion.$dirty ? !$v.plan.duracion.$error : null"
                        aria-describedby="plan-duracion"
                    ></b-form-input>

                    <b-form-invalid-feedback id="plan-duracion">
                        Campo de númerico, valor mínimo 0.
                    </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Valor del plan">
                    <b-form-input
                        v-model="$v.plan.valor.$model"
                        :state="$v.plan.valor.$dirty ? !$v.plan.valor.$error : null"
                        aria-describedby="plan-valor"
                    ></b-form-input>

                    <b-form-invalid-feedback id="plan-valor">
                        Campo de númerico, valor mínimo 0.
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.plan.$invalid" v-show="modal_plan.accion == 1" size="md" variant="success" @click="crear_actualizar_plan"> Guardar </b-button>
                <b-button :disabled="$v.plan.$invalid" v-show="modal_plan.accion == 2" size="md" variant="warning" @click="crear_actualizar_plan"> Actualizar </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_plan"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_plan"><i class="ti-plus"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { required, minLength, minValue, numeric } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                items: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'duracion', label: 'Duracion (meses)', sortable: true, class: 'text-left' },
                    { key: 'valor', label: 'Valor', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', sortable: true, class: 'text-center' }
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 150],
                sortBy: '',
                sortDesc: false,
                filter: null,
                modal_plan: {
                    titulo: '',
                    accion: 0
                },
                plan: {
                    id: 0,
                    nombre: '',
                    duracion: null,
                    valor: null
                }
            }
        },
        validations:{
            plan: {
                nombre: {
                    required,
                    minLength: minLength(3)
                },
                duracion:{
                    required,
                    numeric,
                    minValue: minValue(0)
                },
                valor:{
                    required,
                    numeric,
                    minValue: minValue(0)
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
            listar_planes(){
                let me = this

                axios.get('/planes/1').then(function (response) {
                    me.items = response.data.planes
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrir_modal_plan(data = []) {
                let me = this

                me.limpiar_datos_plan()

                me.modal_plan.titulo = data.id == undefined ? "Agregar plan" : "Modificar plan"
                me.modal_plan.accion = data.id == undefined ? 1 : 2

                if(me.modal_plan.accion == 2){
                    me.plan.id = data.id
                    me.plan.nombre = data.nombre
                    me.plan.duracion = data.duracion
                    me.plan.valor = data.valor

                    this.$v.plan.$touch(true)
                }

                this.$refs['modal_plan'].show()
            },
            cerrar_modal_plan() {
                this.modal_plan.titulo = ""
                this.modal_plan.accion = 0
                this.$refs['modal_plan'].hide()
            },
            limpiar_datos_plan() {
                this.plan.id = 0
                this.plan.nombre = ''
                this.plan.duracion = null
                this.plan.valor = null

                this.$v.$reset();
            },
            crear_actualizar_plan() {
                if(this.$v.plan.$invalid){
                    this.$v.plan.$touch()
                    return
                }

                let me = this

                axios.post('/plan/crear/actualizar',{
                        'id': me.plan.id,
                        'nombre': me.plan.nombre,
                        'duracion': me.plan.duracion,
                        'valor': me.plan.valor
                    }).then(function (response) {
                        me.listar_planes()
                        me.$store.commit('msg_success', me.plan.id == 0 ? 'Registro agregado exitosamente.' :  'Registro actualizado exitosamente.')

                        if(me.plan.id == 0){
                            me.limpiar_datos_plan()
                        } else {
                            me.cerrar_modal_plan()
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
                        axios.post('/plan/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_planes();
                            me.$store.commit('msg_success', 'Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            }
        },
        mounted() {
            this.listar_planes()
        }
    }
</script>
