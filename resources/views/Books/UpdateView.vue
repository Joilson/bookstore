<script setup>
import useRequest from "../../js/requests.js";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import {handlePriceInput, years} from "../../js/helper.js";

const route = useRoute();

const {get, update, getAll, errors} = useRequest();
const book = ref();

const resource = 'books'

onMounted(async () => (book.value = await get(resource, route.params.id)));

onMounted(async () => {
    book.value = await get('books', route.params.id);

    // Altera os objetos da response para utilizar os ids
    if (book) {
        const authorsIds = [];
        book.value.authors.forEach(function (obj, i) {
            authorsIds[i] = obj.id
        })
        book.value.authors = authorsIds;

        const subjectIds = [];
        book.value.subjects.forEach(function (obj, i) {
            subjectIds[i] = obj.id
        })
        book.value.subjects = subjectIds;
        book.value.priceFormatted = book.value.price;
    }
});

const authors = ref([]);
onMounted(async () => (authors.value = await getAll('authors')));

const subjects = ref([]);
onMounted(async () => (subjects.value = await getAll('subjects')));

</script>

<template>
    <main>
        <div v-if="book">
            <h1 class="title">Atualizar Livro</h1>

            <form @submit.prevent="update(resource, book.id, book)" class="w-1/2 mx-auto space-y-6">
                <div>
                    <div class="form-group">
                        <label>Titulo</label>
                        <input type="text" required maxlength="40" placeholder="Titulo" v-model="book.title"/>
                        <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
                    </div>

                    <div class="form-group">
                        <label>Editora</label>
                        <input class="form-control" required type="text" maxlength="40" placeholder="Editora"
                               v-model="book.publisher"/>
                        <p v-if="errors.publisher" class="error">{{ errors.publisher[0] }}</p>
                    </div>

                    <div class="form-group">
                        <label>Ediçao</label>
                        <input type="number" class="form-control" required placeholder="Ediçao" v-model.number="book.edition"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                        <p v-if="errors.edition" class="error">{{ errors.edition[0] }}</p>
                    </div>

                    <div class="form-group">
                        <label>Ano de publicaçao</label>

                        <select v-model.trim="book.publicationYear" class="form-control"
                                id="year">
                            <option v-for="year in years" :key="year" :value="String(year)">
                                {{ year }}
                            </option>
                        </select>

                        <p v-if="errors.publicationYear" class="error">{{ errors.publicationYear[0] }}</p>
                    </div>

                    <div class="form-group">
                        <label>Preço</label>

                        <input
                            type="text"
                            required
                            maxlength="10"
                            placeholder="Preço"
                            :value="book.priceFormatted"
                            @input="event => handlePriceInput(event, book)"
                        />

                        <p v-if="errors.price" class="error">{{ errors.price[0] }}</p>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Autores</label>
                        <select v-model="book.authors" multiple class="form-control">
                            <option v-for="author in authors" :value="author.id"> {{ author.name }}</option>
                        </select>

                        <p v-if="errors.authors" class="error">{{ errors.authors[0] }}</p>
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Assuntos</label>
                        <select v-model="book.subjects" multiple class="form-control">
                            <option v-for="subject in subjects" :value="subject.id" :key="subject.id"> {{
                                    subject.description
                                }}
                            </option>
                        </select>

                        <p v-if="errors.subjects" class="error">{{ errors.subjects[0] }}</p>
                    </div>

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
