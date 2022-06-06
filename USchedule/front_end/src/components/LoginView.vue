<template>
    <div class="container">
        <h5>Форма входа</h5>
        <div class="mb-3 ">
            <label for="NSP" class="form-label">Имя Фамилия Отчество </label>
            <input type="text" v-model="email" class="form-control" id="NSP" placeholder="Иван Иванов Иваныч">
        </div>
        <div class="mb-3 ">
            <label for="email" class="form-label">E-mail </label>
            <input type="email" v-model="email" class="form-control" id="email" placeholder="name@example.com">
        </div>

        <div class="mb-3">
            <label for="psw" class="form-label">Пароль</label>
            <input type="text" v-model="password" class="form-control" id="psw" placeholder="Ваш пароль">
        </div>
        <div class="row">
            <div class="col-auto">
                <button type="button" @click="login" class="btn btn-primary">Войти</button>
            </div>
            <div class="col-auto">
                <router-link to="/reset">
                    <button type="button" class="btn btn-primary">Востоновление данных</button>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'LoginView',
    data() {
        return {
            email: null,
            password: null,
        }
    },
    methods: {
        login() {
            /* axios.post('/api/login', {
                email: this.email,
                password: this.password
            }, { headers: { 'Content-Type': 'application/json' } })
                .then(response => {

                    console.log(response)
                    
                }) */
            this.$router.push('/personal_account')
        },
    },
}
</script>
