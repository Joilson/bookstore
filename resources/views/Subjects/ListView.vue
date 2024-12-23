<script setup>
import useRequest from "../../js/requests.js";
import {onMounted, ref} from "vue";
import {RouterLink} from "vue-router";

const {getAll, remove} = useRequest();
const subjects = ref([]);

const resource = 'subjects'

onMounted(async () => (subjects.value = await getAll(resource)));
</script>

<template>
    <main>
        <h1 class="title">Autores</h1>
        <div>
            <RouterLink :to="{ name: 'createSubject' }" class="btn btn-primary mb-10">Adicionar</RouterLink>
        </div>

        <table class="table table-striped" v-if="subjects.length > 0">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Description</th>
                <th scope="col">Açoes</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="subject in subjects" :key="subject.id">
                <th scope="row">{{ subject.id }}</th>
                <td>{{ subject.description }}</td>
                <td>
                    <RouterLink
                        :to="{ name: 'updateSubject', params: { id: subject.id } }"
                        class="text-blue-500"
                    >
                        update
                    </RouterLink>
                    <button class="ml-5 text-red-500" @click="remove(resource, subject.id)">remove</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-else>
            <h2 class="title">There are no subjects</h2>
        </div>
    </main>
</template>
