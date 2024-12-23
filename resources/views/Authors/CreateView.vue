<script setup>
// import {create, errors} from "../../js/requests.js";
import {reactive} from "vue";
import useRequest from "../../js/requests.js";

const {create, errors} = useRequest();


const resource = 'authors'

const formData = reactive({
    name: "",
});

</script>

<template>
    <main>
        <h1 class="title">Novo Autor</h1>

        <form
            @submit.prevent="create(resource, formData)"
            class="w-1/2 mx-auto space-y-6"
        >
            <div>
                <input required type="text" placeholder="Nome" v-model="formData.name"/>
                <p v-if="errors.name" class="error">{{ errors.name }}</p>
                <p v-if="errors.generic" class="error">{{ errors.generic }}</p>
            </div>

            <button class="primary-btn">Criar</button>
        </form>
    </main>
</template>
