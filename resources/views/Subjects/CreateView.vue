<script setup>
import useRequest from "../../js/requests.js";
import {storeToRefs} from "pinia";
import {reactive} from "vue";

const {create, errors} = useRequest();

const resource = 'subjects'

const formData = reactive({
    description: "",
});
</script>

<template>
    <main>
        <h1 class="title">Novo Assunto</h1>

        <form
            @submit.prevent="create(resource, formData)"
            class="w-1/2 mx-auto space-y-6"
        >
            <div>
                <input type="text" required maxlength="20" placeholder="Descriçao" v-model="formData.description"/>
                <p v-if="errors.description" class="error">{{ errors.description[0] }}</p>
                <p v-if="errors.generic" class="error">{{ errors.generic }}</p>
            </div>

            <button class="primary-btn">Criar</button>
        </form>
    </main>
</template>
