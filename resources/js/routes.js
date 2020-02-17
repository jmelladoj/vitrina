window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Usuarios from './components/intranet/usuarios.vue'
import Rubros from './components/intranet/rubros.vue'
import Planes from './components/intranet/planes.vue'
import Provincias from './components/intranet/provincias.vue'
import Perfil from './components/intranet/perfil.vue'

export default new VueRouter({
    routes: [
        {
            path: '/usuarios',
            name: 'usuarios',
            component: Usuarios
        },{
            path: '/rubros',
            name: 'rubros',
            component: Rubros
        },{
            path: '/planes',
            name: 'planes',
            component: Planes
        },{
            path: '/provincias',
            name: 'provincias',
            component: Provincias
        },{
            path: '/perfil',
            name: 'perfil',
            component: Perfil
        }
    ],
    mode: 'history'
})
