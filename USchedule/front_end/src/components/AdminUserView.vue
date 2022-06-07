 
 <template>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Факультет</th>
                    <th scope="col">Группа</th>
                    <th scope="col">Курс</th>
                    <th scope="col">Имя Фамилия Отчество</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Статус</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.nsp">
                    <td>{{ user.faculty }}</td>
                    <td>{{ user.group }}</td>
                    <td>{{ user.сourse }}</td>
                    <td>{{ user.nsp }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.status }}</td>
                    <td>
                        <button class="btn btn-primary mx-1"><i class="bi bi-brush"></i></button>
                        <button class="btn btn-danger"><i class="bi bi-trash3"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
export default {
    name: 'AdminUser',
    data() {
        return {
            users: [
                { faculty: 'fkn', group: '1', сourse: '3', nsp: 'Иван Иванов Иванович', email: 'name@example.com', status: 'студент' },
                { faculty: 'fkn', group: '4', сourse: '3', nsp: 'Мария Евгеньевна Романова', email: 'name@уамвмв.com', status: 'студент' },
                { faculty: 'fkn', group: null, сourse: null, nsp: 'Алиса Алексеевна Круцких', email: 'name@вмвмвм.com', status: 'профессор' }
            ]
        }
    }
}
</script>