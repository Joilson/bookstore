<script setup>
import useRequest from "../../js/requests.js";
import {onMounted, reactive, ref} from "vue";
import {handlePriceInput, years} from "../../js/helper.js";

const {create, getAll, errors} = useRequest();

const resource = 'books'

const formData = reactive({});

const authors = ref([]);
onMounted(async () => (authors.value = await getAll('authors')));

const subjects = ref([]);
onMounted(async () => (subjects.value = await getAll('subjects')));
</script>

<template>
    <main>
        <h1 class="title">Novo Livro</h1>

        <form
            @submit.prevent="create(resource, formData)"
            class="w-1/2 mx-auto space-y-6"
        >
            <div>
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" required maxlength="40" placeholder="Titulo" v-model="formData.title"/>
                    <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
                </div>

                <div class="form-group">
                    <label>Editora</label>
                    <input class="form-control" required type="text" maxlength="40" placeholder="Editora"
                           v-model="formData.publisher"/>
                    <p v-if="errors.publisher" class="error">{{ errors.publisher[0] }}</p>
                </div>

                <div class="form-group">
                    <label>Ediçao</label>
                    <input type="text" required placeholder="Ediçao" v-model.number="formData.edition"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                    <p v-if="errors.edition" class="error">{{ errors.edition[0] }}</p>
                </div>

                <div class="form-group">
                    <label>Ano de publicaçao</label>

                    <select v-model="formData.publicationYear" class="form-control" id="year">
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
                        :value="formData.priceFormatted"
                        @input="event => handlePriceInput(event, formData)"
                    />
                    <p v-if="errors.price" class="error">{{ errors.price[0] }}</p>
                </div>


                <div class="form-group">
                    <label for="exampleFormControlSelect2">Autores</label>
                    <select v-model="formData.authors" multiple class="form-control">
                        <option v-for="author in authors" :value="author.id"> {{ author.name }}</option>
                    </select>

                    <p v-if="errors.authors" class="error">{{ errors.authors[0] }}</p>
                </div>


                <div class="form-group">
                    <label for="exampleFormControlSelect2">Assuntos</label>
                    <select v-model="formData.subjects" multiple class="form-control">
                        <option v-for="subject in subjects" :value="subject.id" :key="subject.id"> {{
                                subject.description
                            }}
                        </option>
                    </select>

                    <p v-if="errors.subjects" class="error">{{ errors.subjects[0] }}</p>
                </div>

                <p v-if="errors.generic" class="error">{{ errors.generic }}</p>
            </div>

            <button class="primary-btn">Criar</button>
        </form>
    </main>
</template>
