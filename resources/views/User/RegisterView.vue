<script setup>

import {onMounted, reactive} from "vue";

import {useAuth} from "../../js/auth.js";

const {createUser, errors} = useAuth();

const formData = reactive({
    name: "",
    email: "",
    password: "",
});

onMounted(() => (errors.value = {}));
</script>

<template>
    <main>
        <h1 class="title">Register a new user</h1>

        <form
            @submit.prevent="createUser(formData)"
            class="w-1/2 mx-auto space-y-6"
        >
            <div>
                <input type="text" placeholder="Name" v-model="formData.name"/>
                <p v-if="errors.name" class="error">{{ errors.name[0] }}</p>
            </div>

            <div>
                <input type="text" placeholder="Email" v-model="formData.email"/>
                <p v-if="errors.email" class="error">{{ errors.email[0] }}</p>
            </div>

            <div>
                <input
                    type="password"
                    placeholder="Password"
                    v-model="formData.password"
                />
                <p v-if="errors.password" class="error">{{ errors.password[0] }}</p>
            </div>

            <button class="primary-btn">Register</button>
        </form>
    </main>
</template>
