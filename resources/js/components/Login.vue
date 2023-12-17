<template>
    <b-container class="my-5">
        <b-row align-h="center">
            <b-col cols="12" md="6" lg="4">
                <h2 class="mb-4 text-center">Вход для администратора магазина</h2>
                <b-form @submit.prevent="onSubmit">
                    <b-form-group label="Почтовый ящик" label-for="input-email">
                        <b-form-input
                            id="input-email"
                            v-model="credentials.email"
                            type="email"
                            required
                            placeholder="Введите почту"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group label="Пароль" label-for="input-password">
                        <b-form-input
                            id="input-password"
                            v-model="credentials.password"
                            type="password"
                            required
                            placeholder="Введите пароль"
                        ></b-form-input>
                    </b-form-group>

                    <b-button type="submit" variant="primary" class="w-100">Вход</b-button>
                </b-form>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            credentials: {
                email: '',
                password: '',
            },
        };
    },
    methods: {
        onSubmit() {
            axios.post('/api/login', this.credentials)
                .then(response => {
                    if (response.data.is_admin) {
                        window.location.href = response.data.redirect;
                    } else {
                        alert("You do not have admin privileges.");
                        window.location.href = response.data.redirect;
                    }
                })
                .catch(error => {
                    console.error('Login error:', error);
                    if (error.response && error.response.data) {
                        alert(error.response.data.message);
                    } else {
                        alert("An error occurred during login.");
                    }
                });
        },

    },
};
</script>

<style scoped>
h2 {
    color: #007bff;
}
</style>
