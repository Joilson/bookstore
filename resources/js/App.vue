<script setup>
import {RouterLink, RouterView} from "vue-router";
import {useAuth} from "./auth.js";

const {logout} = useAuth()


const token = localStorage.getItem("token")

</script>


<template>
    <header>
        <nav>
            <div v-if="token" class="flex items-center space-x-6">

                <RouterLink :to="{ name: 'listAuthor' }" class="nav-link">Autores</RouterLink>
                <RouterLink :to="{ name: 'listSubject' }" class="nav-link">Assuntos</RouterLink>
                <RouterLink :to="{ name: 'listBook' }" class="nav-link">Livros</RouterLink>
                <RouterLink :to="{ name: 'reports' }" class="nav-link">Report</RouterLink>


                <button @click="logout" class="nav-link">Sair</button>
            </div>

            <div v-else class="flex items-center space-x-6">
                <RouterLink :to="{ name: 'register' }" class="nav-link">
                    Registrar
                </RouterLink>

                <RouterLink :to="{ name: 'home' }" class="nav-link">
                    Entrar
                </RouterLink>
            </div>
        </nav>

    </header>


    <RouterView/>
</template>
