<script setup>
import useRequest from "../../js/requests.js";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";

const route = useRoute();

const {get, errors, update} = useRequest();

const author = ref();

const resource = 'authors'

onMounted(async () => (author.value = await get(resource, route.params.id)));
</script>

<template>
    <main>
        <div v-if="author">
            <h1 class="title">Atualizar Author</h1>

            <form @submit.prevent="update(resource, author.id, author)" class="w-1/2 mx-auto space-y-6">
                <div>
                    Name
                    <input maxlength="40" required type="text" placeholder="Nome" v-model="author.name"/>
                    <p v-if="errors.name" class="error">{{ errors.name[0] }}</p>
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
