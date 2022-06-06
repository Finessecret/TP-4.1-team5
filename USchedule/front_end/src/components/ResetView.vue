<template >
    <div class="container">
        <h5>Форма восстановления данных</h5>
        <div class="mb-3 ">
            <label for="email" class="form-label">E-mail </label>
            <input type="email" v-model="email" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <button type="button" @click="sendCode" class="btn btn-primary">Отправить код подтверждения</button>
    </div>
</template>
<script>
import axios from "axios"

export default {
    name: 'ResetView',
    data() {
        return {
            email: null,
        }
    },
    methods: {
        sendCode() {
            axios.post('/api/reset', {
                email: this.email
            }, { headers: { 'Content-Type': 'application/json' } })
                .then(response => {
                    console.log(response)
                })
        }
    },
}
</script>