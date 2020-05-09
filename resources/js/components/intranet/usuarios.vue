<template>
    <div>
        <titulo-pagina titulo="Usuarios"></titulo-pagina>

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

                        <template v-slot:cell(contacto)="data">
                            {{ data.item.email + ' - ' + data.item.telefono }}
                        </template>

                        <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="success" title="Información de usuario" @click="abrir_modal_informacion_usuario(row.item)">
                                <i class="fa fa-list"></i>
                            </b-button>

                            <b-button size="xs" variant="info" title="Cambiar clave" @click="abrir_modal_clave_usuario(row.item)">
                                <i class="fa fa-key"></i>
                            </b-button>

                            <b-button size="xs" variant="warning" title="Actualizar información" @click="abrir_modal_usuario(row.item)">
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

        <b-modal ref="modal_informacion_usuario" :title="modal_informacion_usuario.titulo" size="xl" no-close-on-backdrop scrollable static>
            <b-form>
                <b-tabs content-class="mt-3" justified active-nav-item-class="btn-info font-weight-bold">
                    <b-tab title="Foto perfil y redes sociales" active @click="menu_usuario = 0">
                        <b-row>
                            <b-col cols="4">
                                <b-img center :src="perfil.imagen_url" class="mb-5 limite-altura" fluid alt="Imagen de perfil"></b-img>

                                <b-form-file
                                    id="imagen_perfil"
                                    accept="image/*"
                                    placeholder="Escoge tu foto de perfil"
                                    drop-placeholder="Arrastra o hace click aquí"
                                    @change="cambiar_foto($event)"
                                ></b-form-file>

                                <b-button class="mt-2" v-show="perfil.imagen_url != ''" size="md" variant="danger" block @click="eliminar_foto_perfil"> Eliminar foto </b-button>
                            </b-col>
                            <b-col cols="8">
                                <b-form-group label="Link linkedin" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.perfil.link_linkedin.$model"
                                        :state="$v.perfil.link_linkedin.$dirty ? !$v.perfil.link_linkedin.$error : null"
                                        aria-describedby="perfil-link-linkedin"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="perfil-link-linkedin">
                                        Procura ingresar el link de tu red social y sin espacios.
                                    </b-form-invalid-feedback>
                                </b-form-group>
                                <b-form-group label="Link facebook" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.perfil.link_facebook.$model"
                                        :state="$v.perfil.link_facebook.$dirty ? !$v.perfil.link_facebook.$error : null"
                                        aria-describedby="perfil-link_facebook"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="perfil-link-facebook">
                                        Procura ingresar el link de tu red social y sin espacios.
                                    </b-form-invalid-feedback>
                                </b-form-group>
                                <b-form-group label="Link instagram" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.perfil.link_instagram.$model"
                                        :state="$v.perfil.link_instagram.$dirty ? !$v.perfil.link_instagram.$error : null"
                                        aria-describedby="perfil-link_instagram"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="perfil-link-instagram">
                                        Procura ingresar el link de tu red social y sin espacios.
                                    </b-form-invalid-feedback>
                                </b-form-group>
                                <b-form-group label="Teléfono whatsapp" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.perfil.telefono.$model"
                                        :state="$v.perfil.telefono.$dirty ? !$v.perfil.telefono.$error : null"
                                        aria-describedby="perfil-telefono"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="perfil-telefono">
                                        Campo de númerico, ingresa un teléfono con formato 987654321.
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-tab>
                    <b-tab title="Comunas" @click="menu_usuario = 1">
                        <b-row>
                            <b-col>
                                <b-form-group label="Selección de comuna :" label-cols-md="2" label-cols-lg="2">
                                    <vue-bootstrap-typeahead
                                        ref="typeahead_comuna"
                                        :data="comunas"
                                        :serializer="p => p.nombre"
                                        placeholder="Escribe para filtrar ..."
                                        @hit="comuna_seleccionada($event)"
                                    />
                                </b-form-group>
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

                        <b-row>
                            <b-col>
                                <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="comunas_usuario" :fields="fields_comuna" :current-page="currentPage_comuna" :per-page="perPage_comuna" :filter="filter_comuna" :sort-by.sync="sortBy_comuna" :sort-desc.sync="sortDesc_comuna" @filtered="onFiltered_comuna" >
                                    <template v-slot:empty>
                                        <center><h5>No hay registros</h5></center>
                                    </template>

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>


                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar_comuna_usuario(row.item.id)">
                                            <i class="fa fa-trash"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                            </b-col>
                        </b-row>
                    </b-tab>
                    <b-tab title="Rubros" @click="menu_usuario = 2">
                        <b-row>
                            <b-col cols="10">
                                <b-form-group label="Selección de rubro :" label-cols-md="2" label-cols-lg="2">
                                    <vue-bootstrap-typeahead
                                        ref="typeahead_rubro"
                                        v-model="usuario.rubro_usuario"
                                        :data="rubros"
                                        :serializer="p => p.nombre"
                                        placeholder="Escribe para filtrar ..."
                                        @hit="rubro_seleccionado($event)"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col cols="2">
                                <b-button :disabled="usuario.rubro_usuario.length == 0" size="md" block variant="success" @click="agregar_rubro_usuario"> Agregar rubro </b-button>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col lg="6" class="my-1">
                                <b-form-group label="Búsqueda" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="filterInput" class="mb-0" >
                                <b-input-group size="sm">
                                    <b-form-input v-model="filter_rubro" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                                    <b-input-group-append>
                                        <b-button :disabled="!filter_rubro" @click="filter_rubro = ''">Limpiar</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                                </b-form-group>
                            </b-col>

                            <b-col lg="6" class="my-1">
                                <b-form-group label="Ordenar" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="sortBySelect" class="mb-0">
                                    <b-input-group size="sm">
                                        <b-form-select v-model="sortBy_rubro" id="sortBySelect" :options="sortOptions_rubro" class="w-75">
                                            <template v-slot:first>
                                                <option value="">Sin ordenar</option>
                                            </template>
                                        </b-form-select>
                                        <b-form-select v-model="sortDesc_rubro" size="sm" :disabled="!sortBy_rubro" class="w-25">
                                            <option :value="false">Asc</option>
                                            <option :value="true">Desc</option>
                                        </b-form-select>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>

                            <b-col lg="6" class="my-1">
                                <b-form-group label="Por página" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="perPageSelect" class="mb-0">
                                    <b-form-select v-model="perPage_rubro" id="perPageSelect" size="sm" :options="pageOptions_rubro"></b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col lg="6" class="my-1">
                                <b-pagination v-model="currentPage_rubro" :total-rows="totalRows_rubro" :per-page="perPage_rubro" align="fill" size="sm" class="my-0" ></b-pagination>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="rubros_usuario" :fields="fields_rubro" :current-page="currentPage_rubro" :per-page="perPage_rubro" :filter="filter_rubro" :sort-by.sync="sortBy_rubro" :sort-desc.sync="sortDesc_rubro" @filtered="onFiltered_rubro" >
                                    <template v-slot:empty>
                                        <center><h5>No hay registros</h5></center>
                                    </template>

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>


                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar_rubro_usuario(row.item.id)">
                                            <i class="fa fa-trash"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                            </b-col>
                        </b-row>
                    </b-tab>
                    <b-tab title="Publicaciones" @click="menu_usuario = 3">
                        <b-row>
                            <b-col v-if="plan_publicaciones.length == 0">
                                <b-form-group label="Plan asociado a publicación" v-if="publicacion.id == 0">
                                    <b-form-select
                                        v-model="$v.publicacion.plan_id.$model"
                                        :state="$v.publicacion.plan_id.$dirty ? !$v.publicacion.plan_id.$error : null"
                                        aria-describedby="publicacion-plan-id">
                                        <option :value="0">Selecciona una opción</option>
                                        <option v-for="plan in planes" :key="plan.id" :value="plan.id" v-text="plan.nombre + ' - $' + plan.valor"></option>
                                    </b-form-select>

                                    <b-form-invalid-feedback id="publicacion-plan-id">
                                        Debes asignar un plan a la publicación.
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <b-form-group label="Título de publicación">
                                    <b-form-input
                                        v-model="$v.publicacion.titulo.$model"
                                        :state="$v.publicacion.titulo.$dirty ? !$v.publicacion.titulo.$error : null"
                                        aria-describedby="publicacion-titulo"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="publicacion-titulo">
                                        Campo de alfabético, mínimo de 3 caracteres.
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                <b-form-group label="¿Qué ofreces?">
                                    <b-form-textarea
                                        v-model="$v.publicacion.descripcion.$model"
                                        :state="$v.publicacion.descripcion.$dirty ? !$v.publicacion.descripcion.$error : null"
                                        aria-describedby="publicacion-descripcion"
                                        rows="3"
                                        max-rows="6"
                                    ></b-form-textarea>

                                    <b-form-invalid-feedback id="publicacion-descripcion">
                                        Campo de alfabético, mínimo de 20 caracteres.
                                    </b-form-invalid-feedback>
                                </b-form-group>

                                
                                <b-form-group label="Carga imagenes o vídeos sobre la publicación">
                                    <b-form-file
                                        v-model="publicacion.imagenes"
                                        :state="Boolean(publicacion.imagenes)"
                                        multiple
                                        accept="image/*, video/*"
                                        placeholder="Elija un archivo o suéltelo aquí ..."
                                        drop-placeholder="Suelta el archivo aquí... "
                                        :file-name-formatter="formatear_nombre_imagenes"
                                        @change="mostrar_archivos"
                                    ></b-form-file>
                                </b-form-group>

                                <b-row>
                                    <b-col lg="4" v-for="(i, index) in publicacion.url_imagenes" :key="index" class="mb-2">
                                        <b-img thumbnail fluid center :src="i.url" class="imagen-galeria mb-2"></b-img>
                                        <center>
                                            <b-button size="md" title="Marcar como imagen de perfil" variant="success" @click="cambiar_imagen_destacada(index, i.id)">
                                                <i v-if="i.perfil == 1" class="fa fa-heart" aria-hidden="true"></i>
                                                <i v-else class="fa fa-heart-o" aria-hidden="true"></i>
                                            </b-button>
                                            <b-button size="md" title="Eliminar imagen" variant="danger" @click="eliminar_imagen(i.id)"><i class="fa fa-remove" aria-hidden="true"></i></b-button>
                                        </center>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col v-else>
                                <b-row>
                                    <b-col>
                                        <b-form-group label="Plan asociado a publicación">
                                            <b-form-select
                                                v-model="$v.plan_publicacion.plan_id.$model"
                                                :state="$v.plan_publicacion.plan_id.$dirty ? !$v.plan_publicacion.plan_id.$error : null"
                                                aria-describedby="plan-publicacion-id">
                                                <option :value="0">Selecciona una opción</option>
                                                <option v-for="plan in planes" :key="plan.id" :value="plan.id" v-text="plan.nombre + ' - $' + plan.valor"></option>
                                            </b-form-select>

                                            <b-form-invalid-feedback id="plan-publicacion-id">
                                                Debes asignar un plan a la publicación.
                                            </b-form-invalid-feedback>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col lg="6" class="my-1">
                                        <b-form-group label="Búsqueda" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="filterInput" class="mb-0" >
                                        <b-input-group size="sm">
                                            <b-form-input v-model="filter_plan_publicacion" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                                            <b-input-group-append>
                                                <b-button :disabled="!filter_plan_publicacion" @click="filter_plan_publicacion = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col lg="6" class="my-1">
                                        <b-form-group label="Ordenar" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="sortBySelect" class="mb-0">
                                            <b-input-group size="sm">
                                                <b-form-select v-model="sortBy_plan_publicacion" id="sortBySelect" :options="sortOptions_plan_publicacion" class="w-75">
                                                    <template v-slot:first>
                                                        <option value="">Sin ordenar</option>
                                                    </template>
                                                </b-form-select>
                                                <b-form-select v-model="sortDesc_plan_publicacion" size="sm" :disabled="!sortBy_plan_publicacion" class="w-25">
                                                    <option :value="false">Asc</option>
                                                    <option :value="true">Desc</option>
                                                </b-form-select>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col lg="6" class="my-1">
                                        <b-form-group label="Por página" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="perPageSelect" class="mb-0">
                                            <b-form-select v-model="perPage_plan_publicacion" id="perPageSelect" size="sm" :options="pageOptions_plan_publicacion"></b-form-select>
                                        </b-form-group>
                                    </b-col>

                                    <b-col lg="6" class="my-1">
                                        <b-pagination v-model="currentPage_plan_publicacion" :total-rows="totalRows_plan_publicacion" :per-page="perPage_plan_publicacion" align="fill" size="sm" class="my-0" ></b-pagination>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col>
                                        <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="plan_publicaciones" :fields="fields_plan_publicacion" :current-page="currentPage_plan_publicacion" :per-page="perPage_plan_publicacion" :filter="filter_plan_publicacion" :sort-by.sync="sortBy_plan_publicacion" :sort-desc.sync="sortDesc_plan_publicacion" @filtered="onFiltered_plan_publicacion" >
                                            <template v-slot:empty>
                                                <center><h5>No hay registros</h5></center>
                                            </template>

                                            <template v-slot:cell(index)="data">
                                                {{ data.index + 1 }}
                                            </template>

                                            <template v-slot:cell(acciones)="row">
                                                <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar_plan_publicacion_usuario(row.item.id)">
                                                    <i class="fa fa-trash"></i>
                                                </b-button>
                                            </template>
                                        </b-table>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col>
                                <b-row>
                                    <b-col lg="6" class="my-1">
                                        <b-form-group label="Búsqueda" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="filterInput" class="mb-0" >
                                        <b-input-group size="sm">
                                            <b-form-input v-model="filter_publicacion" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                                            <b-input-group-append>
                                                <b-button :disabled="!filter_publicacion" @click="filter_publicacion = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col lg="6" class="my-1">
                                        <b-form-group label="Ordenar" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="sortBySelect" class="mb-0">
                                            <b-input-group size="sm">
                                                <b-form-select v-model="sortBy_publicacion" id="sortBySelect" :options="sortOptions_publicacion" class="w-75">
                                                    <template v-slot:first>
                                                        <option value="">Sin ordenar</option>
                                                    </template>
                                                </b-form-select>
                                                <b-form-select v-model="sortDesc_publicacion" size="sm" :disabled="!sortBy_publicacion" class="w-25">
                                                    <option :value="false">Asc</option>
                                                    <option :value="true">Desc</option>
                                                </b-form-select>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col lg="6" class="my-1">
                                        <b-form-group label="Por página" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="perPageSelect" class="mb-0">
                                            <b-form-select v-model="perPage_publicacion" id="perPageSelect" size="sm" :options="pageOptions_publicacion"></b-form-select>
                                        </b-form-group>
                                    </b-col>

                                    <b-col lg="6" class="my-1">
                                        <b-pagination v-model="currentPage_publicacion" :total-rows="totalRows_publicacion" :per-page="perPage_publicacion" align="fill" size="sm" class="my-0" ></b-pagination>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col>
                                        <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="publicaciones_usuario" :fields="fields_publicacion" :current-page="currentPage_publicacion" :per-page="perPage_publicacion" :filter="filter_publicacion" :sort-by.sync="sortBy_publicacion" :sort-desc.sync="sortDesc_publicacion" @filtered="onFiltered_publicacion" >
                                            <template v-slot:empty>
                                                <center><h5>No hay registros</h5></center>
                                            </template>

                                            <template v-slot:cell(index)="data">
                                                {{ data.index + 1 }}
                                            </template>

                                            <template v-slot:cell(estado)="data">
                                                <b-badge v-if="data.item.estado_publicacion" variant="success" class="text-white">Activa</b-badge>
                                                <b-badge v-else variant="danger" class="text-white">Inactiva</b-badge>
                                            </template>

                                            <template v-slot:cell(acciones)="row">
                                                <b-button size="xs" variant="success" title="Agregar plan a publicación" @click="cargar_datos_plan_usuario(row.item.id)">
                                                    <i class="fa fa-plus"></i>
                                                </b-button>

                                                <b-button size="xs" variant="warning" title="Actualizar información" @click="actualizar_publicacion(row.item)">
                                                    <i class="fa fa-pencil"></i>
                                                </b-button>

                                                <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar_publicacion_usuario(row.item.id)">
                                                    <i class="fa fa-trash"></i>
                                                </b-button>
                                            </template>
                                        </b-table>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                    </b-tab>
                    <b-tab title="Certificaciones y documentos" :active="menu_usuario == 4">
                        <b-row>
                            <b-col col-md="6">
                                <b-form-group>
                                    <b-form-input
                                        v-model="$v.documento.titulo.$model"
                                        :state="$v.documento.titulo.$dirty ? !$v.documento.titulo.$error : null"
                                        placeholder="Título del documento"
                                        aria-describedby="documento-titulo"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="documento-titulo">
                                        Campo de alfabético, mínimo de 3 caracteres.
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </b-col>
                            <b-col col-md="4">
                                <b-form-file
                                    v-model="$v.documento.documento.$model"
                                    :state="$v.documento.documento.$dirty ? !$v.documento.documento.$error : null"
                                    placeholder="Elija un archivo o suéltalo aquí ..."
                                    drop-placeholder="Suelta el archivo aquí ..."
                                    aria-describedby="documento-documento">
                                </b-form-file>

                                <b-form-invalid-feedback id="documento-documento">
                                    Debes de agregar algún documento.
                                </b-form-invalid-feedback>
                            </b-col>
                            <b-col col-md="2">
                                <b-button size="md" block variant="success" @click="agregar_documento_usuario"> Agregar documento </b-button>
                            </b-col>
                        </b-row>
                        
                    
                        <b-row>
                            <b-col lg="6" class="my-1">
                                <b-form-group label="Búsqueda" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="filterInput" class="mb-0" >
                                <b-input-group size="sm">
                                    <b-form-input v-model="filter_documentos" type="search" id="filterInput" placeholder="Escribe para buscar"></b-form-input>
                                    <b-input-group-append>
                                        <b-button :disabled="!filter_documentos" @click="filter_documentos = ''">Limpiar</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                                </b-form-group>
                            </b-col>

                            <b-col lg="6" class="my-1">
                                <b-form-group label="Ordenar" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="sortBySelect" class="mb-0">
                                    <b-input-group size="sm">
                                        <b-form-select v-model="sortBy_documentos" id="sortBySelect" :options="sortOptions_documentos" class="w-75">
                                            <template v-slot:first>
                                                <option value="">Sin ordenar</option>
                                            </template>
                                        </b-form-select>
                                        <b-form-select v-model="sortDesc_documentos" size="sm" :disabled="!sortBy_documentos" class="w-25">
                                            <option :value="false">Asc</option>
                                            <option :value="true">Desc</option>
                                        </b-form-select>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>

                            <b-col lg="6" class="my-1">
                                <b-form-group label="Por página" label-cols-sm="2" label-align-sm="left" label-size="sm" label-for="perPageSelect" class="mb-0">
                                    <b-form-select v-model="perPage_documentos" id="perPageSelect" size="sm" :options="pageOptions_documentos"></b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col lg="6" class="my-1">
                                <b-pagination v-model="currentPage_documentos" :total-rows="totalRows_documentos" :per-page="perPage_documentos" align="fill" size="sm" class="my-0" ></b-pagination>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-table class="my-3" show-empty small striped outlined stacked="sm" :items="documentos_usuario" :fields="fields_documentos" :current-page="currentPage_documentos" :per-page="perPage_documentos" :filter="filter_documentos" :sort-by.sync="sortBy_documentos" :sort-desc.sync="sortDesc_documentos" @filtered="onFiltered_documentos" >
                                    <template v-slot:empty>
                                        <center><h5>No hay registros</h5></center>
                                    </template>

                                    <template v-slot:cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>


                                    <template v-slot:cell(acciones)="row">
                                        <b-button size="xs" variant="danger" title="Eliminar registro" @click="borrar_documento_usuario(row.item.id)">
                                            <i class="fa fa-trash"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                            </b-col>
                        </b-row>
                    </b-tab>
                </b-tabs>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.perfil.$invalid" v-show="menu_usuario == 0" size="md" variant="success" @click="cambiar_redes_sociales"> Actualizar información </b-button>
                <b-button :disabled="$v.plan_publicacion.$invalid" v-show="menu_usuario == 3 && plan_publicaciones.length > 0" size="md" variant="success" @click="crear_actualizar_plan_publicacion"> Agregar plan a publicación </b-button>
                <b-button :disabled="$v.publicacion.$invalid" v-show="menu_usuario == 3  && plan_publicaciones.length == 0" size="md" variant="success" @click="crear_actualizar_publicacion"> Agregar publicación </b-button>
                <b-button :disabled="$v.publicacion.$invalid" v-show="menu_usuario == 3 && publicacion.id > 0" size="md" variant="warning" @click="crear_actualizar_publicacion"> Actualizar publicación </b-button>
                <b-button :disabled="$v.publicacion.$invalid" v-show="menu_usuario == 3 && publicacion.id > 0" size="md" variant="info" @click="limpiar_datos_publicacion"> Limpiar campos </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_informacion_usuario"> Cerrar </b-button>
            </template>
        </b-modal>

        <b-modal ref="modal_clave_usuario" :title="modal_clave_usuario.titulo" no-close-on-backdrop scrollable static>
            <b-form>
                <b-form-group label="Nueva contraseña">
                    <b-form-input
                        type="password"
                        v-model="$v.clave_usuario.clave.$model"
                        :state="$v.clave_usuario.clave.$dirty ? !$v.clave_usuario.clave.$error : null"
                        aria-describedby="clave_usuario-clave"
                    ></b-form-input>

                    <b-form-invalid-feedback id="clave-usuario-clave">
                        Campo de alfabético, mínimo de 3 caracteres.
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.clave_usuario.$invalid" size="md" variant="success" @click="cambiar_clave_usuario"> Cambiar clave </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_clave_usuario"> Cerrar </b-button>
            </template>
        </b-modal>

        <b-modal ref="modal_usuario" :title="modal_usuario.titulo" no-close-on-backdrop scrollable static>
            <b-form>
                <b-form-group label="Nombre y apellido">
                    <b-form-input
                        v-model="$v.usuario.nombre.$model"
                        :state="$v.usuario.nombre.$dirty ? !$v.usuario.nombre.$error : null"
                        aria-describedby="usuario-nombre"
                    ></b-form-input>

                    <b-form-invalid-feedback id="usuario-nombre">
                        Campo de alfabético, mínimo de 3 caracteres.
                    </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Teléfono">
                    <b-form-input
                        v-model="$v.usuario.telefono.$model"
                        :state="$v.usuario.telefono.$dirty ? !$v.usuario.telefono.$error : null"
                        aria-describedby="usuario-telefono"
                    ></b-form-input>

                    <b-form-invalid-feedback id="usuario-telefono">
                        Campo de númerico, ingresa un teléfono con formato 987654321.
                    </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Correo">
                    <b-form-input
                        v-model="$v.usuario.email.$model"
                        :state="$v.usuario.email.$dirty ? !$v.usuario.email.$error : null"
                        aria-describedby="usuario-email"
                        :disabled="modal_usuario.accion == 2"
                    ></b-form-input>

                    <b-form-invalid-feedback id="usuario-email">
                        Ingresa un email válido y que no exista en nuestros usuarios.
                    </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Fecha de nacimiento">
                    <b-form-input
                        type="date"
                        v-model="$v.usuario.fecha_nacimiento.$model"
                        :state="$v.usuario.fecha_nacimiento.$dirty ? !$v.usuario.fecha_nacimiento.$error : null"
                        aria-describedby="usuario-fecha-nacimiento"
                    ></b-form-input>

                    <b-form-invalid-feedback id="usuario-fecha-nacimiento">
                        Ingresa una fecha válida.
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.usuario.$invalid" v-show="modal_usuario.accion == 1" size="md" variant="success" @click="crear_actualizar_usuario"> Guardar </b-button>
                <b-button :disabled="$v.usuario.$invalid" v-show="modal_usuario.accion == 2" size="md" variant="warning" @click="crear_actualizar_usuario"> Actualizar </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_usuario"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_usuario"><i class="ti-plus"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { required, email, minLength, maxLength, numeric, alpha, minValue, url, requiredIf } from 'vuelidate/lib/validators'
    import { mapMutations, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                items: [],
                comunas: [],
                rubros: [],
                planes: [],
                comunas_usuario: [],
                rubros_usuario: [],
                publicaciones_usuario: [],
                plan_publicaciones: [],
                documentos_usuario: [],
                menu_usuario: 0,
                fields: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'contacto', label: 'Contacto rápido', sortable: true, class: 'text-left' },
                    { key: 'tipo', label: 'Tipo usuario', sortable: true, class: 'text-left' },
                    { key: 'created_at', label: 'Fecha creación', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 15,
                pageOptions: [15, 50, 100, 150, 200, 250],
                sortBy: '',
                sortDesc: false,
                filter: null,
                fields_comuna: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows_comuna: 1,
                currentPage_comuna: 1,
                perPage_comuna: 15,
                pageOptions_comuna: [15, 50, 100, 150, 200, 250],
                sortBy_comuna: '',
                sortDesc_comuna: false,
                filter_comuna: null,
                fields_rubro: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows_rubro: 1,
                currentPage_rubro: 1,
                perPage_rubro: 15,
                pageOptions_rubro: [15, 50, 100, 150, 200, 250],
                sortBy_rubro: '',
                sortDesc_rubro: false,
                filter_rubro: null,
                fields_publicacion: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'titulo', label: 'Título', sortable: true, class: 'text-left' },
                    { key: 'created_at', label: 'Creada', sortable: true, class: 'text-left' },
                    { key: 'expira', label: 'Expira', sortable: true, class: 'text-left' },
                    { key: 'estado', label: 'Estado', sortable: true, class: 'text-center' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows_publicacion: 1,
                currentPage_publicacion: 1,
                perPage_publicacion: 15,
                pageOptions_publicacion: [15, 50, 100, 150, 200, 250],
                sortBy_publicacion: '',
                sortDesc_publicacion: false,
                filter_publicacion: null,
                modal_usuario: {
                    titulo: '',
                    accion: 0
                },
                modal_clave_usuario: {
                    titulo: ''
                },
                modal_informacion_usuario: {
                    titulo: ''
                },
                documento: {
                    id: null,
                    titulo: '',
                    documento: null
                },
                usuario: {
                    id: 0,
                    nombre: '',
                    email: '',
                    fecha_nacimiento: '',
                    telefono: null,
                    rubro_usuario: ''
                },
                clave_usuario: {
                    clave: ''
                },
                perfil:{
                    imagen_url: null,
                    link_linkedin: '',
                    link_facebook: '',
                    link_instagram: '',
                    telefono: null
                },
                publicacion: {
                    id: 0,
                    titulo: '',
                    descripcion: '',
                    plan_id: 0,
                    imagenes: [],
                    url_imagenes: []
                },
                plan_publicacion: {
                    plan_id: 0
                },
                fields_plan_publicacion: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre_plan', label: 'Plan', sortable: true, class: 'text-left' },
                    { key: 'valor', label: 'Valor', sortable: true, class: 'text-left' },
                    { key: 'duracion', label: 'Duración', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows_plan_publicacion: 1,
                currentPage_plan_publicacion: 1,
                perPage_plan_publicacion: 15,
                pageOptions_plan_publicacion: [15, 50, 100, 150, 200, 250],
                sortBy_plan_publicacion: '',
                sortDesc_plan_publicacion: false,
                filter_plan_publicacion: null,
                fields_documentos: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'titulo', label: 'Título', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'Acciones', class: 'text-center'}
                ],
                totalRows_documentos: 1,
                currentPage_documentos: 1,
                perPage_documentos: 15,
                pageOptions_documentos: [15, 50, 100, 150, 200, 250],
                sortBy_documentos: '',
                sortDesc_documentos: false,
                filter_documentos: null
            }
        },
        validations:{
            documento: {
                titulo: {
                    required,
                    minLength: minLength(3),
                },
                documento: {
                    required
                }
            },
            usuario: {
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
                        if (value.includes('@') == false) return true
                        if (value.includes('.') == false) return true

                        const response = await fetch(`/usuarios/unico/${value}`)
                        return Boolean(await response.json())
                    }
                },
                fecha_nacimiento: {
                    required,
                    minValue: value => value < new Date().toISOString()
                }
            },
            clave_usuario: {
                clave: {
                    required,
                    minLength: minLength(3)
                }
            },
            perfil:{
                link_linkedin: {
                    required: requiredIf(function (value) {
                        return value.length > 0 ? true : false
                    }),
                    url
                },
                link_facebook: {
                    required: requiredIf(function (value) {
                        return value.length > 0 ? true : false
                    }),
                    url
                },
                link_instagram: {
                    required: requiredIf(function (value) {
                        return value.length > 0 ? true : false
                    }),
                    url
                },
                telefono: {
                    required,
                    numeric,
                    minLength: minLength(9),
                    maxLength: maxLength(9)
                }
            },
            publicacion: {
                titulo: {
                    required,
                    minLength: minLength(3)
                },
                descripcion: {
                    required,
                    minLength: minLength(20)
                },
                plan_id: {
                    required: requiredIf(function () {
                        return this.publicacion.id == 0 ? true : false
                    }),
                    minValue: minValue(1)
                }
            },
            plan_publicacion: {
                plan_id: {
                    required,
                    minValue: minValue(1)
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
            },
            sortOptions_rubro() {
                return this.fields_rubro.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
            sortOptions_publicacion() {
                return this.fields_publicacion.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
            sortOptions_plan_publicacion() {
                return this.fields_plan_publicacion.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            },
            sortOptions_documentos() {
                return this.fields_documentos.filter(f => f.sortable).map(f => {
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
            onFiltered_rubro(filteredItems) {
                this.totalRows_rubro = filteredItems.length
                this.currentPage = 1
            },
            onFiltered_publicacion(filteredItems) {
                this.totalRows_publicacion = filteredItems.length
                this.currentPage = 1
            },
            onFiltered_plan_publicacion(filteredItems) {
                this.totalRows_plan_publicacion = filteredItems.length
                this.currentPage = 1
            },
            onFiltered_documentos(filteredItems) {
                this.totalRows_documentos = filteredItems.length
                this.currentPage = 1
            },
            comuna_seleccionada(e){
                let me = this

                axios.post('/usuario/agregar/comunas',{
                        'nombre_comuna': e.nombre,
                        'usuario_id': me.usuario.id,
                        'comuna_id': e.id
                    }).then(function (response) {
                        me.listar_usuarios()
                        me.msg_success('Comuna agregada exitosamente.')
                        me.listar_comunas_usuario()
                        me.$refs.typeahead_comuna.inputValue = ''
                    }).catch(function (error) {
                        console.log(error)
                })

            },
            agregar_rubro_usuario(){
                let me = this

                axios.post('/usuario/agregar/rubros',{
                        'nombre_rubro': me.usuario.rubro_usuario,
                        'usuario_id': me.usuario.id,
                        'rubro_id': 0
                    }).then(function (response) {
                        me.listar_usuarios()
                        me.msg_success('Rubro agregado exitosamente.')
                        me.listar_rubros_usuario()
                        me.listar_rubros()
                        me.$refs.typeahead_rubro.inputValue = ''
                        me.usuario.rubro_usuario = ''
                    }).catch(function (error) {
                        console.log(error)
                })

            },
            rubro_seleccionado(e){
                let me = this

                axios.post('/usuario/agregar/rubros',{
                        'nombre_rubro': e.nombre,
                        'usuario_id': me.usuario.id,
                        'rubro_id': e.id
                    }).then(function (response) {
                        me.listar_usuarios()
                        me.msg_success('Rubro agregado exitosamente.')
                        me.listar_rubros_usuario()
                        me.$refs.typeahead_rubro.inputValue = ''
                    }).catch(function (error) {
                        console.log(error)
                })

            },
            listar_registros(){
                this.listar_usuarios()
                this.listar_comunas()
                this.listar_rubros()
                this.listar_planes()
            },
            listar_usuarios(){
                let me = this

                axios.get('/usuarios/1').then(function (response) {
                    me.items = response.data.usuarios
                    me.totalRows = me.items.length
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_comunas(){
                let me = this

                axios.get('/comunas/1').then(function (response) {
                    me.comunas = response.data.comunas
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_rubros(){
                let me = this

                axios.get('/rubros/1').then(function (response) {
                    me.rubros = response.data.rubros
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_planes(){
                let me = this

                axios.get('/planes/1').then(function (response) {
                    me.planes = response.data.planes
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_documentos(){
                let me = this

                axios.get('/usuario/documentos/' + me.usuario.id).then(function (response) {
                    me.documentos_usuario = response.data.documentos
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_comunas_usuario(){
                let me = this

                axios.get('/usuario/comunas/' + me.usuario.id).then(function (response) {
                    me.comunas_usuario = response.data.comunas
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_rubros_usuario(){
                let me = this

                axios.get('/usuario/rubros/' + me.usuario.id).then(function (response) {
                    me.rubros_usuario = response.data.rubros
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_publicaciones_usuario(){
                let me = this

                axios.get('/usuario/publicaciones/' + me.usuario.id).then(function (response) {
                    me.publicaciones_usuario = response.data.publicaciones
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_planes_publicacion(){
                let me = this

                axios.get('/usuario/planes/publicacion/' + me.publicacion.id).then(function (response) {

                    me.plan_publicaciones = response.data.plan_publicaciones
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            agregar_documento_usuario(){
                if(this.$v.documento.$invalid){
                    this.$v.documento.$touch()
                    return
                }

                let me = this
                let form = new FormData()

                form.append('documento_id', me.documento.id)
                form.append('titulo', me.documento.titulo)
                form.append('documento', me.documento.documento)
                form.append('user_id', me.usuario.id)

                axios.post('/usuario/agregar/documentos',form).then(function (response) {
                    me.listar_documentos()
                    me.msg_success('Documento actualizado exitosamente.')

                    me.documento.id = null
                    me.documento.titulo = ''
                    me.documento.documento = null
                }).catch(function (error) {
                    console.error(error)
                })
            },
            cargar_datos_plan_usuario(id){
                let me = this

                me.plan_publicaciones = []
                me.publicacion.id = id

                me.listar_planes_publicacion()
            },
            abrir_modal_usuario(data = []) {
                let me = this

                me.limpiar_datos_usuario()
                me.modal_usuario.titulo = data.id == undefined ? "Agregar usuario" : "Modificar usuario"
                me.modal_usuario.accion = data.id == undefined ? 1 : 2

                if(me.modal_usuario.accion == 2){
                    me.usuario.id = data.id
                    me.usuario.nombre = data.nombre
                    me.usuario.email = data.email
                    me.usuario.fecha_nacimiento = data.fecha_nacimiento
                    me.usuario.telefono = data.telefono

                    this.$v.usuario.$touch(true)
                }

                this.$refs['modal_usuario'].show()
            },
            cerrar_modal_usuario() {
                this.modal_usuario.titulo = ""
                this.modal_usuario.accion = 0
                this.$refs['modal_usuario'].hide()
            },
            abrir_modal_clave_usuario(data = []){
                this.usuario.id = data.id
                this.modal_clave_usuario.titulo = 'Cambiar clave a ' + data.nombre
                this.$refs['modal_clave_usuario'].show()
            },
            cerrar_modal_clave_usuario(data = []){
                this.usuario.id = 0
                this.clave_usuario.clave = ''
                this.modal_clave_usuario.titulo = ''
                this.$refs['modal_clave_usuario'].hide()
            },
            abrir_modal_informacion_usuario(data = []){
                this.usuario.id = data.id

                this.perfil.imagen_url = data.perfil_url == 'https://image.flaticon.com/icons/svg/149/149076.svg' ? data.perfil_url : 'storage/' + data.perfil_url
                this.perfil.telefono = data.telefono
                this.perfil.link_linkedin = data.linkedin
                this.perfil.link_facebook = data.facebook
                this.perfil.link_instagram = data.instagram

                this.$v.perfil.$touch(true)

                this.listar_comunas_usuario()
                this.listar_rubros_usuario()
                this.listar_publicaciones_usuario()
                this.listar_documentos()

                this.modal_informacion_usuario.titulo = 'Información de ' + data.nombre
                this.$refs['modal_informacion_usuario'].show()
            },
            cerrar_modal_informacion_usuario(data = []){
                this.limpiar_datos_informacion_usuario()
                this.limpiar_datos_publicacion()
                this.menu_usuario = 0
                this.plan_publicaciones = []
                this.$refs['modal_informacion_usuario'].hide()
            },
            borrar_documento_usuario(id) {
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
                        axios.post('/usuario/documento/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_documentos();
                            me.msg_success('Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            limpiar_datos_informacion_usuario(){
                this.usuario.id = 0

                this.perfil.telefono = null
                this.perfil.link_linkedin = ''
                this.perfil.link_facebook = ''
                this.perfil.link_instagram = ''

                this.modal_informacion_usuario.titulo = ''
            },
            limpiar_datos_usuario() {
                this.usuario.id = 0
                this.usuario.nombre = ''
                this.usuario.email = ''
                this.usuario.fecha_nacimiento = ''
                this.usuario.telefono = null

                this.$v.$reset();
            },
            limpiar_datos_publicacion(){
                this.publicacion.id = 0
                this.publicacion.titulo = ''
                this.publicacion.descripcion = ''
                this.publicacion.plan_id = 0
                this.publicacion.imagenes = []
                this.publicacion.url_imagenes = []

                this.$v.publicacion.$touch(true)
            },
            crear_actualizar_usuario() {
                if(this.$v.usuario.$invalid){
                    this.$v.usuario.$touch()
                    return
                }

                let me = this

                axios.post('/usuario/crear/actualizar',{
                        'id': me.usuario.id,
                        'nombre': me.usuario.nombre,
                        'email': me.usuario.email,
                        'fecha_nacimiento': me.usuario.fecha_nacimiento,
                        'telefono': me.usuario.telefono
                    }).then(function (response) {
                        me.listar_usuarios()
                        me.msg_success(me.usuario.id == 0 ? 'Registro agregado exitosamente.' :  'Registro actualizado exitosamente.')

                        if(me.usuario.id == 0){
                            me.limpiar_datos_usuario()
                        } else {
                            me.cerrar_modal_usuario()
                        }

                    }).catch(function (error) {
                        console.log(error)
                })
            },
            cambiar_clave_usuario(){
                if(this.$v.clave_usuario.$invalid){
                    this.$v.clave_usuario.$touch()
                    return
                }

                let me = this

                axios.post('/usuario/cambiar/clave',{
                        'id': me.usuario.id,
                        'clave': me.clave_usuario.clave
                    }).then(function (response) {
                        me.listar_usuarios()
                        me.msg_success('Registro actualizado exitosamente.')
                        me.cerrar_modal_clave_usuario()

                    }).catch(function (error) {
                        console.log(error)
                })
            },
            cambiar_redes_sociales(){
                if(this.$v.perfil.$invalid){
                    this.$v.perfil.$touch()
                    return
                }

                let me = this

                axios.post('/usuario/cambiar/sociales',{
                        'id': me.usuario.id,
                        'link_linkedin': me.perfil.link_linkedin,
                        'link_facebook': me.perfil.link_facebook,
                        'link_instagram': me.perfil.link_instagram,
                        'telefono': me.perfil.telefono
                    }).then(function (response) {
                        me.msg_success('Registro actualizado exitosamente.')
                    }).catch(function (error) {
                        console.log(error)
                })
            },
            actualizar_publicacion(data = []){
                this.publicacion.id = data.id
                this.publicacion.titulo = data.titulo
                this.publicacion.descripcion = data.descripcion

                this.$v.publicacion.$touch(true)
            },
            crear_actualizar_publicacion(){
                if(this.$v.publicacion.$invalid){
                    this.$v.publicacion.$touch()
                    return
                }

                let me = this
                let form = new FormData()

                var imagen = this.publicacion.url_imagenes.find(function(i) {
                    return i.perfil == 1
                })

                var indice = this.publicacion.url_imagenes.indexOf(imagen)

                 this.publicacion.imagenes.forEach( function(i, index) {
                    form.append('imagen_' + index, i)
                })

                form.append('id', me.publicacion.id)
                form.append('titulo', me.publicacion.titulo)
                form.append('descripcion', me.publicacion.descripcion.replace(/\r?\n/g, '<br />'),)
                form.append('user_id', me.usuario.id)
                form.append('plan_id', me.publicacion.plan_id)
                form.append('cantidad_imagenes', this.publicacion.imagenes.length)
                form.append('indice_perfil', indice)



                axios.post('/usuario/crear/actualizar/publicacion', form).then(function (response) {
                        me.listar_publicaciones_usuario()
                        me.limpiar_datos_publicacion()
                        me.msg_success(me.publicacion.id == 0 ? 'Registro agregado exitosamente.' :  'Registro actualizado exitosamente.')
                    }).catch(function (error) {
                        console.log(error)
                })
            },
            crear_actualizar_plan_publicacion(){
                if(this.$v.plan_publicacion.$invalid){
                    this.$v.plan_publicacion.$touch()
                    return
                }

                let me = this

                axios.post('/usuario/crear/plan/publicacion',{
                        'publicacion_id': me.publicacion.id,
                        'plan_id': me.plan_publicacion.plan_id,
                        'user_id': me.usuario.id
                    }).then(function (response) {
                        me.listar_planes_publicacion()
                        me.plan_publicacion.plan_id = 0
                        me.msg_success('Registro agregado exitosamente.')
                    }).catch(function (error) {
                        console.log(error)
                })
            },
            eliminar_foto_perfil(){
                let me = this
                axios.post('/usuario/eliminar/foto',{
                        'id': me.usuario.id
                    }).then(function (response) {
                        me.msg_success('Registro actualizado exitosamente.')
                        me.perfil.imagen_url = 'https://image.flaticon.com/icons/svg/149/149076.svg'
                    }).catch(function (error) {
                        console.log(error)
                })
            },
            cambiar_foto(e){
                var reader = new FileReader()
                let me = this

                reader.onload = function(e) {
                    $('#imagen_perfil').attr('src', e.target.result)
                }

                if(e.target.files[0]){
                    reader.readAsDataURL(e.target.files[0])
                    this.perfil.imagen_url = URL.createObjectURL(e.target.files[0])

                    let form_data = new FormData()
                    let imagen_perfil = document.querySelector('#imagen_perfil')

                    form_data.append('id', me.usuario.id)
                    form_data.append('imagen_perfil', imagen_perfil.files[0])

                    axios.post('/usuario/cambiar/foto',form_data).then(function (response) {
                        me.msg_success('Registro actualizado exitosamente.')
                    }).catch(function (error) {
                        console.error(error)
                    });
                }
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
                        axios.post('/usuario/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_usuarios();
                            me.msg_success('Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            borrar_comuna_usuario(id) {
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
                        axios.post('/usuario/comuna/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_comunas_usuario();
                            me.msg_success('Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            borrar_rubro_usuario(id) {
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
                        axios.post('/usuario/rubro/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_rubros_usuario();
                            me.msg_success('Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            borrar_plan_publicacion_usuario(id){
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
                        axios.post('/usuario/plan/publicacion/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_planes_publicacion();
                            me.msg_success('Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
            formatear_nombre_imagenes(files) {
                if (files.length === 1) {
                    return files[0].name
                } else {
                    return `${files.length} archivos seleccionados`
                }
            },
            cambiar_imagen_destacada(index_imagen, id_imagen){
                this.publicacion.url_imagenes.forEach( function(i, index) {
                    i.perfil = index_imagen == index ? 1 : 0
                })
                if(id_imagen > 0){
                    this.seleccionar_imagen_perfil(id_imagen)
                }
            },
            mostrar_archivos(e){
                let me = this
                this.publicacion.url_imagenes = []
                Array.from(e.target.files).forEach( function(i, index) {
                    var item = new Object()
                    item.id = 0
                    item.url = URL.createObjectURL(i)
                    item.perfil = index == 0 ? 1 : 0
                    me.publicacion.url_imagenes.push(item)
                })
            },
            eliminar_imagen(id){
                let me = this
                if(this.modal_publicacion.accion == 1){
                    this.publicacion.imagenes.splice(id, 1)
                    this.publicacion.url_imagenes.splice(id, 1)
                } else {
                    axios.post('/usuario/imagen/eliminar',{
                        'id': id
                    }).then(function (response) {
                        me.listar_imagenes_publicacion();
                        me.$store.commit('msg_success', 'Registro eliminado exitosamente.')
                    }).catch(function (error) {
                        console.log(error);
                    })
                }

            },
            listar_imagenes_publicacion(){
                let me = this
                axios.get('/imagenes/usuario/' + me.publicacion.id).then(function (response) {
                    me.publicacion.url_imagenes = response.data.imagenes
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            borrar_publicacion_usuario(id) {
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
                        axios.post('/usuario/publicacion/borrar',{
                            'id': id
                        }).then(function (response) {
                            me.listar_publicaciones_usuario(me.usuario.id);
                            me.msg_success('Registro eliminado exitosamente.')
                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            },
        },
        mounted() {
            this.listar_registros()
        }
    }
</script>
