<script setup>
import useRequest from "../../js/requests.js";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";

const route = useRoute();

const {get, update, errors} = useRequest();
const subject = ref();

const resource = 'subjects'

onMounted(async () => (subject.value = await get(resource, route.params.id)));
</script>

<template>
    <main>
        <div v-if="subject">
            <h1 class="title">Atualizar Descriçao</h1>

            <form @submit.prevent="update(resource, subject.id, subject)" class="w-1/2 mx-auto space-y-6">
                <div>
                    Descriçao
                    <input maxlength="40" required type="text" placeholder="Descriçao" v-model="subject.description"/>
                    <p v-if="errors.description" class="error">{{ errors.description[0] }}</p>
                    <p v-if="errors.generic" class="error">{{ errors.generic }}</p>
                </div>

                <button class="btn btn-primary ">Atualizar</button>
            </form>
        </div>

        <div v-else>
            <h2 class="title">Page not found!</h2>
        </div>
    </main>
</template>
