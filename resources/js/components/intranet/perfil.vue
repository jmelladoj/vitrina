<template>
    <div>
       <titulo-pagina titulo="Mis publicaciones">
            <template slot="accion_titulo">
                <button type="button" title="Configurar mi perfil" class="btn btn-info d-none d-lg-block m-l-15" @click="abrir_modal_informacion_usuario"><i class="fa fa-cog"></i> Configurar mi perfil</button>
            </template>
        </titulo-pagina>

        <b-row :if="modal_perfil || modal_comunas || modal_rubros || modal_documentos">
            <b-col>
                <b-card>
                    <b-row>
                        <b-col>
                            <b-alert variant="warning" :show="modal_perfil || modal_comunas || modal_rubros || modal_documentos">
                                <p>
                                    Recuerda que mientras más completo este tu perfil, tienes más posibildidades de aparecen en las búsquedas.
                                </p>
                                <p>    
                                    <label v-if="modal_perfil"><b>* </b>Falta completar información en <b><u>foto de perfil y redes sociales</u></b><b-button size="md" variant="primary" class="ml-2" @click="abrir_configuracion_usuario(0)"><i class="fa fa-cog"></i> Configurar información</b-button></label><br>
                                    <label v-if="modal_comunas"><b>* </b>Debes de ingresar al menos <b><u>una comuna dentro de tu perfil</u></b><b-button size="md" variant="primary" class="ml-2" @click="abrir_configuracion_usuario(1)"><i class="fa fa-cog"></i> Configurar comunas</b-button></label><br>
                                    <label v-if="modal_rubros"><b>* </b>Debes de ingresar al menos <b><u>un rubro dentro de tu perfil</u></b><b-button size="md" variant="primary" class="ml-2" @click="abrir_configuracion_usuario(2)"><i class="fa fa-cog"></i> Configurar rubros</b-button></label><br>
                                    <label v-if="modal_documentos"><b>* </b>Debes de ingresar al menos <b><u>un documento dentro de tu perfil</u></b><b-button size="md" variant="primary" class="ml-2" @click="abrir_configuracion_usuario(3)"><i class="fa fa-cog"></i> Configurar documentos</b-button></label>
                                </p>
                            </b-alert>
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
        </b-row>

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

                        <template v-slot:cell(estado)="data">
                            <b-badge v-if="data.item.estado_publicacion" variant="success" class="text-white">Activa</b-badge>
                            <b-badge v-else variant="danger" class="text-white">Inactiva</b-badge>
                        </template>

                        <template v-slot:cell(acciones)="row">
                            <b-button size="xs" variant="success" title="Agregar plan a publicación" @click="abrir_modal_plan_publicacion_usuario(row.item.id)">
                                <i class="fa fa-plus"></i>
                            </b-button>

                            <b-button size="xs" variant="warning" title="Actualizar publicación" @click="abrir_modal_publicacion(row.item)">
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

        <b-modal ref="modal_informacion_usuario" title="Configurar perfil" size="xl" no-close-on-backdrop scrollable static>
            <b-form>
                <b-row :show="modal_perfil || modal_comunas  || modal_rubros || modal_documentos ">
                    <b-col>
                        <b-alert variant="warning" :show="modal_perfil || modal_comunas || modal_rubros || modal_documentos">
                            <p>
                                Recuerda que mientras más completo este tu perfil, tienes más posibildidades de aparecen en las búsquedas.
                            </p>
                            <p>    
                                <label v-if="modal_perfil"><b>* </b>Falta completar información en <b><u>foto de perfil y redes sociales</u></b></label><br>
                                <label v-if="modal_comunas"><b>* </b>Debes de ingresar al menos <b><u>una comuna dentro de tu perfil</u></b></label><br>
                                <label v-if="modal_rubros"><b>* </b>Debes de ingresar al menos <b><u>un rubro dentro de tu perfil</u></b></label><br>
                                <label v-if="modal_documentos"><b>* </b>Debes de ingresar al menos <b><u>un documentos dentro de tu perfil</u></b></label>
                            </p>
                        </b-alert>
                    </b-col>
                </b-row>

                <b-tabs content-class="mt-3" justified active-nav-item-class="btn-info font-weight-bold">
                    <b-tab title="Foto perfil y redes sociales" :active="menu_usuario == 0" @click="menu_usuario = 0">
                        <b-row>
                            <b-col cols="4">
                                <b-img center :src="usuario.perfil_url" class="mb-5 limite-altura" fluid alt="Imagen de perfil"></b-img>
                                <b-form-file
                                    id="imagen_perfil"
                                    accept="image/*"
                                    placeholder="Escoge tu foto de perfil"
                                    drop-placeholder="Arrastra o hace click aquí"
                                    @change="cambiar_foto($event)"
                                ></b-form-file>

                                <b-button class="mt-2" v-show="usuario.perfil_url != ''" size="md" variant="danger" block @click="eliminar_foto_perfil"> Eliminar foto </b-button>
                            </b-col>
                            <b-col cols="8">
                                <b-form-group label="Link linkedin" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.usuario.linkedin.$model"
                                        :state="$v.usuario.linkedin.$dirty ? !$v.usuario.linkedin.$error : null"
                                        aria-describedby="usuario-link-linkedin"
                                        :disabled="usuario.usuario_pago == 0"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="usuario-link-linkedin">
                                        Procura ingresar el link de tu red social y sin espacios.
                                    </b-form-invalid-feedback>

                                    <span class="text-danger" v-show="usuario.usuario_pago == 0">
                                        Recuerda que para acceder a este campo, debes de tener una membresía activa.
                                    </span>
                                </b-form-group>
                                <b-form-group label="Link facebook" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.usuario.facebook.$model"
                                        :state="$v.usuario.facebook.$dirty ? !$v.usuario.facebook.$error : null"
                                        aria-describedby="usuario-facebook"
                                        :disabled="usuario.usuario_pago == 0"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="usuario-link-facebook">
                                        Procura ingresar el link de tu red social y sin espacios.
                                    </b-form-invalid-feedback>

                                    <span class="text-danger" v-show="usuario.usuario_pago == 0">
                                        Recuerda que para acceder a este campo, debes de tener una membresía activa.
                                    </span>
                                </b-form-group>
                                <b-form-group label="Link instagram" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.usuario.instagram.$model"
                                        :state="$v.usuario.instagram.$dirty ? !$v.usuario.instagram.$error : null"
                                        aria-describedby="usuario-instagram"
                                        :disabled="usuario.usuario_pago == 0"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="usuario-link-instagram">
                                        Procura ingresar el link de tu red social y sin espacios.
                                    </b-form-invalid-feedback>

                                    <span class="text-danger" v-show="usuario.usuario_pago == 0">
                                        Recuerda que para acceder a este campo, debes de tener una membresía activa.
                                    </span>
                                </b-form-group>
                                <b-form-group label="Teléfono whatsapp" label-cols-md="2" label-cols-lg="2">
                                    <b-form-input
                                        v-model="$v.usuario.telefono.$model"
                                        :state="$v.usuario.telefono.$dirty ? !$v.usuario.telefono.$error : null"
                                        aria-describedby="usuario-telefono"
                                    ></b-form-input>

                                    <b-form-invalid-feedback id="usuario-telefono">
                                        Campo de númerico, ingresa un teléfono con formato 987654321.
                                    </b-form-invalid-feedback>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-tab>
                    <b-tab title="Comunas" :active="menu_usuario == 1" @click="menu_usuario = 1">
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
                    <b-tab title="Rubros" :active="menu_usuario == 2" @click="menu_usuario = 2">
                        <b-row>
                            <b-col>
                                <b-alert variant="info" show>
                                    <p>
                                        Recuerda que mientras más rubros agregues a tu perfil, tienes más posibildidades de aparecer en las búsquedas.
                                    </p>
                                </b-alert>
                            </b-col>
                        </b-row>

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
                    <b-tab title="Certificaciones y documentos" :active="menu_usuario == 3" @click="menu_usuario = 3">
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
                <b-button :disabled="$v.usuario.$invalid" v-show="menu_usuario == 0" size="md" variant="success" @click="cambiar_redes_sociales"> Actualizar información </b-button>

                <b-button size="md" variant="danger" @click="cerrar_modal_informacion_usuario"> Cerrar </b-button>
                <b-button size="md" variant="warning" @click="menu_usuario--" v-show="menu_usuario < 4 && menu_usuario > 0"> Paso anterior </b-button>
                <b-button size="md" variant="info" @click="menu_usuario++" v-show="menu_usuario > -1 && menu_usuario < 3"> Siguiente paso </b-button>
            </template>
        </b-modal>

        <b-modal ref="modal_publicacion" :title="modal_publicacion.titulo" size="md" no-close-on-backdrop scrollable static>
            <b-form>

                <b-row :if="items.length == 0">
                    <b-col>
                        <b-alert variant="success" show>
                            <p>
                                ¡Bienvenido a Vitrinalaboral.cl!, ahora que eres parte de nuestra comunidad, te invitamos a generar tu primera publicación.
                            </p>
                        </b-alert>
                    </b-col>
                </b-row>

                <b-form-group label="¿En qué comunas prestaras el servicio?">
                    <vue-bootstrap-typeahead
                        ref="typeahead_comuna"
                        :data="comunas"
                        :serializer="p => p.nombre"
                        placeholder="Escribe para filtrar ..."
                        @hit="comuna_seleccionada($event)"
                    />
                </b-form-group>

                <b-form-group v-if="comunas_usuario.length">
                    <b-button variant="primary" size="sm" class="ml-1 mr-1" v-for="c in comunas_usuario" :key="c.id" @click="borrar_comuna_usuario(c.id)">{{ c.nombre }} <i class="fa fa-remove"></i> </b-button>
                </b-form-group>

                <b-row>    
                    <b-col lg="10" class="pr-0">
                        <b-form-group label="¿Cuáles son tus rubros?">
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
                    <b-col lg="2" class="pl-0">
                        <b-button :disabled="usuario.rubro_usuario.length == 0" size="md" variant="success" @click="agregar_rubro_usuario" class="mt-4" style="margin-top: 1.8rem !important;">Agregar</b-button>
                    </b-col>
                </b-row>

                <b-form-group v-if="rubros_usuario.length">
                    <b-button variant="primary" size="sm" class="ml-1 mr-1" v-for="r in rubros_usuario" :key="r.id" @click="borrar_rubro_usuario(r.id)">{{ r.nombre }} <i class="fa fa-remove"></i> </b-button>
                </b-form-group>

                <b-form-group label="¿Qué plan prefieres?" v-show="modal_publicacion.accion == 1">
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
            </b-form>

            <template slot="modal-footer">
                <b-button :disabled="$v.publicacion.$invalid" v-show="modal_publicacion.accion == 1" size="md" variant="success" @click="crear_actualizar_publicacion"> Ir a pagar </b-button>
                <b-button :disabled="$v.publicacion.$invalid" v-show="modal_publicacion.accion == 2" size="md" variant="warning" @click="crear_actualizar_publicacion"> Actualizar </b-button>
                <b-button size="md" variant="danger" @click="cerrar_modal_publicacion"> Cerrar </b-button>
                <b-button size="md" variant="primary" class="ml-2" @click="abrir_configuracion_usuario(0)"><i class="fa fa-cog"></i> Configurar mi perfil</b-button>
            </template>
        </b-modal>

        <b-modal ref="modal_plan_publicacion" title="Agregar plan a publicación" size="lg" no-close-on-backdrop scrollable static>
            <b-form>
                <b-row>
                    <b-col cols="8">
                        <b-form-group label="Agregar plan a publicación" label-cols-md="4" label-cols-lg="4">
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
                    <b-col cols="4">
                        <b-button :disabled="$v.plan_publicacion.$invalid" size="md" variant="success" class="mt-auto" block @click="crear_actualizar_plan_publicacion"> Agregar plan a publicación </b-button>
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

                            <template v-slot:cell(estado)="data">
                                {{ data.item.estado == 0 ? 'RECHAZADO' : 'APROBADO' }}
                            </template>
                        </b-table>
                    </b-col>
                </b-row>
            </b-form>

            <template slot="modal-footer">
                <b-button size="md" variant="danger" @click="cerrar_modal_plan_publicacion"> Cerrar </b-button>
            </template>
        </b-modal>

        <div class="fixed-bottom mb-5 mr-5">
            <b-button pill variant="success" size="lg" class="pull-right heigth-50" @click="abrir_modal_publicacion"><i class="ti-plus"></i></b-button>
        </div>
    </div>
</template>

<script>
    import { required, email, minLength, maxLength, numeric, alpha, minValue, requiredIf, url } from 'vuelidate/lib/validators'
    import { mapMutations, mapState } from 'vuex'

    export default {
        data(){
            return {
                documento: {
                    id: null,
                    titulo: '',
                    documento: null
                },
                usuario: {
                    id: 0,
                    telefono: '',
                    linkedin: '',
                    facebook: '',
                    instagram: '',
                    perfil_url: null,
                    rubro_usuario: '',
                    usuario_pago: null
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
                    plan_id: 0,
                    publicacion_id: 0
                },
                modal_publicacion: {
                    titulo: '',
                    accion: 0
                },
                items: [],
                comunas: [],
                comunas_usuario: [],
                rubros: [],
                rubros_usuario: [],
                plan_publicaciones: [],
                planes: [],
                documentos_usuario: [],
                menu_usuario: 0,
                fields: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'titulo', label: 'Título', sortable: true, class: 'text-left' },
                    { key: 'created_at', label: 'Creada', sortable: true, class: 'text-left' },
                    { key: 'expira', label: 'Expira', sortable: true, class: 'text-left' },
                    { key: 'estado', label: 'Estado', sortable: true, class: 'text-center' },
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
                fields_plan_publicacion: [
                    { key: 'index', label: '#', sortable: true, class: 'text-center' },
                    { key: 'nombre_plan', label: 'Plan', sortable: true, class: 'text-left' },
                    { key: 'valor', label: 'Valor', sortable: true, class: 'text-left' },
                    { key: 'duracion', label: 'Duración', sortable: true, class: 'text-left' },
                    { key: 'estado', label: 'Estado pago', sortable: true, class: 'text-left' }
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
                telefono: {
                    required,
                    numeric,
                    minLength: minLength(9),
                    maxLength: maxLength(9)
                },
                linkedin: {
                    required: requiredIf(function (value) {
                        return value.length > 0 ? true : false
                    }),
                    url
                },
                facebook: {
                    required: requiredIf(function (value) {
                        return value.length > 0 ? true : false
                    }),
                    url
                },
                instagram: {
                    required: requiredIf(function (value) {
                        return value.length > 0 ? true : false
                    }),
                    url
                }
            },
            publicacion: {
                plan_id: {
                    required: requiredIf(function (value) {
                        return this.modal_publicacion.accion === 1
                    }),
                    minValue: minValue(1)
                },
                titulo: {
                    required,
                    minLength: minLength(3)
                },
                descripcion: {
                    required,
                    minLength: minLength(20)
                }
            },
            plan_publicacion: {
                plan_id: {
                    required,
                    minValue: minValue(1)
                }
            }
        },
        computed:{
            modal_perfil(){
                return this.usuario.linkedin && this.usuario.facebook && this.usuario.instagram ? false : true
            },
            modal_comunas(){
                return this.comunas_usuario.length == 0 ? true : false
            },
            modal_rubros(){
                return this.rubros_usuario.length == 0 ? true : false
            },
            modal_documentos(){
                return this.documentos_usuario.length == 0 ? true : false  
            },
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
            onFiltered_plan_publicacion(filteredItems) {
                this.totalRows_plan_publicacion = filteredItems.length
                this.currentPage = 1
            },
            onFiltered_documentos(filteredItems) {
                this.totalRows_documentos = filteredItems.length
                this.currentPage = 1
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
                axios.get('/imagenes/usuario/' + this.publicacion.id).then(function (response) {
                    me.publicacion.url_imagenes = response.data.imagenes
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            comuna_seleccionada(e){
                let me = this

                axios.post('/usuario/agregar/comunas',{
                        'nombre_comuna': e.nombre,
                        'usuario_id': me.usuario.id,
                        'comuna_id': e.id
                    }).then(function (response) {
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
                        me.msg_success('Rubro agregado exitosamente.')
                        me.listar_rubros_usuario()
                        me.listar_rubros()
                        me.$refs.typeahead_rubro.inputValue = ''
                        me.usuario.rubro_usuario = ''
                    }).catch(function (error) {
                        console.log(error)
                })

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
            rubro_seleccionado(e){
                let me = this

                axios.post('/usuario/agregar/rubros',{
                        'nombre_rubro': e.nombre,
                        'usuario_id': me.usuario.id,
                        'rubro_id': e.id
                    }).then(function (response) {
                        me.msg_success('Rubro agregado exitosamente.')
                        me.listar_rubros_usuario()
                        me.$refs.typeahead_rubro.inputValue = ''
                    }).catch(function (error) {
                        console.log(error)
                })

            },
            usuario_logeado(){
                let me = this

                axios.get('/usuario/logeado').then(function (response) {
                    me.usuario.id = response.data.usuario.id
                    me.usuario.telefono = response.data.usuario.telefono
                    me.usuario.linkedin = response.data.usuario.linkedin
                    me.usuario.facebook = response.data.usuario.facebook
                    me.usuario.instagram = response.data.usuario.instagram
                    me.usuario.perfil_url = response.data.usuario.perfil_url
                    me.usuario.usuario_pago = response.data.usuario.usuario_pago

                    me.listar_publicaciones_usuario(response.data.usuario.id)
                    me.listar_comunas_usuario()
                    me.listar_rubros_usuario()
                    me.listar_documentos()
                })
            },
            listar_documentos(){
                let me = this

                axios.get('/usuario/documentos/' + this.usuario.id).then(function (response) {
                    me.documentos_usuario = response.data.documentos
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
            listar_comunas_usuario(){
                let me = this

                axios.get('/usuario/comunas/' + this.usuario.id).then(function (response) {
                    me.comunas_usuario = response.data.comunas
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_publicaciones_usuario(id){
                let me = this

                axios.get('/usuario/publicaciones/' + id).then(function (response) {
                    me.items = response.data.publicaciones

                    if(me.items.length == 0){
                        me.abrir_modal_publicacion()
                    }
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
            listar_rubros_usuario(){
                let me = this

                axios.get('/usuario/rubros/' + this.usuario.id).then(function (response) {
                    me.rubros_usuario = response.data.rubros
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listar_planes_publicacion(){
                let me = this

                axios.get('/usuario/planes/publicacion/' + me.plan_publicacion.publicacion_id).then(function (response) {
                    me.plan_publicaciones = response.data.plan_publicaciones
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
            eliminar_foto_perfil(){
                let me = this
                axios.post('/usuario/eliminar/foto',{
                        'id': me.usuario.id
                    }).then(function (response) {
                        me.msg_success('Registro actualizado exitosamente.')
                        me.usuario.perfil_url = 'https://image.flaticon.com/icons/svg/149/149076.svg'
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
                    this.usuario.perfil_url = URL.createObjectURL(e.target.files[0])

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
            abrir_configuracion_usuario(accion){
                this.abrir_modal_informacion_usuario()
                this.menu_usuario = accion
            },
            abrir_modal_informacion_usuario(){
                this.usuario.perfil_url = this.usuario.perfil_url == 'https://image.flaticon.com/icons/svg/149/149076.svg' ? this.usuario.perfil_url : 'storage/' + this.usuario.perfil_url
                this.$v.usuario.$touch(true)

                this.$refs['modal_informacion_usuario'].show()
            },
            abrir_modal_publicacion(data = []){
                let me = this
                this.limpiar_datos_publicacion()

                me.modal_publicacion.titulo = data.id == undefined ? "Agregar publicación" : "Modificar publicación"
                me.modal_publicacion.accion = data.id == undefined ? 1 : 2

                if(me.modal_publicacion.accion == 2){
                    me.publicacion.id = data.id
                    me.publicacion.titulo = data.titulo
                    me.publicacion.descripcion = data.descripcion
                    me.publicacion.url_imagenes = data.imagenes_publicacion
                }

                this.$refs['modal_publicacion'].show()
            },
            abrir_modal_plan_publicacion_usuario(id){
                let me = this

                me.plan_publicaciones = []
                me.plan_publicacion.publicacion_id = id

                

                me.listar_planes_publicacion()

                this.$refs['modal_plan_publicacion'].show()
            },
            cerrar_modal_plan_publicacion(){
                this.modal_publicacion.titulo = ''
                this.modal_publicacion.accion = 0

                this.$refs['modal_plan_publicacion'].hide()
            },
            cerrar_modal_publicacion(){
                this.modal_publicacion.titulo = ''
                this.modal_publicacion.accion = 0

                this.$refs['modal_publicacion'].hide()
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
                        me.listar_publicaciones_usuario(me.usuario.id)
                        me.msg_success(me.modal_publicacion.accion == 1 ? 'Seras redireccionado al portal de transbank.' : 'Perfil actualizado exitosamente.')

                        if(me.modal_publicacion.accion == 1){
                            me.limpiar_datos_publicacion()

                            var form = document.createElement("form");
                            var input_token = document.createElement("input");

                            console.log(response.data.url);
                            form.method = "POST";
                            form.action = response.data.url;

                            input_token.value = response.data.token;
                            input_token.name = "TBK_TOKEN";

                            form.appendChild(input_token);
                            document.body.appendChild(form);
                            form.submit();
                        }

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

                axios.post('/usuario/pagar/plan/publicacion',{
                        'publicacion_id': me.plan_publicacion.publicacion_id,
                        'plan_id': me.plan_publicacion.plan_id,
                        'user_id': me.usuario.id
                    }).then(function (response) {
                        me.plan_publicacion.plan_id = 0
                        me.msg_success('Seras redireccionado al portal de transbank.')

                        var form = document.createElement("form");
                        var input_token = document.createElement("input");

                        form.method = "POST";
                        form.action = response.data.url;

                        input_token.value = response.data.token;
                        input_token.name = "TBK_TOKEN";

                        form.appendChild(input_token);
                        document.body.appendChild(form);
                        form.submit();

                    }).catch(function (error) {
                        console.log(error)
                })

            },
            limpiar_datos_publicacion(){
                this.publicacion.id = 0
                this.publicacion.titulo = ''
                this.publicacion.descripcion = ''
                this.publicacion.imagenes = []
                this.publicacion.url_imagenes = []
                this.publicacion.plan_id = null
            },
            cerrar_modal_informacion_usuario(){
                this.menu_usuario = 0
                this.$refs['modal_informacion_usuario'].hide()
            },
            cambiar_redes_sociales(){
                if(this.$v.usuario.$invalid){
                    this.$v.usuario.$touch()
                    return
                }

                let me = this

                axios.post('/usuario/cambiar/sociales',{
                        'id': me.usuario.id,
                        'link_linkedin': me.usuario.linkedin,
                        'link_facebook': me.usuario.facebook,
                        'link_instagram': me.usuario.instagram,
                        'telefono': me.usuario.telefono
                    }).then(function (response) {
                        me.msg_success('Registro actualizado exitosamente.')
                    }).catch(function (error) {
                        console.log(error)
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
            abrir_modal_inicio_sesion(){
                if(this.modal_perfil || this.modal_comunas || this.modal_rubros && this.items.length > 0){
                    this.abrir_modal_informacion_usuario()
                }
            }
        },
        mounted() {
            this.usuario_logeado()
            this.listar_comunas()
            this.listar_rubros()
            this.listar_planes()
        }
    }
</script>
