<script setup>
import {useAuth} from "../../js/auth.js";
import {onMounted, reactive} from "vue";

const {errors, authenticate} = useAuth();

const formData = reactive({
    email: "",
    password: "",
});

onMounted(() => (errors.value = {}));
</script>

<template>
    <main>
        <h1 class="title">Login to your account</h1>

        <form
            @submit.prevent="authenticate(formData)"
            class="w-1/2 mx-auto space-y-6"
        >
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
                <p v-if="errors.unautorized" class="error">Invalid credentials</p>
            </div>


            <button class="primary-btn">Login</button>
        </form>
    </main>
</template>
