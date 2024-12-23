<script setup>
import useRequest from "../../js/requests.js";
import {onMounted, ref} from "vue";
import {RouterLink} from "vue-router";

const {getAll, remove} = useRequest();

const books = ref([]);

const resource = 'books'


onMounted(async () => (books.value = await getAll(resource)));
</script>

<template>
    <main>
        <h1 class="title">Livros</h1>
        <div>
            <RouterLink :to="{ name: 'createBook' }" class="btn btn-primary mb-10">Adicionar</RouterLink>
        </div>

        <table class="table table-striped" v-if="books.length > 0">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col">Editora</th>
                <th scope="col">Ediçao</th>
                <th scope="col">Ano de publicaçao</th>
                <th scope="col">Preço</th>
                <th scope="col">Autores</th>
                <th scope="col">Assuntos</th>
                <th scope="col">Açoes</th>
            </tr>
            </thead>
            <tbody>
            <tr  v-for="book in books" :key="book.id">
                <th scope="row">{{ book.id }}</th>
                <td>{{ book.title }}</td>
                <td>{{ book.publisher }}</td>
                <td>{{ book.edition }}</td>
                <td>{{ book.publicationYear }}</td>
                <td>
                    R$ {{ book.price.toLocaleString() }}
                </td>
                <td>
                    <div class="text-gray-400 text-xs" v-for="author in book.authors" :key="author.id">- {{
                            author.name
                        }} <br>
                    </div>
                </td>
                <td>
                    <div class="text-gray-400 text-xs" v-for="subject in book.subjects" :key="subject.id">
                        - {{ subject.description }} <br>
                    </div>
                </td>
                <td>
                    <RouterLink
                        :to="{ name: 'updateBook', params: { id: book.id } }"
                        class="text-blue-500"
                    >
                        update
                    </RouterLink>
                    <button class="ml-5 text-red-500" @click="remove(resource, book.id)">remove</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-else>
            <h2 class="title">There are no books</h2>
        </div>
    </main>
</template>
