<template>
    <div class="container">

        <router-link to="/schedule_table">
            <h5>Мое расписание</h5>
        </router-link>

        <h5>Мой профиль </h5>
        <p><b>Группа</b> <br>{{ group }}.</p>
        <p><b>Факультет</b><br>{{ faculty }}.</p>
        <p><b> Курс</b><br>{{ сourse }}.</p>
        <p><b> Имя Фамилия Отчество:</b> <br>{{ nsp }}.</p>
        <p><b>E-mail </b> <br>{{ email }}</p>
        <p><b>Статус</b> <br>{{ status }}</p>
        <button @click="exit" class="btn btn-primary">Выход</button>


    </div>
</template>
<script>

export default {
    name: 'PersonAccount',
    data() {
        return {
            group: 1,
            faculty: 'ФКН',
            сourse: 3,
            nsp: 'Иван Иванов Иванович',
            email: 'name@example.com',
            status: 'студент',

        }
    },
    methods: {
        exit() {
            /* axios.get('/api/exit')
                .then(response => {
                    console.log(response)
                }) */
            this.$router.push('/login')
        }
    },
}
</script>