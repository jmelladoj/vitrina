<template>
    <div class="row" id="myBtnContainer">
        <div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 px-0">
            <ul class="category-links">
                <li class="nav-item" v-for="(rubro, index) in rubros" :key="rubro.id">
                    <a :href="'#' + rubro.id" class="nav-link" :class="index == 0 ? 'active': ''" v-text="rubro.nombre"></a>
                </li>
            </ul>
        </div>
    </div>
</template>


<script>
    export default {
        props: [
            'rubros'
        ]
    }
</script>
