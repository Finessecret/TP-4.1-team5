<template>
    <div class="container">
        <h5>Моё расписание</h5>
        <router-link to="/personal_account">
            <h5>Мой профиль</h5>
        </router-link>
        <div class="text-center">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Поискккк" aria-label="Поискккк"
                    aria-describedby="button-addon2" v-model="searchText">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="bi bi-search"
                        @click="search"></i></button>
            </div>
        </div>
        <div class="row justify-content-center">
            <b class="col text-center">Числитель</b>
            <b class="col text-center">Знаменатель</b>
        </div>
        <div class="row justify-content-center text-center" v-for="row in shedule" :key="row.day">
            <h5>{{ row.day }}</h5>
            <div class="col-auto flex-grow-1">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Время</th>
                            <th scope="col">Предмет</th>
                            <th scope="col">Преподаватель</th>
                            <th scope="col">Аудитория</th>
                            <th scope="col">Вместительность</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in row.numerator" :key="item.time">
                            <td>{{ item.time }}</td>
                            <td>{{ item.subject }}</td>
                            <td>{{ item.teacher }}</td>
                            <td>{{ item.classroom }}</td>
                            <td>{{ item.placecount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-auto flex-grow-1">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Время</th>
                            <th scope="col">Предмет</th>
                            <th scope="col">Преподаватель</th>
                            <th scope="col">Аудитория</th>
                            <th scope="col">Вместительность</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in row.denominator" :key="item.time">
                            <td>{{ item.time }}</td>
                            <td>{{ item.subject }}</td>
                            <td>{{ item.teacher }}</td>
                            <td>{{ item.classroom }}</td>
                            <td>{{ item.placecount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'


export default {
    name: 'ScheduleTableView',
    data() {
        return {
            searchText: null,
            shedule: [
                /*{
                day: 'Понедельник', numerator:
                    [
                        { time: '8:00', subject: 'Военная подготовка', teacher: null, classroom: null },
                        { time: '9:45', subject: 'Военная подготовка', teacher: null, classroom: null },
                        { time: '11:30', subject: 'Военная подготовка', teacher: null, classroom: null },
                        { time: '13:25', subject: 'Военная подготовка', teacher: null, classroom: null },
                        { time: '15:10', subject: 'Военная подготовка', teacher: null, classroom: null },
                        { time: '16:55', subject: 'Военная подготовка', teacher: null, classroom: null },
                        { time: '18:40', subject: 'Военная подготовка', teacher: null, classroom: null },
                        { time: '20:10', subject: 'Военная подготовка', teacher: null, classroom: null, placecount: 150 },

                    ]
                , denominator: [

                    { time: '8:00', subject: 'Военная подготовка', teacher: null, classroom: null },
                    { time: '9:45', subject: 'Военная подготовка', teacher: null, classroom: null },
                    { time: '11:30', subject: 'Военная подготовка', teacher: null, classroom: null },
                    { time: '13:25', subject: 'Военная подготовка', teacher: null, classroom: null },
                    { time: '15:10', subject: 'Военная подготовка', teacher: null, classroom: null },
                    { time: '16:55', subject: 'Военная подготовка', teacher: null, classroom: null },
                    { time: '18:40', subject: 'Военная подготовка', teacher: null, classroom: null },
                    { time: '20:10', subject: 'Военная подготовка', teacher: null, classroom: null, placecount: 150 },
                ]

            },*/
                {
                    day: 'Понедельник', numerator:
                        [
                            { time: '8:00 - 9:35', subject: 'Технологии программирования', teacher: 'Зенин К.В.', classroom: '479', placecount: 150 },
                            { time: '9:45 - 11:20', subject: 'Квантовая теория', teacher: 'Стадная Н.П.', classroom: '385', placecount: 25 },
                            { time: '11:30 - 13:05', subject: null, teacher: null, classroom: null, placecount: null },
                            { time: '13:25 - 15:00', subject: null, teacher: null, classroom: null, placecount: null },
                            { time: '15:10 - 16:45', subject: 'РБЗ', teacher: 'Матвеев М.Г.', classroom: 'ДО', placecount: 50 },
                            { time: '16:55 - 18:30', subject: 'SAP R3', teacher: 'Илларионов И.В.', classroom: 'ДО', placecount: 30 },
                            { time: '18:40 - 20:00', subject: null, teacher: null, classroom: null, placecount: null },
                            { time: '20:10 - 21:30', subject: null, teacher: null, classroom: null, placecount: null },

                        ]
                    , denominator: [

                        { time: '8:00 - 9:35', subject: 'Технологии программирования', teacher: 'Зенин К.В.', classroom: '479', placecount: 150 },
                        { time: '9:45 - 11:20', subject: 'Квантовая теория', teacher: 'Стадная Н.П.', classroom: '385', placecount: 25 },
                        { time: '11:30 - 13:05', subject: null, teacher: null, classroom: null, placecount: null },
                        { time: '13:25 - 15:00', subject: 'ИТ', teacher: 'Михайлов Е.М.', classroom: 'ДО', placecount: 50 },
                        { time: '15:10 - 16:45', subject: 'РБЗ', teacher: 'Матвеев М.Г.', classroom: 'ДО', placecount: 30 },
                        { time: '16:55 - 18:30', subject: 'SAP R3', teacher: 'Илларионов И.В.', classroom: 'ДО', placecount: 30 },
                        { time: '18:40 - 20:00', subject: null, teacher: null, classroom: null, placecount: null },
                        { time: '20:10 - 21:30', subject: null, teacher: null, classroom: null, placecount: null },
                    ]

                },
                {
                    day: 'Среда', numerator:
                        [
                            { time: '8:00 - 9:35', subject: 'ИСиС', teacher: 'Коваль А.С.', classroom: '316п' },
                            { time: '9:45 - 11:20', subject: 'ФИЗВОСПИТАНИЕ', teacher: 'Щеглова Е.В.', classroom: 'центральный корпус' },
                            { time: '11:30 - 13:05', subject: null, teacher: null, classroom: null },
                            { time: '13:25 - 15:00', subject: 'ЯП Джава', teacher: 'Самойлов Н.К', classroom: 'ДО' },
                            { time: '15:10 - 16:45', subject: 'КТ', teacher: 'Запрягаев С.А.', classroom: 'ДО' },
                            { time: '16:55 - 18:30', subject: 'ИТ', teacher: 'Михайлов Е.М.', classroom: 'ДО' },
                            { time: '18:40 - 20:00', subject: null, teacher: null, classroom: null },
                            { time: '20:10 - 21:30', subject: null, teacher: null, classroom: null },

                        ]
                    , denominator: [

                        { time: '8:00 - 9:35', subject: 'Технологии программирования', teacher: 'Зенин К.В.', classroom: '479' },
                        { time: '9:45 - 11:20', subject: 'Квантовая теория', teacher: 'Стадная Н.П.', classroom: '385' },
                        { time: '11:30 - 13:05', subject: null, teacher: null, classroom: null },
                        { time: '13:25 - 15:00', subject: null, teacher: null, classroom: null },
                        { time: '15:10 - 16:45', subject: 'КТ', teacher: 'Запрягаев С.А.', classroom: 'ДО' },
                        { time: '16:55 - 18:30', subject: 'ИТ', teacher: 'Михайлов Е.М.', classroom: 'ДО' },
                        { time: '18:40 - 20:00', subject: null, teacher: null, classroom: null },
                        { time: '20:10 - 21:30', subject: null, teacher: null, classroom: null },
                    ]

                }
            ]
        }
    },
    methods: {
        search() {
            axios.post("/api/search", { searchText: this.searchText }).then(response => console.log(response))
        }
    },
}
</script>
