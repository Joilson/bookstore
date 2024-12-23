<script setup>
import useRequest from "../../js/requests.js";
import {onMounted, ref} from "vue";
import {RouterLink} from "vue-router";
import {useAuth} from "../../js/auth.js";

const {remove, getAll} = useRequest();
const authors = ref([]);

const resource = 'authors'

onMounted(async () => (authors.value = await getAll(resource)));
</script>

<template>
    <main>
        <h1 class="title">Autores</h1>
        <div>
            <RouterLink :to="{ name: 'createAuthor' }" class="btn btn-primary mb-10">Adicionar</RouterLink>
        </div>

        <table class="table table-striped" v-if="authors.length > 0">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Açoes</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="author in authors" :key="author.id">
                <th scope="row">{{ author.id }}</th>
                <td>{{ author.name }}</td>
                <td>
                    <RouterLink
                        :to="{ name: 'updateAuthor', params: { id: author.id } }"
                        class="text-blue-500"
                    >
                        update
                    </RouterLink>
                    <button class="ml-5 text-red-500" @click="remove(resource, author.id)">remove</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-else>
            <h2 class="title">There are no authors</h2>
        </div>
    </main>
</template>
